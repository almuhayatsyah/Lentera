<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Kunjungan;
use App\Models\Pengukuran;
use App\Models\Pelayanan;
use App\Services\GrowthCalculatorService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    protected $growthCalculator;

    public function __construct(GrowthCalculatorService $growthCalculator)
    {
        $this->growthCalculator = $growthCalculator;
    }

    /**
     * Show the 5-step wizard form
     */
    public function wizard()
    {
        // Get children for selection (step 1)
        $anaks = auth()->user()->isKader()
            ? Anak::where('posyandu_id', auth()->user()->posyandu_id)
                ->aktif()
                ->balita()
                ->with('ibu')
                ->orderBy('nama')
                ->get()
            : Anak::aktif()->balita()->with('ibu')->orderBy('nama')->get();

        return view('kunjungan.wizard', compact('anaks'));
    }

    /**
     * Show wizard with pre-selected child
     */
    public function wizardWithAnak(Anak $anak)
    {
        $this->authorizeAccess($anak);

        return view('kunjungan.wizard', [
            'selectedAnak' => $anak,
            'anaks' => collect([$anak]),
        ]);
    }

    /**
     * Store the visit data from wizard
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Step 1: Identity
            'anak_id' => 'required|exists:anaks,id',
            'tanggal_kunjungan' => 'required|date|before_or_equal:today',

            // Step 2: Anthropometry
            'berat_badan' => 'required|numeric|min:0.5|max:100',
            'tinggi_badan' => 'required|numeric|min:30|max:200',
            'lingkar_kepala' => 'nullable|numeric|min:20|max:60',
            'lingkar_lengan' => 'nullable|numeric|min:5|max:40',

            // Step 4: Intervention
            'vitamin_a' => 'boolean',
            'vitamin_a_dosis' => 'nullable|in:biru,merah',
            'obat_cacing' => 'boolean',
            'imunisasi' => 'nullable|array',
            'pmt' => 'boolean',
            'jenis_pmt' => 'nullable|string|max:255',
            'jumlah_pmt' => 'nullable|integer|min:0',
            'satuan_pmt' => 'nullable|string|max:50',
            'asi_eksklusif' => 'nullable|boolean',
            'konseling_gizi' => 'boolean',
            'materi_konseling' => 'nullable|string',

            // Step 5: Notes
            'catatan' => 'nullable|string',
        ]);

        // Get anak data
        $anak = Anak::findOrFail($validated['anak_id']);
        $this->authorizeAccess($anak);

        // Calculate age
        $tanggalKunjungan = Carbon::parse($validated['tanggal_kunjungan']);
        $usiaBulan = $this->growthCalculator->calculateAgeInMonths($anak->tanggal_lahir, $tanggalKunjungan);
        $usiaHari = $this->growthCalculator->calculateAgeInDays($anak->tanggal_lahir, $tanggalKunjungan);

        // Calculate Z-scores and status
        $analysis = $this->growthCalculator->analyze(
            $anak->tanggal_lahir,
            $anak->jenis_kelamin,
            $validated['berat_badan'],
            $validated['tinggi_badan'],
            $tanggalKunjungan
        );

        // Check weight gain from previous visit
        $previousPengukuran = $anak->pengukuran_terakhir;
        $naikBeratBadan = null;
        $keteranganBb = null;

        if ($previousPengukuran) {
            $naikBeratBadan = $validated['berat_badan'] > $previousPengukuran->berat_badan;
            $keteranganBb = $naikBeratBadan ? 'N' : 'T'; // N=Naik, T=Tidak naik
        }

        // Create Kunjungan
        $kunjungan = Kunjungan::create([
            'anak_id' => $anak->id,
            'posyandu_id' => $anak->posyandu_id,
            'user_id' => auth()->id(),
            'tanggal_kunjungan' => $tanggalKunjungan,
            'usia_bulan' => $usiaBulan,
            'usia_hari' => $usiaHari,
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'complete',
        ]);

        // Create Pengukuran
        Pengukuran::create([
            'kunjungan_id' => $kunjungan->id,
            'berat_badan' => $validated['berat_badan'],
            'tinggi_badan' => $validated['tinggi_badan'],
            'lingkar_kepala' => $validated['lingkar_kepala'] ?? null,
            'lingkar_lengan' => $validated['lingkar_lengan'] ?? null,
            'zscore_bb_u' => $analysis['zscore_bb_u'],
            'zscore_tb_u' => $analysis['zscore_tb_u'],
            'zscore_bb_tb' => $analysis['zscore_bb_tb'],
            'status_gizi' => $analysis['status_gizi'],
            'status_stunting' => $analysis['status_stunting'],
            'status_wasting' => $analysis['status_wasting'],
            'naik_berat_badan' => $naikBeratBadan,
            'keterangan_bb' => $keteranganBb,
        ]);

        // Create Pelayanan
        Pelayanan::create([
            'kunjungan_id' => $kunjungan->id,
            'vitamin_a' => $request->boolean('vitamin_a'),
            'vitamin_a_dosis' => $validated['vitamin_a_dosis'] ?? null,
            'vitamin_a_tanggal' => $request->boolean('vitamin_a') ? $tanggalKunjungan : null,
            'obat_cacing' => $request->boolean('obat_cacing'),
            'obat_cacing_tanggal' => $request->boolean('obat_cacing') ? $tanggalKunjungan : null,
            'imunisasi' => $validated['imunisasi'] ?? null,
            'pmt' => $request->boolean('pmt'),
            'jenis_pmt' => $validated['jenis_pmt'] ?? null,
            'jumlah_pmt' => $validated['jumlah_pmt'] ?? null,
            'satuan_pmt' => $validated['satuan_pmt'] ?? null,
            'asi_eksklusif' => $validated['asi_eksklusif'] ?? null,
            'konseling_gizi' => $request->boolean('konseling_gizi'),
            'materi_konseling' => $validated['materi_konseling'] ?? null,
        ]);

        // Prepare success message with status info
        $statusMessage = "Data kunjungan {$anak->nama} berhasil disimpan.";
        if ($analysis['is_stunting'] || $analysis['is_underweight']) {
            $statusMessage .= " ⚠️ PERHATIAN: Anak memerlukan intervensi!";
        }

        return redirect()->route('kunjungan.show', $kunjungan)
            ->with('success', $statusMessage);
    }

    /**
     * Calculate status via AJAX (for step 3 preview)
     */
    public function calculateStatus(Request $request)
    {
        $validated = $request->validate([
            'anak_id' => 'required|exists:anaks,id',
            'berat_badan' => 'required|numeric|min:0.5|max:100',
            'tinggi_badan' => 'required|numeric|min:30|max:200',
            'tanggal_kunjungan' => 'nullable|date',
        ]);

        $anak = Anak::findOrFail($validated['anak_id']);
        $tanggal = Carbon::parse($validated['tanggal_kunjungan'] ?? now());

        $analysis = $this->growthCalculator->analyze(
            $anak->tanggal_lahir,
            $anak->jenis_kelamin,
            $validated['berat_badan'],
            $validated['tinggi_badan'],
            $tanggal
        );

        $formatted = $this->growthCalculator->formatAnalysisResult($analysis);

        return response()->json([
            'success' => true,
            'anak' => [
                'nama' => $anak->nama,
                'usia' => $formatted['usia'],
                'jenis_kelamin' => $anak->jenis_kelamin_text,
            ],
            'pengukuran' => [
                'berat_badan' => $validated['berat_badan'],
                'tinggi_badan' => $validated['tinggi_badan'],
            ],
            'hasil' => [
                'status_gizi' => $formatted['status_gizi'],
                'status_stunting' => $formatted['status_stunting'],
                'status_wasting' => $formatted['status_wasting'],
                'zscore' => [
                    'bb_u' => $analysis['zscore_bb_u'],
                    'tb_u' => $analysis['zscore_tb_u'],
                    'bb_tb' => $analysis['zscore_bb_tb'],
                ],
                'needs_intervention' => $formatted['needs_intervention'],
                'alert_level' => $formatted['alert_level'],
            ],
        ]);
    }

    /**
     * Show visit details
     */
    public function show(Kunjungan $kunjungan)
    {
        $this->authorizeAccessKunjungan($kunjungan);
        
        $kunjungan->load(['anak.ibu', 'pengukuran', 'pelayanan', 'user', 'posyandu']);

        return view('kunjungan.show', compact('kunjungan'));
    }

    /**
     * Show visit history
     */
    public function history(Request $request)
    {
        $query = Kunjungan::with(['anak', 'pengukuran', 'user']);

        // Filter by posyandu for Kader
        if (auth()->user()->isKader()) {
            $query->where('posyandu_id', auth()->user()->posyandu_id);
        }

        // Filter by date range
        if ($request->filled('from')) {
            $query->where('tanggal_kunjungan', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->where('tanggal_kunjungan', '<=', $request->to);
        }

        // Filter by child
        if ($request->filled('anak_id')) {
            $query->where('anak_id', $request->anak_id);
        }

        $kunjungans = $query->orderByDesc('tanggal_kunjungan')
            ->paginate(15)
            ->withQueryString();

        return view('kunjungan.history', compact('kunjungans'));
    }

    /**
     * Authorize access for Kader
     */
    private function authorizeAccess(Anak $anak)
    {
        if (auth()->user()->isKader() && $anak->posyandu_id !== auth()->user()->posyandu_id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
    }

    private function authorizeAccessKunjungan(Kunjungan $kunjungan)
    {
        if (auth()->user()->isKader() && $kunjungan->posyandu_id !== auth()->user()->posyandu_id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Ibu;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;


class AnakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Anak::with(['ibu', 'posyandu'])
            ->aktif()
            ->balita(); // Only show children under 5 years old

        // Filter by posyandu for Kader
        if (auth()->user()->isKader()) {
            $query->where('posyandu_id', auth()->user()->posyandu_id);
        }

        // Search
        if ($request->filled('search')) {
            $query->cari($request->search);
        }

        // Filter by posyandu (for Admin)
        if ($request->filled('posyandu_id')) {
            $query->where('posyandu_id', $request->posyandu_id);
        }

        // Filter by gender
        if ($request->filled('jenis_kelamin')) {
            $query->jenisKelamin($request->jenis_kelamin);
        }

        $anaks = $query->orderBy('nama')->paginate(10)->withQueryString();
        $posyandus = auth()->user()->isAdmin() ? Posyandu::aktif()->get() : collect();

        return view('anak.index', compact('anaks', 'posyandus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $posyandus = auth()->user()->isAdmin() 
            ? Posyandu::aktif()->get() 
            : collect([auth()->user()->posyandu]);

        // Pre-select ibu if passed
        $selectedIbu = null;
        if ($request->filled('ibu_id')) {
            $selectedIbu = Ibu::find($request->ibu_id);
        }

        // Get ibus for selection
        $ibus = auth()->user()->isKader()
            ? Ibu::where('posyandu_id', auth()->user()->posyandu_id)->aktif()->get()
            : Ibu::aktif()->get();

        return view('anak.create', compact('posyandus', 'ibus', 'selectedIbu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|size:16|unique:anaks,nik',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date|before:today',
            'tempat_lahir' => 'nullable|string|max:255',
            'ibu_id' => 'required|exists:ibus,id',
            'posyandu_id' => 'required|exists:posyandus,id',
            'urutan_anak' => 'nullable|integer|min:1',
            'berat_lahir' => 'nullable|numeric|min:0.5|max:10',
            'panjang_lahir' => 'nullable|numeric|min:20|max:70',
            'lingkar_kepala_lahir' => 'nullable|numeric|min:20|max:50',
            'golongan_darah' => 'nullable|string|max:3',
            'catatan' => 'nullable|string',
        ]);

        // Additional validation: Check if child is under 5 years old (Balita)
        $tanggalLahir = \Carbon\Carbon::parse($validated['tanggal_lahir']);
        $usiaBulan = $tanggalLahir->diffInMonths(now());
        
        if ($usiaBulan >= 60) { // 60 months = 5 years
            return back()
                ->withErrors(['tanggal_lahir' => 'Anak harus berusia di bawah 5 tahun (Balita). Data yang diinput berusia ' . floor($usiaBulan / 12) . ' tahun ' . ($usiaBulan % 12) . ' bulan.'])
                ->withInput();
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('anak-photos', 'public');
        }

        // Kader can only add to their posyandu
        if (auth()->user()->isKader()) {
            $validated['posyandu_id'] = auth()->user()->posyandu_id;
        }

        // Ensure aktif is set to true for new records
        $validated['aktif'] = true;

        Anak::create($validated);

        ActivityLogger::log('Tambah Data Anak', "Berhasil menambahkan data anak: {$validated['nama']}");

        return redirect()->route('anak.index')
            ->with('success', 'Data anak berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anak $anak)
    {
        $this->authorizeAccess($anak);
        
        $anak->load(['ibu', 'posyandu', 'kunjungans.pengukuran', 'kunjungans.pelayanan']);

        return view('anak.show', compact('anak'));
    }

    /**
     * Show growth history
     */
    public function riwayat(Anak $anak)
    {
        $this->authorizeAccess($anak);
        
        $anak->load(['kunjungans' => function ($q) {
            $q->with(['pengukuran', 'pelayanan', 'user'])->orderByDesc('tanggal_kunjungan');
        }]);

        return view('anak.riwayat', compact('anak'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anak $anak)
    {
        $this->authorizeAccess($anak);

        $posyandus = auth()->user()->isAdmin() 
            ? Posyandu::aktif()->get() 
            : collect([auth()->user()->posyandu]);

        $ibus = auth()->user()->isKader()
            ? Ibu::where('posyandu_id', auth()->user()->posyandu_id)->aktif()->get()
            : Ibu::aktif()->get();

        return view('anak.edit', compact('anak', 'posyandus', 'ibus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anak $anak)
    {
        $this->authorizeAccess($anak);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|size:16|unique:anaks,nik,' . $anak->id,
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date|before:today',
            'tempat_lahir' => 'nullable|string|max:255',
            'ibu_id' => 'required|exists:ibus,id',
            'posyandu_id' => 'required|exists:posyandus,id',
            'urutan_anak' => 'nullable|integer|min:1',
            'berat_lahir' => 'nullable|numeric|min:0.5|max:10',
            'panjang_lahir' => 'nullable|numeric|min:20|max:70',
            'lingkar_kepala_lahir' => 'nullable|numeric|min:20|max:50',
            'golongan_darah' => 'nullable|string|max:3',
            'catatan' => 'nullable|string',
            'aktif' => 'boolean',
        ]);

        // Additional validation: Check if child is under 5 years old (Balita)
        $tanggalLahir = \Carbon\Carbon::parse($validated['tanggal_lahir']);
        $usiaBulan = $tanggalLahir->diffInMonths(now());
        
        if ($usiaBulan >= 60) { // 60 months = 5 years
            return back()
                ->withErrors(['tanggal_lahir' => 'Anak harus berusia di bawah 5 tahun (Balita). Data yang diinput berusia ' . floor($usiaBulan / 12) . ' tahun ' . ($usiaBulan % 12) . ' bulan.'])
                ->withInput();
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($anak->foto && \Storage::disk('public')->exists($anak->foto)) {
                \Storage::disk('public')->delete($anak->foto);
            }
            $validated['foto'] = $request->file('foto')->store('anak-photos', 'public');
        }

        $validated['aktif'] = $request->boolean('aktif', true);

        $anak->update($validated);

        ActivityLogger::log('Update Data Anak', "Memperbarui data anak: {$anak->nama}");

        return redirect()->route('anak.index')
            ->with('success', 'Data anak berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anak $anak)
    {
        $this->authorizeAccess($anak);

        if ($anak->kunjungans()->count() > 0) {
            return redirect()->route('anak.index')
                ->with('error', 'Tidak dapat menghapus anak yang sudah memiliki riwayat kunjungan.');
        }

        ActivityLogger::log('Hapus Data Anak', "Menghapus data anak: {$anak->nama}");

        $anak->delete();

        return redirect()->route('anak.index')
            ->with('success', 'Data anak berhasil dihapus.');
    }

    /**
     * Search anak for API (used in wizard)
     */
    public function search(Request $request)
    {
        $query = Anak::with('ibu')
            ->aktif()
            ->balita();

        if (auth()->user()->isKader()) {
            $query->where('posyandu_id', auth()->user()->posyandu_id);
        }

        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }

        $anaks = $query->limit(10)->get()->map(function ($anak) {
            return [
                'id' => $anak->id,
                'nama' => $anak->nama,
                'jenis_kelamin' => $anak->jenis_kelamin_text,
                'usia' => $anak->usia_format,
                'ibu' => $anak->ibu->nama ?? '-',
            ];
        });

        return response()->json($anaks);
    }

    /**
     * Authorize access for Kader (only their posyandu)
     */
    private function authorizeAccess(Anak $anak)
    {
        if (auth()->user()->isKader() && $anak->posyandu_id !== auth()->user()->posyandu_id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
    }
}

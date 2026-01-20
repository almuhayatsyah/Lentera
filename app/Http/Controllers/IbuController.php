<?php

namespace App\Http\Controllers;

use App\Models\Ibu;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class IbuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ibu::with(['posyandu'])
            ->withCount('anaks');

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

        $ibus = $query->orderBy('nama')->paginate(10)->withQueryString();
        $posyandus = auth()->user()->isAdmin() ? Posyandu::aktif()->get() : collect();

        return view('ibu.index', compact('ibus', 'posyandus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $posyandus = auth()->user()->isAdmin() 
            ? Posyandu::aktif()->get() 
            : collect([auth()->user()->posyandu]);

        return view('ibu.create', compact('posyandus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:ibus,nik',
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'desa' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:15',
            'nama_suami' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'posyandu_id' => 'required|exists:posyandus,id',
        ]);

        // Kader can only add to their posyandu
        if (auth()->user()->isKader()) {
            $validated['posyandu_id'] = auth()->user()->posyandu_id;
        }

        Ibu::create($validated);

        ActivityLogger::log('Tambah Data Ibu', "Berhasil menambahkan data ibu: {$validated['nama']}");

        return redirect()->route('ibu.index')
            ->with('success', 'Data ibu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ibu $ibu)
    {
        $this->authorizeAccess($ibu);
        
        $ibu->load(['posyandu', 'anaks.pengukurans']);

        return view('ibu.show', compact('ibu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ibu $ibu)
    {
        $this->authorizeAccess($ibu);

        $posyandus = auth()->user()->isAdmin() 
            ? Posyandu::aktif()->get() 
            : collect([auth()->user()->posyandu]);

        return view('ibu.edit', compact('ibu', 'posyandus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ibu $ibu)
    {
        $this->authorizeAccess($ibu);

        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:ibus,nik,' . $ibu->id,
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'desa' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:15',
            'nama_suami' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'posyandu_id' => 'required|exists:posyandus,id',
            'aktif' => 'boolean',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);

        $ibu->update($validated);

        ActivityLogger::log('Update Data Ibu', "Memperbarui data ibu: {$ibu->nama}");

        return redirect()->route('ibu.index')
            ->with('success', 'Data ibu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ibu $ibu)
    {
        $this->authorizeAccess($ibu);

        if ($ibu->anaks()->count() > 0) {
            return redirect()->route('ibu.index')
                ->with('error', 'Tidak dapat menghapus ibu yang masih memiliki data anak.');
        }

        ActivityLogger::log('Hapus Data Ibu', "Menghapus data ibu: {$ibu->nama}");

        $ibu->delete();

        return redirect()->route('ibu.index')
            ->with('success', 'Data ibu berhasil dihapus.');
    }

    /**
     * Authorize access for Kader (only their posyandu)
     */
    private function authorizeAccess(Ibu $ibu)
    {
        if (auth()->user()->isKader() && $ibu->posyandu_id !== auth()->user()->posyandu_id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
    }
}

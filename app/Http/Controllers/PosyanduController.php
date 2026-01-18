<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use Illuminate\Http\Request;

class PosyanduController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Posyandu::withCount(['anaks', 'users']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('desa', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%");
            });
        }

        $posyandus = $query->orderBy('nama')->paginate(10)->withQueryString();

        return view('posyandu.index', compact('posyandus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posyandu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'kader_utama' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:15',
            'catatan' => 'nullable|string',
            'aktif' => 'boolean',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);

        Posyandu::create($validated);

        return redirect()->route('posyandu.index')
            ->with('success', 'Posyandu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Posyandu $posyandu)
    {
        $posyandu->load(['anaks.ibu', 'users']);
        
        return view('posyandu.show', compact('posyandu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Posyandu $posyandu)
    {
        return view('posyandu.edit', compact('posyandu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Posyandu $posyandu)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'kader_utama' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:15',
            'catatan' => 'nullable|string',
            'aktif' => 'boolean',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);

        $posyandu->update($validated);

        return redirect()->route('posyandu.index')
            ->with('success', 'Posyandu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posyandu $posyandu)
    {
        // Check if posyandu has related data
        if ($posyandu->anaks()->count() > 0) {
            return redirect()->route('posyandu.index')
                ->with('error', 'Tidak dapat menghapus Posyandu yang masih memiliki data anak.');
        }

        $posyandu->delete();

        return redirect()->route('posyandu.index')
            ->with('success', 'Posyandu berhasil dihapus.');
    }
}

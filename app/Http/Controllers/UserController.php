<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Services\ActivityLogger;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('posyandu');

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by posyandu
        if ($request->filled('posyandu_id')) {
            $query->where('posyandu_id', $request->posyandu_id);
        }

        $users = $query->orderBy('name')->paginate(10)->withQueryString();
        $posyandus = Posyandu::aktif()->get();

        return view('users.index', compact('users', 'posyandus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $posyandus = Posyandu::aktif()->get();

        return view('users.create', compact('posyandus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:admin_puskesmas,kader',
            'posyandu_id' => 'nullable|exists:posyandus,id',
            'nip' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:15',
        ]);

        // Kader must have posyandu
        if ($validated['role'] === 'kader' && empty($validated['posyandu_id'])) {
            return back()->withErrors(['posyandu_id' => 'Kader harus ditugaskan ke Posyandu.'])->withInput();
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'posyandu_id' => $validated['posyandu_id'],
            'nip' => $validated['nip'],
            'telepon' => $validated['telepon'],
            'aktif' => true,
        ]);

        ActivityLogger::log('Tambah Pengguna', "Admin berhasil menambahkan pengguna baru: {$validated['name']} ({$validated['role']})");

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('posyandu');

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $posyandus = Posyandu::aktif()->get();

        return view('users.edit', compact('user', 'posyandus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:admin_puskesmas,kader',
            'posyandu_id' => 'nullable|exists:posyandus,id',
            'nip' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:15',
            'aktif' => 'boolean',
        ]);

        // Kader must have posyandu
        if ($validated['role'] === 'kader' && empty($validated['posyandu_id'])) {
            return back()->withErrors(['posyandu_id' => 'Kader harus ditugaskan ke Posyandu.'])->withInput();
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->posyandu_id = $validated['posyandu_id'];
        $user->nip = $validated['nip'];
        $user->telepon = $validated['telepon'];
        $user->aktif = $request->boolean('aktif', true);

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        ActivityLogger::log('Update Pengguna', "Admin memperbarui data pengguna: {$user->name}");

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deletion of developer account
        if ($user->email === 'developer@lentera.app') {
            return redirect()->route('users.index')
                ->with('error', 'Tidak dapat menghapus akun Developer yang dilindungi.');
        }

        // Check for related data
        if ($user->kunjungans()->count() > 0) {
            // Soft delete - just deactivate
            $user->update(['aktif' => false]);
            return redirect()->route('users.index')
                ->with('success', 'Pengguna berhasil dinonaktifkan (memiliki data kunjungan).');
        }

        ActivityLogger::log('Hapus Pengguna', "Admin menghapus pengguna: {$user->name}");

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}

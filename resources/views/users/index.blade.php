<x-admin-layout>
    <x-slot name="title">Manajemen Pengguna</x-slot>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <h5 class="mb-0">
                <i class="bx bx-user-circle me-2"></i>
                Manajemen Pengguna
            </h5>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Pengguna
            </a>
        </div>
        <div class="card-body">
            <!-- Filter -->
            <form action="{{ route('users.index') }}" method="GET" class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-12 col-md-3">
                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>
                        <option value="admin_puskesmas" {{ request('role') == 'admin_puskesmas' ? 'selected' : '' }}>Admin Puskesmas</option>
                        <option value="kader" {{ request('role') == 'kader' ? 'selected' : '' }}>Kader</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <select name="posyandu_id" class="form-select">
                        <option value="">Semua Posyandu</option>
                        @foreach($posyandus as $posyandu)
                            <option value="{{ $posyandu->id }}" {{ request('posyandu_id') == $posyandu->id ? 'selected' : '' }}>
                                {{ $posyandu->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bx bx-search"></i> Cari
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Posyandu</th>
                            <th>NIP</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                    @if($user->telepon)
                                        <br><small class="text-muted">{{ $user->telepon }}</small>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->isAdmin() ? 'primary' : 'info' }}">
                                        {{ $user->isAdmin() ? 'Admin Puskesmas' : 'Kader' }}
                                    </span>
                                </td>
                                <td>{{ $user->posyandu->nama ?? '-' }}</td>
                                <td>{{ $user->nip ?? '-' }}</td>
                                <td>
                                    @if($user->aktif)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('users.edit', $user) }}">
                                                    <i class="bx bx-edit me-2"></i> Edit
                                                </a>
                                            </li>
                                            @if($user->id !== auth()->id())
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" 
                                                      onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bx bx-trash me-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bx bx-info-circle bx-lg"></i>
                                    <p class="mb-0 mt-2">Belum ada data pengguna</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>

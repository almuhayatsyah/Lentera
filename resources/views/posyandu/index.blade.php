<x-admin-layout>
    <x-slot name="title">Data Posyandu</x-slot>
    <x-slot name="pageTitle">Data Posyandu</x-slot>
    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Posyandu</li>
    </x-slot>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">
                <i class="bx bx-building-house me-2"></i>
                Daftar Posyandu
            </h5>
            <a href="{{ route('posyandu.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Posyandu
            </a>
        </div>
        <div class="card-body">
            <!-- Search Form -->
            <form action="{{ route('posyandu.index') }}" method="GET" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari nama, desa, kecamatan..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        @if(request('search'))
                            <a href="{{ route('posyandu.index') }}" class="btn btn-outline-secondary">Reset</a>
                        @endif
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Posyandu</th>
                            <th>Desa</th>
                            <th>Kecamatan</th>
                            <th class="text-center">Jumlah Anak</th>
                            <th class="text-center">Jumlah Kader</th>
                            <th class="text-center">Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posyandus as $posyandu)
                            <tr>
                                <td>
                                    <strong>{{ $posyandu->nama }}</strong>
                                    @if($posyandu->kader_utama)
                                        <br><small class="text-muted">Kader: {{ $posyandu->kader_utama }}</small>
                                    @endif
                                </td>
                                <td>{{ $posyandu->desa }}</td>
                                <td>{{ $posyandu->kecamatan }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $posyandu->anaks_count }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $posyandu->users_count }}</span>
                                </td>
                                <td class="text-center">
                                    @if($posyandu->aktif)
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
                                                <a class="dropdown-item" href="{{ route('posyandu.show', $posyandu) }}">
                                                    <i class="bx bx-show me-2"></i> Lihat Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('posyandu.edit', $posyandu) }}">
                                                    <i class="bx bx-edit me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('posyandu.destroy', $posyandu) }}" method="POST" 
                                                      onsubmit="return confirm('Yakin ingin menghapus posyandu ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bx bx-trash me-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bx bx-info-circle bx-lg"></i>
                                    <p class="mb-0 mt-2">Belum ada data posyandu</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $posyandus->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>

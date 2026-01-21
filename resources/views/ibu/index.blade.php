<x-admin-layout>
    <x-slot name="title">Data Ibu</x-slot>
    <x-slot name="pageTitle">Data Ibu</x-slot>
    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Data Ibu</li>
    </x-slot>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <h5 class="mb-0">
                <i class="bx bx-female me-2"></i>
                Daftar Data Ibu
            </h5>
            <div class="d-flex gap-2">
                <a href="{{ route('export.ibu', request()->query()) }}" class="btn btn-success">
                    <i class="bx bx-download"></i> Export Excel
                </a>
                <a href="{{ route('ibu.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus"></i> Tambah Ibu
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter -->
            <form action="{{ route('ibu.index') }}" method="GET" class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIK..." 
                           value="{{ request('search') }}">
                </div>
                @if(auth()->user()->isAdmin())
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
                @endif
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bx bx-search"></i> Cari
                    </button>
                </div>
            </form>

            <!-- Mobile Card View -->
            <div class="d-md-none">
                @forelse($ibus as $ibu)
                    <div class="card mb-2">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">{{ $ibu->nama }}</h6>
                                    <small class="text-muted">
                                        NIK: {{ $ibu->nik }}<br>
                                        {{ $ibu->alamat_singkat }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-info">{{ $ibu->anaks_count }} anak</span>
                                </div>
                            </div>
                            <div class="mt-2 d-flex gap-2">
                                <a href="{{ route('ibu.show', $ibu) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                    <i class="bx bx-show"></i> Detail
                                </a>
                                <a href="{{ route('ibu.edit', $ibu) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bx bx-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bx bx-info-circle bx-lg"></i>
                        <p class="mb-0 mt-2">Belum ada data ibu</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th class="text-center">Jumlah Anak</th>
                            @if(auth()->user()->isAdmin())
                            <th>Posyandu</th>
                            @endif
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ibus as $ibu)
                            <tr>
                                <td><code>{{ $ibu->nik }}</code></td>
                                <td>
                                    <strong>{{ $ibu->nama }}</strong>
                                    @if($ibu->nama_suami)
                                        <br><small class="text-muted">Suami: {{ $ibu->nama_suami }}</small>
                                    @endif
                                </td>
                                <td>{{ $ibu->alamat_singkat }}</td>
                                <td>{{ $ibu->telepon ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $ibu->anaks_count }}</span>
                                </td>
                                @if(auth()->user()->isAdmin())
                                <td>{{ $ibu->posyandu->nama ?? '-' }}</td>
                                @endif
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('ibu.show', $ibu) }}">
                                                    <i class="bx bx-show me-2"></i> Lihat Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('anak.create', ['ibu_id' => $ibu->id]) }}">
                                                    <i class="bx bx-plus me-2"></i> Tambah Anak
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('ibu.edit', $ibu) }}">
                                                    <i class="bx bx-edit me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('ibu.destroy', $ibu) }}" method="POST" id="deleteFormIbu{{ $ibu->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="dropdown-item text-danger" onclick="confirmDeleteIbu({{ $ibu->id }})">
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
                                <td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}" class="text-center text-muted py-4">
                                    <i class="bx bx-info-circle bx-lg"></i>
                                    <p class="mb-0 mt-2">Belum ada data ibu</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $ibus->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">
                        <i class="bx bx-error-circle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bx bx-trash bx-lg text-danger mb-3"></i>
                    <p class="mb-0">Apakah Anda yakin ingin menghapus data ibu ini?</p>
                    <small class="text-muted">Data yang dihapus tidak dapat dikembalikan.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="bx bx-trash me-1"></i>Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let deleteIbuId = null;

        function confirmDeleteIbu(id) {
            deleteIbuId = id;
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (deleteIbuId) {
                document.getElementById('deleteFormIbu' + deleteIbuId).submit();
            }
        });
    </script>
    @endpush
</x-admin-layout>

<x-admin-layout>
    <x-slot name="title">Data Anak</x-slot>
    <x-slot name="pageTitle">Data Anak Balita</x-slot>
    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Data Anak</li>
    </x-slot>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <h5 class="mb-0">
                <i class="bx bx-child me-2"></i>
                Daftar Data Anak
            </h5>
            <div class="d-flex gap-2">
                <a href="{{ route('export.anak', request()->query()) }}" class="btn btn-success">
                    <i class="bx bx-download"></i> Export Excel
                </a>
                <a href="{{ route('anak.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus"></i> Tambah Anak
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter -->
            <form action="{{ route('anak.index') }}" method="GET" class="row g-3 mb-4">
                <div class="col-12 col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama anak..." 
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
                <div class="col-6 col-md-2">
                    <select name="jenis_kelamin" class="form-select">
                        <option value="">Semua JK</option>
                        <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bx bx-search"></i> Cari
                    </button>
                </div>
            </form>

            <!-- Mobile Card View -->
            <div class="d-md-none">
                @forelse($anaks as $anak)
                    <div class="card mb-2 {{ $anak->pengukuran_terakhir?->is_stunting ? 'border-warning' : '' }}">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $anak->nama }}</h6>
                                    <small class="text-muted">
                                        {{ $anak->jenis_kelamin_text }} • {{ $anak->usia_format }}<br>
                                        Ibu: {{ $anak->ibu->nama ?? '-' }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    @if($anak->pengukuran_terakhir)
                                        <span class="badge bg-{{ $anak->pengukuran_terakhir->status_gizi_color }}">
                                            {{ $anak->pengukuran_terakhir->status_gizi_label }}
                                        </span>
                                        @if($anak->pengukuran_terakhir->is_stunting)
                                            <br><span class="badge bg-warning mt-1">Stunting</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Belum ada data</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2 d-flex gap-2">
                                <a href="{{ route('anak.show', $anak) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                    <i class="bx bx-show"></i> Detail
                                </a>
                                <a href="{{ route('kunjungan.wizard.anak', $anak) }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-plus"></i> Kunjungan
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bx bx-info-circle bx-lg"></i>
                        <p class="mb-0 mt-2">Belum ada data anak</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Anak</th>
                            <th>JK</th>
                            <th>Tgl Lahir</th>
                            <th>Usia</th>
                            <th>Nama Ibu</th>
                            <th>Status Gizi</th>
                            @if(auth()->user()->isAdmin())
                            <th>Posyandu</th>
                            @endif
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anaks as $anak)
                            <tr class="{{ $anak->pengukuran_terakhir?->is_stunting ? 'table-warning' : '' }}">
                                <td><strong>{{ $anak->nama }}</strong></td>
                                <td>
                                    <span class="badge bg-{{ $anak->jenis_kelamin == 'L' ? 'info' : 'pink' }}">
                                        {{ $anak->jenis_kelamin }}
                                    </span>
                                </td>
                                <td>{{ $anak->tanggal_lahir->format('d/m/Y') }}</td>
                                <td>{{ $anak->usia_format }}</td>
                                <td>{{ $anak->ibu->nama ?? '-' }}</td>
                                <td>
                                    @if($anak->pengukuran_terakhir)
                                        <span class="badge bg-{{ $anak->pengukuran_terakhir->status_gizi_color }}">
                                            {{ $anak->pengukuran_terakhir->status_gizi_label }}
                                        </span>
                                        @if($anak->pengukuran_terakhir->is_stunting)
                                            <span class="badge bg-warning">Stunting</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                @if(auth()->user()->isAdmin())
                                <td>{{ $anak->posyandu->nama ?? '-' }}</td>
                                @endif
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('kunjungan.wizard.anak', $anak) }}">
                                                    <i class="bx bx-plus me-2"></i> Kunjungan Baru
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('anak.show', $anak) }}">
                                                    <i class="bx bx-show me-2"></i> Lihat Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('anak.riwayat', $anak) }}">
                                                    <i class="bx bx-history me-2"></i> Riwayat
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('anak.edit', $anak) }}">
                                                    <i class="bx bx-edit me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('anak.destroy', $anak) }}" method="POST" 
                                                      onsubmit="return confirm('Yakin ingin menghapus data anak ini?')">
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
                                <td colspan="{{ auth()->user()->isAdmin() ? 8 : 7 }}" class="text-center text-muted py-4">
                                    <i class="bx bx-info-circle bx-lg"></i>
                                    <p class="mb-0 mt-2">Belum ada data anak</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $anaks->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>

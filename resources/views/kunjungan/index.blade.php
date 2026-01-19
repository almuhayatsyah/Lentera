<x-admin-layout>
    <x-slot name="title">Riwayat Kunjungan</x-slot>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <h5 class="mb-0">
                <i class="bx bx-history me-2"></i>
                Riwayat Kunjungan
            </h5>
            <div class="d-flex gap-2">
                <a href="{{ route('kunjungan.wizard') }}" class="btn btn-primary">
                    <i class="bx bx-plus-circle"></i> Tambah Kunjungan
                </a>
                <a href="{{ route('export.kunjungan', request()->query()) }}" class="btn btn-success">
                    <i class="bx bx-download"></i> Export Excel
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter -->
            <form action="{{ route('kunjungan.index') }}" method="GET" class="row g-3 mb-4">
                <div class="col-12 col-md-3">
                    <label class="form-label small">Bulan</label>
                    <input type="month" name="bulan" class="form-control" 
                           value="{{ request('bulan', date('Y-m')) }}">
                </div>
                @if(auth()->user()->isAdmin())
                <div class="col-12 col-md-3">
                    <label class="form-label small">Posyandu</label>
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
                <div class="col-12 col-md-3">
                    <label class="form-label small">Status Gizi</label>
                    <select name="status_gizi" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="gizi_baik" {{ request('status_gizi') == 'gizi_baik' ? 'selected' : '' }}>Gizi Baik</option>
                        <option value="gizi_kurang" {{ request('status_gizi') == 'gizi_kurang' ? 'selected' : '' }}>Gizi Kurang</option>
                        <option value="gizi_buruk" {{ request('status_gizi') == 'gizi_buruk' ? 'selected' : '' }}>Gizi Buruk</option>
                    </select>
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bx bx-filter"></i> Filter
                    </button>
                </div>
            </form>

            <!-- Mobile Card View -->
            <div class="d-md-none">
                @forelse($kunjungans as $kunjungan)
                    <div class="card mb-2">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">{{ $kunjungan->anak->nama ?? '-' }}</h6>
                                    <small class="text-muted">
                                        {{ $kunjungan->tanggal_format }}<br>
                                        {{ $kunjungan->posyandu->nama ?? '-' }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    @if($kunjungan->pengukuran)
                                        <span class="badge bg-{{ $kunjungan->pengukuran->status_gizi_color }}">
                                            {{ $kunjungan->pengukuran->status_gizi_label }}
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            {{ $kunjungan->pengukuran->berat_badan }} kg / {{ $kunjungan->pengukuran->tinggi_badan }} cm
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('kunjungan.show', $kunjungan) }}" class="btn btn-sm btn-outline-primary w-100">
                                    <i class="bx bx-show"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bx bx-info-circle bx-lg"></i>
                        <p>Tidak ada data kunjungan</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Anak</th>
                            <th>Usia</th>
                            <th>BB/TB</th>
                            <th>Status Gizi</th>
                            <th>Stunting</th>
                            <th>Pelayanan</th>
                            @if(auth()->user()->isAdmin())
                            <th>Posyandu</th>
                            @endif
                            <th>Petugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kunjungans as $kunjungan)
                            <tr>
                                <td>{{ $kunjungan->tanggal_format }}</td>
                                <td>
                                    <a href="{{ route('anak.show', $kunjungan->anak) }}">
                                        <strong>{{ $kunjungan->anak->nama ?? '-' }}</strong>
                                    </a>
                                </td>
                                <td>{{ $kunjungan->usia_bulan }} bln</td>
                                <td>
                                    @if($kunjungan->pengukuran)
                                        {{ $kunjungan->pengukuran->berat_badan }} / {{ $kunjungan->pengukuran->tinggi_badan }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($kunjungan->pengukuran)
                                        <span class="badge bg-{{ $kunjungan->pengukuran->status_gizi_color }}">
                                            {{ $kunjungan->pengukuran->status_gizi_label }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($kunjungan->pengukuran)
                                        @if($kunjungan->pengukuran->is_stunting)
                                            <span class="badge bg-warning">{{ $kunjungan->pengukuran->status_stunting_label }}</span>
                                        @else
                                            <span class="text-success">Normal</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($kunjungan->pelayanan)
                                        @if($kunjungan->pelayanan->vitamin_a)
                                            <span class="badge bg-danger me-1" title="Vitamin A">VA</span>
                                        @endif
                                        @if($kunjungan->pelayanan->pmt)
                                            <span class="badge bg-success me-1" title="PMT">PMT</span>
                                        @endif
                                        @if($kunjungan->pelayanan->imunisasi)
                                            <span class="badge bg-info" title="Imunisasi">IM</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                @if(auth()->user()->isAdmin())
                                <td>{{ $kunjungan->posyandu->nama ?? '-' }}</td>
                                @endif
                                <td>{{ $kunjungan->user->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('kunjungan.show', $kunjungan) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-show"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->isAdmin() ? 10 : 9 }}" class="text-center text-muted py-4">
                                    <i class="bx bx-info-circle bx-lg"></i>
                                    <p class="mb-0">Tidak ada data kunjungan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $kunjungans->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>

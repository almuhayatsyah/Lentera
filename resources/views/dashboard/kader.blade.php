<x-admin-layout>
    <x-slot name="title">Dashboard Kader</x-slot>

    <!-- Big Entry Button (Mobile First) -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('kunjungan.wizard') }}" class="btn btn-entry w-100 d-flex align-items-center justify-content-center gap-2 py-3">
                <i class="bx bx-plus-circle bx-lg"></i>
                <span class="fs-5">ENTRI DATA BARU</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-6 col-lg-3 mb-3">
            <div class="card card-hover h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-child"></i>
                            </span>
                        </div>
                        <div>
                            <span class="text-muted d-block mb-1">Total Anak</span>
                            <h4 class="mb-0">{{ $stats['total_anak'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
            <div class="card card-hover h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-calendar-check"></i>
                            </span>
                        </div>
                        <div>
                            <span class="text-muted d-block mb-1">Kunjungan Bulan Ini</span>
                            <h4 class="mb-0">{{ $stats['kunjungan_bulan_ini'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
            <div class="card card-hover h-100 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="bx bx-trending-down"></i>
                            </span>
                        </div>
                        <div>
                            <span class="text-muted d-block mb-1">Stunting</span>
                            <h4 class="mb-0 text-warning">{{ $stats['stunting'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
            <div class="card card-hover h-100 border-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="bx bx-error-circle"></i>
                            </span>
                        </div>
                        <div>
                            <span class="text-muted d-block mb-1">Gizi Kurang</span>
                            <h4 class="mb-0 text-danger">{{ $stats['gizi_kurang'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Visits & Children Not Yet Visited -->
    <div class="row">
        <!-- Children not yet visited this month -->
        <div class="col-12 col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="bx bx-user-x text-warning me-2"></i>
                        Belum Kunjungan Bulan Ini
                    </h5>
                    <span class="badge bg-warning">{{ $anakBelumKunjungan->count() }}</span>
                </div>
                <div class="card-body">
                    @if($anakBelumKunjungan->isEmpty())
                        <div class="text-center text-success py-4">
                            <i class="bx bx-check-circle bx-lg"></i>
                            <p class="mb-0 mt-2">Semua anak sudah dikunjungi bulan ini! 🎉</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($anakBelumKunjungan->take(5) as $anak)
                                <a href="{{ route('kunjungan.wizard.anak', $anak) }}" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $anak->nama }}</h6>
                                        <small class="text-muted">
                                            {{ $anak->jenis_kelamin_text }} • {{ $anak->usia_format }}
                                            <br>Ibu: {{ $anak->ibu->nama ?? '-' }}
                                        </small>
                                    </div>
                                    <span class="badge bg-primary">
                                        <i class="bx bx-plus"></i> Input
                                    </span>
                                </a>
                            @endforeach
                        </div>
                        @if($anakBelumKunjungan->count() > 5)
                            <div class="text-center mt-3">
                                <a href="{{ route('anak.index') }}" class="btn btn-sm btn-outline-primary">
                                    Lihat Semua ({{ $anakBelumKunjungan->count() - 5 }} lainnya)
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Today's visits -->
        <div class="col-12 col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="bx bx-calendar text-primary me-2"></i>
                        Kunjungan Hari Ini
                    </h5>
                    <span class="badge bg-primary">{{ $kunjunganHariIni->count() }}</span>
                </div>
                <div class="card-body">
                    @if($kunjunganHariIni->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="bx bx-calendar-x bx-lg"></i>
                            <p class="mb-0 mt-2">Belum ada kunjungan hari ini</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama Anak</th>
                                        <th>BB/TB</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kunjunganHariIni as $kunjungan)
                                        <tr>
                                            <td>
                                                <a href="{{ route('kunjungan.show', $kunjungan) }}">
                                                    {{ $kunjungan->anak->nama }}
                                                </a>
                                            </td>
                                            <td>
                                                @if($kunjungan->pengukuran)
                                                    {{ $kunjungan->pengukuran->berat_badan }} kg / 
                                                    {{ $kunjungan->pengukuran->tinggi_badan }} cm
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($kunjungan->pengukuran)
                                                    <span class="badge bg-{{ $kunjungan->pengukuran->status_gizi_color }}">
                                                        {{ $kunjungan->pengukuran->status_gizi_label }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- All Children List (Card View for Mobile) -->
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">
                <i class="bx bx-list-ul me-2"></i>
                Daftar Anak - {{ $posyandu->nama }}
            </h5>
            <a href="{{ route('anak.create') }}" class="btn btn-sm btn-primary">
                <i class="bx bx-plus"></i> Tambah Anak
            </a>
        </div>
        <div class="card-body">
            <!-- Mobile: Card View -->
            <div class="d-md-none">
                @foreach($anaks as $anak)
                    <div class="card mb-2 {{ $anak->pengukuran_terakhir?->is_stunting ? 'border-warning' : '' }}">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $anak->nama }}</h6>
                                    <small class="text-muted">
                                        {{ $anak->jenis_kelamin_text }} • {{ $anak->usia_format }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    @if($anak->pengukuran_terakhir)
                                        <span class="badge bg-{{ $anak->pengukuran_terakhir->status_gizi_color }} mb-1">
                                            {{ $anak->pengukuran_terakhir->status_gizi_label }}
                                        </span>
                                        @if($anak->pengukuran_terakhir->is_stunting)
                                            <br><span class="badge bg-warning">Stunting</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Belum ada data</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2 d-flex gap-2">
                                <a href="{{ route('kunjungan.wizard.anak', $anak) }}" class="btn btn-sm btn-primary flex-grow-1">
                                    <i class="bx bx-plus"></i> Kunjungan
                                </a>
                                <a href="{{ route('anak.show', $anak) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bx bx-info-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop: Table View -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>Usia</th>
                            <th>Ibu</th>
                            <th>Status Terakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anaks as $anak)
                            <tr>
                                <td>{{ $anak->nama }}</td>
                                <td>{{ $anak->jenis_kelamin }}</td>
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
                                                    <i class="bx bx-info-circle me-2"></i> Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('anak.riwayat', $anak) }}">
                                                    <i class="bx bx-history me-2"></i> Riwayat
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>

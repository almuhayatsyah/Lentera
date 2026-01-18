<x-admin-layout>
    <x-slot name="title">Dashboard Admin</x-slot>

    <!-- Welcome Banner -->
    <div class="card bg-primary mb-4">
        <div class="card-body p-3 p-md-4">
            <div class="row align-items-center">
                <div class="col-8 col-md-8">
                    <div class="d-flex align-items-center">
                        @if(auth()->user()->photo_url)
                            <a href="{{ route('profile.edit') }}" title="Lihat Profil" class="flex-shrink-0">
                                <img src="{{ auth()->user()->photo_url }}" alt="{{ auth()->user()->name }}" 
                                     class="rounded-circle me-2 me-md-3" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid rgba(255,255,255,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            </a>
                        @else
                            <a href="{{ route('profile.edit') }}" class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center me-2 me-md-3 text-decoration-none flex-shrink-0" 
                                 style="width: 50px; height: 50px; transition: transform 0.2s;" title="Lihat Profil" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                <span class="text-white fs-5 fw-bold">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                            </a>
                        @endif
                        <div class="text-white overflow-hidden">
                            <p class="mb-0 opacity-75 small">
                                @php
                                    $hour = now()->hour;
                                    $greeting = $hour < 12 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
                                @endphp
                                {{ $greeting }},
                            </p>
                            <h5 class="mb-1 text-white fw-bold text-truncate" style="font-size: clamp(0.9rem, 3vw, 1.25rem);">{{ auth()->user()->name }}</h5>
                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                <span class="badge bg-light text-primary" style="font-size: 0.65rem;">
                                    {{ auth()->user()->role_label }}
                                </span>
                                <span class="badge bg-warning text-dark d-flex align-items-center" style="font-size: 0.65rem;">
                                    <img src="{{ asset('assets/img/favicon/logo.png') }}" alt="" height="12" class="me-1">
                                    v1.0.0
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-md-4 text-end">
                    <a href="{{ route('kunjungan.wizard') }}" class="btn btn-light btn-sm btn-md-lg">
                        <i class="bx bx-plus-circle"></i>
                        <span class="d-none d-md-inline ms-1">Kunjungan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row mb-4">
        <div class="col-6 col-lg-3 mb-3">
            <div class="card card-hover h-100">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-2 me-md-3">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-child"></i>
                            </span>
                        </div>
                        <div class="overflow-hidden">
                            <span class="text-muted d-block mb-1 small text-truncate">Total Balita</span>
                            <h4 class="mb-0">{{ $totalAnak }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
            <div class="card card-hover h-100">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-2 me-md-3">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-calendar-check"></i>
                            </span>
                        </div>
                        <div class="overflow-hidden">
                            <span class="text-muted d-block mb-1 small text-truncate">Kunjungan</span>
                            <h4 class="mb-0">{{ $totalKunjunganBulanIni }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
            <div class="card card-hover h-100 border-warning">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-2 me-md-3">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="bx bx-trending-down"></i>
                            </span>
                        </div>
                        <div class="overflow-hidden">
                            <span class="text-muted d-block mb-1 small text-truncate">Stunting</span>
                            <h4 class="mb-0 text-warning">{{ $stuntingCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
            <div class="card card-hover h-100 border-danger">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-2 me-md-3">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="bx bx-error-circle"></i>
                            </span>
                        </div>
                        <div class="overflow-hidden">
                            <span class="text-muted d-block mb-1 small text-truncate">Gizi Buruk</span>
                            <h4 class="mb-0 text-danger">{{ $underweightCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Status Distribution -->
        <div class="col-12 col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-pie-chart-alt-2 me-2"></i>
                        Distribusi Status Gizi Bulan Ini
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 col-md-3 mb-3">
                            <div class="p-3 rounded bg-light-success">
                                <h3 class="text-success mb-1">{{ $statusDistribution['gizi_baik'] }}</h3>
                                <small>Gizi Baik</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="p-3 rounded bg-light-warning">
                                <h3 class="text-warning mb-1">{{ $statusDistribution['gizi_kurang'] }}</h3>
                                <small>Gizi Kurang</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="p-3 rounded bg-light-danger">
                                <h3 class="text-danger mb-1">{{ $statusDistribution['gizi_buruk'] }}</h3>
                                <small>Gizi Buruk</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="p-3 rounded bg-light-info">
                                <h3 class="text-info mb-1">{{ $statusDistribution['gizi_lebih'] }}</h3>
                                <small>Gizi Lebih</small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="p-3 rounded bg-light-warning">
                                <h3 class="text-warning mb-1">{{ $statusDistribution['stunting'] }}</h3>
                                <small>Stunting</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded bg-light-success">
                                <h3 class="text-success mb-1">{{ $statusDistribution['normal'] }}</h3>
                                <small>Tinggi Normal</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Sebaran Posyandu -->
        <div class="col-12 col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="bx bx-map me-2"></i>
                        Peta Sebaran Posyandu
                    </h5>
                    <a href="{{ route('laporan.sebaran') }}" class="btn btn-sm btn-outline-primary">
                        Detail
                    </a>
                </div>
                <div class="card-body p-0">
                    <div id="dashboardMap" style="height: 300px; border-radius: 0 0 8px 8px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stunting Trend Chart Row -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-line-chart me-2"></i>
                        Tren Stunting & Gizi Kurang (6 Bulan Terakhir)
                    </h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="stuntingTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Posyandu Table Row -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="bx bx-building-house me-2"></i>
                        Ringkasan Per Posyandu
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Posyandu</th>
                                    <th class="text-center">Anak</th>
                                    <th class="text-center">Kunjungan</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posyandus as $posyandu)
                                    <tr>
                                        <td>
                                            <a href="{{ route('posyandu.show', $posyandu) }}">
                                                {{ $posyandu->nama }}
                                            </a>
                                            <br>
                                            <small class="text-muted">{{ $posyandu->desa }}</small>
                                        </td>
                                        <td class="text-center">{{ $posyandu->anaks_count }}</td>
                                        <td class="text-center">{{ $posyandu->kunjungans_count }}</td>
                                        <td class="text-center">
                                            @php
                                                $stuntingRate = $posyandu->stunting_rate ?? 0;
                                                $color = $stuntingRate > 20 ? 'danger' : ($stuntingRate > 10 ? 'warning' : 'success');
                                            @endphp
                                            <span class="badge bg-{{ $color }}">
                                                {{ $stuntingRate }}% Stunting
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Visits -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="bx bx-history me-2"></i>
                        Kunjungan Terbaru
                    </h5>
                    <a href="{{ route('kunjungan.history') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Anak</th>
                                    <th>Posyandu</th>
                                    <th>BB/TB</th>
                                    <th>Status</th>
                                    <th>Petugas</th>
                                </tr>
                            </thead>
                            <tbody>
                        @forelse($recentKunjungans as $kunjungan)
                            <tr>
                                <td>{{ $kunjungan->tanggal_format }}</td>
                                <td>
                                    <a href="{{ route('anak.show', $kunjungan->anak) }}">
                                        {{ $kunjungan->anak->nama }}
                                    </a>
                                </td>
                                <td>{{ $kunjungan->posyandu->nama ?? '-' }}</td>
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
                                        @if($kunjungan->pengukuran->is_stunting)
                                            <span class="badge bg-warning">Stunting</span>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $kunjungan->user->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada data kunjungan
                                </td>
                            </tr>
                        @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex flex-nowrap gap-2 overflow-auto pb-2">
                <a href="{{ route('laporan.skdn') }}" class="card card-hover text-decoration-none flex-shrink-0" style="min-width: 100px;">
                    <div class="card-body text-center p-2 p-md-3">
                        <i class="bx bx-file text-primary fs-4 mb-1"></i>
                        <p class="mb-0 small text-truncate">SKDN</p>
                    </div>
                </a>
                <a href="{{ route('users.index') }}" class="card card-hover text-decoration-none flex-shrink-0" style="min-width: 100px;">
                    <div class="card-body text-center p-2 p-md-3">
                        <i class="bx bx-user-circle text-info fs-4 mb-1"></i>
                        <p class="mb-0 small text-truncate">Pengguna</p>
                    </div>
                </a>
                <a href="{{ route('posyandu.index') }}" class="card card-hover text-decoration-none flex-shrink-0" style="min-width: 100px;">
                    <div class="card-body text-center p-2 p-md-3">
                        <i class="bx bx-building-house text-success fs-4 mb-1"></i>
                        <p class="mb-0 small text-truncate">Posyandu</p>
                    </div>
                </a>
                <a href="{{ route('anak.index') }}" class="card card-hover text-decoration-none flex-shrink-0" style="min-width: 100px;">
                    <div class="card-body text-center p-2 p-md-3">
                        <i class="bx bx-child text-warning fs-4 mb-1"></i>
                        <p class="mb-0 small text-truncate">Data Anak</p>
                    </div>
                </a>
                <a href="{{ route('ibu.index') }}" class="card card-hover text-decoration-none flex-shrink-0" style="min-width: 100px;">
                    <div class="card-body text-center p-2 p-md-3">
                        <i class="bx bx-female text-danger fs-4 mb-1"></i>
                        <p class="mb-0 small text-truncate">Data Ibu</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #dashboardMap { z-index: 1; }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ========== Stunting Trend Chart ==========
            const stuntingTrendData = @json($stuntingTrend);
            
            const ctx = document.getElementById('stuntingTrendChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: stuntingTrendData.map(d => d.label),
                        datasets: [
                            {
                                label: 'Stunting (%)',
                                data: stuntingTrendData.map(d => d.stunting_rate),
                                borderColor: '#f9a825',
                                backgroundColor: 'rgba(249, 168, 37, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#f9a825',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 5,
                                pointHoverRadius: 7
                            },
                            {
                                label: 'Gizi Kurang/Buruk (%)',
                                data: stuntingTrendData.map(d => d.gizi_buruk_rate),
                                borderColor: '#e63946',
                                backgroundColor: 'rgba(230, 57, 70, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#e63946',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 5,
                                pointHoverRadius: 7
                            },
                            {
                                label: 'Total Kunjungan',
                                data: stuntingTrendData.map(d => d.total),
                                borderColor: '#1e5799',
                                backgroundColor: 'transparent',
                                borderWidth: 2,
                                borderDash: [5, 5],
                                fill: false,
                                tension: 0.4,
                                pointRadius: 3,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 15
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 12,
                                callbacks: {
                                    label: function(context) {
                                        if (context.dataset.yAxisID === 'y1') {
                                            return context.dataset.label + ': ' + context.parsed.y + ' kunjungan';
                                        }
                                        return context.dataset.label + ': ' + context.parsed.y + '%';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                beginAtZero: true,
                                max: 100,
                                title: {
                                    display: true,
                                    text: 'Persentase (%)'
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Kunjungan'
                                },
                                grid: {
                                    drawOnChartArea: false
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // ========== Map Section ==========
            // Build posyandus array from PHP
            const posyandus = [
                @foreach($posyandus as $p)
                {
                    id: {{ $p->id }},
                    nama: "{{ addslashes($p->nama) }}",
                    desa: "{{ addslashes($p->desa ?? '') }}",
                    latitude: {{ $p->latitude ?? 'null' }},
                    longitude: {{ $p->longitude ?? 'null' }},
                    anaks_count: {{ $p->anaks_count ?? 0 }},
                    stunting_rate: {{ $p->stunting_rate ?? 0 }}
                },
                @endforeach
            ];
            
            let validPosyandus = posyandus.filter(p => p.latitude && p.longitude);
            let centerLat = -6.9175, centerLng = 107.6200;
            
            if (validPosyandus.length > 0) {
                centerLat = validPosyandus.reduce((sum, p) => sum + parseFloat(p.latitude), 0) / validPosyandus.length;
                centerLng = validPosyandus.reduce((sum, p) => sum + parseFloat(p.longitude), 0) / validPosyandus.length;
            }
            
            const map = L.map('dashboardMap').setView([centerLat, centerLng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OSM' }).addTo(map);
            
            const getMarkerIcon = (rate) => {
                let color = rate > 20 ? '#ea5455' : (rate > 10 ? '#ff9f43' : '#28c76f');
                return L.divIcon({
                    className: 'custom-marker',
                    html: '<div style="background:' + color + ';width:24px;height:24px;border-radius:50%;border:2px solid white;box-shadow:0 2px 5px rgba(0,0,0,0.3);"></div>',
                    iconSize: [24, 24], iconAnchor: [12, 12], popupAnchor: [0, -12]
                });
            };
            
            posyandus.forEach(p => {
                if (p.latitude && p.longitude) {
                    L.marker([parseFloat(p.latitude), parseFloat(p.longitude)], { icon: getMarkerIcon(p.stunting_rate) })
                        .addTo(map)
                        .bindPopup('<strong>' + p.nama + '</strong><br><small>' + p.desa + '</small><br><small>Balita: ' + p.anaks_count + ' | Stunting: ' + p.stunting_rate + '%</small>');
                }
            });
            
            if (validPosyandus.length > 0) {
                const bounds = L.latLngBounds(validPosyandus.map(p => [parseFloat(p.latitude), parseFloat(p.longitude)]));
                map.fitBounds(bounds, { padding: [30, 30] });
            }
        });
    </script>
    @endpush
</x-admin-layout>

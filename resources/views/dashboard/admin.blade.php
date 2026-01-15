<x-admin-layout>
    <x-slot name="title">Dashboard Admin</x-slot>

    <!-- Summary Stats -->
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
                            <span class="text-muted d-block mb-1">Total Balita</span>
                            <h4 class="mb-0">{{ $totalAnak }}</h4>
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
                            <h4 class="mb-0">{{ $totalKunjunganBulanIni }}</h4>
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
                            <span class="text-muted d-block mb-1">Kasus Stunting</span>
                            <h4 class="mb-0 text-warning">{{ $stuntingCount }}</h4>
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
                            <span class="text-muted d-block mb-1">Gizi Kurang/Buruk</span>
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

    <!-- Recent Visits -->
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

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12 col-md-4 mb-3">
            <a href="{{ route('laporan.skdn') }}" class="card card-hover text-decoration-none">
                <div class="card-body text-center py-4">
                    <i class="bx bx-file text-primary bx-lg mb-2"></i>
                    <h6 class="mb-0">Laporan SKDN</h6>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <a href="{{ route('users.index') }}" class="card card-hover text-decoration-none">
                <div class="card-body text-center py-4">
                    <i class="bx bx-user-circle text-info bx-lg mb-2"></i>
                    <h6 class="mb-0">Manajemen Pengguna</h6>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <a href="{{ route('posyandu.index') }}" class="card card-hover text-decoration-none">
                <div class="card-body text-center py-4">
                    <i class="bx bx-building-house text-success bx-lg mb-2"></i>
                    <h6 class="mb-0">Manajemen Posyandu</h6>
                </div>
            </a>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

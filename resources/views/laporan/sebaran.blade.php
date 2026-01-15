<x-admin-layout>
    <x-slot name="title">Peta Sebaran Status Gizi</x-slot>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            height: 450px;
            border-radius: 8px;
            z-index: 1;
        }
        .legend {
            padding: 10px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.4);
            line-height: 24px;
        }
        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            border-radius: 50%;
        }
        .marker-cluster-success { background-color: rgba(40, 199, 111, 0.6); }
        .marker-cluster-warning { background-color: rgba(255, 159, 67, 0.6); }
        .marker-cluster-danger { background-color: rgba(234, 84, 85, 0.6); }
    </style>
    @endpush

    <div class="row mb-4">
        <!-- Summary Cards -->
        <div class="col-6 col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3 class="mb-2">{{ $summary['total_posyandu'] }}</h3>
                    <small>Posyandu</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3 class="mb-2">{{ $summary['total_anak'] }}</h3>
                    <small>Total Balita</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3 class="mb-2">{{ $summary['posyandu_hijau'] }}</h3>
                    <small>Posyandu Hijau</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-4">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h3 class="mb-2">{{ $summary['posyandu_merah'] }}</h3>
                    <small>Posyandu Merah</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Card -->
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <h5 class="mb-0">
                    <i class="bx bx-map me-2"></i>
                    Peta Sebaran Posyandu
                </h5>
                <!-- Filter -->
                <form action="{{ route('laporan.sebaran') }}" method="GET" class="d-flex gap-2">
                    <select name="bulan" class="form-select form-select-sm" style="width: auto;">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="tahun" class="form-select form-select-sm" style="width: auto;">
                        @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bx bx-filter"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div id="map"></div>
        </div>
    </div>

    <!-- Posyandu Detail Cards -->
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Detail per Posyandu</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($posyandus as $posyandu)
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <div class="card border-{{ $posyandu['status_color'] }} h-100">
                            <div class="card-header bg-{{ $posyandu['status_color'] }} text-white py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>{{ $posyandu['nama'] }}</strong>
                                    <span class="badge bg-white text-{{ $posyandu['status_color'] }}">
                                        {{ $posyandu['stunting_rate'] }}% Stunting
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td class="text-muted">Desa</td>
                                        <td>{{ $posyandu['desa'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Total Balita</td>
                                        <td><strong>{{ $posyandu['total_anak'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Ditimbang Bulan Ini</td>
                                        <td>{{ $posyandu['kunjungan_bulan_ini'] }}</td>
                                    </tr>
                                </table>
                                <hr class="my-2">
                                <div class="row text-center small">
                                    <div class="col-4">
                                        <span class="text-success fw-bold">{{ $posyandu['status']['gizi']['baik'] }}</span>
                                        <br>Gizi Baik
                                    </div>
                                    <div class="col-4">
                                        <span class="text-warning fw-bold">{{ $posyandu['status']['gizi']['kurang'] }}</span>
                                        <br>Gizi Kurang
                                    </div>
                                    <div class="col-4">
                                        <span class="text-danger fw-bold">{{ $posyandu['status']['gizi']['buruk'] }}</span>
                                        <br>Gizi Buruk
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-4">
                        <i class="bx bx-info-circle bx-lg"></i>
                        <p>Tidak ada data posyandu</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Posyandu data from backend
            const posyandus = @json($posyandus);
            
            // Find center point (average of all coordinates)
            let validPosyandus = posyandus.filter(p => p.latitude && p.longitude);
            let centerLat = -6.9175;
            let centerLng = 107.6200;
            
            if (validPosyandus.length > 0) {
                centerLat = validPosyandus.reduce((sum, p) => sum + parseFloat(p.latitude), 0) / validPosyandus.length;
                centerLng = validPosyandus.reduce((sum, p) => sum + parseFloat(p.longitude), 0) / validPosyandus.length;
            }
            
            // Initialize map
            const map = L.map('map').setView([centerLat, centerLng], 14);
            
            // Add OpenStreetMap tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Custom marker icons
            const getMarkerIcon = (color) => {
                const colors = {
                    success: '#28c76f',
                    warning: '#ff9f43',
                    danger: '#ea5455'
                };
                
                return L.divIcon({
                    className: 'custom-marker',
                    html: `<div style="
                        background-color: ${colors[color] || colors.success};
                        width: 30px;
                        height: 30px;
                        border-radius: 50%;
                        border: 3px solid white;
                        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: white;
                        font-weight: bold;
                        font-size: 12px;
                    "><i class="bx bx-plus"></i></div>`,
                    iconSize: [30, 30],
                    iconAnchor: [15, 15],
                    popupAnchor: [0, -15]
                });
            };
            
            // Add markers for each posyandu
            posyandus.forEach(posyandu => {
                if (posyandu.latitude && posyandu.longitude) {
                    const marker = L.marker(
                        [parseFloat(posyandu.latitude), parseFloat(posyandu.longitude)],
                        { icon: getMarkerIcon(posyandu.status_color) }
                    ).addTo(map);
                    
                    // Popup content
                    const popupContent = `
                        <div style="min-width: 200px;">
                            <h6 class="mb-2">${posyandu.nama}</h6>
                            <p class="mb-1 text-muted small">${posyandu.desa}, ${posyandu.kecamatan}</p>
                            <hr class="my-2">
                            <table class="table table-sm table-borderless mb-0" style="font-size: 12px;">
                                <tr>
                                    <td>Total Balita</td>
                                    <td><strong>${posyandu.total_anak}</strong></td>
                                </tr>
                                <tr>
                                    <td>Ditimbang</td>
                                    <td>${posyandu.kunjungan_bulan_ini}</td>
                                </tr>
                                <tr>
                                    <td>Rate Stunting</td>
                                    <td><span class="badge bg-${posyandu.status_color}">${posyandu.stunting_rate}%</span></td>
                                </tr>
                            </table>
                            <hr class="my-2">
                            <small>
                                <span class="text-success">Baik: ${posyandu.status.gizi.baik}</span> |
                                <span class="text-warning">Kurang: ${posyandu.status.gizi.kurang}</span> |
                                <span class="text-danger">Buruk: ${posyandu.status.gizi.buruk}</span>
                            </small>
                        </div>
                    `;
                    
                    marker.bindPopup(popupContent);
                }
            });
            
            // Add legend
            const legend = L.control({ position: 'bottomright' });
            legend.onAdd = function(map) {
                const div = L.DomUtil.create('div', 'legend');
                div.innerHTML = `
                    <div style="margin-bottom: 5px;"><strong>Keterangan</strong></div>
                    <div><i style="background: #28c76f;"></i> Stunting &lt; 10%</div>
                    <div><i style="background: #ff9f43;"></i> Stunting 10-20%</div>
                    <div><i style="background: #ea5455;"></i> Stunting &gt; 20%</div>
                `;
                return div;
            };
            legend.addTo(map);
            
            // Fit map to show all markers if there are valid positions
            if (validPosyandus.length > 0) {
                const bounds = L.latLngBounds(validPosyandus.map(p => [parseFloat(p.latitude), parseFloat(p.longitude)]));
                map.fitBounds(bounds, { padding: [50, 50] });
            }
        });
    </script>
    @endpush
</x-admin-layout>

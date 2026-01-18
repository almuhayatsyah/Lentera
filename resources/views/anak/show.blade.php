<x-admin-layout>
    <x-slot name="title">Detail Anak</x-slot>

    <div class="row">
        <div class="col-12 col-lg-4 mb-4">
            <!-- Profile Card -->
            <div class="card">
                <div class="card-body text-center pt-4">
                    <div class="avatar avatar-xl mb-3">
                        @if($anak->foto)
                            <img src="{{ asset('storage/'.$anak->foto) }}" alt="{{ $anak->nama }}" 
                                 class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                        @else
                            <span class="avatar-initial rounded-circle bg-{{ $anak->jenis_kelamin == 'L' ? 'info' : 'pink' }}" 
                                  style="width: 80px; height: 80px; font-size: 2rem;">
                                {{ strtoupper(substr($anak->nama, 0, 2)) }}
                            </span>
                        @endif
                    </div>
                    <h4 class="mb-1">{{ $anak->nama }}</h4>
                    <p class="text-muted mb-2">{{ $anak->jenis_kelamin_text }} • {{ $anak->usia_format }}</p>
                    
                    @if($anak->pengukuran_terakhir)
                        <div class="mb-3">
                            <span class="badge bg-{{ $anak->pengukuran_terakhir->status_gizi_color }} fs-6">
                                {{ $anak->pengukuran_terakhir->status_gizi_label }}
                            </span>
                            @if($anak->pengukuran_terakhir->is_stunting)
                                <span class="badge bg-warning fs-6">Stunting</span>
                            @endif
                        </div>
                    @endif

                    <a href="{{ route('kunjungan.wizard.anak', $anak) }}" class="btn btn-primary w-100 mb-2">
                        <i class="bx bx-plus"></i> Kunjungan Baru
                    </a>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Informasi Anak</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="45%">NIK</td>
                            <td><code>{{ $anak->nik ?? '-' }}</code></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal Lahir</td>
                            <td>{{ $anak->tanggal_lahir->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tempat Lahir</td>
                            <td>{{ $anak->tempat_lahir ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nama Ibu</td>
                            <td>
                                <a href="{{ route('ibu.show', $anak->ibu) }}">{{ $anak->ibu->nama ?? '-' }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Posyandu</td>
                            <td>{{ $anak->posyandu->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Anak ke-</td>
                            <td>{{ $anak->urutan_anak ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Birth Data Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Data Kelahiran</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <h5 class="mb-0">{{ $anak->berat_lahir ?? '-' }}</h5>
                            <small class="text-muted">BB (kg)</small>
                        </div>
                        <div class="col-4">
                            <h5 class="mb-0">{{ $anak->panjang_lahir ?? '-' }}</h5>
                            <small class="text-muted">PB (cm)</small>
                        </div>
                        <div class="col-4">
                            <h5 class="mb-0">{{ $anak->lingkar_kepala_lahir ?? '-' }}</h5>
                            <small class="text-muted">LK (cm)</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('anak.edit', $anak) }}" class="btn btn-outline-primary">
                    <i class="bx bx-edit"></i> Edit
                </a>
                <a href="{{ route('anak.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <!-- Latest Measurement -->
            @if($anak->pengukuran_terakhir)
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bx bx-stats me-2"></i>
                        Pengukuran Terakhir
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 col-md-3 mb-3">
                            <h4 class="text-primary mb-0">{{ $anak->pengukuran_terakhir->berat_badan }}</h4>
                            <small class="text-muted">Berat (kg)</small>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <h4 class="text-primary mb-0">{{ $anak->pengukuran_terakhir->tinggi_badan }}</h4>
                            <small class="text-muted">Tinggi (cm)</small>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <h4 class="text-primary mb-0">{{ $anak->pengukuran_terakhir->lingkar_kepala ?? '-' }}</h4>
                            <small class="text-muted">LK (cm)</small>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <h4 class="text-primary mb-0">{{ number_format($anak->pengukuran_terakhir->bmi, 1) }}</h4>
                            <small class="text-muted">BMI</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-4">
                            <small class="text-muted d-block">Z-Score BB/U</small>
                            <strong>{{ number_format($anak->pengukuran_terakhir->zscore_bb_u, 2) }}</strong>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Z-Score TB/U</small>
                            <strong>{{ number_format($anak->pengukuran_terakhir->zscore_tb_u, 2) }}</strong>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Z-Score BB/TB</small>
                            <strong>{{ number_format($anak->pengukuran_terakhir->zscore_bb_tb, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Growth Chart -->
            @if($anak->pengukurans->count() > 1)
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bx bx-line-chart me-2"></i>
                        Grafik Pertumbuhan
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#chartBB" type="button">Berat Badan</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#chartTB" type="button">Tinggi Badan</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#chartAll" type="button">Semua</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-3">
                        <div class="tab-pane fade show active" id="chartBB">
                            <div style="height: 250px;">
                                <canvas id="weightChart"></canvas>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="chartTB">
                            <div style="height: 250px;">
                                <canvas id="heightChart"></canvas>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="chartAll">
                            <div style="height: 250px;">
                                <canvas id="combinedChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Visit History -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">
                        <i class="bx bx-history me-2"></i>
                        Riwayat Kunjungan
                    </h6>
                    <a href="{{ route('anak.riwayat', $anak) }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($anak->kunjungans->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="bx bx-calendar-x bx-lg"></i>
                            <p class="mb-0 mt-2">Belum ada riwayat kunjungan</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Usia</th>
                                        <th>BB/TB</th>
                                        <th>Status</th>
                                        <th>Petugas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($anak->kunjungans->take(5) as $kunjungan)
                                        <tr>
                                            <td>
                                                <a href="{{ route('kunjungan.show', $kunjungan) }}">
                                                    {{ $kunjungan->tanggal_format }}
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
                                                @endif
                                            </td>
                                            <td>{{ $kunjungan->user->name ?? '-' }}</td>
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

    @if($anak->pengukurans->count() > 1)
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    @php
        $growthData = $anak->pengukurans->sortBy('created_at')->values()->map(function($p) {
            return [
                'date' => $p->kunjungan?->tanggal_kunjungan?->format('d/m/Y') ?? $p->created_at->format('d/m/Y'),
                'age' => $p->kunjungan?->usia_bulan ?? null,
                'weight' => $p->berat_badan,
                'height' => $p->tinggi_badan,
                'head' => $p->lingkar_kepala
            ];
        });
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prepare growth data from measurements
            const measurements = @json($growthData);

            const labels = measurements.map(m => m.age ? m.age + ' bln' : m.date);
            const weights = measurements.map(m => m.weight);
            const heights = measurements.map(m => m.height);
            const heads = measurements.map(m => m.head);

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { usePointStyle: true, padding: 10 }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 10
                    }
                },
                scales: {
                    x: {
                        title: { display: true, text: 'Usia / Kunjungan' },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: false,
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    }
                }
            };

            // Weight Chart
            new Chart(document.getElementById('weightChart'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Berat Badan (kg)',
                        data: weights,
                        borderColor: '#1e5799',
                        backgroundColor: 'rgba(30, 87, 153, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#1e5799',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        ...chartOptions.scales,
                        y: { ...chartOptions.scales.y, title: { display: true, text: 'Berat (kg)' } }
                    }
                }
            });

            // Height Chart
            new Chart(document.getElementById('heightChart'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Tinggi Badan (cm)',
                        data: heights,
                        borderColor: '#52b788',
                        backgroundColor: 'rgba(82, 183, 136, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#52b788',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        ...chartOptions.scales,
                        y: { ...chartOptions.scales.y, title: { display: true, text: 'Tinggi (cm)' } }
                    }
                }
            });

            // Combined Chart
            new Chart(document.getElementById('combinedChart'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Berat (kg)',
                            data: weights,
                            borderColor: '#1e5799',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            tension: 0.3,
                            pointRadius: 4,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Tinggi (cm)',
                            data: heights,
                            borderColor: '#52b788',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            tension: 0.3,
                            pointRadius: 4,
                            yAxisID: 'y1'
                        },
                        {
                            label: 'Lingkar Kepala (cm)',
                            data: heads,
                            borderColor: '#f9a825',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            tension: 0.3,
                            pointRadius: 4,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { position: 'top', labels: { usePointStyle: true } }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: { display: true, text: 'Berat (kg)' },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: { display: true, text: 'Tinggi/LK (cm)' },
                            grid: { drawOnChartArea: false }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
    @endif
</x-admin-layout>

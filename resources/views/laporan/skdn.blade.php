<x-admin-layout>
    <x-slot name="title">Laporan SKDN</x-slot>

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <h5 class="mb-0">
                    <i class="bx bx-bar-chart-alt-2 me-2"></i>
                    Laporan SKDN
                </h5>
                <a href="{{ route('laporan.export-skdn', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-success">
                    <i class="bx bx-download"></i> Export Excel
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter -->
            <form action="{{ route('laporan.skdn') }}" method="GET" class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <label class="form-label small">Bulan</label>
                    <select name="bulan" class="form-select">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small">Tahun</label>
                    <select name="tahun" class="form-select">
                        @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-filter"></i> Tampilkan
                    </button>
                </div>
            </form>

            <!-- Keterangan SKDN -->
            <div class="alert alert-info mb-4">
                <strong>Keterangan SKDN:</strong>
                <ul class="mb-0 mt-2">
                    <li><strong>S</strong> = Sasaran (Jumlah seluruh balita di wilayah Posyandu)</li>
                    <li><strong>K</strong> = Memiliki KMS (Balita yang terdaftar di Posyandu)</li>
                    <li><strong>D</strong> = Ditimbang (Balita yang ditimbang bulan ini)</li>
                    <li><strong>N</strong> = Naik Berat Badan (Balita yang berat badannya naik dari bulan lalu)</li>
                </ul>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th rowspan="2" class="align-middle text-center">Posyandu</th>
                            <th colspan="4" class="text-center">SKDN</th>
                            <th colspan="2" class="text-center">Cakupan (%)</th>
                            <th colspan="3" class="text-center">Status Gizi</th>
                            <th colspan="2" class="text-center">Stunting</th>
                        </tr>
                        <tr>
                            <th class="text-center">S</th>
                            <th class="text-center">K</th>
                            <th class="text-center">D</th>
                            <th class="text-center">N</th>
                            <th class="text-center">D/S</th>
                            <th class="text-center">N/D</th>
                            <th class="text-center text-success">Baik</th>
                            <th class="text-center text-warning">Kurang</th>
                            <th class="text-center text-danger">Buruk</th>
                            <th class="text-center text-success">Normal</th>
                            <th class="text-center text-warning">Stunting</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $row)
                            <tr>
                                <td>
                                    <strong>{{ $row['posyandu']->nama }}</strong>
                                    <br><small class="text-muted">{{ $row['posyandu']->desa }}</small>
                                </td>
                                <td class="text-center">{{ $row['s'] }}</td>
                                <td class="text-center">{{ $row['k'] }}</td>
                                <td class="text-center">{{ $row['d'] }}</td>
                                <td class="text-center">{{ $row['n'] }}</td>
                                <td class="text-center {{ $row['d_per_s'] >= 80 ? 'text-success' : ($row['d_per_s'] >= 60 ? 'text-warning' : 'text-danger') }}">
                                    <strong>{{ $row['d_per_s'] }}%</strong>
                                </td>
                                <td class="text-center {{ $row['n_per_d'] >= 80 ? 'text-success' : ($row['n_per_d'] >= 60 ? 'text-warning' : 'text-danger') }}">
                                    <strong>{{ $row['n_per_d'] }}%</strong>
                                </td>
                                <td class="text-center">{{ $row['status']['gizi']['baik'] }}</td>
                                <td class="text-center">{{ $row['status']['gizi']['kurang'] }}</td>
                                <td class="text-center">{{ $row['status']['gizi']['buruk'] }}</td>
                                <td class="text-center">{{ $row['status']['stunting']['normal'] }}</td>
                                <td class="text-center">{{ $row['status']['stunting']['pendek'] + $row['status']['stunting']['sangat_pendek'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted py-4">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr>
                            <th>TOTAL</th>
                            <th class="text-center">{{ $total['s'] }}</th>
                            <th class="text-center">{{ $total['k'] }}</th>
                            <th class="text-center">{{ $total['d'] }}</th>
                            <th class="text-center">{{ $total['n'] }}</th>
                            <th class="text-center">{{ $total['d_per_s'] }}%</th>
                            <th class="text-center">{{ $total['n_per_d'] }}%</th>
                            <th colspan="5"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>

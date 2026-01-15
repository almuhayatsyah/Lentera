<x-admin-layout>
    <x-slot name="title">Detail Kunjungan</x-slot>

    <div class="row">
        <div class="col-12 col-lg-8">
            <!-- Main Info -->
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="bx bx-calendar-check me-2"></i>
                        Detail Kunjungan
                    </h5>
                    <span class="badge bg-primary">{{ $kunjungan->tanggal_format }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted" width="40%">Nama Anak</td>
                                    <td>
                                        <a href="{{ route('anak.show', $kunjungan->anak) }}">
                                            <strong>{{ $kunjungan->anak->nama ?? '-' }}</strong>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jenis Kelamin</td>
                                    <td>{{ $kunjungan->anak->jenis_kelamin_text ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Usia saat Kunjungan</td>
                                    <td>{{ $kunjungan->usia_bulan }} bulan</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Nama Ibu</td>
                                    <td>{{ $kunjungan->anak->ibu->nama ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted" width="40%">Posyandu</td>
                                    <td>{{ $kunjungan->posyandu->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Petugas</td>
                                    <td>{{ $kunjungan->user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Dicatat pada</td>
                                    <td>{{ $kunjungan->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengukuran -->
            @if($kunjungan->pengukuran)
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bx bx-ruler me-2"></i>
                        Hasil Pengukuran
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-4">
                        <div class="col-6 col-md-3">
                            <h3 class="text-primary mb-0">{{ $kunjungan->pengukuran->berat_badan }}</h3>
                            <small class="text-muted">Berat Badan (kg)</small>
                        </div>
                        <div class="col-6 col-md-3">
                            <h3 class="text-primary mb-0">{{ $kunjungan->pengukuran->tinggi_badan }}</h3>
                            <small class="text-muted">Tinggi Badan (cm)</small>
                        </div>
                        <div class="col-6 col-md-3">
                            <h3 class="text-primary mb-0">{{ $kunjungan->pengukuran->lingkar_kepala ?? '-' }}</h3>
                            <small class="text-muted">Lingkar Kepala (cm)</small>
                        </div>
                        <div class="col-6 col-md-3">
                            <h3 class="text-primary mb-0">{{ $kunjungan->pengukuran->lingkar_lengan ?? '-' }}</h3>
                            <small class="text-muted">LiLA (cm)</small>
                        </div>
                    </div>

                    <hr>

                    <!-- Status -->
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted d-block mb-2">Status Gizi (BB/U)</small>
                                <span class="badge bg-{{ $kunjungan->pengukuran->status_gizi_color }} fs-6">
                                    {{ $kunjungan->pengukuran->status_gizi_label }}
                                </span>
                                <div class="mt-2">
                                    <small>Z-Score: <strong>{{ number_format($kunjungan->pengukuran->zscore_bb_u, 2) }}</strong></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted d-block mb-2">Status Stunting (TB/U)</small>
                                <span class="badge bg-{{ $kunjungan->pengukuran->is_stunting ? 'warning' : 'success' }} fs-6">
                                    {{ $kunjungan->pengukuran->status_stunting_label }}
                                </span>
                                <div class="mt-2">
                                    <small>Z-Score: <strong>{{ number_format($kunjungan->pengukuran->zscore_tb_u, 2) }}</strong></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted d-block mb-2">Status Wasting (BB/TB)</small>
                                <span class="badge bg-{{ $kunjungan->pengukuran->status_wasting_color ?? 'secondary' }} fs-6">
                                    {{ $kunjungan->pengukuran->status_wasting_label ?? '-' }}
                                </span>
                                <div class="mt-2">
                                    <small>Z-Score: <strong>{{ number_format($kunjungan->pengukuran->zscore_bb_tb, 2) }}</strong></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($kunjungan->pengukuran->naik_berat_badan !== null)
                    <div class="mt-3 text-center">
                        @if($kunjungan->pengukuran->naik_berat_badan)
                            <span class="badge bg-success fs-6">
                                <i class="bx bx-trending-up"></i> Berat Badan NAIK
                            </span>
                        @else
                            <span class="badge bg-danger fs-6">
                                <i class="bx bx-trending-down"></i> Berat Badan TIDAK NAIK
                            </span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Pelayanan -->
            @if($kunjungan->pelayanan)
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bx bx-capsule me-2"></i>
                        Pelayanan yang Diberikan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    @if($kunjungan->pelayanan->vitamin_a)
                                        <i class="bx bx-check-circle text-success"></i>
                                        <strong>Vitamin A</strong> - {{ ucfirst($kunjungan->pelayanan->vitamin_a_dosis ?? '-') }}
                                    @else
                                        <i class="bx bx-x-circle text-muted"></i>
                                        <span class="text-muted">Vitamin A</span>
                                    @endif
                                </li>
                                <li class="mb-2">
                                    @if($kunjungan->pelayanan->obat_cacing)
                                        <i class="bx bx-check-circle text-success"></i>
                                        <strong>Obat Cacing</strong>
                                    @else
                                        <i class="bx bx-x-circle text-muted"></i>
                                        <span class="text-muted">Obat Cacing</span>
                                    @endif
                                </li>
                                <li class="mb-2">
                                    @if($kunjungan->pelayanan->konseling_gizi)
                                        <i class="bx bx-check-circle text-success"></i>
                                        <strong>Konseling Gizi</strong>
                                    @else
                                        <i class="bx bx-x-circle text-muted"></i>
                                        <span class="text-muted">Konseling Gizi</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            @if($kunjungan->pelayanan->pmt)
                                <div class="alert alert-success mb-2">
                                    <strong>PMT Diberikan</strong><br>
                                    {{ ucfirst($kunjungan->pelayanan->jenis_pmt ?? '-') }}
                                    @if($kunjungan->pelayanan->jumlah_pmt)
                                        - {{ $kunjungan->pelayanan->jumlah_pmt }} {{ $kunjungan->pelayanan->satuan_pmt }}
                                    @endif
                                </div>
                            @endif

                            @if($kunjungan->pelayanan->imunisasi)
                                <div class="alert alert-info mb-0">
                                    <strong>Imunisasi</strong><br>
                                    @if(is_array($kunjungan->pelayanan->imunisasi))
                                        {{ implode(', ', $kunjungan->pelayanan->imunisasi) }}
                                    @else
                                        {{ $kunjungan->pelayanan->imunisasi }}
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Catatan -->
            @if($kunjungan->catatan)
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Catatan</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $kunjungan->catatan }}</p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-12 col-lg-4">
            <!-- Actions -->
            <div class="card mb-4">
                <div class="card-body">
                    <a href="{{ route('anak.riwayat', $kunjungan->anak) }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="bx bx-history"></i> Lihat Semua Riwayat
                    </a>
                    <a href="{{ route('kunjungan.wizard.anak', $kunjungan->anak) }}" class="btn btn-primary w-100 mb-2">
                        <i class="bx bx-plus"></i> Kunjungan Baru
                    </a>
                    <a href="{{ route('kunjungan.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bx bx-arrow-back"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

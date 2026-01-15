<x-admin-layout>
    <x-slot name="title">Riwayat Kunjungan {{ $anak->nama }}</x-slot>

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0">
                        <i class="bx bx-history me-2"></i>
                        Riwayat Kunjungan
                    </h5>
                    <small class="text-muted">{{ $anak->nama }} • {{ $anak->usia_format }}</small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('kunjungan.wizard.anak', $anak) }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Kunjungan Baru
                    </a>
                    <a href="{{ route('anak.show', $anak) }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($anak->kunjungans->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bx bx-calendar-x bx-lg"></i>
                    <p class="mb-0 mt-2">Belum ada riwayat kunjungan</p>
                    <a href="{{ route('kunjungan.wizard.anak', $anak) }}" class="btn btn-primary mt-3">
                        <i class="bx bx-plus"></i> Tambah Kunjungan Pertama
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Usia</th>
                                <th>BB (kg)</th>
                                <th>TB (cm)</th>
                                <th>LK (cm)</th>
                                <th>Status Gizi</th>
                                <th>Stunting</th>
                                <th>Naik BB</th>
                                <th>Pelayanan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($anak->kunjungans as $index => $kunjungan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $kunjungan->tanggal_format }}</td>
                                    <td>{{ $kunjungan->usia_bulan }} bln</td>
                                    <td>{{ $kunjungan->pengukuran?->berat_badan ?? '-' }}</td>
                                    <td>{{ $kunjungan->pengukuran?->tinggi_badan ?? '-' }}</td>
                                    <td>{{ $kunjungan->pengukuran?->lingkar_kepala ?? '-' }}</td>
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
                                                <span class="badge bg-success">Normal</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($kunjungan->pengukuran?->naik_berat_badan !== null)
                                            @if($kunjungan->pengukuran->naik_berat_badan)
                                                <span class="text-success"><i class="bx bx-up-arrow-alt"></i> N</span>
                                            @else
                                                <span class="text-danger"><i class="bx bx-down-arrow-alt"></i> T</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($kunjungan->pelayanan)
                                            @if($kunjungan->pelayanan->vitamin_a)
                                                <span class="badge bg-danger">Vit A</span>
                                            @endif
                                            @if($kunjungan->pelayanan->pmt)
                                                <span class="badge bg-success">PMT</span>
                                            @endif
                                            @if($kunjungan->pelayanan->imunisasi)
                                                <span class="badge bg-info">Imun</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('kunjungan.show', $kunjungan) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

<x-admin-layout>
    <x-slot name="title">Detail Ibu</x-slot>

    <div class="row">
        <div class="col-12 col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-female me-2"></i>
                        {{ $ibu->nama }}
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted" width="40%">NIK</td>
                            <td><code>{{ $ibu->nik }}</code></td>
                        </tr>
                        <tr>
                            <td class="text-muted">TTL</td>
                            <td>{{ $ibu->tempat_lahir ?? '-' }}, {{ $ibu->tanggal_lahir?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Usia</td>
                            <td>{{ $ibu->usia ?? '-' }} tahun</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Telepon</td>
                            <td>{{ $ibu->telepon ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Alamat</td>
                            <td>{{ $ibu->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">RT/RW</td>
                            <td>{{ $ibu->rt ?? '-' }}/{{ $ibu->rw ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Desa</td>
                            <td>{{ $ibu->desa ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nama Suami</td>
                            <td>{{ $ibu->nama_suami ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Pekerjaan</td>
                            <td>{{ $ibu->pekerjaan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Posyandu</td>
                            <td>{{ $ibu->posyandu->nama ?? '-' }}</td>
                        </tr>
                    </table>

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="{{ route('ibu.edit', $ibu) }}" class="btn btn-primary btn-sm">
                            <i class="bx bx-edit"></i> Edit
                        </a>
                        <a href="{{ route('anak.create', ['ibu_id' => $ibu->id]) }}" class="btn btn-success btn-sm">
                            <i class="bx bx-plus"></i> Tambah Anak
                        </a>
                        <a href="{{ route('ibu.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bx bx-arrow-back"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">
                        <i class="bx bx-child me-2"></i>
                        Daftar Anak
                    </h6>
                    <span class="badge bg-primary">{{ $ibu->anaks->count() }} anak</span>
                </div>
                <div class="card-body">
                    @if($ibu->anaks->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="bx bx-child bx-lg"></i>
                            <p class="mb-0 mt-2">Belum ada data anak</p>
                            <a href="{{ route('anak.create', ['ibu_id' => $ibu->id]) }}" class="btn btn-sm btn-primary mt-3">
                                <i class="bx bx-plus"></i> Tambah Anak
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>JK</th>
                                        <th>Tgl Lahir</th>
                                        <th>Usia</th>
                                        <th>Status Terakhir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ibu->anaks as $anak)
                                        <tr>
                                            <td><strong>{{ $anak->nama }}</strong></td>
                                            <td>{{ $anak->jenis_kelamin }}</td>
                                            <td>{{ $anak->tanggal_lahir->format('d/m/Y') }}</td>
                                            <td>{{ $anak->usia_format }}</td>
                                            <td>
                                                @if($anak->pengukuran_terakhir)
                                                    <span class="badge bg-{{ $anak->pengukuran_terakhir->status_gizi_color }}">
                                                        {{ $anak->pengukuran_terakhir->status_gizi_label }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('anak.show', $anak) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <a href="{{ route('kunjungan.wizard.anak', $anak) }}" class="btn btn-sm btn-primary">
                                                    <i class="bx bx-plus"></i> Kunjungan
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
        </div>
    </div>
</x-admin-layout>

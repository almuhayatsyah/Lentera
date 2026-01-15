<x-admin-layout>
    <x-slot name="title">Detail Posyandu</x-slot>

    <div class="row">
        <div class="col-12 col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-building-house me-2"></i>
                        {{ $posyandu->nama }}
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted" width="40%">Desa</td>
                            <td>{{ $posyandu->desa }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kecamatan</td>
                            <td>{{ $posyandu->kecamatan }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kabupaten</td>
                            <td>{{ $posyandu->kabupaten ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Alamat</td>
                            <td>{{ $posyandu->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kader Utama</td>
                            <td>{{ $posyandu->kader_utama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Telepon</td>
                            <td>{{ $posyandu->telepon ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td>
                                @if($posyandu->aktif)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="{{ route('posyandu.edit', $posyandu) }}" class="btn btn-primary btn-sm">
                            <i class="bx bx-edit"></i> Edit
                        </a>
                        <a href="{{ route('posyandu.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bx bx-arrow-back"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h3 class="text-primary mb-0">{{ $posyandu->anaks->count() }}</h3>
                            <small class="text-muted">Anak Terdaftar</small>
                        </div>
                        <div class="col-6">
                            <h3 class="text-info mb-0">{{ $posyandu->users->count() }}</h3>
                            <small class="text-muted">Petugas/Kader</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <!-- Daftar Anak -->
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">
                        <i class="bx bx-child me-2"></i>
                        Daftar Anak di {{ $posyandu->nama }}
                    </h6>
                </div>
                <div class="card-body">
                    @if($posyandu->anaks->isEmpty())
                        <p class="text-muted text-center mb-0">Belum ada anak terdaftar</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>JK</th>
                                        <th>Usia</th>
                                        <th>Ibu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posyandu->anaks->take(10) as $anak)
                                        <tr>
                                            <td>
                                                <a href="{{ route('anak.show', $anak) }}">{{ $anak->nama }}</a>
                                            </td>
                                            <td>{{ $anak->jenis_kelamin }}</td>
                                            <td>{{ $anak->usia_format }}</td>
                                            <td>{{ $anak->ibu->nama ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($posyandu->anaks->count() > 10)
                            <div class="text-center">
                                <a href="{{ route('anak.index', ['posyandu_id' => $posyandu->id]) }}" class="btn btn-sm btn-outline-primary">
                                    Lihat Semua ({{ $posyandu->anaks->count() }})
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Daftar Kader -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bx bx-user me-2"></i>
                        Daftar Kader
                    </h6>
                </div>
                <div class="card-body">
                    @if($posyandu->users->isEmpty())
                        <p class="text-muted text-center mb-0">Belum ada kader terdaftar</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($posyandu->users as $user)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <br><small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                    <span class="badge bg-label-{{ $user->aktif ? 'success' : 'danger' }}">
                                        {{ $user->aktif ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

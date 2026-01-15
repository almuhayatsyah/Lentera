<x-admin-layout>
    <x-slot name="title">Edit Posyandu</x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-edit me-2"></i>
                        Edit Posyandu: {{ $posyandu->nama }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('posyandu.update', $posyandu) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Posyandu <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                       value="{{ old('nama', $posyandu->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kader Utama</label>
                                <input type="text" name="kader_utama" class="form-control" 
                                       value="{{ old('kader_utama', $posyandu->kader_utama) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Desa <span class="text-danger">*</span></label>
                                <input type="text" name="desa" class="form-control @error('desa') is-invalid @enderror" 
                                       value="{{ old('desa', $posyandu->desa) }}" required>
                                @error('desa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" name="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" 
                                       value="{{ old('kecamatan', $posyandu->kecamatan) }}" required>
                                @error('kecamatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kabupaten</label>
                                <input type="text" name="kabupaten" class="form-control" 
                                       value="{{ old('kabupaten', $posyandu->kabupaten) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $posyandu->alamat) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="telepon" class="form-control" 
                                       value="{{ old('telepon', $posyandu->telepon) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input type="checkbox" class="form-check-input" name="aktif" value="1" 
                                           {{ old('aktif', $posyandu->aktif) ? 'checked' : '' }}>
                                    <label class="form-check-label">Aktif</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2">{{ old('catatan', $posyandu->catatan) }}</textarea>
                        </div>

                        <hr>
                        <h6 class="mb-3"><i class="bx bx-map me-2"></i>Koordinat Peta (Opsional)</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="number" step="0.00000001" name="latitude" class="form-control" 
                                       value="{{ old('latitude', $posyandu->latitude) }}" placeholder="-6.917500">
                                <small class="text-muted">Contoh: -6.917500</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="number" step="0.00000001" name="longitude" class="form-control" 
                                       value="{{ old('longitude', $posyandu->longitude) }}" placeholder="107.619100">
                                <small class="text-muted">Contoh: 107.619100</small>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('posyandu.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

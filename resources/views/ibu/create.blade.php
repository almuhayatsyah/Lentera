<x-admin-layout>
    <x-slot name="title">Tambah Data Ibu</x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-plus-circle me-2"></i>
                        Tambah Data Ibu Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('ibu.store') }}" method="POST">
                        @csrf

                        <div class="alert alert-info">
                            <i class="bx bx-info-circle me-2"></i>
                            NIK harus 16 digit dan unik untuk setiap ibu.
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" 
                                       value="{{ old('nik') }}" maxlength="16" pattern="[0-9]{16}" 
                                       placeholder="16 digit NIK" required>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                       value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" 
                                       value="{{ old('tempat_lahir') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" 
                                       value="{{ old('tanggal_lahir') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="telepon" class="form-control" 
                                       value="{{ old('telepon') }}" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        <hr>
                        <h6 class="mb-3"><i class="bx bx-home me-2"></i>Alamat</h6>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">RT</label>
                                <input type="text" name="rt" class="form-control" value="{{ old('rt') }}" maxlength="5">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">RW</label>
                                <input type="text" name="rw" class="form-control" value="{{ old('rw') }}" maxlength="5">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Desa/Kelurahan</label>
                                <input type="text" name="desa" class="form-control" value="{{ old('desa') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Posyandu <span class="text-danger">*</span></label>
                                <select name="posyandu_id" class="form-select @error('posyandu_id') is-invalid @enderror" required>
                                    <option value="">Pilih Posyandu</option>
                                    @foreach($posyandus as $posyandu)
                                        <option value="{{ $posyandu->id }}" {{ old('posyandu_id') == $posyandu->id ? 'selected' : '' }}>
                                            {{ $posyandu->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('posyandu_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <h6 class="mb-3"><i class="bx bx-user me-2"></i>Data Keluarga</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Suami</label>
                                <input type="text" name="nama_suami" class="form-control" value="{{ old('nama_suami') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}">
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('ibu.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

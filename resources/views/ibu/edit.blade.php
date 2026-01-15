<x-admin-layout>
    <x-slot name="title">Edit Data Ibu</x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-edit me-2"></i>
                        Edit Data Ibu: {{ $ibu->nama }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('ibu.update', $ibu) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" 
                                       value="{{ old('nik', $ibu->nik) }}" maxlength="16" pattern="[0-9]{16}" required>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                       value="{{ old('nama', $ibu->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" 
                                       value="{{ old('tempat_lahir', $ibu->tempat_lahir) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" 
                                       value="{{ old('tanggal_lahir', $ibu->tanggal_lahir?->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="telepon" class="form-control" 
                                       value="{{ old('telepon', $ibu->telepon) }}">
                            </div>
                        </div>

                        <hr>
                        <h6 class="mb-3"><i class="bx bx-home me-2"></i>Alamat</h6>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $ibu->alamat) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">RT</label>
                                <input type="text" name="rt" class="form-control" value="{{ old('rt', $ibu->rt) }}" maxlength="5">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">RW</label>
                                <input type="text" name="rw" class="form-control" value="{{ old('rw', $ibu->rw) }}" maxlength="5">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Desa/Kelurahan</label>
                                <input type="text" name="desa" class="form-control" value="{{ old('desa', $ibu->desa) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Posyandu <span class="text-danger">*</span></label>
                                <select name="posyandu_id" class="form-select @error('posyandu_id') is-invalid @enderror" required>
                                    <option value="">Pilih Posyandu</option>
                                    @foreach($posyandus as $posyandu)
                                        <option value="{{ $posyandu->id }}" {{ old('posyandu_id', $ibu->posyandu_id) == $posyandu->id ? 'selected' : '' }}>
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
                                <input type="text" name="nama_suami" class="form-control" 
                                       value="{{ old('nama_suami', $ibu->nama_suami) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" 
                                       value="{{ old('pekerjaan', $ibu->pekerjaan) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" name="aktif" value="1" 
                                       {{ old('aktif', $ibu->aktif) ? 'checked' : '' }}>
                                <label class="form-check-label">Status Aktif</label>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('ibu.index') }}" class="btn btn-outline-secondary">
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

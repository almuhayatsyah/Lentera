<x-admin-layout>
    <x-slot name="title">Edit Data Anak</x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-edit me-2"></i>
                        Edit Data Anak: {{ $anak->nama }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('anak.update', $anak) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Foto Upload -->
                        <div class="mb-4 text-center">
                            <label class="form-label d-block">Foto Anak (Opsional)</label>
                            <div class="position-relative d-inline-block">
                                <img id="fotoPreview" 
                                     src="{{ $anak->foto ? asset('storage/'.$anak->foto) : asset('assets/img/avatars/child-placeholder.png') }}" 
                                     class="rounded-circle border" style="width: 120px; height: 120px; object-fit: cover;"
                                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($anak->nama) }}&background=random&size=120'">
                                <label for="foto" class="btn btn-sm btn-primary rounded-circle position-absolute" 
                                       style="bottom: 5px; right: 5px; width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                    <i class="bx bx-camera"></i>
                                </label>
                                <input type="file" name="foto" id="foto" class="d-none" accept="image/jpeg,image/jpg,image/png"
                                       onchange="previewImage(this)">
                            </div>
                            <small class="text-muted d-block mt-1">Max 2MB (JPG, PNG)</small>
                            @error('foto')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Anak <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                       value="{{ old('nama', $anak->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIK Anak</label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" 
                                       value="{{ old('nik', $anak->nik) }}" maxlength="16" pattern="[0-9]{16}"
                                       inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="L" {{ old('jenis_kelamin', $anak->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $anak->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control" 
                                       value="{{ old('tanggal_lahir', $anak->tanggal_lahir->format('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" 
                                       value="{{ old('tempat_lahir', $anak->tempat_lahir) }}">
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Ibu <span class="text-danger">*</span></label>
                                <select name="ibu_id" class="form-select" required>
                                    @foreach($ibus as $ibu)
                                        <option value="{{ $ibu->id }}" {{ old('ibu_id', $anak->ibu_id) == $ibu->id ? 'selected' : '' }}>
                                            {{ $ibu->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Posyandu <span class="text-danger">*</span></label>
                                <select name="posyandu_id" class="form-select" required>
                                    @foreach($posyandus as $posyandu)
                                        <option value="{{ $posyandu->id }}" {{ old('posyandu_id', $anak->posyandu_id) == $posyandu->id ? 'selected' : '' }}>
                                            {{ $posyandu->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Anak ke-</label>
                            <input type="number" name="urutan_anak" class="form-control" 
                                   value="{{ old('urutan_anak', $anak->urutan_anak) }}" min="1" style="width: 100px;">
                        </div>

                        <hr>
                        <h6 class="mb-3">Data Kelahiran</h6>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Berat Lahir (kg)</label>
                                <input type="number" step="0.01" name="berat_lahir" class="form-control" 
                                       value="{{ old('berat_lahir', $anak->berat_lahir) }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Panjang Lahir (cm)</label>
                                <input type="number" step="0.1" name="panjang_lahir" class="form-control" 
                                       value="{{ old('panjang_lahir', $anak->panjang_lahir) }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Lingkar Kepala (cm)</label>
                                <input type="number" step="0.1" name="lingkar_kepala_lahir" class="form-control" 
                                       value="{{ old('lingkar_kepala_lahir', $anak->lingkar_kepala_lahir) }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Golongan Darah</label>
                                <select name="golongan_darah" class="form-select">
                                    <option value="">-</option>
                                    @foreach(['A', 'B', 'AB', 'O'] as $gol)
                                        <option value="{{ $gol }}" {{ old('golongan_darah', $anak->golongan_darah) == $gol ? 'selected' : '' }}>{{ $gol }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2">{{ old('catatan', $anak->catatan) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" name="aktif" value="1" 
                                       {{ old('aktif', $anak->aktif) ? 'checked' : '' }}>
                                <label class="form-check-label">Status Aktif</label>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('anak.index') }}" class="btn btn-outline-secondary">
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

    @push('scripts')
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('fotoPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</x-admin-layout>

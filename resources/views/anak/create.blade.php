<x-admin-layout>
    <x-slot name="title">Tambah Data Anak</x-slot>
    <x-slot name="pageTitle">Tambah Data Anak Baru</x-slot>
    <x-slot name="backUrl">{{ route('anak.index') }}</x-slot>
    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('anak.index') }}">Data Anak</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-plus-circle me-2"></i>
                        Tambah Data Anak Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('anak.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Foto Upload -->
                        <div class="mb-4 text-center">
                            <label class="form-label d-block">Foto Anak (Opsional)</label>
                            <div class="position-relative d-inline-block">
                                <img id="fotoPreview" src="{{ asset('assets/img/avatars/child-placeholder.png') }}" 
                                     class="rounded-circle border" style="width: 120px; height: 120px; object-fit: cover;"
                                     onerror="this.src='https://ui-avatars.com/api/?name=Foto&background=random&size=120'">
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
                                       value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIK Anak</label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" 
                                       value="{{ old('nik') }}" maxlength="16" pattern="[0-9]{16}"
                                       inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                       placeholder="16 digit (opsional)">
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                    <option value="">Pilih</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       value="{{ old('tanggal_lahir') }}" max="{{ date('Y-m-d') }}" required>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" 
                                       value="{{ old('tempat_lahir') }}">
                            </div>
                        </div>

                        <hr>
                        <h6 class="mb-3"><i class="bx bx-female me-2"></i>Data Ibu & Posyandu</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Ibu <span class="text-danger">*</span></label>
                                <select name="ibu_id" class="form-select @error('ibu_id') is-invalid @enderror" required>
                                    <option value="">Pilih Ibu</option>
                                    @foreach($ibus as $ibu)
                                        <option value="{{ $ibu->id }}" {{ old('ibu_id', $selectedIbu?->id) == $ibu->id ? 'selected' : '' }}>
                                            {{ $ibu->nama }} ({{ $ibu->nik }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('ibu_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    Ibu belum terdaftar? <a href="{{ route('ibu.create') }}">Tambah dulu</a>
                                </small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Posyandu <span class="text-danger">*</span></label>
                                <select name="posyandu_id" class="form-select @error('posyandu_id') is-invalid @enderror" required>
                                    <option value="">Pilih Posyandu</option>
                                    @foreach($posyandus as $posyandu)
                                        <option value="{{ $posyandu->id }}" {{ old('posyandu_id', $selectedIbu?->posyandu_id) == $posyandu->id ? 'selected' : '' }}>
                                            {{ $posyandu->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('posyandu_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Anak ke-</label>
                            <input type="number" name="urutan_anak" class="form-control" 
                                   value="{{ old('urutan_anak', 1) }}" min="1" max="20" style="width: 100px;">
                        </div>

                        <hr>
                        <h6 class="mb-3"><i class="bx bx-body me-2"></i>Data Kelahiran</h6>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Berat Lahir (kg)</label>
                                <input type="number" step="0.01" name="berat_lahir" class="form-control" 
                                       value="{{ old('berat_lahir') }}" placeholder="3.2">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Panjang Lahir (cm)</label>
                                <input type="number" step="0.1" name="panjang_lahir" class="form-control" 
                                       value="{{ old('panjang_lahir') }}" placeholder="50">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Lingkar Kepala (cm)</label>
                                <input type="number" step="0.1" name="lingkar_kepala_lahir" class="form-control" 
                                       value="{{ old('lingkar_kepala_lahir') }}" placeholder="34">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Golongan Darah</label>
                                <select name="golongan_darah" class="form-select">
                                    <option value="">-</option>
                                    <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('anak.index') }}" class="btn btn-outline-secondary">
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

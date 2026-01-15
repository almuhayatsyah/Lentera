<x-admin-layout>
    <x-slot name="title">Tambah Pengguna</x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-plus-circle me-2"></i>
                        Tambah Pengguna Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimal 8 karakter</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror" 
                                        id="roleSelect" required onchange="togglePosyandu()">
                                    <option value="">Pilih Role</option>
                                    <option value="admin_puskesmas" {{ old('role') == 'admin_puskesmas' ? 'selected' : '' }}>Admin Puskesmas</option>
                                    <option value="kader" {{ old('role') == 'kader' ? 'selected' : '' }}>Kader</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3" id="posyanduField">
                                <label class="form-label">Posyandu <span class="text-danger" id="posyanduRequired">*</span></label>
                                <select name="posyandu_id" class="form-select @error('posyandu_id') is-invalid @enderror">
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
                                <small class="text-muted">Wajib diisi untuk role Kader</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" 
                                       placeholder="Nomor Induk Pegawai (opsional)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}" 
                                       placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" name="aktif" value="1" 
                                       {{ old('aktif', true) ? 'checked' : '' }}>
                                <label class="form-check-label">Status Aktif</label>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
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
        function togglePosyandu() {
            const role = document.getElementById('roleSelect').value;
            const required = document.getElementById('posyanduRequired');
            const posyanduSelect = document.querySelector('select[name="posyandu_id"]');
            
            if (role === 'kader') {
                required.style.display = 'inline';
                posyanduSelect.setAttribute('required', 'required');
            } else {
                required.style.display = 'none';
                posyanduSelect.removeAttribute('required');
            }
        }
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', togglePosyandu);
    </script>
    @endpush
</x-admin-layout>

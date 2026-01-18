<x-admin-layout>
    <x-slot name="title">Profil Saya</x-slot>
    <x-slot name="pageTitle">Profil Saya</x-slot>
    <x-slot name="backUrl">{{ route('dashboard') }}</x-slot>
    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Profil</li>
    </x-slot>


    <div class="row">
        <!-- Profile Summary Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center py-4">
                    <div class="mb-3">
                        @if(auth()->user()->photo_url)
                            <img src="{{ auth()->user()->photo_url }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="rounded-circle mb-2"
                                 style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #e9ecef;">
                        @else
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-2"
                                 style="width: 120px; height: 120px;">
                                <span class="text-white fs-1 fw-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                    <span class="badge bg-label-primary mb-2">{{ auth()->user()->role_label }}</span>
                    <p class="text-muted small mb-0">
                        <i class="bx bx-envelope me-1"></i>{{ auth()->user()->email }}
                    </p>
                    @if(auth()->user()->nip)
                        <p class="text-muted small mb-0 mt-1">
                            <i class="bx bx-id-card me-1"></i>NIP: {{ auth()->user()->nip }}
                        </p>
                    @endif
                    @if(auth()->user()->telepon)
                        <p class="text-muted small mb-0 mt-1">
                            <i class="bx bx-phone me-1"></i>{{ auth()->user()->telepon }}
                        </p>
                    @endif
                    @if(auth()->user()->posyandu)
                        <p class="text-muted small mb-0 mt-1">
                            <i class="bx bx-building-house me-1"></i>{{ auth()->user()->posyandu->nama }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profile Forms -->
        <div class="col-md-8">
            <!-- Photo Upload -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-camera me-2"></i>Foto Profil
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.photo') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex align-items-center gap-4">
                            <div class="flex-shrink-0">
                                @if($user->photo_url)
                                    <img src="{{ $user->photo_url }}" 
                                         alt="{{ $user->name }}" 
                                         class="rounded-circle"
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                         style="width: 80px; height: 80px;">
                                        <i class="bx bx-user bx-lg text-white"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" name="photo" id="photo" class="form-control" 
                                       accept="image/jpeg,image/png,image/jpg">
                                <small class="text-muted">JPG, JPEG, atau PNG. Maksimal 2MB.</small>
                                @error('photo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-upload me-1"></i>Upload
                            </button>
                        </div>
                        @if (session('status') === 'photo-updated')
                            <div class="alert alert-success mt-3 mb-0 py-2">
                                <i class="bx bx-check-circle me-1"></i>Foto berhasil diupload!
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-user me-2"></i>Informasi Profil
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" 
                                       value="{{ old('nip', $user->nip) }}" placeholder="Nomor Induk Pegawai">
                                @error('nip')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="telepon" name="telepon" 
                                       value="{{ old('telepon', $user->telepon) }}" placeholder="08xxxxxxxxxx">
                                @error('telepon')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i>Simpan Perubahan
                        </button>
                        @if (session('status') === 'profile-updated')
                            <span class="text-success ms-2">
                                <i class="bx bx-check-circle"></i> Tersimpan!
                            </span>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Update Password -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-lock-alt me-2"></i>Ubah Password
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                <input type="password" class="form-control" id="current_password" name="current_password">
                                @error('current_password', 'updatePassword')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password" name="password">
                                @error('password', 'updatePassword')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bx bx-key me-1"></i>Ubah Password
                        </button>
                        @if (session('status') === 'password-updated')
                            <span class="text-success ms-2">
                                <i class="bx bx-check-circle"></i> Password diubah!
                            </span>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

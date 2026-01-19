<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LENTERA') }} - Login</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">

    <style>
        :root {
            --primary: #1e5799;
            --primary-light: #4a90d9;
            --secondary: #28c76f;
        }
        
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e5799 0%, #4a90d9 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .login-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            animation: slideUp 0.5s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-logo {
            height: 70px;
            margin-bottom: 1rem;
        }
        
        .login-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.3rem;
        }
        
        .login-subtitle {
            color: #64748b;
            font-size: 0.9rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
        }
        
        .form-control {
            border-radius: 12px;
            padding: 0.8rem 1rem;
            border: 2px solid #e5e7eb;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(30, 87, 153, 0.1);
        }
        
        .input-group .form-control {
            border-right: none;
        }
        
        .input-group-text {
            background: white;
            border: 2px solid #e5e7eb;
            border-left: none;
            border-radius: 0 12px 12px 0;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .input-group:focus-within .input-group-text {
            border-color: var(--primary);
        }
        
        .btn-login {
            width: 100%;
            padding: 0.9rem;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border: none;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 87, 153, 0.3);
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: var(--primary);
        }
        
        .alert {
            border-radius: 12px;
            font-size: 0.9rem;
        }
        
        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem;
                border-radius: 16px;
            }
            
            .login-logo {
                height: 55px;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('assets/img/favicon/logo.png') }}" alt="LENTERA" class="login-logo">
            <h1 class="login-title">LENTERA</h1>
            <p class="login-subtitle">Layanan Elektronik Nutrisi Tumbuh Kembang Entri Rutin Anak</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="bx bx-error-circle me-1"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">NIP / Email</label>
                <input type="text" name="login" class="form-control" 
                       value="{{ old('login') }}" placeholder="Masukkan NIP atau Email" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Kata Sandi</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" 
                           placeholder="Masukkan kata sandi" required>
                    <span class="input-group-text" onclick="togglePassword()">
                        <i class="bx bx-hide" id="toggleIcon"></i>
                    </span>
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-login">
                <i class="bx bx-log-in me-1"></i> Masuk
            </button>
        </form>

        <div class="mt-3 text-center">
            <small class="text-muted">
                Dengan masuk, Anda menyetujui <br>
                <a href="#" class="text-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#tosModal">Syarat & Ketentuan</a> & 
                <a href="#" class="text-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#policyModal">Kebijakan Privasi</a>
            </small>
        </div>

        <a href="{{ route('home') }}" class="back-link">
            <i class="bx bx-arrow-back"></i> Kembali ke Beranda
        </a>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="tosModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Syarat & Ketentuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ol class="small text-muted ps-3">
                        <li class="mb-2"><strong>Penerimaan Layanan</strong>: Dengan menggunakan aplikasi LENTERA, Anda setuju untuk mematuhi aturan penggunaan yang berlaku.</li>
                        <li class="mb-2"><strong>Kewajiban Pengguna</strong>: Kader dan Admin wajib menjaga kerahasiaan kredensial akun dan dilarang membagikan data pasien kepada pihak yang tidak berwenang.</li>
                        <li class="mb-2"><strong>Disclaimer Kesehatan</strong>: Data hasil perhitungan otomatis (Stunting/Gizi) adalah alat bantu skrining awal dan bukan merupakan diagnosa medis final tanpa konsultasi tenaga kesehatan.</li>
                        <li class="mb-2"><strong>Keamanan</strong>: Pengguna bertanggung jawab penuh atas segala aktivitas yang dilakukan melalui akun milik mereka.</li>
                    </ol>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-primary w-100 rounded-pill" data-bs-dismiss="modal">Saya Mengerti</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="policyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Kebijakan Privasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ol class="small text-muted ps-3">
                        <li class="mb-2"><strong>Pengumpulan Data</strong>: LENTERA mengumpulkan data Balita dan Ibu (Nama, Tanggal Lahir, Pengukuran Fisik) semata-mata untuk tujuan pemantauan tumbuh kembang oleh Puskesmas.</li>
                        <li class="mb-2"><strong>Penyimpanan Data</strong>: Data disimpan secara aman di server kami dan hanya dapat diakses oleh personil berwenang (Kader Posyandu & Admin Puskesmas).</li>
                        <li class="mb-2"><strong>Keamanan Data</strong>: Kami menggunakan enkripsi standar untuk melindungi data dari akses tanpa izin.</li>
                        <li class="mb-2"><strong>Hak Pengguna</strong>: Orang tua balita memiliki hak untuk mengetahui data yang tercatat dan meminta perbaikan jika terdapat kesalahan data.</li>
                    </ol>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-primary w-100 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.replace('bx-hide', 'bx-show');
            } else {
                password.type = 'password';
                icon.classList.replace('bx-show', 'bx-hide');
            }
        }
    </script>
</body>
</html>

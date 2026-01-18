<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LENTERA') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">

    <style>
        :root {
            --lentera-primary: #1e5799;
            --lentera-secondary: #00b4d8;
            --lentera-success: #52b788;
            --lentera-warning: #f9a825;
            --lentera-gradient: linear-gradient(135deg, #1e5799 0%, #00b4d8 50%, #52b788 100%);
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #0a3d62 0%, #1e5799 50%, #00b4d8 100%);
            overflow-x: hidden;
        }
        
        .login-wrapper {
            min-height: 100vh;
            display: flex;
        }
        
        /* Left Side - Features */
        .features-side {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            color: white;
        }
        
        .features-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("{{ asset('assets/img/backgrounds/ilustration.png') }}") right center no-repeat;
            background-size: contain;
            opacity: 0.15;
            pointer-events: none;
        }
        
        .features-content {
            position: relative;
            z-index: 1;
            max-width: 600px;
        }
        
        .brand-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .brand-header img {
            height: 60px;
            filter: drop-shadow(0 4px 10px rgba(0,0,0,0.2));
        }
        
        .brand-header h1 {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin: 0;
        }
        
        .tagline {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }
        
        .tagline span {
            background: linear-gradient(90deg, #00b4d8, #52b788);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .subtitle {
            color: rgba(255,255,255,0.8);
            font-size: 1rem;
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.25rem;
            padding: 1rem;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .feature-item:hover {
            background: rgba(255,255,255,0.15);
            transform: translateX(5px);
        }
        
        .feature-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #00b4d8, #52b788);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .feature-icon i {
            font-size: 1.5rem;
            color: white;
        }
        
        .feature-text h6 {
            font-weight: 600;
            margin-bottom: 0.25rem;
            font-size: 0.95rem;
        }
        
        .feature-text p {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.7);
            margin: 0;
            line-height: 1.4;
        }
        
        /* Right Side - Form */
        .form-side {
            width: 480px;
            min-width: 480px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem;
            position: relative;
        }
        
        .form-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 6px;
            background: var(--lentera-gradient);
        }
        
        .login-form-wrapper {
            max-width: 360px;
            margin: 0 auto;
            width: 100%;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .form-header .form-logo {
            height: 70px;
            width: auto;
            margin-bottom: 1rem;
        }
        
        .form-header h3 {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .form-header p {
            color: #64748b;
            font-size: 0.9rem;
        }
        
        .form-floating {
            margin-bottom: 1rem;
        }
        
        .form-floating > .form-control {
            padding: 1rem 1rem;
            height: auto;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            font-size: 0.95rem;
        }
        
        .form-floating > .form-control:focus {
            border-color: var(--lentera-secondary);
            box-shadow: 0 0 0 4px rgba(0, 180, 216, 0.1);
        }
        
        .form-floating > label {
            padding: 1rem;
            color: #94a3b8;
        }
        
        .btn-login {
            width: 100%;
            padding: 0.9rem;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 10px;
            background: var(--lentera-gradient);
            border: none;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 87, 153, 0.35);
        }
        
        .form-check-input:checked {
            background-color: var(--lentera-primary);
            border-color: var(--lentera-primary);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #94a3b8;
            font-size: 0.8rem;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .divider span {
            padding: 0 1rem;
        }
        
        .demo-accounts {
            background: #f8fafc;
            border-radius: 10px;
            padding: 1rem;
            font-size: 0.8rem;
        }
        
        .demo-accounts h6 {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .demo-account-item {
            display: flex;
            justify-content: space-between;
            padding: 0.4rem 0;
            border-bottom: 1px dashed #e2e8f0;
        }
        
        .demo-account-item:last-child {
            border-bottom: none;
        }
        
        .demo-account-item span {
            color: #475569;
        }
        
        .demo-account-item code {
            background: #e2e8f0;
            padding: 0.15rem 0.4rem;
            border-radius: 4px;
            font-size: 0.75rem;
            color: var(--lentera-primary);
        }
        
        .footer-text {
            text-align: center;
            margin-top: 2rem;
            color: #94a3b8;
            font-size: 0.8rem;
        }
        
        /* Responsive */
        @media (max-width: 1199.98px) {
            .features-side {
                padding: 2rem;
            }
            .form-side {
                width: 420px;
                min-width: 420px;
                padding: 2rem;
            }
        }
        
        @media (max-width: 991.98px) {
            body {
                background: #f8fafc;
            }
            .login-wrapper {
                flex-direction: column;
                min-height: 100vh;
            }
            .features-side {
                padding: 1.5rem;
                text-align: center;
                flex: none;
                min-height: auto;
            }
            .features-side::before {
                display: none;
            }
            .features-content {
                max-width: 100%;
            }
            .brand-header {
                justify-content: center;
                margin-bottom: 1rem;
            }
            .brand-header img {
                height: 50px;
            }
            .brand-header h1 {
                font-size: 1.5rem;
            }
            .tagline {
                font-size: 1rem;
                margin-bottom: 0.25rem;
            }
            .subtitle {
                display: none;
            }
            .feature-list {
                display: none;
            }
            .form-side {
                flex: 1;
                width: 100%;
                min-width: 100%;
                padding: 1.5rem;
                background: #f8fafc;
            }
            .form-side::before {
                display: none;
            }
            .login-card {
                background: white;
                padding: 1.5rem;
                border-radius: 1rem;
                box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            }
            .form-header .form-logo {
                height: 50px;
                margin-bottom: 0.5rem;
            }
            .form-header h3 {
                font-size: 1.25rem;
            }
            .form-header {
                margin-bottom: 1.5rem;
            }
            .demo-accounts {
                display: none;
            }
            .divider {
                display: none;
            }
            .footer-text {
                margin-top: 1.5rem;
            }
            /* Hide logo in form on mobile since header already shows it */
            .form-header .form-logo {
                display: none;
            }
        }
        
        @media (max-width: 575.98px) {
            .features-side {
                padding: 1rem 0.75rem;
                background: linear-gradient(135deg, #0a3d62 0%, #1e5799 100%);
            }
            .brand-header img {
                height: 36px;
            }
            .brand-header h1 {
                font-size: 1.1rem;
            }
            .tagline {
                font-size: 0.75rem;
                line-height: 1.3;
                margin-bottom: 0;
            }
            .tagline span {
                display: inline;
            }
            .form-side {
                padding: 0.75rem;
            }
            .login-card {
                padding: 1.25rem;
            }
            .form-header {
                margin-bottom: 1rem;
            }
            .form-header h3 {
                font-size: 1.1rem;
                margin-bottom: 0.25rem;
            }
            .form-header p {
                font-size: 0.8rem;
            }
            .btn-login {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Features Side -->
        <div class="features-side">
            <div class="features-content">
                <!-- Brand -->
                <div class="brand-header">
                    <img src="{{ asset('assets/img/favicon/logo.png') }}" alt="LENTERA">
                    <h1>LENTERA</h1>
                </div>
                
                <!-- Tagline -->
                <h2 class="tagline">
                    <span>Layanan Elektronik Nutrisi</span> Tumbuh Kembang Entri Rutin Anak
                </h2>
                <p class="subtitle">
                    Sistem pencatatan digital untuk kader Posyandu dalam memantau kesehatan dan pertumbuhan balita dengan mudah, cepat, dan akurat.
                </p>
                
                <!-- Features List -->
                <ul class="feature-list">
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class='bx bx-line-chart'></i>
                        </div>
                        <div class="feature-text">
                            <h6>Deteksi Status Gizi Otomatis</h6>
                            <p>Langsung mengetahui kondisi gizi dan stunting anak sesuai standar kesehatan dunia</p>
                        </div>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class='bx bx-mobile-alt'></i>
                        </div>
                        <div class="feature-text">
                            <h6>Mudah Digunakan di HP</h6>
                            <p>Tampilan yang nyaman digunakan di handphone untuk kemudahan kader di lapangan</p>
                        </div>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class='bx bx-map-alt'></i>
                        </div>
                        <div class="feature-text">
                            <h6>Peta Sebaran Posyandu</h6>
                            <p>Lihat lokasi semua posyandu beserta status kesehatan anak di wilayah Anda dalam peta</p>
                        </div>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class='bx bx-file'></i>
                        </div>
                        <div class="feature-text">
                            <h6>Laporan SKDN Otomatis</h6>
                            <p>Buat laporan bulanan SKDN lengkap dengan sekali klik untuk pelaporan ke Puskesmas</p>
                        </div>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class='bx bx-check-shield'></i>
                        </div>
                        <div class="feature-text">
                            <h6>Data Aman & Tersimpan</h6>
                            <p>Semua data balita tersimpan dengan aman dan dapat diakses kapan saja</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Form Side -->
        <div class="form-side">
            <div class="login-form-wrapper login-card">
                <div class="form-header">
                    <img src="{{ asset('assets/img/favicon/logo.png') }}" alt="LENTERA" class="form-logo">
                    <h3>Selamat Datang!</h3>
                    <p>Masuk ke akun Anda untuk melanjutkan</p>
                </div>
                
                <!-- Alerts -->
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-floating">
                        <input type="text" 
                               class="form-control" 
                               id="login" 
                               name="login" 
                               value="{{ old('login') }}"
                               placeholder="NIP atau Email"
                               required 
                               autofocus>
                        <label for="login"><i class='bx bx-id-card me-2'></i>NIP atau Email</label>
                    </div>
                    
                    <div class="form-floating">
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password"
                               placeholder="Password"
                               required>
                        <label for="password"><i class='bx bx-lock-alt me-2'></i>Password</label>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label small text-muted" for="remember">
                                Ingat saya
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small text-decoration-none" style="color: var(--lentera-primary);">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    
                    <button type="submit" class="btn btn-login">
                        <i class='bx bx-log-in-circle me-2'></i>Masuk
                    </button>
                </form>
                
                <!-- Demo Accounts -->
                <div class="divider"><span>Demo Accounts</span></div>
                
                <div class="demo-accounts">
                    <h6><i class='bx bx-info-circle me-1'></i>Akun untuk Testing</h6>
                    <div class="demo-account-item">
                        <span>Admin Puskesmas</span>
                        <code>admin@lentera.test</code>
                    </div>
                    <div class="demo-account-item">
                        <span>Kader Posyandu</span>
                        <code>siti@lentera.test</code>
                    </div>
                    <div class="demo-account-item">
                        <span>Password</span>
                        <code>password</code>
                    </div>
                </div>
                
                <div class="footer-text">
                    &copy; {{ date('Y') }} LENTERA - Posyandu Digital
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

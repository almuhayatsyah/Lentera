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
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        
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
                --lentera-light: #fff8e7;
            }
            
            * {
                font-family: 'Public Sans', sans-serif;
            }
            
            body {
                min-height: 100vh;
                background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #f0fdf4 100%);
            }
            
            .login-container {
                min-height: 100vh;
            }
            
            .illustration-side {
                background: linear-gradient(180deg, var(--lentera-primary) 0%, #0a3d62 100%);
                position: relative;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 2rem;
            }
            
            .illustration-side::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url("{{ asset('assets/img/backgrounds/ilustration.png') }}") center center no-repeat;
                background-size: contain;
                opacity: 0.95;
            }
            
            .illustration-content {
                position: relative;
                z-index: 1;
                text-align: center;
                color: white;
                padding: 2rem;
            }
            
            .form-side {
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 3rem;
            }
            
            .login-card {
                max-width: 420px;
                width: 100%;
                margin: 0 auto;
            }
            
            .logo-wrapper {
                text-align: center;
                margin-bottom: 2rem;
            }
            
            .logo-wrapper img {
                height: 80px;
                width: auto;
            }
            
            .logo-wrapper h4 {
                color: var(--lentera-primary);
                font-weight: 700;
                margin-top: 0.5rem;
            }
            
            .form-control {
                padding: 0.75rem 1rem;
                border-radius: 0.5rem;
                border: 1px solid #e2e8f0;
            }
            
            .form-control:focus {
                border-color: var(--lentera-secondary);
                box-shadow: 0 0 0 0.25rem rgba(0, 180, 216, 0.15);
            }
            
            .form-label {
                font-weight: 500;
                color: #475569;
            }
            
            .btn-login {
                background: linear-gradient(135deg, var(--lentera-primary) 0%, var(--lentera-secondary) 100%);
                border: none;
                padding: 0.75rem 2rem;
                font-weight: 600;
                border-radius: 0.5rem;
                transition: all 0.3s ease;
            }
            
            .btn-login:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(30, 87, 153, 0.4);
            }
            
            .form-check-input:checked {
                background-color: var(--lentera-primary);
                border-color: var(--lentera-primary);
            }
            
            .welcome-text {
                color: #64748b;
                margin-bottom: 1.5rem;
            }
            
            .input-group-text {
                background: #f8fafc;
                border-right: none;
            }
            
            .input-icon .form-control {
                border-left: none;
            }
            
            .divider {
                display: flex;
                align-items: center;
                text-align: center;
                margin: 1.5rem 0;
                color: #94a3b8;
            }
            
            .divider::before,
            .divider::after {
                content: '';
                flex: 1;
                border-bottom: 1px solid #e2e8f0;
            }
            
            .divider span {
                padding: 0 1rem;
                font-size: 0.875rem;
            }
            
            .footer-text {
                text-align: center;
                color: #94a3b8;
                font-size: 0.875rem;
                margin-top: 2rem;
            }
            
            @media (max-width: 991.98px) {
                .illustration-side {
                    display: none;
                }
                .form-side {
                    padding: 2rem 1.5rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="container-fluid login-container">
            <div class="row h-100">
                <!-- Illustration Side -->
                <div class="col-lg-7 illustration-side d-none d-lg-flex">
                    <div class="illustration-content">
                        <!-- Content is in the background -->
                    </div>
                </div>
                
                <!-- Form Side -->
                <div class="col-lg-5 form-side">
                    <div class="login-card">
                        <!-- Logo -->
                        <div class="logo-wrapper">
                            <img src="{{ asset('assets/img/favicon/logo.png') }}" alt="LENTERA">
                            <h4>LENTERA</h4>
                            <p class="text-muted small">Sistem Pemantauan Tumbuh Kembang Anak</p>
                        </div>
                        
                        <!-- Welcome Text -->
                        <div class="text-center mb-4">
                            <h5 class="fw-bold text-dark">Selamat Datang! 👋</h5>
                            <p class="welcome-text">Silakan masuk ke akun Anda</p>
                        </div>
                        
                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success mb-4">
                                {{ session('status') }}
                            </div>
                        @endif
                        
                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        
                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group input-icon">
                                    <span class="input-group-text">
                                        <i class='bx bx-envelope text-muted'></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           placeholder="email@lentera.test"
                                           required 
                                           autofocus>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-icon">
                                    <span class="input-group-text">
                                        <i class='bx bx-lock-alt text-muted'></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password" 
                                           name="password"
                                           placeholder="••••••••"
                                           required>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label text-muted small" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="small text-decoration-none" style="color: var(--lentera-primary);">
                                        Lupa password?
                                    </a>
                                @endif
                            </div>
                            
                            <button type="submit" class="btn btn-login btn-primary w-100">
                                <i class='bx bx-log-in-circle me-1'></i>
                                Masuk
                            </button>
                        </form>
                        
                        <!-- Footer -->
                        <div class="footer-text">
                            &copy; {{ date('Y') }} LENTERA - Posyandu Digital
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

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
                <input type="text" name="nip" class="form-control" 
                       value="{{ old('nip') }}" placeholder="Masukkan NIP atau Email" required autofocus>
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

        <a href="{{ route('home') }}" class="back-link">
            <i class="bx bx-arrow-back"></i> Kembali ke Beranda
        </a>
    </div>

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

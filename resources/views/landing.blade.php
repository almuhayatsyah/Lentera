<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LENTERA - Layanan Elektronik Nutrisi Tumbuh Kembang Entri Rutin Anak. Sistem Informasi Posyandu untuk pemantauan tumbuh kembang balita.">
    <title>LENTERA POSYANDU RINDAM IM - Layanan Elektronik Nutrisi Tumbuh Kembang Entri Rutin Anak</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #1e5799;
            --primary-light: #4a90d9;
            --secondary: #28c76f;
            --accent: #ff9f43;
            --dark: #2c3e50;
            --light: #f8fafc;
        }
        
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        body {
            background: var(--light);
            overflow-x: hidden;
        }
        
        /* Navbar */
        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary) !important;
        }
        
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        
        .nav-link {
            color: var(--dark) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            color: var(--primary) !important;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white !important;
            border: none;
            border-radius: 50px;
            padding: 0.6rem 1.5rem !important;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(30, 87, 153, 0.3);
        }
        
        /* Hero Section */
        .hero-section {
            min-height: 90vh;
            display: flex;
            align-items: center;
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 70%;
            height: 150%;
            background: linear-gradient(135deg, rgba(30, 87, 153, 0.05), rgba(40, 199, 111, 0.05));
            border-radius: 50%;
            z-index: -1;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            color: var(--dark);
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        .hero-title span {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.8;
        }
        
        .hero-image {
            max-width: 100%;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        
        .btn-cta {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-cta:hover {
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(30, 87, 153, 0.3);
        }
        
        .btn-outline-cta {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: 50px;
            padding: 0.9rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-outline-cta:hover {
            background: var(--primary);
            color: white;
        }
        
        /* Features Section */
        .features-section {
            padding: 5rem 0;
            background: white;
        }
        
        .section-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark);
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            color: #64748b;
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .feature-card {
            background: var(--light);
            border-radius: 20px;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s;
            border: 1px solid transparent;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
            border-color: var(--primary);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }
        
        .feature-icon.green { background: rgba(40, 199, 111, 0.15); color: var(--secondary); }
        .feature-icon.blue { background: rgba(30, 87, 153, 0.15); color: var(--primary); }
        .feature-icon.orange { background: rgba(255, 159, 67, 0.15); color: var(--accent); }
        .feature-icon.purple { background: rgba(115, 103, 240, 0.15); color: #7367f0; }
        
        .feature-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.8rem;
        }
        
        .feature-desc {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.7;
        }
        
        /* Stats Section */
        .stats-section {
            padding: 4rem 0;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
        }
        
        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }
        
        /* Footer */
        .footer {
            background: var(--dark);
            color: #94a3b8;
            padding: 3rem 0;
        }
        
        .footer-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
        }
        
        .footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer a:hover {
            color: white;
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .hero-section {
                min-height: auto;
                padding: 3rem 0;
            }
            
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-image {
                max-width: 80%;
                margin: 2rem auto 0;
                display: block;
            }
        }
        
        @media (max-width: 575px) {
            .hero-title {
                font-size: 1.8rem;
            }
            
            .btn-cta {
                width: 100%;
                justify-content: center;
            }
            
            .stat-number {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('assets/img/favicon/logo.png') }}" alt="LENTERA" 
                     style="height: 45px; margin-right: 10px;">
                <span>LENTERA<br><small style="font-size: 0.7rem; display: block; margin-top: -5px;">POSYANDU RINDAM IM</small></span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bx bx-menu fs-3"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link btn-login" href="{{ route('login') }}">
                            <i class="bx bx-log-in"></i> Masuk
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-1 order-2">
                    <div class="mb-4">
                        <img src="{{ asset('assets/img/favicon/logo.png') }}" alt="LENTERA" style="height: 80px; margin-bottom: 1.5rem;">
                        <h1 class="hero-title mb-0" style="line-height: 1.1;">
                            LENTERA
                            <div style="font-size: 1.2rem; font-weight: 600; color: var(--primary); margin-top: 0.5rem;">
                                POSYANDU RINDAM IM
                            </div>
                        </h1>
                    </div>
                    <p class="hero-acronym mb-3" style="font-size: 1.1rem; color: var(--primary); font-weight: 600;">
                        <strong>L</strong>ayanan <strong>E</strong>lektronik <strong>N</strong>utrisi <strong>T</strong>umbuh K<strong>e</strong>mbang Ent<strong>r</strong>i Rutin <strong>A</strong>nak
                    </p>
                    <p class="hero-subtitle">
                        Sistem informasi digital untuk membantu kader Posyandu dan tenaga kesehatan 
                        dalam mencatat, memantau, dan menganalisis pertumbuhan anak secara real-time. 
                        Cegah stunting sejak dini dengan data yang akurat!
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('login') }}" class="btn-cta">
                            <i class="bx bx-log-in"></i> Mulai Sekarang
                        </a>
                        <a href="#fitur" class="btn-outline-cta">
                            <i class="bx bx-info-circle"></i> Pelajari Lebih
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-2 order-1 text-center">
                    <img src="{{ asset('assets/img/landing-hero.png') }}" alt="LENTERA Posyandu" class="hero-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="fitur">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <p class="section-subtitle">Solusi digital lengkap untuk kegiatan Posyandu</p>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon green">
                            <i class="bx bx-child"></i>
                        </div>
                        <h5 class="feature-title">Pendataan Balita</h5>
                        <p class="feature-desc">
                            Catat data balita lengkap termasuk NIK, tanggal lahir, dan data kelahiran.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon blue">
                            <i class="bx bx-line-chart"></i>
                        </div>
                        <h5 class="feature-title">Deteksi Stunting</h5>
                        <p class="feature-desc">
                            Analisis otomatis Z-Score dan deteksi dini stunting berdasarkan standar WHO.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon orange">
                            <i class="bx bx-bar-chart-alt-2"></i>
                        </div>
                        <h5 class="feature-title">Laporan Real-time</h5>
                        <p class="feature-desc">
                            Dashboard statistik dan laporan yang dapat diekspor kapan saja.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon purple">
                            <i class="bx bx-map"></i>
                        </div>
                        <h5 class="feature-title">Peta Sebaran</h5>
                        <p class="feature-desc">
                            Visualisasi sebaran posyandu dan kasus stunting dalam peta interaktif.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section" id="tentang">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['posyandu'] ?? 0 }}</div>
                        <div class="stat-label">Posyandu Aktif</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['balita'] ?? 0 }}</div>
                        <div class="stat-label">Balita Terpantau</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['kader'] ?? 0 }}</div>
                        <div class="stat-label">Kader Aktif</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Akses Online</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5" style="background: var(--light);">
        <div class="container text-center py-4">
            <h3 class="mb-3" style="font-weight: 700; color: var(--dark);">Siap Menggunakan LENTERA POSYANDU RINDAM IM?</h3>
            <p class="text-muted mb-4">Hubungi kami untuk mendapatkan akses atau login jika sudah memiliki akun.</p>
            <a href="{{ route('login') }}" class="btn-cta">
                <i class="bx bx-log-in"></i> Login Sekarang
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" style="background: linear-gradient(135deg, #1e5799 0%, #2c3e50 100%); color: white; padding: 3rem 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="mb-3">
                        <img src="{{ asset('assets/img/favicon/logo.png') }}" alt="LENTERA" style="height: 60px; margin-bottom: 1rem;">
                        <div class="footer-brand" style="font-size: 1.8rem; font-weight: 700; color: white; margin-bottom: 0.5rem;">
                            LENTERA
                            <div style="font-size: 1rem; font-weight: 600; color: #28c76f; margin-top: 0.3rem;">
                                POSYANDU RINDAM IM
                            </div>
                        </div>
                    </div>
                    <p class="mt-2 mb-1" style="color: rgba(255,255,255,0.9);"><strong>L</strong>ayanan <strong>E</strong>lektronik <strong>N</strong>utrisi <strong>T</strong>umbuh K<strong>e</strong>mbang Ent<strong>r</strong>i Rutin <strong>A</strong>nak</p>
                    <p style="color: rgba(255,255,255,0.8);">Sistem Informasi Posyandu untuk pemantauan tumbuh kembang balita dan pencegahan stunting.</p>
                </div>
                <div class="col-lg-3 col-6">
                    <h6 class="text-white mb-3" style="color: #28c76f !important; font-weight: 600;">Navigasi</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#fitur" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s;">Fitur</a></li>
                        <li class="mb-2"><a href="#tentang" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s;">Tentang</a></li>
                        <li class="mb-2"><a href="{{ route('login') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s;">Login</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-6">
                    <h6 class="text-white mb-3" style="color: #28c76f !important; font-weight: 600;">Kontak</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2" style="color: rgba(255,255,255,0.8);"><i class="bx bx-envelope"></i> <a href="mailto:naomi_puze@yahoo.com" style="color: rgba(255,255,255,0.8); text-decoration: none;">naomi_puze@yahoo.com</a></li>
                        <li class="mb-2" style="color: rgba(255,255,255,0.8);"><i class="bx bx-phone"></i><a href="tel:+6281265977994" style="color: rgba(255,255,255,0.8); text-decoration: none;">+6281265977994</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
            <div class="text-center">
                <small style="color: rgba(255,255,255,0.9);">&copy; {{ date('Y') }} LENTERA POSYANDU RINDAM IM. Dibuat dengan <i class="bx bx-heart text-danger"></i> untuk Indonesia Sehat.</small>
                <br>
               <small style="color: rgba(255,255,255,0.7);">Developed by <a href="https://almuhayatsyah.my.id" style="color: #28c76f; text-decoration: none;">Almuhayatsyah</a></small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            } else {
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.05)';
            }
        });
    </script>
</body>
</html>

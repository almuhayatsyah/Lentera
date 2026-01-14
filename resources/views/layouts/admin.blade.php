<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name', 'LENTERA') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Sneat Core CSS (Local) -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#7367f0">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="LENTERA">

    <!-- Custom Styles -->
    <style>
        :root {
            --bs-primary: #7367f0;
            --bs-success: #28c76f;
            --bs-danger: #ea5455;
            --bs-warning: #ff9f43;
            --bs-info: #00cfe8;
        }
        .bg-menu-theme {
            background-color: #2f3349 !important;
        }
        .menu-vertical .menu-item .menu-link {
            color: rgba(255, 255, 255, 0.8);
        }
        .menu-vertical .menu-item.active > .menu-link {
            background: linear-gradient(72.47deg, #7367f0 22.16%, rgba(115, 103, 240, 0.7) 76.47%);
            color: #fff;
            box-shadow: 0 2px 6px 0 rgba(115, 103, 240, 0.5);
        }
        .app-brand .app-brand-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: #7367f0;
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 0.35em 0.7em;
            border-radius: 0.25rem;
        }
        .status-danger { background-color: #ea5455; color: white; }
        .status-warning { background-color: #ff9f43; color: white; }
        .status-success { background-color: #28c76f; color: white; }
        .status-info { background-color: #00cfe8; color: white; }
        
        /* Mobile First Improvements */
        @media (max-width: 767.98px) {
            .layout-menu {
                width: 16.25rem;
            }
            .card-mobile {
                margin-bottom: 1rem;
            }
            .btn-mobile-lg {
                padding: 1rem 2rem;
                font-size: 1.1rem;
            }
            .hide-on-mobile {
                display: none !important;
            }
        }
        
        /* Card hover effect */
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        
        /* Entry button style */
        .btn-entry {
            background: linear-gradient(72.47deg, #7367f0 22.16%, rgba(115, 103, 240, 0.7) 76.47%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 15px rgba(115, 103, 240, 0.4);
        }
        .btn-entry:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(115, 103, 240, 0.5);
            color: white;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo py-3 px-4">
                    <a href="{{ route('dashboard') }}" class="app-brand-link">
                        <span class="app-brand-logo demo me-2">
                            <i class='bx bxs-baby-carriage text-white' style="font-size: 2rem;"></i>
                        </span>
                        <span class="app-brand-text demo text-white fw-bold">LENTERA</span>
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle text-white"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div>Dashboard</div>
                        </a>
                    </li>

                    <!-- Entri Data (Kader Only) -->
                    @if(auth()->user()->isKader())
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text text-white-50">ENTRI DATA</span>
                    </li>
                    <li class="menu-item {{ request()->routeIs('kunjungan.*') ? 'active' : '' }}">
                        <a href="{{ route('kunjungan.wizard') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                            <div>Kunjungan Baru</div>
                        </a>
                    </li>
                    @endif

                    <!-- Data Master -->
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text text-white-50">DATA MASTER</span>
                    </li>
                    
                    @if(auth()->user()->isAdmin())
                    <li class="menu-item {{ request()->routeIs('posyandu.*') ? 'active' : '' }}">
                        <a href="{{ route('posyandu.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-building-house"></i>
                            <div>Posyandu</div>
                        </a>
                    </li>
                    @endif

                    <li class="menu-item {{ request()->routeIs('ibu.*') ? 'active' : '' }}">
                        <a href="{{ route('ibu.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-female"></i>
                            <div>Data Ibu</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->routeIs('anak.*') ? 'active' : '' }}">
                        <a href="{{ route('anak.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-child"></i>
                            <div>Data Anak</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->routeIs('kunjungan.history') ? 'active' : '' }}">
                        <a href="{{ route('kunjungan.history') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-history"></i>
                            <div>Riwayat Kunjungan</div>
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin())
                    <!-- Laporan -->
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text text-white-50">LAPORAN</span>
                    </li>
                    <li class="menu-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                            <div>Laporan</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('laporan.skdn') }}" class="menu-link">
                                    <div>Laporan SKDN</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('laporan.sebaran') }}" class="menu-link">
                                    <div>Peta Sebaran</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Manajemen -->
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text text-white-50">MANAJEMEN</span>
                    </li>
                    <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-user-circle"></i>
                            <div>Pengguna</div>
                        </a>
                    </li>
                    @endif
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search - Mobile Hidden -->
                        <div class="navbar-nav align-items-center d-none d-md-flex">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Cari anak..." aria-label="Search...">
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Posyandu Info -->
                            <li class="nav-item me-3 d-none d-md-block">
                                <span class="badge bg-label-primary">
                                    <i class="bx bx-building-house me-1"></i>
                                    {{ auth()->user()->posyandu_name }}
                                </span>
                            </li>

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <span class="avatar-initial rounded-circle bg-primary">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                        </span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <span class="avatar-initial rounded-circle bg-primary">
                                                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                                                    <small class="text-muted">{{ auth()->user()->role_label }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li><div class="dropdown-divider"></div></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">Profil Saya</span>
                                        </a>
                                    </li>
                                    <li><div class="dropdown-divider"></div></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">Keluar</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <!-- Flash Messages -->
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bx bx-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bx bx-error-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bx bx-error-circle me-2"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        {{ $slot }}
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                © {{ date('Y') }} <strong>LENTERA</strong> - Sistem Pemantauan Tumbuh Kembang Anak
                            </div>
                            <div>
                                <span class="text-muted">v1.0.0</span>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Alpine.js for Wizard -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- PWA Service Worker -->
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .then(reg => console.log('Service Worker registered'))
                .catch(err => console.log('Service Worker registration failed:', err));
        }
    </script>

    @stack('scripts')
</body>
</html>

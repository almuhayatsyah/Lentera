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
    <meta name="theme-color" content="#1e5799">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="LENTERA">

    <!-- Custom Styles -->
    <style>
        :root {
            /* LENTERA Brand Colors from Logo */
            --lentera-primary: #1e5799;      /* Biru Tua */
            --lentera-secondary: #00b4d8;    /* Biru Muda/Cyan */
            --lentera-success: #52b788;      /* Hijau */
            --lentera-warning: #f9a825;      /* Orange */
            --lentera-danger: #e63946;       /* Merah */
            --lentera-light: #fff8e7;        /* Krem */
            
            /* Bootstrap overrides */
            --bs-primary: #1e5799;
            --bs-success: #52b788;
            --bs-danger: #e63946;
            --bs-warning: #f9a825;
            --bs-info: #00b4d8;
        }
        
        /* Sidebar Menu with gradient from logo colors */
        .bg-menu-theme {
            background: linear-gradient(180deg, #1e5799 0%, #0a3d62 100%) !important;
        }
        .menu-vertical .menu-item .menu-link {
            color: rgba(255, 255, 255, 0.85);
        }
        .menu-vertical .menu-item .menu-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .menu-vertical .menu-item.active > .menu-link {
            background: linear-gradient(90deg, #00b4d8 0%, #52b788 100%);
            color: #fff;
            box-shadow: 0 2px 6px 0 rgba(0, 180, 216, 0.4);
        }
        
        /* Modern Menu Headers */
        .menu-header {
            padding: 1rem 1.25rem 0.5rem;
            margin-top: 0.75rem;
        }
        .menu-header-text {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5) !important;
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            background: linear-gradient(90deg, rgba(255,255,255,0.08) 0%, transparent 100%);
            border-left: 3px solid rgba(0, 180, 216, 0.6);
        }
        .menu-header-text::before {
            content: '';
            display: inline-block;
            width: 18px;
            height: 18px;
            background-size: contain;
            background-repeat: no-repeat;
            opacity: 0.6;
        }
        /* Different icons for each menu section */
        .menu-header.data-master .menu-header-text::before {
            content: '📊';
            font-size: 12px;
            width: auto;
            height: auto;
        }
        .menu-header.laporan .menu-header-text::before {
            content: '📋';
            font-size: 12px;
            width: auto;
            height: auto;
        }
        .menu-header.manajemen .menu-header-text::before {
            content: '⚙️';
            font-size: 12px;
            width: auto;
            height: auto;
        }
        .menu-header.entri-data .menu-header-text::before {
            content: '✏️';
            font-size: 12px;
            width: auto;
            height: auto;
        }
        
        /* Brand text */
        .app-brand .app-brand-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
        }
        
        /* Status badges with new colors */
        .status-badge {
            font-size: 0.75rem;
            padding: 0.35em 0.7em;
            border-radius: 0.25rem;
        }
        .status-danger { background-color: #e63946; color: white; }
        .status-warning { background-color: #f9a825; color: white; }
        .status-success { background-color: #52b788; color: white; }
        .status-info { background-color: #00b4d8; color: white; }
        
        /* Primary button with gradient */
        .btn-primary {
            background: linear-gradient(135deg, #1e5799 0%, #00b4d8 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #164578 0%, #0096b7 100%);
        }
        
        /* Badge colors */
        .bg-primary, .badge.bg-primary { background-color: #1e5799 !important; }
        .bg-success, .badge.bg-success { background-color: #52b788 !important; }
        .bg-info, .badge.bg-info { background-color: #00b4d8 !important; }
        .bg-warning, .badge.bg-warning { background-color: #f9a825 !important; }
        .bg-danger, .badge.bg-danger { background-color: #e63946 !important; }
        
        /* Label badges */
        .bg-label-primary { background-color: rgba(30, 87, 153, 0.16) !important; color: #1e5799 !important; }
        .bg-label-success { background-color: rgba(82, 183, 136, 0.16) !important; color: #52b788 !important; }
        .bg-label-info { background-color: rgba(0, 180, 216, 0.16) !important; color: #00b4d8 !important; }
        .bg-label-warning { background-color: rgba(249, 168, 37, 0.16) !important; color: #f9a825 !important; }
        .bg-label-danger { background-color: rgba(230, 57, 70, 0.16) !important; color: #e63946 !important; }
        
        /* Avatar initial */
        .avatar-initial.bg-primary { background: linear-gradient(135deg, #1e5799 0%, #00b4d8 100%) !important; }
        
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
            
            /* Sticky First Column for Tables on Mobile */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .table-responsive table thead th:first-child,
            .table-responsive table tbody td:first-child {
                position: sticky;
                left: 0;
                background-color: #fff;
                z-index: 10;
                box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            }
            .table-responsive table thead th:first-child {
                background-color: #f8f9fa;
                z-index: 11;
            }
            .table-responsive table tbody tr:nth-child(even) td:first-child {
                background-color: #f8f9fa;
            }
            .table-responsive table tbody tr:hover td:first-child {
                background-color: #e9ecef;
            }
        }
        
        /* Card hover effect */
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(30, 87, 153, 0.15);
            transition: all 0.3s ease;
        }
        
        /* Entry button style - gradient from logo */
        .btn-entry {
            background: linear-gradient(135deg, #1e5799 0%, #00b4d8 50%, #52b788 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 15px rgba(30, 87, 153, 0.4);
        }
        .btn-entry:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 87, 153, 0.5);
            color: white;
        }
        
        /* Text colors */
        .text-primary { color: #1e5799 !important; }
        .text-success { color: #52b788 !important; }
        .text-info { color: #00b4d8 !important; }
        .text-warning { color: #f9a825 !important; }
        .text-danger { color: #e63946 !important; }
        
        /* Links */
        a { color: #1e5799; }
        a:hover { color: #00b4d8; }
        
        /* ===== Bottom Navigation for Mobile ===== */
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #ffffff;
            box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.1);
            z-index: 1050;
            padding: 8px 0;
            padding-bottom: max(8px, env(safe-area-inset-bottom));
        }
        
        .bottom-nav-container {
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #94a3b8;
            font-size: 0.7rem;
            padding: 4px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
            min-width: 60px;
        }
        
        .bottom-nav-item i {
            font-size: 1.4rem;
            margin-bottom: 2px;
        }
        
        .bottom-nav-item.active {
            color: #1e5799;
        }
        
        .bottom-nav-item.active i {
            color: #1e5799;
        }
        
        .bottom-nav-item:hover {
            color: #00b4d8;
        }
        
        /* FAB Entry Button in Center */
        .bottom-nav-fab {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            margin-top: -25px;
        }
        
        .bottom-nav-fab-btn {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e5799 0%, #00b4d8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(30, 87, 153, 0.4);
            transition: all 0.3s ease;
        }
        
        .bottom-nav-fab-btn i {
            font-size: 1.8rem;
            color: white;
        }
        
        .bottom-nav-fab:hover .bottom-nav-fab-btn {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(30, 87, 153, 0.5);
        }
        
        .bottom-nav-fab-label {
            font-size: 0.65rem;
            color: #1e5799;
            margin-top: 4px;
            font-weight: 600;
        }
        
        /* Show bottom nav on mobile, hide sidebar toggle */
        @media (max-width: 991.98px) {
            .bottom-nav {
                display: block;
            }
            
            /* Add padding to content so it doesn't hide behind bottom nav */
            .layout-page {
                padding-bottom: 80px !important;
            }
            
            /* Hide the menu toggle button on mobile since we have bottom nav */
            .layout-menu-toggle {
                display: none !important;
            }
        }
        
        /* Keep sidebar visible on desktop */
        @media (min-width: 992px) {
            .bottom-nav {
                display: none !important;
            }
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
                            <img src="{{ asset('assets/img/favicon/logo.png') }}" alt="LENTERA" style="height: 32px; width: auto;">
                        </span>
                        <span class="app-brand-text demo text-white fw-bold" style="text-transform: none !important;">LENTERA</span>
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
                    <li class="menu-header small text-uppercase entri-data">
                        <span class="menu-header-text">ENTRI DATA</span>
                    </li>
                    <li class="menu-item {{ request()->routeIs('kunjungan.*') ? 'active' : '' }}">
                        <a href="{{ route('kunjungan.wizard') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                            <div>Kunjungan Baru</div>
                        </a>
                    </li>
                    @endif

                    <!-- Data Master -->
                    <li class="menu-header small text-uppercase data-master">
                        <span class="menu-header-text">DATA MASTER</span>
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

                    <li class="menu-item {{ request()->routeIs('kunjungan.index') || request()->routeIs('kunjungan.show') ? 'active' : '' }}">
                        <a href="{{ route('kunjungan.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-history"></i>
                            <div>Riwayat Kunjungan</div>
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin())
                    <!-- Laporan -->
                    <li class="menu-header small text-uppercase laporan">
                        <span class="menu-header-text">LAPORAN</span>
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
                    <li class="menu-header small text-uppercase manajemen">
                        <span class="menu-header-text">MANAJEMEN</span>
                    </li>
                    <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-user-circle"></i>
                            <div>Pengguna</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('activity-log.*') ? 'active' : '' }}">
                        <a href="{{ route('activity-log.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ul"></i>
                            <div>Log Aktivitas</div>
                        </a>
                    </li>
                    @endif
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar" style="position: sticky; top: 0; z-index: 1030;">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <!-- Mobile Logo -->
                    <div class="d-flex align-items-center d-xl-none me-auto">
                        <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                            <img src="{{ asset('assets/img/favicon/logo.png') }}" alt="LENTERA" height="32" class="me-2">
                            <span class="fw-bold text-primary d-inline" style="font-size: 1.1rem; text-transform: none !important;">LENTERA</span>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Date & Time Display -->
                        <div class="navbar-nav align-items-center d-none d-md-flex">
                            <div class="nav-item d-flex align-items-center text-muted">
                                <i class="bx bx-calendar me-2 fs-5"></i>
                                <span id="currentDateTime" class="small fw-medium"></span>
                            </div>
                        </div>
                        <!-- /Date & Time -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Notification Bell -->
                            @php
                                $notifCount = 0;
                                $anakBelumKunjungan = collect();
                                if (auth()->user()->isKader()) {
                                    $anakBelumKunjungan = \App\Models\Anak::where('posyandu_id', auth()->user()->posyandu_id)
                                        ->aktif()
                                        ->balita()
                                        ->whereDoesntHave('kunjungans', function($q) {
                                            $q->whereMonth('tanggal_kunjungan', now()->month)
                                              ->whereYear('tanggal_kunjungan', now()->year);
                                        })
                                        ->take(5)
                                        ->get();
                                    $notifCount = $anakBelumKunjungan->count();
                                }
                            @endphp
                            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-2">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    <i class="bx bx-bell bx-sm"></i>
                                    @if($notifCount > 0)
                                        <span class="badge bg-danger rounded-pill badge-notifications">{{ $notifCount > 9 ? '9+' : $notifCount }}</span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end py-0" style="min-width: 300px;">
                                    <li class="dropdown-menu-header border-bottom">
                                        <div class="dropdown-header d-flex align-items-center py-3">
                                            <h6 class="mb-0 me-auto">Notifikasi</h6>
                                            @if($notifCount > 0)
                                                <span class="badge bg-warning rounded-pill">{{ $notifCount }} belum kunjungan</span>
                                            @endif
                                        </div>
                                    </li>
                                    <li class="dropdown-notifications-list scrollable-container" style="max-height: 300px; overflow-y: auto;">
                                        <ul class="list-group list-group-flush">
                                            @forelse($anakBelumKunjungan as $anak)
                                                <li class="list-group-item list-group-item-action">
                                                    <a href="{{ route('kunjungan.wizard.anak', $anak) }}" class="d-flex text-decoration-none">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar avatar-sm">
                                                                <span class="avatar-initial rounded-circle bg-label-warning">
                                                                    <i class="bx bx-child"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1 small">{{ $anak->nama }}</h6>
                                                            <small class="text-muted">
                                                                {{ $anak->usia_format }} • Belum kunjungan bulan ini
                                                            </small>
                                                        </div>
                                                    </a>
                                                </li>
                                            @empty
                                                <li class="list-group-item">
                                                    <div class="text-center py-3 text-success">
                                                        <i class="bx bx-check-circle bx-md"></i>
                                                        <p class="mb-0 small">Semua anak sudah kunjungan!</p>
                                                    </div>
                                                </li>
                                            @endforelse
                                        </ul>
                                    </li>
                                    @if($notifCount > 0)
                                        <li class="dropdown-menu-footer border-top py-2">
                                            <a href="{{ route('anak.index') }}" class="dropdown-item text-center text-primary small">
                                                Lihat Semua Data Anak
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>

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
                                        @if(auth()->user()->photo_url)
                                            <img src="{{ auth()->user()->photo_url }}" alt="{{ auth()->user()->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <span class="avatar-initial rounded-circle bg-primary">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                            </span>
                                        @endif
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        @if(auth()->user()->photo_url)
                                                            <img src="{{ auth()->user()->photo_url }}" alt="{{ auth()->user()->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                                        @else
                                                            <span class="avatar-initial rounded-circle bg-primary">
                                                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                                            </span>
                                                        @endif
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
                        <!-- Breadcrumb Navigation -->
                        @if(isset($breadcrumb) || isset($pageTitle))
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center gap-3">
                                @if(isset($backUrl))
                                    <a href="{{ $backUrl }}" class="btn btn-icon btn-outline-secondary rounded-circle" title="Kembali">
                                        <i class="bx bx-arrow-back"></i>
                                    </a>
                                @endif
                                <div>
                                    @if(isset($pageTitle))
                                        <h4 class="mb-0">{{ $pageTitle }}</h4>
                                    @endif
                                        @if(isset($breadcrumbItems))
                                            <nav aria-label="breadcrumb">
                                                <ol class="breadcrumb mb-0 mt-1">
                                                    <li class="breadcrumb-item">
                                                        <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                                                    </li>
                                                    {{ $breadcrumbItems }}
                                                </ol>
                                            </nav>
                                        @endif
                                </div>
                            </div>
                            @if(isset($headerAction))
                                <div>{{ $headerAction }}</div>
                            @endif
                        </div>
                        @endif

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
        
        // Live Date & Time Display
        function updateDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            const formatted = now.toLocaleDateString('id-ID', options);
            const el = document.getElementById('currentDateTime');
            if (el) el.textContent = formatted;
        }
        updateDateTime();
        setInterval(updateDateTime, 60000); // Update setiap menit
    </script>

    <!-- Bottom Navigation for Mobile -->
    <nav class="bottom-nav">
        <div class="bottom-nav-container">
            <!-- Beranda -->
            <a href="{{ route('dashboard') }}" class="bottom-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class='bx {{ request()->routeIs('dashboard') ? 'bxs-home' : 'bx-home' }}'></i>
                <span>Beranda</span>
            </a>
            
            <!-- Anak -->
            <a href="{{ route('anak.index') }}" class="bottom-nav-item {{ request()->routeIs('anak.*') ? 'active' : '' }}">
                <i class='bx {{ request()->routeIs('anak.*') ? 'bxs-baby-carriage' : 'bx-child' }}'></i>
                <span>Anak</span>
            </a>
            
            <!-- Entri (FAB) -->
            <a href="{{ route('kunjungan.wizard') }}" class="bottom-nav-fab">
                <div class="bottom-nav-fab-btn">
                    <i class='bx bx-plus'></i>
                </div>
                <span class="bottom-nav-fab-label">Entri</span>
            </a>
            
            <!-- Riwayat -->
            <a href="{{ route('kunjungan.index') }}" class="bottom-nav-item {{ request()->routeIs('kunjungan.*') ? 'active' : '' }}">
                <i class='bx {{ request()->routeIs('kunjungan.*') ? 'bxs-calendar-check' : 'bx-history' }}'></i>
                <span>Riwayat</span>
            </a>
            
            <!-- Akun -->
            <a href="{{ route('profile.edit') }}" class="bottom-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class='bx {{ request()->routeIs('profile.*') ? 'bxs-user' : 'bx-user' }}'></i>
                <span>Akun</span>
            </a>
        </div>
    </nav>

    @stack('scripts')
</body>
</html>

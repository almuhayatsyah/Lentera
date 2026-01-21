<?php

/**
 * resources/views/settings/index.blade.php
 *
 * Unified Settings dashboard with cards linking to sub‑features:
 *   - Users management
 *   - Activity Log (view & prune)
 *   - Backup & Reset
 */
?>
<x-admin-layout>
    <x-slot name="title">Pengaturan Sistem</x-slot>
    <x-slot name="pageTitle">Pengaturan</x-slot>
    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Pengaturan</li>
    </x-slot>

    <div class="row g-4">
        <!-- Users Card -->
        <div class="col-12 col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title"><i class="bx bx-user me-2"></i>Pengguna</h5>
                    <p class="card-text text-muted">Kelola akun pengguna, peran, dan hak akses.</p>
                    <a href="{{ route('settings.users') }}" class="btn btn-primary mt-3">Buka</a>
                </div>
            </div>
        </div>

        <!-- Activity Log Card -->
        <div class="col-12 col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title"><i class="bx bx-history me-2"></i>Log Aktivitas</h5>
                    <p class="card-text text-muted">Lihat riwayat aksi dan bersihkan log lama.</p>
                    <div class="mt-3">
                        <a href="{{ route('settings.activity') }}" class="btn btn-primary me-2">Lihat Log</a>
                        <form action="{{ route('settings.activity.prune') }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus semua log lebih lama dari {{ env('ACTIVITY_LOG_RETENTION_DAYS', 30) }} hari?');">
                            @csrf
                            <button type="submit" class="btn btn-danger">Bersihkan Log</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Backup & Reset Card -->
        <div class="col-12 col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title"><i class="bx bx-save me-2"></i>Backup & Reset</h5>
                    <p class="card-text text-muted">Ekspor database atau reset sistem (kecuali akun developer).</p>
                    <a href="{{ route('settings.backup') }}" class="btn btn-primary mt-3">Kelola Backup</a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

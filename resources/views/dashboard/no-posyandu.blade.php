<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-warning">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="bx bx-info-circle me-2"></i>
                        Belum Ditugaskan ke Posyandu
                    </h5>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bx bx-building-house" style="font-size: 80px; color: #f9a825;"></i>
                    </div>
                    
                    <h4 class="mb-3">Selamat Datang, {{ auth()->user()->name }}!</h4>
                    
                    <p class="text-muted mb-4">
                        Akun Anda saat ini <strong>belum ditugaskan ke Posyandu</strong> tertentu.
                        <br>Silakan hubungi <strong>Admin Puskesmas</strong> untuk mendapatkan penugasan Posyandu.
                    </p>

                    <div class="alert alert-info">
                        <i class="bx bx-info-circle me-2"></i>
                        Setelah ditugaskan, Anda akan dapat:
                        <ul class="mt-2 mb-0 text-start" style="max-width: 400px; margin-left: auto; margin-right: auto;">
                            <li>Melihat data anak di Posyandu Anda</li>
                            <li>Mencatat kunjungan dan pengukuran</li>
                            <li>Memantau status gizi anak</li>
                            <li>Melihat laporan Posyandu</li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary me-2">
                            <i class="bx bx-user me-1"></i>
                            Lihat Profil Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="bx bx-power-off me-1"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Admin Card -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="mb-3">
                        <i class="bx bx-support me-2"></i>
                        Butuh Bantuan?
                    </h6>
                    <p class="text-muted mb-2">
                        Jika Anda sudah seharusnya ditugaskan ke suatu Posyandu atau memiliki pertanyaan, 
                        silakan hubungi Admin Puskesmas untuk bantuan lebih lanjut.
                    </p>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bx bx-phone text-primary fs-5"></i>
                        <small class="text-muted">Hubungi: Admin Puskesmas</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

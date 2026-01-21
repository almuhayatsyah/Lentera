<x-admin-layout>
    <x-slot name="title">Backup & Reset Sistem</x-slot>

    <div class="row">
        <!-- Backup Database Card -->
        <div class="col-md-6 mb-4">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bx bx-data me-2"></i>
                        Backup Database
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Export seluruh database ke file SQL untuk backup atau migrasi.</p>
                    
                    <div class="alert alert-info">
                        <strong>Statistik Database:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Users: {{ $stats['users'] }}</li>
                            <li>Posyandu: {{ $stats['posyandus'] }}</li>
                            <li>Data Ibu: {{ $stats['ibus'] }}</li>
                            <li>Data Anak: {{ $stats['anaks'] }}</li>
                            <li>Kunjungan: {{ $stats['kunjungans'] }}</li>
                            <li>Ukuran Database: ~{{ $stats['database_size'] }} MB</li>
                        </ul>
                    </div>

                    <form action="{{ route('settings.backup.perform') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bx bx-download me-2"></i>
                            Download Backup SQL
                        </button>
                    </form>

                    <small class="text-muted mt-2 d-block">
                        <i class="bx bx-info-circle"></i>
                        File akan didownload dengan nama: backup_lentera_YYYY-MM-DD_HHmmss.sql
                    </small>
                </div>
            </div>
        </div>

        <!-- Reset Sistem Card -->
        <div class="col-md-6 mb-4">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bx bx-error-circle me-2"></i>
                        Reset Sistem
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Hapus SEMUA data dan kembalikan sistem ke kondisi awal.</p>
                    
                    <div class="alert alert-warning">
                        <strong>⚠️ PERINGATAN:</strong>
                        <p class="mb-0 mt-2">Reset sistem akan menghapus <strong>SEMUA DATA</strong>:</p>
                        <ul class="mt-2 mb-0">
                            <li>Semua Kunjungan & Pengukuran</li>
                            <li>Semua Data Anak & Ibu</li>
                            <li>Semua Posyandu</li>
                            <li>Semua Users (kecuali Developer)</li>
                            <li>Semua Activity Logs</li>
                        </ul>
                    </div>

                    <div class="alert alert-success">
                        ✅ <strong>Yang Tetap Ada:</strong> Akun Developer (developer@lentera.app)
                    </div>

                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#resetModal">
                        <i class="bx bx-trash me-2"></i>
                        Reset Sistem Total
                    </button>

                    <small class="text-danger mt-2 d-block">
                        <i class="bx bx-error"></i>
                        <strong>Tindakan ini TIDAK DAPAT DIBATALKAN!</strong> Pastikan sudah backup terlebih dahulu.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Confirmation Modal -->
    <div class="modal fade" id="resetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">
                        <i class="bx bx-error-circle me-2"></i>Konfirmasi Reset Sistem
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('settings.reset') }}" method="POST" id="resetForm">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger mb-4">
                            <i class="bx bx-error-circle bx-lg"></i>
                            <p class="mb-0 mt-2"><strong>PERINGATAN KERAS!</strong></p>
                            <p class="mb-0">Anda akan menghapus SEMUA data dari sistem. Tindakan ini PERMANEN dan TIDAK DAPAT DIBATALKAN.</p>
                        </div>

                        <p class="mb-3">Untuk melanjutkan reset sistem, masukkan <strong>password Admin Anda</strong>:</p>
                        
                        <div class="mb-3">
                            <label class="form-label">Password Konfirmasi</label>
                            <input type="password" name="password" class="form-control" required autofocus>
                            <small class="text-muted">Masukkan password akun Anda saat ini</small>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirmCheck" required>
                            <label class="form-check-label text-danger" for="confirmCheck">
                                <strong>Saya memahami risiko dan yakin ingin reset sistem</strong>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" id="confirmResetBtn" disabled>
                            <i class="bx bx-trash me-1"></i>Ya, Reset Sistem
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Enable submit button only when checkbox is checked
        document.getElementById('confirmCheck').addEventListener('change', function() {
            document.getElementById('confirmResetBtn').disabled = !this.checked;
        });

        // Additional confirmation before submit
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            if (!confirm('KONFIRMASI TERAKHIR: Yakin ingin menghapus SEMUA data sistem?')) {
                e.preventDefault();
            }
        });
    </script>
    @endpush
</x-admin-layout>

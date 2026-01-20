<x-admin-layout>
    <x-slot name="title">Log Aktivitas</x-slot>
    <x-slot name="pageTitle">Log Aktivitas Sistem</x-slot>
    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Log Aktivitas</li>
    </x-slot>

    <div class="card">
        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
            <div>
                <h5 class="card-title mb-0">Filter Log</h5>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('activity-log.clear') }}" method="POST" id="clearLogsForm">
                    @csrf
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmClearLogs()">
                        <i class="bx bx-trash me-1"></i> Bersihkan Log Lama
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body py-3">
            <form action="{{ route('activity-log.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Aktivitas</label>
                        <input type="text" name="activity" class="form-control" placeholder="Cari aktivitas..." value="{{ request('activity') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-filter-alt me-1"></i> Filter
                            </button>
                            @if(request()->anyFilled(['activity', 'date', 'user_id']))
                                <a href="{{ route('activity-log.index') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-reset"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 15%">Waktu</th>
                        <th style="width: 15%">Pengguna</th>
                        <th style="width: 15%">Aktivitas</th>
                        <th>Keterangan</th>
                        <th style="width: 10%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($logs as $log)
                        <tr>
                            <td>
                                <span class="fw-medium">{{ $log->created_at->format('d/m/Y') }}</span><br>
                                <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xs me-2">
                                        <span class="avatar-initial rounded-circle bg-label-{{ $log->user->role === 'admin_puskesmas' ? 'primary' : 'success' }}">
                                            {{ strtoupper(substr($log->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fw-bold small">{{ $log->user->name }}</div>
                                        <small class="text-muted" style="font-size: 0.7rem">{{ $log->user->role_label }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-label-{{ 
                                    str_contains(strtolower($log->activity), 'tambah') ? 'success' : 
                                    (str_contains(strtolower($log->activity), 'hapus') ? 'danger' : 
                                    (str_contains(strtolower($log->activity), 'update') ? 'warning' : 'info')) 
                                }}">
                                    {{ $log->activity }}
                                </span>
                            </td>
                            <td>
                                <div class="text-wrap" style="max-width: 300px; font-size: 0.85rem">
                                    {{ Str::limit($log->description, 50) }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-icon btn-sm btn-outline-info" 
                                            onclick="showLogDetail({{ $log->id }})" title="Detail">
                                        <i class="bx bx-search-alt"></i>
                                    </button>
                                    <form action="{{ route('activity-log.destroy', $log) }}" method="POST" id="deleteForm{{ $log->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-icon btn-sm btn-outline-danger" 
                                                onclick="confirmDelete({{ $log->id }})" title="Hapus">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bx bx-info-circle fs-1 mb-2"></i>
                                <p>Belum ada data log aktivitas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer px-4 py-3 border-top">
            {{ $logs->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">
                        <i class="bx bx-error-circle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bx bx-trash bx-lg text-danger mb-3"></i>
                    <p class="mb-0">Apakah Anda yakin ingin menghapus log ini?</p>
                    <small class="text-muted">Data yang dihapus tidak dapat dikembalikan.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="bx bx-trash me-1"></i>Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Clear Logs Confirmation Modal -->
    <div class="modal fade" id="clearLogsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">
                        <i class="bx bx-error-circle me-2"></i>Konfirmasi Bersihkan Log
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bx bx-category bx-lg text-warning mb-3"></i>
                    <p class="mb-0">Apakah Anda yakin ingin membersihkan log lama (lebih dari 30 hari)?</p>
                    <small class="text-muted">Tindakan ini akan menghapus semua log yang sudah lebih dari 30 hari.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning" id="confirmClearBtn">
                        <i class="bx bx-trash me-1"></i>Ya, Bersihkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Log Detail Modal -->
    <div class="modal fade" id="logDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Aktivitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="logDetailContent">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let deleteLogId = null;

        // Show delete confirmation modal
        function confirmDelete(logId) {
            deleteLogId = logId;
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Handle delete confirmation
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (deleteLogId) {
                document.getElementById('deleteForm' + deleteLogId).submit();
            }
        });

        // Show clear logs confirmation modal
        function confirmClearLogs() {
            const modal = new bootstrap.Modal(document.getElementById('clearLogsModal'));
            modal.show();
        }

        // Handle clear logs confirmation
        document.getElementById('confirmClearBtn').addEventListener('click', function() {
            document.getElementById('clearLogsForm').submit();
        });

        // Show log detail modal
        function showLogDetail(id) {
            const modal = new bootstrap.Modal(document.getElementById('logDetailModal'));
            const container = document.getElementById('logDetailContent');
            
            modal.show();
            container.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;

            fetch(`/activity-log/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const log = data.data;
                        container.innerHTML = `
                            <div class="row g-3">
                                <div class="col-md-6 border-end">
                                    <h6 class="text-primary mb-2">Informasi Umum</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr><th style="width: 120px">Waktu</th><td>: ${log.created_at}</td></tr>
                                        <tr><th>Pengguna</th><td>: ${log.user} (${log.role})</td></tr>
                                        <tr><th>Aktivitas</th><td>: <span class="badge bg-label-info">${log.activity}</span></td></tr>
                                        <tr><th>IP Address</th><td>: ${log.ip_address}</td></tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-2">Metadata</h6>
                                    <div class="bg-light p-2 rounded" style="font-size: 0.75rem; word-break: break-all;">
                                        <strong>User Agent:</strong><br>
                                        ${log.user_agent}
                                    </div>
                                </div>
                                <div class="col-12 border-top pt-3">
                                    <h6 class="text-primary mb-2">Keterangan Lengkap</h6>
                                    <div class="p-3 bg-lighter rounded border">
                                        ${log.description || 'Tidak ada keterangan tambahan.'}
                                    </div>
                                </div>
                                ${log.properties ? `
                                <div class="col-12 mt-3">
                                    <h6 class="text-primary mb-2">Data Properti</h6>
                                    <pre class="bg-dark text-white p-3 rounded" style="font-size: 0.75rem">${JSON.stringify(log.properties, null, 2)}</pre>
                                </div>` : ''}
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    container.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan saat mengambil data.</div>`;
                });
        }
    </script>
    @endpush
</x-admin-layout>

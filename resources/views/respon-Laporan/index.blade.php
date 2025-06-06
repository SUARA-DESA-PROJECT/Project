@extends('layouts.app')

@section('content')
<script>
    @if(Session::has('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ Session::get('success') }}",
            showConfirmButton: true,
            confirmButtonColor: '#468B94',
            timer: 3000,
            timerProgressBar: true,
            position: 'center'
        });
    @endif
</script>
<div class="container-fluid px-4">
    <h2 class="mt-4">Respon Laporan</h2>
    <p class="text-muted">Kelola dan update status penanganan laporan yang telah terverifikasi</p>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-chart-line me-1"></i>
                    Daftar Laporan Terverifikasi
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pelapor</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Status Penanganan</th>
                            <th>Deskripsi Penanganan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $index => $laporan)
                        <tr class="align-middle">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $laporan->tanggal_pelaporan }}</td>
                            <td>{{ $laporan->nama_pelapor }}</td>
                            <td>{{ $laporan->kategori_laporan }}</td>
                            <td>{{ $laporan->tempat_kejadian }}</td>
                            <td class="text-center">
                                <span class="status-badge {{ $laporan->status_penanganan == 'Sudah ditangani' ? 'verified' : 'unverified' }}">
                                    <i class="fas {{ $laporan->status_penanganan == 'Sudah ditangani' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                    {{ $laporan->status_penanganan }}
                                </span>
                            </td>
                            <td>{{ $laporan->deskripsi_penanganan ?? '-' }}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <a href="{{ route('respon.edit', $laporan->id) }}" class="btn-action edit">
                                        <i class="fa fa-edit"></i> Update
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                                    <p>Tidak ada data laporan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="updateResponModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Respon Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateResponForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status Penanganan</label>
                        <select name="status_penanganan" class="form-select" required>
                            <option value="">Pilih Status</option>
                            <option value="Sudah ditangani">Sudah ditangani</option>
                            <option value="Belum ditangani">Belum ditangani</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Penanganan</label>
                        <textarea name="deskripsi_penanganan" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-action edit">Update Respon</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check for success message

        // Check for error message
        @if(Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ Session::get('error') }}",
                showConfirmButton: true,
                confirmButtonColor: '#468B94',
                toast: true,
                position: 'top-end',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        @endif
    });
</script>
@endpush

<style>
/* Animation Keyframes */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translate3d(0, -20px, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

/* Title Styles */
h2 {
    color: #333333;
    font-weight: 600;
    margin-bottom: 10px;
    animation: fadeInUp 0.4s ease-out;
}

p {
    margin-bottom: 20px;
    animation: fadeInUp 0.4s ease-out 0.1s backwards;
}

/* Card Animation */
.card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    animation: scaleIn 0.4s ease-out;
    margin-top: 1rem;
}

/* Table Styles */
.table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
    animation: fadeInUp 0.4s ease-out 0.2s backwards;
}

.table thead th {
    padding: 16px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    color: #495057;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    text-align: center;
    vertical-align: middle;
}

/* Row Animation */
.table tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #dee2e6;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateX(6px);
    box-shadow: -6px 0 0 0 #468B94;
}

/* Action Buttons */
.btn-action {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: all 0.3s ease;
    width: 100px;
    height: 36px;
}

.btn-action.edit {
    background-color: #468B94;
    color: white;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    color: white;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    min-width: 120px;
    justify-content: center;
    transition: all 0.3s ease;
}

.status-badge.verified {
    background-color: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.status-badge.unverified {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.status-badge i {
    margin-right: 6px;
}

/* Empty State */
.empty-state {
    padding: 40px;
    text-align: center;
    color: #6c757d;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.empty-state p {
    margin: 0;
    font-size: 14px;
}

/* Additional Styles */
.table-responsive {
    overflow-x: hidden !important;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.table-responsive::-webkit-scrollbar {
    display: none;
}

.container-fluid {
    overflow-x: hidden;
}
</style>
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
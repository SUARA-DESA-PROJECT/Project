@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h2 class="mt-4">Respon Laporan</h2>
    <p class="text-muted">Kelola dan berikan respon untuk laporan yang telah diverifikasi atau ditolak</p>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-reply-all me-1"></i>
                    Daftar Laporan
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th class="text-start" width="20%">JUDUL LAPORAN</th>
                            <th width="15%">TANGGAL</th>
                            <th width="15%">TEMPAT KEJADIAN</th>
                            <th width="12%">STATUS VERIFIKASI</th>
                            <th width="15%">STATUS PENANGANAN</th>
                            <th width="23%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $laporan)
                            <tr class="align-middle">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="report-icon me-3">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <div class="report-details">
                                            <div class="report-title">{{ $laporan->judul_laporan }}</div>
                                            <small class="report-category text-muted">{{ $laporan->kategori_laporan }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($laporan->tanggal_pelaporan)->format('d-m-Y') }}
                                </td>
                                <td class="text-center">
                                    {{ $laporan->tempat_kejadian }}
                                </td>
                                <td class="text-center">
                                    <span class="status-badge {{ $laporan->status_verifikasi == 'Diverifikasi' ? 'verified' : 'rejected' }}">
                                        <i class="fas {{ $laporan->status_verifikasi == 'Diverifikasi' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                        {{ $laporan->status_verifikasi }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($laporan->status_penanganan)
                                        <span class="status-badge {{ 
                                            $laporan->status_penanganan == 'Sudah ditangani' ? 'completed' : 
                                            ($laporan->status_penanganan == 'Belum ditangani' ? 'pending' : 'progress') 
                                        }}">
                                            <i class="fas {{ 
                                                $laporan->status_penanganan == 'Sudah ditangani' ? 'fa-check-circle' : 
                                                ($laporan->status_penanganan == 'Belum ditangani' ? 'fa-exclamation-circle' : 'fa-clock') 
                                            }}"></i>
                                            {{ $laporan->status_penanganan }}
                                        </span>
                                    @else
                                        <span class="status-badge null-status">
                                            <i class="fas fa-minus"></i>
                                    
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($laporan->status_verifikasi == 'Diverifikasi')
                                        <a href="{{ route('respon.edit', $laporan->id) }}" class="btn-action update">
                                            <i class="fas fa-edit"></i> Update
                                        </a>
                                    @elseif($laporan->status_verifikasi == 'Ditolak')
                                        <a href="{{ route('respon.editRejection', $laporan->id) }}" class="btn-action rejection">
                                            <i class="fas fa-plus-circle"></i> Edit Keterangan
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-reply-all fa-3x mb-3"></i>
                                    <p>Tidak ada laporan yang perlu direspon</p>
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

.table tbody td {
    padding: 12px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6;
}

/* Row Animation */
.table tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #dee2e6;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    justify-content: center;
    min-width: 120px;
}

.status-badge.verified {
    background-color: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.status-badge.rejected {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.status-badge.completed {
    background-color: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.status-badge.progress {
    background-color: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.status-badge.pending {
    background-color: rgba(108, 117, 125, 0.1);
    color: #6c757d;
}

.status-badge.null-status {
    background-color: rgba(108, 117, 125, 0.1);
    color: #6c757d;
}

.status-badge i {
    margin-right: 6px;
}

/* Action Button Styles */
.btn-action {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-action.update {
    background-color: #468B94;
    color: white;
}

.btn-action.update:hover {
    background-color: #3a7a82;
    transform: translateY(-2px);
    color: white;
}

.btn-action.rejection {
    background-color: #468B94; /* Ubah dari #fd7e14 menjadi hijau */
    color: white;
}

.btn-action.rejection:hover {
    background-color: #218838; /* Ubah dari #e8690b menjadi hijau gelap */
    transform: translateY(-2px);
    color: white;
}

/* Report Icon and Details */
.report-icon {
    width: 40px;
    height: 40px;
    background-color: #468B94;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0; /* Mencegah icon menyusut */
    min-width: 40px; /* Pastikan lebar minimum tetap */
}

.report-icon i {
    font-size: 20px;
    color: white;
    flex-shrink: 0; /* Mencegah icon menyusut */
}

.report-details {
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin-left: 8px;
    flex-grow: 1; /* Biarkan teks yang menyesuaikan */
    min-width: 0; /* Memungkinkan text wrap jika perlu */
}

.report-title {
    font-weight: 600;
    font-size: 14px;
    color: #333;
    margin-bottom: 2px;
    line-height: 1.2;
    word-wrap: break-word; /* Pecah kata jika terlalu panjang */
}

.report-category {
    font-size: 12px;
    color: #6c757d;
    line-height: 1;
    word-wrap: break-word; /* Pecah kata jika terlalu panjang */
}

/* Container untuk mencegah kompresi */
.d-flex.align-items-center {
    gap: 8px;
    flex-wrap: nowrap; /* Mencegah wrapping */
    min-width: 0; /* Reset min-width */
}

/* Kolom pertama tabel */
.table td:first-child {
    min-width: 200px; /* Set minimum width untuk kolom pertama */
    max-width: 300px; /* Set maximum width untuk mencegah terlalu lebar */
}

/* Responsive adjustments */
@media (max-width: 1200px) {
    .table td:first-child {
        min-width: 180px;
    }
    
    .report-title {
        font-size: 13px;
    }
    
    .report-category {
        font-size: 11px;
    }
}

@media (max-width: 992px) {
    .table td:first-child {
        min-width: 160px;
    }
    
    .report-icon {
        width: 36px;
        height: 36px;
        margin-right: 12px;
    }
    
    .report-icon i {
        font-size: 18px;
    }
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
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#28a745',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>
@endsection
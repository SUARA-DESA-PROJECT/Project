@extends('layouts.app')

@section('title', 'Verifikasi Laporan')

@section('content')
<div class="container-fluid px-4">
    <h2 class="mt-4">Verifikasi Laporan</h2>
    <p class="text-muted">Kelola dan verifikasi laporan yang telah diajukan oleh warga</p>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-clipboard-list me-1"></i>
                    Daftar Laporan
                </div>
                <div class="dropdown">
                    <button class="btn" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #468B94; color: white; border-radius: 6px; padding: 6px 15px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1); min-width: 120px; width: auto;">
                        <i class="fa fa-filter mr-2"></i> Filter <i class="fa fa-caret-down ml-2"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="filterDropdown">
                        <a class="dropdown-item" href="{{ route('verifikasilap.index') }}">Semua Data</a>
                        <a class="dropdown-item" href="{{ route('verifikasilap.index', ['status' => 'Diverifikasi']) }}">Diverifikasi</a>
                        <a class="dropdown-item" href="{{ route('verifikasilap.index', ['status' => 'Belum Diverifikasi']) }}">Belum Diverifikasi</a>
                        <a class="dropdown-item" href="{{ route('verifikasilap.index', ['status' => 'Ditolak']) }}">Ditolak</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th class="text-start" width="25%">JUDUL LAPORAN</th>
                            <th width="15%">TANGGAL PELAPORAN</th>
                            <th width="20%">TEMPAT KEJADIAN</th>
                            <th width="15%">STATUS VERIFIKASI</th>
                            <th width="25%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $laporan)
                            <tr class="align-middle laporan-row" 
                                data-id="{{ $laporan->id }}"
                                data-judul="{{ $laporan->judul_laporan }}"
                                data-deskripsi="{{ $laporan->deskripsi_laporan }}"
                                data-tanggal="{{ $laporan->tanggal_pelaporan }}"
                                data-tempat="{{ $laporan->tempat_kejadian }}"
                                data-status="{{ $laporan->status_verifikasi }}"
                                data-kategori="{{ $laporan->kategori_laporan }}"
                                data-penanganan="{{ $laporan->status_penanganan }}"
                                data-deskripsi_penanganan="{{ $laporan->deskripsi_penanganan }}"
                                style="cursor: pointer;">
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
                                <td>
                                    {{ \Carbon\Carbon::parse($laporan->tanggal_pelaporan)->format('d-m-Y') }}
                                </td>
                                <td>
                                    {{ $laporan->tempat_kejadian }}
                                </td>
                                <td>
                                    <span class="status-badge {{ 
                                        $laporan->status_verifikasi == 'Diverifikasi' ? 'verified' : 
                                        ($laporan->status_verifikasi == 'Ditolak' ? 'rejected' : 'unverified') 
                                    }}">
                                        <i class="fas {{ 
                                            $laporan->status_verifikasi == 'Diverifikasi' ? 'fa-check-circle' : 
                                            ($laporan->status_verifikasi == 'Ditolak' ? 'fa-times-circle' : 'fa-clock') 
                                        }}"></i>
                                        {{ $laporan->status_verifikasi }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @if($laporan->status_verifikasi == 'Belum Diverifikasi')
                                            <form action="{{ route('verifikasilap.verify', $laporan->id) }}" method="POST" class="d-inline me-1">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn-action verify">
                                                    <i class="fas fa-check-circle"></i> Verifikasi
                                                </button>
                                            </form>
                                            <form action="{{ route('verifikasilap.reject', $laporan->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn-action reject">
                                                    <i class="fas fa-ban"></i> Tolak
                                                </button>
                                            </form>
                                        @elseif($laporan->status_verifikasi == 'Diverifikasi')
                                            <form action="{{ route('verifikasilap.unverify', $laporan->id) }}" method="POST" class="d-inline me-1">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn-action unverify">
                                                    <i class="fas fa-undo"></i> Batalkan
                                                </button>
                                            </form>
                                            <form action="{{ route('verifikasilap.reject', $laporan->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn-action reject">
                                                    <i class="fas fa-ban"></i> Tolak
                                                </button>
                                            </form>
                                        @elseif($laporan->status_verifikasi == 'Ditolak')
                                            <form action="{{ route('verifikasilap.verify', $laporan->id) }}" method="POST" class="d-inline me-1">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn-action verify">
                                                    <i class="fas fa-check-circle"></i> Verifikasi
                                                </button>
                                            </form>
                                            <form action="{{ route('verifikasilap.unverify', $laporan->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn-action unverify">
                                                    <i class="fas fa-undo"></i> Reset
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
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

/* Card Animations */
.card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    animation: scaleIn 0.4s ease-out;
}

/* Table Animation */
.table {
    animation: fadeInUp 0.4s ease-out 0.2s backwards;
}

/* Report Icon */
.report-icon {
    width: 40px;
    height: 40px;
    background-color: #468B94;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}

.report-icon i {
    font-size: 20px;
    color: white;
}

/* Report Details */
.report-details {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.report-title {
    font-weight: 600;
    font-size: 14px;
    color: #333;
    margin-bottom: 2px;
    line-height: 1.2;
}

.report-category {
    font-size: 12px;
    color: #6c757d;
    line-height: 1;
}

/* Table Styles */
.table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
}

.table thead th {
    padding: 16px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    color: #495057;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    vertical-align: middle;
}

.table tbody td {
    padding: 12px 16px;
    vertical-align: middle;
}

.table td:first-child {
    text-align: left;
    padding-left: 24px;
}

.table td:nth-child(2),
.table td:nth-child(3),
.table td:nth-child(4),
.table td:last-child {
    text-align: center;
}

.table th:first-child {
    padding-left: 24px;
}

/* Row Transition */
.table tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #dee2e6;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateX(6px);
    box-shadow: -6px 0 0 0 #468B94;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.3s ease;
    justify-content: center;
    min-width: 140px;
}

.status-badge.verified {
    background-color: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.status-badge.unverified {
    background-color: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.status-badge.rejected {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.status-badge i {
    margin-right: 6px;
}

.status-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-action {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-action.verify {
    background-color: #28a745;
    color: white;
}

.btn-action.unverify {
    background-color: #6c757d;
    color: white;
}

.btn-action.reject {
    background-color: #dc3545;
    color: white;
}

.btn-action:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn-action.verify:hover {
    background-color: #218838;
}

.btn-action.unverify:hover {
    background-color: #5a6268;
}

.btn-action.reject:hover {
    background-color: #c82333;
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

/* Filter Button */
.dropdown .btn {
    transition: all 0.3s ease;
    background-color: #468B94;
    color: white;
    border-radius: 6px;
    padding: 8px 16px;
    font-weight: 500;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    min-width: 120px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}

.dropdown .btn:hover {
    background-color: #3a7a82;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.dropdown .btn i {
    transition: transform 0.3s ease;
}

.dropdown .btn:hover i.fa-caret-down {
    transform: rotate(180deg);
}

/* Dropdown menu transition */
.dropdown-menu {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-radius: 8px;
    padding: 8px;
    margin-top: 8px;
}

.dropdown-item {
    transition: all 0.2s ease;
    padding: 8px 16px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.dropdown-item:hover {
    background-color: #f0f7f8;
    transform: translateX(4px);
    color: #468B94;
}

/* Report Icon Transition */
.report-icon {
    transition: all 0.3s ease;
}

tr:hover .report-icon {
    transform: scale(1.1);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

/* Report Details Transition */
.report-details {
    transition: all 0.3s ease;
}

tr:hover .report-details {
    transform: translateX(4px);
}

/* Card */
.card {
    margin-top: 1rem;
}

.card-header {
    padding: 1rem 1.25rem;
}

.card-body {
    padding: 0;
}

/* Table responsive */
.table-responsive {
    overflow-x: hidden;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.table-responsive::-webkit-scrollbar {
    display: none;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check for success message from session
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#28a745',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: true,
                allowOutsideClick: true,
                showClass: {
                    popup: 'animate__animated animate__zoomIn'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut'
                }
            });
        @endif

        // Confirmation for verify, unverify, and reject actions
        const actionForms = document.querySelectorAll('form[action*="verifikasilap"]');
        actionForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                let title, text, confirmButtonText, confirmButtonColor, icon;
                
                if (this.action.includes('verify') && !this.action.includes('unverify')) {
                    title = 'Verifikasi Laporan';
                    text = 'Apakah Anda yakin ingin memverifikasi laporan ini?';
                    confirmButtonText = 'Ya, Verifikasi';
                    confirmButtonColor = '#28a745';
                    icon = 'question';
                } else if (this.action.includes('reject')) {
                    title = 'Tolak Laporan';
                    text = 'Apakah Anda yakin ingin menolak laporan ini?';
                    confirmButtonText = 'Ya, Tolak';
                    confirmButtonColor = '#dc3545';
                    icon = 'warning';
                } else if (this.action.includes('unverify')) {
                    title = 'Reset Status';
                    text = 'Apakah Anda yakin ingin mereset status laporan ini?';
                    confirmButtonText = 'Ya, Reset';
                    confirmButtonColor = '#6c757d';
                    icon = 'question';
                }
                
                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonColor: confirmButtonColor,
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    showClass: {
                        popup: 'animate__animated animate__zoomIn'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__zoomOut'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Sedang mengubah status laporan',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        this.submit();
                    }
                });
            });
        });
        
        // Show laporan details on row click (exclude button clicks)
        const laporanRows = document.querySelectorAll('.laporan-row');
        
        laporanRows.forEach(row => {
            row.addEventListener('click', function(e) {
                // Don't trigger if clicking on buttons
                if (e.target.closest('.btn-action') || e.target.closest('form')) {
                    return;
                }
                
                // Get data from row attributes
                const data = {
                    id: this.dataset.id,
                    judul: this.dataset.judul,
                    deskripsi: this.dataset.deskripsi,
                    tanggal: this.dataset.tanggal,
                    tempat: this.dataset.tempat,
                    status: this.dataset.status,
                    kategori: this.dataset.kategori,
                    penanganan: this.dataset.penanganan,
                    deskripsiPenanganan: this.dataset.deskripsi_penanganan
                };
                
                const statusClass = data.status === 'Diverifikasi' ? 'verified' : 
                                  (data.status === 'Ditolak' ? 'rejected' : 'unverified');
                const statusIcon = data.status === 'Diverifikasi' ? 'fa-check-circle' : 
                                 (data.status === 'Ditolak' ? 'fa-times-circle' : 'fa-clock');
                
                // Create modal content
                const modalContent = `
                    <div class="laporan-details-modal">
                        <table class="table table-bordered m-0">
                            <tr>
                                <th style="width: 35%;">ID Laporan</th>
                                <td>${data.id}</td>
                            </tr>
                            <tr>
                                <th>Judul Laporan</th>
                                <td>${data.judul}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>${data.deskripsi}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pelaporan</th>
                                <td>${data.tanggal}</td>
                            </tr>
                            <tr>
                                <th>Tempat Kejadian</th>
                                <td>${data.tempat}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>${data.kategori}</td>
                            </tr>
                            <tr>
                                <th>Status Penanganan</th>
                                <td>${data.penanganan}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi Penanganan</th>
                                <td>${data.deskripsiPenanganan}</td>
                            </tr>
                            <tr>
                                <th>Status Verifikasi</th>
                                <td>
                                    <span class="status-badge ${statusClass}">
                                        <i class="fas ${statusIcon}"></i>
                                        ${data.status}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                `;

                // Show SweetAlert modal
                Swal.fire({
                    title: 'Detail Laporan',
                    html: modalContent,
                    width: '600px',
                    showCloseButton: true,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'laporan-details-popup'
                    },
                    showClass: {
                        popup: 'animate__animated animate__zoomIn'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__zoomOut'
                    }
                });
            });
        });
    });
</script>

<style>
/* Add custom styles for SweetAlert */
.swal2-popup.laporan-details-popup {
    border-radius: 10px;
}

.laporan-details-modal .table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #495057;
    border-color: #dee2e6;
}

.laporan-details-modal .table td {
    border-color: #dee2e6;
}

.laporan-details-modal .status-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.laporan-details-modal .status-badge.verified {
    background-color: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.laporan-details-modal .status-badge.unverified {
    background-color: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.laporan-details-modal .status-badge.rejected {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.laporan-details-modal .status-badge i {
    margin-right: 4px;
}
</style>
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
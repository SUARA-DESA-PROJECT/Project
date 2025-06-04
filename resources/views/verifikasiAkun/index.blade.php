@extends('layouts.app')

@section('title', 'Verifikasi Akun')

@section('content')
<div class="container-fluid px-4">
    <h2 class="mt-4">Verifikasi Akun Pengguna</h2>
    <p class="text-muted">Kelola dan verifikasi akun pengguna yang terdaftar dalam sistem</p>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-users me-1"></i>
                    Daftar Akun Pengguna
                </div>
                <div class="dropdown">
                    <button class="btn" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #468B94; color: white; border-radius: 6px; padding: 6px 15px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1); min-width: 120px; width: auto;">
                        <i class="fa fa-filter mr-2"></i> Filter <i class="fa fa-caret-down ml-2"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="filterDropdown">
                        <a class="dropdown-item" href="{{ route('warga.verifikasi') }}">Semua Data</a>
                        <a class="dropdown-item" href="{{ route('warga.verifikasi', ['status' => 'Terverifikasi']) }}">Terverifikasi</a>
                        <a class="dropdown-item" href="{{ route('warga.verifikasi', ['status' => 'Belum diverifikasi']) }}">Belum Diverifikasi</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0"> <!-- Remove padding -->
            @if(session('success'))
                <div class="alert alert-success m-3">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th class="text-start" width="40%">PENGGUNA</th>
                            <th width="30%">STATUS VERIFIKASI</th>
                            <th width="30%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wargas as $warga)
                        <tr class="align-middle user-row" 
                            data-nama="{{ $warga->nama_lengkap }}"
                            data-username="{{ $warga->username }}"
                            data-email="{{ $warga->email }}"
                            data-telepon="{{ $warga->nomor_telepon ?? '-' }}"
                            data-alamat="{{ $warga->alamat ?? '-' }}"
                            data-status="{{ $warga->status_verifikasi }}"
                            style="cursor: pointer;">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="profile-icon me-3">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">{{ $warga->nama_lengkap }}</div>
                                        <small class="user-username text-muted">{{ $warga->username }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge {{ $warga->status_verifikasi == 'Terverifikasi' ? 'verified' : 'unverified' }}">
                                    <i class="fas {{ $warga->status_verifikasi == 'Terverifikasi' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                    {{ $warga->status_verifikasi }}
                                </span>
                            </td>
                            <td>
                                @if($warga->status_verifikasi == 'Belum diverifikasi')
                                    <form action="{{ route('warga.verify', $warga->username) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-action verify">
                                            <i class="fas fa-check-circle"></i> Verifikasi
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('warga.unverify', $warga->username) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-action unverify">
                                            <i class="fas fa-times-circle"></i> Batalkan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <p>Tidak ada data warga</p>
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

/* Profile Icon */
.profile-icon {
    width: 40px;
    height: 40px;
    background-color: #468B94;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}

.profile-icon i {
    font-size: 20px;
    color: white;
}

/* User Details */
.user-details {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.user-name {
    font-weight: 600;
    font-size: 14px;
    color: #333;
    margin-bottom: 2px;
    line-height: 1.2;
}

.user-username {
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
    white-space: nowrap;
}

.table td:first-child {
    text-align: left;
}

.table td:nth-child(2),
.table td:last-child {
    text-align: center;
}

/* Center status column */
.table td:nth-child(2) {
    text-align: center;
}

/* Center action column */
.table td:last-child {
    text-align: center;
}

/* Adjust column widths */
.table th:first-child {
    padding-left: 24px;
}

.table td:first-child {
    padding-left: 24px;
}

/* Add hover effect */
.table tbody tr:hover {
    background-color: #f8f9fa;
}

/* Make the card more compact */
.card {
    margin-top: 1rem;
}

.card-header {
    padding: 1rem 1.25rem;
}

/* Make status badge more centered */
.status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 140px;
}

/* Center action buttons */
.btn-action {
    margin: 0 auto;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
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
    gap: 6px;
    transition: all 0.2s;
}

.btn-action.verify {
    background-color: #28a745;
    color: white;
}

.btn-action.unverify {
    background-color: #dc3545;
    color: white;
}

.btn-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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

/* Update existing table styles */
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

/* Update td styles for alignment */
.table tbody td {
    padding: 12px 16px;
    vertical-align: middle;
}

.table td:first-child {
    text-align: left;
}

.table td:nth-child(2),
.table td:last-child {
    text-align: center;
}

/* Make the table more compact */
.card-body {
    padding: 0;
}

.table {
    margin-bottom: 0;
}

/* Adjust status badge for center alignment */
.status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 140px;
}

/* Add these styles to your existing CSS */
.table-responsive {
    overflow-x: hidden; /* Hide horizontal scrollbar */
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* Internet Explorer 10+ */
}

/* Hide webkit scrollbar */
.table-responsive::-webkit-scrollbar {
    display: none;
}

/* Add these new styles and update existing ones */

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

/* Status Badge Transition */
.status-badge {
    transition: all 0.3s ease;
}

.status-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Action Button Transition */
.btn-action {
    transition: all 0.3s ease;
}

.btn-action:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Profile Icon Transition */
.profile-icon {
    transition: all 0.3s ease;
}

tr:hover .profile-icon {
    transform: scale(1.1);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

/* User Details Transition */
.user-details {
    transition: all 0.3s ease;
}

tr:hover .user-details {
    transform: translateX(4px);
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add confirmation for verify and unverify actions
        const verifyForms = document.querySelectorAll('form[action*="verify"]');
        
        verifyForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const isVerify = this.action.includes('verify') && !this.action.includes('unverify');
                const title = isVerify ? 'Verifikasi Akun' : 'Hapus Verifikasi';
                const text = isVerify 
                    ? 'Apakah Anda yakin ingin memverifikasi akun ini?' 
                    : 'Apakah Anda yakin ingin menghapus status verifikasi akun ini?';
                const confirmButtonText = isVerify ? 'Ya, Verifikasi' : 'Ya, Hapus Verifikasi';
                const confirmButtonColor = isVerify ? '#28a745' : '#dc3545';
                
                Swal.fire({
                    title: title,
                    text: text,
                    icon: isVerify ? 'question' : 'warning',
                    showCancelButton: true,
                    confirmButtonColor: confirmButtonColor,
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
        
        // Show warga details on username click
        const wargaDetailLinks = document.querySelectorAll('.show-warga-details');
        
        wargaDetailLinks.forEach(link => {
            link.addEventListener('click', function() {
                const username = this.getAttribute('data-username');
                const nama = this.getAttribute('data-nama');
                const telepon = this.getAttribute('data-telepon');
                const alamat = this.getAttribute('data-alamat');
                const email = this.getAttribute('data-email');
                const status = this.getAttribute('data-status');
                const isVerified = status === 'Terverifikasi';
                
                // Create HTML content for the modal
                const htmlContent = `
                    <div class="text-left">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 40%;">Username</th>
                                <td>${username}</td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>${nama}</td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <td>${telepon}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>${alamat}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>${email}</td>
                            </tr>
                            <tr>
                                <th>Status Verifikasi</th>
                                <td>
                                    <span class="badge" style="background-color: ${isVerified ? '#28a745' : '#dc3545'}; color: white; padding: 5px 10px;">
                                        ${status}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                `;
                
                // Show SweetAlert with warga details
                Swal.fire({
                    title: 'Detail Warga',
                    html: htmlContent,
                    width: 600,
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#6c757d'
                });
            });
        });
        
        // Get all user rows
        const userRows = document.querySelectorAll('.user-row');
        
        userRows.forEach(row => {
            row.addEventListener('click', function() {
                // Get data from row attributes
                const data = {
                    nama: this.dataset.nama,
                    username: this.dataset.username,
                    email: this.dataset.email,
                    telepon: this.dataset.telepon,
                    alamat: this.dataset.alamat,
                    status: this.dataset.status
                };
                
                // Create modal content
                const modalContent = `
                    <div class="user-details-modal">
                        <table class="table table-bordered m-0">
                            <tr>
                                <th style="width: 35%;">Nama Lengkap</th>
                                <td>${data.nama}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>${data.username}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>${data.email}</td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <td>${data.telepon}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>${data.alamat}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="status-badge ${data.status === 'Terverifikasi' ? 'verified' : 'unverified'}">
                                        <i class="fas ${data.status === 'Terverifikasi' ? 'fa-check-circle' : 'fa-clock'}"></i>
                                        ${data.status}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                `;

                // Show SweetAlert modal
                Swal.fire({
                    title: 'Detail Pengguna',
                    html: modalContent,
                    width: '600px',
                    showCloseButton: true,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'user-details-popup'
                    }
                });
            });
        });
    });
</script>
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
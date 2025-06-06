@extends('layouts.app-warga')

@section('title', 'Riwayat Laporan')

@section('content')
<!-- Tambahkan FontAwesome CDN di bagian atas -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container-fluid pl-4">
    <h2 class="mt-4">Riwayat Laporan</h2>
    <p class="text-muted">Riwayat laporan yang telah Anda buat akan muncul di sini.</p>

    <div class="card riwayat-card" style="margin-left: 0; text-align: left;">
        <div class="card-header riwayat-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-history me-1"></i>
                    Daftar Riwayat Laporan
                </div>
                <div class="dropdown d-flex align-items-center" style="gap: 12px;">
                    <a href="{{ url('/export-pdf') }}?{{ http_build_query(request()->query()) }}" 
                       class="btn mr-2" 
                       style="background-color: #3942ef; color: white; border-radius: 6px; padding: 6px 15px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-right: 10px;">
                        <i class="fas fa-file-pdf mr-2"></i> Cetak PDF
                    </a>
                    <button class="btn" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
                            style="background-color: #468B94; color: white; border-radius: 6px; padding: 6px 15px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-right: 10px;">
                        <i class="fas fa-filter mr-2"></i> Filter <i class="fas fa-caret-down ml-2"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="filterDropdown">
                        <a class="dropdown-item" href="{{ route('riwayat-laporan.index') }}">Semua Data</a>
                        <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['status' => 'Diverifikasi']) }}">Diverifikasi</a>
                        <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['status' => 'Belum Diverifikasi']) }}">Belum Diverifikasi</a>
                        <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['jenis' => 'Laporan Positif']) }}">Laporan Positif</a>
                        <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['jenis' => 'Laporan Negatif']) }}">Laporan Negatif</a>
                        <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['status_penanganan' => 'Sudah Ditangani']) }}">Sudah Ditangani</a>
                        <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['status_penanganan' => 'Belum Ditangani']) }}">Belum Ditangani</a>
                    </div>
                    <a href="{{ route('laporan.create') }}" 
                       class="btn" 
                       style="background-color: #468B94; color: white; border-radius: 6px; padding: 6px 15px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <i class="fas fa-plus mr-2"></i> Buat Laporan
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            @forelse($laporans as $laporan)
                <div class="laporan-card laporan-clickable" 
                     data-id="{{ $laporan->id }}"
                     data-judul="{{ $laporan->judul_laporan }}"
                     data-deskripsi="{{ $laporan->deskripsi_laporan }}"
                     data-tanggal="{{ \Carbon\Carbon::parse($laporan->tanggal_pelaporan)->format('d-m-Y') }}"
                     data-tempat="{{ $laporan->tempat_kejadian }}"
                     data-status-verifikasi="{{ $laporan->status_verifikasi }}"
                     data-status-penanganan="{{ $laporan->status_penanganan }}"
                     data-deskripsi-penanganan="{{ $laporan->deskripsi_penanganan }}"
                     data-tipe-pelapor="{{ $laporan->tipe_pelapor }}"
                     data-pengurus-username="{{ $laporan->pengurus_lingkungan_username }}"
                     data-warga-username="{{ $laporan->warga_username }}"
                     data-kategori="{{ $laporan->kategori_laporan }}"
                     data-deskripsi-penolakan="{{ $laporan->deskripsi_penolakan }}"
                     data-jenis-kategori="{{ $laporan->jenis_kategori }}">
                    <div class="laporan-card-header">
                        <div class="laporan-card-title">
                            <i class="fas fa-file-alt"></i> {{ $laporan->judul_laporan }}
                        </div>
                        <div class="action-buttons">
                            <button type="button" class="btn-action-small edit" onclick="event.stopPropagation(); window.location='{{ route('inputlaporan.edit', $laporan->id) }}'">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('inputlaporan.destroy', $laporan->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-action-small delete delete-btn" data-id="{{ $laporan->id }}" onclick="event.stopPropagation();">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="laporan-card-body">
                        <div class="laporan-card-row">
                            <span class="laporan-label"><i class="fas fa-align-left"></i> Deskripsi:</span>
                            <span class="laporan-value">{{ \Illuminate\Support\Str::limit($laporan->deskripsi_laporan, 100) }}</span>
                        </div>
                        <div class="laporan-card-row">
                            <span class="laporan-label"><i class="fas fa-calendar-alt"></i> Tanggal:</span>
                            <span class="laporan-value">{{ \Carbon\Carbon::parse($laporan->tanggal_pelaporan)->format('d-m-Y') }}</span>
                        </div>
                        <div class="laporan-card-row">
                            <span class="laporan-label"><i class="fas fa-map-marker-alt"></i> Tempat:</span>
                            <span class="laporan-value">{{ $laporan->tempat_kejadian }}</span>
                        </div>
                        <div class="laporan-card-row">
                            <span class="laporan-label"><i class="fas fa-tags"></i> Kategori:</span>
                            <span class="laporan-value">{{ $laporan->kategori_laporan }}</span>
                        </div>
                        
                        <!-- Status labels in horizontal row -->
                        <div class="status-labels-container">
                            <div class="status-label">
                                @if($laporan->jenis_kategori == 'Positif')
                                    <span class="badge badge-pill badge-success">Laporan Positif</span>
                                @else
                                    <span class="badge badge-pill badge-danger">Laporan Negatif</span>
                                @endif
                            </div>
                            <div class="status-label">
                                @if($laporan->status_verifikasi == 'Diverifikasi')
                                    <span class="badge badge-pill badge-success">{{ $laporan->status_verifikasi }}</span>
                                @elseif($laporan->status_verifikasi == 'Ditolak')
                                    <span class="badge badge-pill badge-danger">{{ $laporan->status_verifikasi }}</span>
                                @else
                                    <span class="badge badge-pill badge-warning">{{ $laporan->status_verifikasi }}</span>
                                @endif
                            </div>
                            <div class="status-label">
                                @if($laporan->status_penanganan == 'Sudah Ditangani')
                                    <span class="badge badge-pill badge-success">{{ $laporan->status_penanganan }}</span>
                                @elseif($laporan->status_penanganan == 'Sedang Ditangani')
                                    <span class="badge badge-pill badge-warning">{{ $laporan->status_penanganan }}</span>
                                @else
                                    <span class="badge badge-pill badge-danger">{{ $laporan->status_penanganan }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Tambah indikator bahwa card bisa diklik -->
                    <div class="click-indicator">
                        <i class="fas fa-eye"></i> Klik untuk melihat detail
                    </div>
                </div>
            @empty
                <div class="text-center" style="padding: 40px;">
                    <i class="fas fa-info-circle fa-3x mb-3" style="color: #6c757d; opacity: 0.5;"></i>
                    <p style="color: #6c757d;">Belum ada laporan yang dibuat</p>
                </div>
            @endforelse
            
            <div class="pagination-wrapper">
                {{ $laporans->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<style>
/* --- RIWAYAT LAPORAN MODERN STYLE --- */
.riwayat-card {
    background: white;
    border-radius: 18px;
    box-shadow: 0 6px 24px rgba(70,139,148,0.10);
    margin-top: 2rem;
    animation: fadeInDown 0.7s;
}

.riwayat-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e3f6f5;
    padding: 1rem;
}

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

.laporan-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 4px 16px rgba(70,139,148,0.08);
    transition: all 0.3s ease;
    animation: fadeInDown 0.7s;
    position: relative;
    border: 1px solid #e0e0e0;
}

.laporan-card.laporan-clickable {
    cursor: pointer;
}

.laporan-card:hover {
    box-shadow: 0 8px 32px rgba(70,139,148,0.18);
    transform: translateY(-4px) scale(1.01);
}

.laporan-card.laporan-clickable:hover {
    border-color: #468B94;
}

.click-indicator {
    position: absolute;
    bottom: 10px; /* Ubah dari top ke bottom */
    right: 10px; /* Ubah dari left ke right */
    background-color: rgba(70, 139, 148, 0.1);
    color: #468B94;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 1;
}

.laporan-card:hover .click-indicator {
    opacity: 1;
}

.laporan-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.laporan-card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #468B94;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.laporan-card-body {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.laporan-card-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.2rem;
    flex-wrap: wrap;
}

.laporan-label {
    font-weight: 600;
    color: #468B94;
    min-width: 140px;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.laporan-value {
    color: #333;
    font-weight: 500;
}

/* Status labels styling */
.status-labels-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px dashed #e0e0e0;
}

.status-label {
    display: flex;
    flex-direction: column;
    gap: 5px;
    font-weight: 600;
    color: #468B94;
    font-size: 0.9rem;
}

.status-label .badge {
    margin-top: 5px;
}

/* Badge styling */
.badge-pill {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
}

.badge-success {
    background-color: #28a745;
    color: white;
}

.badge-danger {
    background-color: #dc3545;
    color: white;
}

.badge-warning {
    background-color: #ffc107;
    color: #212529;
}

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

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Dropdown styling */
.dropdown-menu {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border: none;
    padding: 0.5rem;
    min-width: 200px;
    margin-top: 0.5rem;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    border-radius: 4px;
    transition: all 0.2s;
    font-weight: 500;
}

.dropdown-item:hover {
    background-color: #e3f6f5;
    color: #468B94;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-action-small {
    width: 32px;
    height: 32px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-action-small.edit {
    background-color: #3942ef;
    color: white;
}

.btn-action-small.delete {
    background-color: #dc3545;
    color: white;
}

.btn-action-small:hover {
    opacity: 0.9;
    transform: scale(1.05);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .status-labels-container {
        flex-direction: column;
        align-items: stretch;
    }

    .status-label {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .click-indicator {
        position: static; /* Ubah menjadi static di mobile */
        opacity: 1;
        margin-top: 10px;
        text-align: center;
        background-color: rgba(70, 139, 148, 0.15);
        border-radius: 6px;
        padding: 8px;
    }
}

/* Pagination Styling */
.pagination {
    margin-bottom: 0;
    border-radius: 8px;
    justify-content: center;
}

.page-item {
    margin: 0 2px;
}

.page-link {
    color: #468B94;
    background-color: white;
    border: 1px solid #dee2e6;
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
}

.page-link:hover {
    color: white;
    background-color: #468B94;
    border-color: #468B94;
    box-shadow: 0 2px 4px rgba(70,139,148,0.2);
    text-decoration: none;
}

.page-item.active .page-link {
    z-index: 3;
    color: white;
    background-color: #468B94;
    border-color: #468B94;
    box-shadow: 0 2px 4px rgba(70,139,148,0.3);
}

.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

/* Custom pagination container */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

/* Hide default Laravel pagination text */
.pagination-wrapper .hidden {
    display: none;
}

/* Style untuk angka halaman yang tidak terlihat berantakan */
.page-item .page-link {
    min-width: 40px;
    text-align: center;
}

/* Untuk link Previous dan Next */
.page-item:first-child .page-link,
.page-item:last-child .page-link {
    font-weight: 600;
}

/* Custom SweetAlert styling */
.swal2-popup.detail-laporan {
    border-radius: 15px;
}

.detail-table {
    width: 100%;
    margin: 0;
}

.detail-table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #468B94;
    padding: 12px;
    border: 1px solid #dee2e6;
    text-align: left;
    width: 35%;
    vertical-align: top;
}

.detail-table td {
    padding: 12px;
    border: 1px solid #dee2e6;
    color: #333;
    text-align: left;
    vertical-align: top;
}

.detail-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    gap: 4px;
}

.detail-badge.success {
    background-color: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.detail-badge.danger {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.detail-badge.warning {
    background-color: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.detail-badge.secondary {
    background-color: rgba(108, 117, 125, 0.1);
    color: #6c757d;
}
</style>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Tampilkan pesan sukses jika ada
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        // Konfirmasi hapus dengan SweetAlert2
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus laporan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Event listener untuk click pada card laporan
        $('.laporan-clickable').on('click', function(e) {
            // Jangan trigger jika yang diklik adalah button action
            if ($(e.target).closest('.action-buttons').length > 0) {
                return;
            }

            const data = {
                id: $(this).data('id'),
                judul: $(this).data('judul'),
                deskripsi: $(this).data('deskripsi'),
                tanggal: $(this).data('tanggal'),
                tempat: $(this).data('tempat'),
                statusVerifikasi: $(this).data('status-verifikasi'),
                statusPenanganan: $(this).data('status-penanganan'),
                deskripsiPenanganan: $(this).data('deskripsi-penanganan'),
                tipePelapor: $(this).data('tipe-pelapor'),
                pengurusUsername: $(this).data('pengurus-username'),
                wargaUsername: $(this).data('warga-username'),
                kategori: $(this).data('kategori'),
                deskripsiPenolakan: $(this).data('deskripsi-penolakan'),
                jenisKategori: $(this).data('jenis-kategori')
            };

            // Function untuk membuat badge status
            function createStatusBadge(status, type) {
                let badgeClass = '';
                let icon = '';
                
                if (type === 'verifikasi') {
                    if (status === 'Diverifikasi') {
                        badgeClass = 'success';
                        icon = 'fa-check-circle';
                    } else if (status === 'Ditolak') {
                        badgeClass = 'danger';
                        icon = 'fa-times-circle';
                    } else {
                        badgeClass = 'warning';
                        icon = 'fa-clock';
                    }
                } else if (type === 'penanganan') {
                    if (status === 'Sudah Ditangani') {
                        badgeClass = 'success';
                        icon = 'fa-check-circle';
                    } else if (status === 'Sedang Ditangani') {
                        badgeClass = 'warning';
                        icon = 'fa-clock';
                    } else {
                        badgeClass = 'danger';
                        icon = 'fa-exclamation-circle';
                    }
                } else if (type === 'jenis') {
                    if (status === 'Positif') {
                        badgeClass = 'success';
                        icon = 'fa-thumbs-up';
                    } else {
                        badgeClass = 'danger';
                        icon = 'fa-thumbs-down';
                    }
                }
                
                return `<span class="detail-badge ${badgeClass}">
                            <i class="fas ${icon}"></i> ${status === 'Positif' ? 'Laporan Positif' : (status === 'Negatif' ? 'Laporan Negatif' : status)}
                        </span>`;
            }

            // Buat konten modal
            const modalContent = `
                <table class="detail-table">
                    <tr>
                        <th><i class="fas fa-heading"></i> Judul Laporan</th>
                        <td>${data.judul}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-align-left"></i> Deskripsi Laporan</th>
                        <td>${data.deskripsi || '-'}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-calendar-alt"></i> Tanggal Pelaporan</th>
                        <td>${data.tanggal}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-map-marker-alt"></i> Tempat Kejadian</th>
                        <td>${data.tempat || '-'}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-tags"></i> Kategori Laporan</th>
                        <td>${data.kategori || '-'}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-chart-line"></i> Jenis Kategori</th>
                        <td>${createStatusBadge(data.jenisKategori, 'jenis')}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-user-tag"></i> Tipe Pelapor</th>
                        <td>${data.tipePelapor || '-'}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-user-tie"></i> Username Pengurus</th>
                        <td>${data.pengurusUsername || '-'}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-user"></i> Username Warga</th>
                        <td>${data.wargaUsername || '-'}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-check-circle"></i> Status Verifikasi</th>
                        <td>${createStatusBadge(data.statusVerifikasi, 'verifikasi')}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-tasks"></i> Status Penanganan</th>
                        <td>${createStatusBadge(data.statusPenanganan, 'penanganan')}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-comment-alt"></i> Deskripsi Penanganan</th>
                        <td>${data.deskripsiPenanganan || '-'}</td>
                    </tr>
                    ${data.deskripsiPenolakan ? `
                    <tr>
                        <th><i class="fas fa-ban"></i> Deskripsi Penolakan</th>
                        <td style="color: #dc3545;">${data.deskripsiPenolakan}</td>
                    </tr>
                    ` : ''}
                </table>
            `;

            // Tampilkan SweetAlert dengan detail lengkap
            Swal.fire({
                title: '<i class="fas fa-file-alt"></i> Detail Laporan',
                html: modalContent,
                width: '800px',
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'detail-laporan'
                }
            });
        });
    });
</script>
@endpush
@extends('layouts.app-warga')

@section('title', 'Riwayat Laporan')

@section('content')

<div class="container-fluid mt-4" style="background: #ffffff">  
    <div class="row">
        <div class="col-12">
            <h2>Riwayat Laporan</h2>
            <p>Riwayat laporan yang telah Anda buat akan muncul di sini.</p>
            <div class="main-card">
                <div class="d-flex justify-content-end mb-3 button-group">
                    <a href="{{ url('/export-pdf') }}?{{ http_build_query(request()->query()) }}" class="btn-custom">
                        <i class="fa fa-file-pdf-o mr-2"></i> Cetak PDF
                    </a>
                    <div class="dropdown">
                        <button class="btn-custom" type="button" id="filterDropdown" data-toggle="dropdown">
                            <i class="fa fa-filter mr-2"></i> Filter <i class="fa fa-caret-down ml-2"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('riwayat-laporan.index') }}">Semua Data</a>
                            <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['status' => 'Diverifikasi']) }}">Diverifikasi</a>
                            <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['status' => 'Belum Diverifikasi']) }}">Belum Diverifikasi</a>
                            <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['jenis' => 'Laporan Positif']) }}">Laporan Positif</a>
                            <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['jenis' => 'Laporan Negatif']) }}">Laporan Negatif</a>
                            <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['status_penanganan' => 'Sudah Ditangani']) }}">Sudah Ditangani</a>
                            <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['status_penanganan' => 'Belum Ditangani']) }}">Belum Ditangani</a>
                        </div>
                    </div>
                    <a href="{{ route('laporan.create') }}" class="btn-custom">
                        <i class="fa fa-plus mr-2"></i> Buat Laporan
                    </a>
                </div>

                <div class="laporan-list">
                    @forelse($laporans as $laporan)
                    <div class="laporan-item">
                        <div class="laporan-header">
                            <h3 class="laporan-title">{{ $laporan->judul_laporan }}</h3>
                            <div class="action-buttons">
                                <a href="{{ route('inputlaporan.edit', $laporan->id) }}" class="btn-action-small edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('inputlaporan.destroy', $laporan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-small delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="laporan-content">
                            <div class="info-group">
                                <label><i class="fa fa-calendar"></i> Tanggal:</label>
                                <span>{{ $laporan->tanggal_pelaporan }}</span>
                            </div>
                            <div class="info-group">
                                <label><i class="fa fa-map-marker"></i> Lokasi:</label>
                                <span>{{ $laporan->tempat_kejadian }}</span>
                            </div>
                            <div class="info-group">
                                <label><i class="fa fa-tag"></i> Kategori:</label>
                                <span>{{ $laporan->kategori_laporan }}</span>
                            </div>
                            <div class="status-badges">
                                <span class="badge {{ $laporan->jenis_kategori == 'Positif' ? 'badge-positif' : 'badge-negatif' }}">
                                    {{ $laporan->jenis_kategori }}
                                </span>
                                <span class="badge {{ $laporan->status_verifikasi == 'Diverifikasi' ? 'badge-verif' : 'badge-unverif' }}">
                                    {{ $laporan->status_verifikasi }}
                                </span>
                                <span class="badge {{ $laporan->status_penanganan == 'Sudah Ditangani' ? 'badge-ditangani' : 'badge-belum' }}">
                                    {{ $laporan->status_penanganan }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="no-data">
                        <i class="fa fa-info-circle fa-2x mb-2"></i>
                        <p>Belum ada laporan yang dibuat</p>
                    </div>
                    @endforelse
                </div>
            <!-- </div> -->
        <!-- </div>
    </div> -->

    <!-- Modal Detail Laporan -->
    <div class="modal fade" id="detailLaporanModal" tabindex="-1" role="dialog" aria-labelledby="detailLaporanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #468B94; color: white;">
                    <h5 class="modal-title" id="detailLaporanModalLabel">Detail Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Judul Laporan:</label>
                                <p id="modal-judul"></p>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Deskripsi Laporan:</label>
                                <p id="modal-deskripsi" style="white-space: pre-wrap; word-wrap: break-word; overflow-wrap: break-word; max-width: 100%;"></p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Tanggal Pelaporan:</label>
                                        <p id="modal-tanggal"></p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Tempat Kejadian:</label>
                                        <p id="modal-tempat"></p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Kategori Laporan:</label>
                                        <p id="modal-kategori"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Jenis Laporan:</label>
                                        <p id="modal-jenis"></p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Status Verifikasi:</label>
                                        <p id="modal-status"></p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Status Penanganan:</label>
                                        <p id="modal-status-penanganan"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="mt-3 mb-5">
        <a href="{{ url('/homepage-warga') }}" class="btn btn-secondary" style="float: left;">
            Kembali ke Beranda
        </a>
    </div> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Event listener untuk menampilkan modal detail laporan
            $('.show-laporan-details').click(function() {
                var id = $(this).data('id');
                var judul = $(this).data('judul');
                var deskripsi = $(this).data('deskripsi');
                var tanggal = $(this).data('tanggal');
                var tempat = $(this).data('tempat');
                var status = $(this).data('status');
                var kategori = $(this).data('kategori');
                var jenis = $(this).data('jenis');
                var statusPenanganan = $(this).data('status-penanganan');
                
                // Isi modal dengan data laporan
                $('#modal-judul').text(judul);
                $('#modal-deskripsi').text(deskripsi);
                $('#modal-tanggal').text(tanggal);
                $('#modal-tempat').text(tempat);
                $('#modal-status').text(status);
                $('#modal-kategori').text(kategori);
                $('#modal-jenis').text(jenis);
                $('#modal-status-penanganan').text(statusPenanganan);
                
                // Tampilkan modal
                $('#detailLaporanModal').modal('show');
            });

            // Event listener untuk tombol delete
            $('.btn-action-small.delete').click(function(e) {
                e.preventDefault();
                const form = $(this).closest('form');
                
                Swal.fire({
                    title: 'Hapus Laporan?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#468B94',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    background: '#fff',
                    borderRadius: '10px',
                    customClass: {
                        confirmButton: 'btn btn-success me-2',
                        cancelButton: 'btn btn-danger'
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                            title: 'Terhapus!',
                            text: 'Data laporan berhasil dihapus.',
                            icon: 'success',
                            confirmButtonColor: '#468B94',
                            background: '#fff',
                            borderRadius: '10px'
                        });
                    }
                });
            });
        });
    </script>

    <style>
    /* Add these animation keyframes at the top of your style section */
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

    /* Update animation keyframes */
    @keyframes slideInPop {
        0% {
            opacity: 0;
            transform: translateX(-10px) scale(0.98);
        }
        50% {
            transform: translateX(3px) scale(1.01);
        }
        100% {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
    }

    /* Container Background */
    .container-fluid {
        background: #E8F5E9; /* Pale green background */
        padding: 20px;
        min-height: 100vh;
    }

    /* Main Card Container */
    .main-card {
        background: #E8F5E9;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        margin-top: 20px;
        animation: scaleIn 0.4s ease-out;
        transform-origin: top;
    }

    /* Title Section */
    /* Update existing h2 and p styles */
    h2 {
        color: #333333; /* Dark gray, almost black */
        font-weight: 600;
        margin-bottom: 10px;
    }

    /* Button Group Styles */
    .button-group {
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(70,139,148,0.2);
    }

    .btn-custom {
        background: #468B94;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        font-weight: 500;
        min-width: 120px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        margin-left: 10px;
        transform-origin: center;
    }

    .btn-custom:hover {
        background: #2C5530;
        color: white;
        transform: translateY(-2px) scale(1.01);
        box-shadow: 0 4px 8px rgba(44,85,48,0.15);
    }

    .btn-custom i {
        margin-right: 8px;
    }

    /* Laporan Card Styles */
    .laporan-list {
        margin-top: 20px;
    }

    .laporan-item {
        background: #468B94;
        background:;
        color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        animation: slideInPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: 2px solid transparent;
    }

    .laporan-item:hover {
        transform: translateY(-3px) scale(1.01);
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        border-color: rgba(255,255,255,0.2);
    }

    .laporan-item:nth-child(1) { animation-delay: 0.1s; }
    .laporan-item:nth-child(2) { animation-delay: 0.2s; }
    .laporan-item:nth-child(3) { animation-delay: 0.3s; }
    .laporan-item:nth-child(4) { animation-delay: 0.4s; }
    .laporan-item:nth-child(5) { animation-delay: 0.5s; }

    .laporan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .laporan-title {
        color: white;
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-action-small {
        background: white;
        color: #468B94;
        border: none;
        border-radius: 6px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-action-small:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .btn-action-small.edit:hover {
        background: #e8f5e9;
    }

    .btn-action-small.delete:hover {
        background: #ffebee;
        color: #d32f2f;
    }

    /* Info Groups */
    .info-group {
        margin-bottom: 12px;
    }

    .info-group label {
        color: rgba(255,255,255,0.9);
        font-weight: 500;
        margin-right: 8px;
    }

    .info-group span {
        color: white;
    }

    /* Badges */
    .status-badges {
        display: flex;
        gap: 8px;
        margin-top: 15px;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        background: white;
    }

    .badge-positif { color: #2e7d32; }
    .badge-negatif { color: #c62828; }
    .badge-verif { color: #2e7d32; }
    .badge-unverif { color: #c62828; }
    .badge-ditangani { color: #2e7d32; }
    .badge-belum { color: #c62828; }

    /* Dropdown Menu */
    .dropdown-menu {
        background: white;
        border: none;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        padding: 8px 0;
    }

    .dropdown-item {
        padding: 8px 16px;
        color: #2C5530;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background: #f5f5f5;
        color: #2C5530;
    }

    /* Empty State */
    .no-data {
        text-align: center;
        padding: 40px;
        color: #666;
    }

    .no-data i {
        font-size: 48px;
        color: #468B94;
        margin-bottom: 16px;
    }

    /* Update modal animation */
    .modal.fade .modal-dialog {
        transform: scale(0.98);
        opacity: 0;
    }

    .modal.show .modal-dialog {
        transform: scale(1);
        opacity: 1;
    }
    </style>
@endsection
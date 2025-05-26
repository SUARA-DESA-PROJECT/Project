@extends('layouts.app-warga')

@section('title', 'Riwayat Laporan')

@section('content')
<div class="container-fluid pl-4">
    <div class="card riwayat-card" style="margin-left: 0; text-align: left;">
        <div class="card-header riwayat-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="riwayat-title"><i class="fa fa-history"></i> Riwayat Laporan</h1>
                <div class="dropdown d-flex align-items-center gap-2">
                    <button class="btn filter-btn" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-filter mr-2"></i> Filter <i class="fa fa-caret-down ml-2"></i>
                    </button>
                    <a href="{{ route('laporan.create') }}" class="btn btn-secondary create-btn">
                        <i class="fa fa-plus mr-2"></i> Buat Laporan
                    </a>
                    <div class="dropdown-menu" aria-labelledby="filterDropdown">
                        <a class="dropdown-item" href="{{ route('riwayat-laporan.index') }}">Semua Data</a>
                        <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['status' => 'Diverifikasi']) }}">Diverifikasi</a>
                        <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['status' => 'Belum Diverifikasi']) }}">Belum Diverifikasi</a>
                        <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['jenis' => 'Laporan Positif']) }}">Laporan Positif</a>
                        <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['jenis' => 'Laporan Negatif']) }}">Laporan Negatif</a>
                        <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['status_penanganan' => 'Sudah Ditangani']) }}">Sudah Ditangani</a>
                        <a class="dropdown-item" href="{{ route('riwayat-laporan.index', ['status_penanganan' => 'Belum Ditangani']) }}">Belum Ditangani</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="riwayat-card-list">
                @forelse($laporans as $laporan)
                    <div class="laporan-card">
                        <div class="laporan-card-header">
                            <div class="laporan-card-title">
                                <i class="fa fa-file-alt"></i> {{ $laporan->judul_laporan }}
                            </div>
                            <div class="laporan-card-actions">
                                <a href="{{ route('inputlaporan.edit', $laporan->id) }}" class="btn-card-aksi" title="Edit">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('inputlaporan.destroy', $laporan->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-card-aksi delete-laporan" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="laporan-card-body">
                            <div class="laporan-card-row">
                                <span class="laporan-label"><i class="fa fa-align-left"></i> Deskripsi:</span>
                                <span class="laporan-value">{{ \Illuminate\Support\Str::limit($laporan->deskripsi_laporan, 100) }}</span>
                            </div>
                            <div class="laporan-card-row">
                                <span class="laporan-label"><i class="fa fa-calendar-alt"></i> Tanggal:</span>
                                <span class="laporan-value">{{ \Carbon\Carbon::parse($laporan->tanggal_pelaporan)->format('d-m-Y') }}</span>
                            </div>
                            <div class="laporan-card-row">
                                <span class="laporan-label"><i class="fa fa-map-marker-alt"></i> Tempat:</span>
                                <span class="laporan-value">{{ $laporan->tempat_kejadian }}</span>
                            </div>
                            <div class="laporan-card-row">
                                <span class="laporan-label"><i class="fa fa-tags"></i> Kategori:</span>
                                <span class="laporan-value">{{ $laporan->kategori_laporan }}</span>
                            </div>
                            <div class="laporan-card-row">
                                <span class="laporan-label"><i class="fa fa-info-circle"></i> Jenis:</span>
                                <span class="badge badge-jenis {{ $laporan->jenis_kategori == 'Positif' ? 'badge-positif' : 'badge-negatif' }}">
                                    {{ $laporan->jenis_kategori == 'Positif' ? 'Laporan Positif' : 'Laporan Negatif' }}
                                </span>
                            </div>
                            <div class="laporan-card-row">
                                <span class="laporan-label"><i class="fa fa-check-circle"></i> Status Verifikasi:</span>
                                <span class="badge badge-status {{ $laporan->status_verifikasi == 'Diverifikasi' ? 'badge-verif' : 'badge-unverif' }}">
                                    {{ $laporan->status_verifikasi }}
                                </span>
                            </div>
                            <div class="laporan-card-row">
                                <span class="laporan-label"><i class="fa fa-tasks"></i> Status Penanganan:</span>
                                <span class="badge badge-status-penanganan {{ $laporan->status_penanganan == 'Sudah Ditangani' ? 'badge-ditangani' : 'badge-belum' }}">
                                    {{ $laporan->status_penanganan }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center" style="padding: 20px;">Tidak ada data laporan</div>
                @endforelse
                <div class="d-flex justify-content-center mt-4">
                    {{ $laporans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

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
        $('.delete-laporan').click(function(e) {
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
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

<style>
/* --- RIWAYAT LAPORAN MODERN STYLE --- */
.riwayat-card {
    background: linear-gradient(135deg, #f8fafc 60%, #e3f6f5 100%);
    border-radius: 18px;
    box-shadow: 0 6px 24px rgba(70,139,148,0.10);
    margin-top: 2rem;
    animation: fadeInDown 0.7s;
}
.riwayat-header {
    background: linear-gradient(90deg, #468B94 60%, #56c6d9 100%);
    color: #fff;
    border-radius: 18px 18px 0 0;
    padding: 2rem 2rem 1.5rem 2rem;
    box-shadow: 0 2px 8px rgba(70,139,148,0.08);
}
.riwayat-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: 1px;
    display: flex;
    align-items: center;
    gap: 0.7rem;
}
.filter-btn, .create-btn {
    background: #fff;
    color: #468B94;
    border: none;
    font-weight: 600;
    border-radius: 8px;
    padding: 0.7rem 1.5rem;
    margin-left: 0.5rem;
    box-shadow: 0 2px 8px rgba(70,139,148,0.08);
    transition: background 0.2s, color 0.2s, transform 0.2s;
}
.filter-btn:hover, .create-btn:hover {
    background: #468B94;
    color: #fff;
    transform: translateY(-2px) scale(1.04);
}
.riwayat-card-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}
.laporan-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 16px rgba(70,139,148,0.10);
    padding: 1.5rem 1.5rem 1rem 1.5rem;
    display: flex;
    flex-direction: column;
    transition: box-shadow 0.2s, transform 0.2s;
    animation: fadeInDown 0.7s;
    position: relative;
}
.laporan-card:hover {
    box-shadow: 0 8px 32px rgba(70,139,148,0.18);
    transform: translateY(-4px) scale(1.01);
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
.laporan-card-actions {
    display: flex;
    gap: 0.5rem;
}
.btn-card-aksi {
    background: none;
    border: none;
    color: #468B94;
    font-size: 1.2rem;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, color 0.2s, transform 0.2s;
}
.btn-card-aksi:hover {
    background: #e3f6f5;
    color: #3a7a82;
    transform: scale(1.12);
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
    word-break: break-word;
}
.badge-jenis, .badge-status, .badge-status-penanganan {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.98rem;
    font-weight: 600;
    display: inline-block;
    box-shadow: 0 1px 4px rgba(70,139,148,0.08);
}
.badge-positif {
    background: #e0f7e9;
    color: #1e824c;
}
.badge-negatif {
    background: #ffeaea;
    color: #c0392b;
}
.badge-verif {
    background: #e0f7e9;
    color: #1e824c;
}
.badge-unverif {
    background: #ffeaea;
    color: #c0392b;
}
.badge-ditangani {
    background: #e0f7e9;
    color: #1e824c;
}
.badge-belum {
    background: #ffeaea;
    color: #c0392b;
}
@media (max-width: 768px) {
    .riwayat-card-list {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    .laporan-card {
        padding: 1rem;
    }
    .laporan-label { min-width: 100px; font-size: 0.98rem; }
}
</style>
@endsection
@extends('layouts.app')

@section('title', 'Riwayat Laporan Pengurus')

@section('content')
<div class="container-fluid pl-4">
    <div class="card riwayat-card" style="margin-left: 0; text-align: left;">
        <div class="card-header riwayat-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="riwayat-title"><i class="fa fa-history"></i> Riwayat Laporan</h1>
                <div class="dropdown d-flex align-items-center gap-2">
                    <a href="{{ url('/export-pdf') }}?{{ http_build_query(request()->query()) }}" 
                       class="btn mr-2" 
                       style="background-color: #3942ef; color: white; border-radius: 6px; padding: 6px 15px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <i class="fa fa-file-pdf-o mr-2"></i> Cetak PDF
                    </a>
                    <button class="btn" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
                            style="background-color: #468B94; color: white; border-radius: 6px; padding: 6px 15px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <i class="fa fa-filter mr-2"></i> Filter <i class="fa fa-caret-down ml-2"></i>
                    </button>

                    <div class="dropdown-menu" aria-labelledby="filterDropdown">
                        <a class="dropdown-item" href="{{ route('pengurus.kelola-laporan.index') }}">Semua Data</a>
                        <a class="dropdown-item" href="{{ route('pengurus.kelola-laporan.index', ['status' => 'Diverifikasi']) }}">Diverifikasi</a>
                        <a class="dropdown-item" href="{{ route('pengurus.kelola-laporan.index', ['status' => 'Belum Diverifikasi']) }}">Belum Diverifikasi</a>
                        <a class="dropdown-item" href="{{ route('pengurus.kelola-laporan.index', ['jenis' => 'Laporan Positif']) }}">Laporan Positif</a>
                        <a class="dropdown-item" href="{{ route('pengurus.kelola-laporan.index', ['jenis' => 'Laporan Negatif']) }}">Laporan Negatif</a>
                        <a class="dropdown-item" href="{{ route('pengurus.kelola-laporan.index', ['status_penanganan' => 'Sudah Ditangani']) }}">Sudah Ditangani</a>
                        <a class="dropdown-item" href="{{ route('pengurus.kelola-laporan.index', ['status_penanganan' => 'Belum Ditangani']) }}">Belum Ditangani</a>
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

            @forelse($laporans as $laporan)
                <div class="laporan-card">
                    <div class="laporan-card-header">
                        <div class="laporan-card-title">
                            <i class="fa fa-file-alt"></i> {{ $laporan->judul_laporan }}
                        </div>
                        <div class="laporan-card-actions">
                            <a href="{{ route('pengurus.kelola-laporan.edit', $laporan->id) }}" 
                               class="btn" 
                               style="background-color: #468B94; color: white; border-radius: 6px; padding: 6px 15px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <i class="fas fa-pencil-alt-mr-1"></i> Edit
                            </a>
                            <form action="{{ route('pengurus.kelola-laporan.destroy', $laporan->id) }}" method="POST" style="display: inline-block;">
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
                    </div>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
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
            
            $('#modal-judul').text(judul);
            $('#modal-deskripsi').text(deskripsi);
            $('#modal-tanggal').text(tanggal);
            $('#modal-tempat').text(tempat);
            $('#modal-status').text(status);
            $('#modal-kategori').text(kategori);
            $('#modal-jenis').text(jenis);
            $('#modal-status-penanganan').text(statusPenanganan);
            
            $('#detailLaporanModal').modal('show');
        });

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
    background-color: transparent;
    border-bottom: 2px solid #e3f6f5;
    padding: 1.5rem;
}

.riwayat-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #468B94;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    margin: 0;
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
    padding: 0.5rem;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
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
}

.badge {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.875rem;
}

.badge-jenis {
    min-width: 120px;
    text-align: center;
}

.badge-positif {
    background-color: #28a745;
    color: white;
}

.badge-negatif {
    background-color: #dc3545;
    color: white;
}

.badge-verif {
    background-color: #28a745;
    color: white;
}

.badge-unverif {
    background-color: #dc3545;
    color: white;
}

.badge-ditangani {
    background-color: #28a745;
    color: white;
}

.badge-belum {
    background-color: #dc3545;
    color: white;
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
</style>
@endsection
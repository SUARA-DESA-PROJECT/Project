@extends('layouts.app-warga')

@section('title', 'Riwayat Laporan')

@section('content')
<div class="container-fluid pl-4">
    <div class="card" style="margin-left: 0; text-align: left;">
        <div class="card-header" style="text-align: left;">
            <div class="d-flex justify-content-between align-items-center">
                <h1 style="text-align: left;">Riwayat Laporan</h1>
                <div class="d-flex align-items-center">
                    <a href="{{ url('/export-pdf') }}?{{ http_build_query(request()->query()) }}" class="btn mr-2" style="background-color: #3942ef; color: white; border-radius: 6px; padding: 6px 15px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <i class="fa fa-file-pdf-o mr-2"></i> Cetak PDF
                    </a>
                    <div class="dropdown">
                        <button class="btn" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #468B94; color: white; border-radius: 6px; padding: 6px 15px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1); min-width: 120px; width: auto;">
                            <i class="fa fa-filter mr-2"></i> Filter <i class="fa fa-caret-down ml-2"></i>
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
            
            <div class="table-responsive">
                <table class="table table-hover" style="text-align: left; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <thead style="background-color: #468B94; color: black; font-weight: bold;">
                        <tr>
                            <th style="padding: 15px; width: 20%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Judul Laporan</th>
                            <th style="padding: 15px; width: 15%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Deskripsi Laporan</th>
                            <th style="padding: 15px; width: 10%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Tanggal Pelaporan</th>
                            <th style="padding: 15px; width: 15%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Tempat Kejadian</th>
                            <th style="padding: 15px; width: 15%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Kategori Laporan</th>
                            <th style="padding: 15px; width: 15%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Jenis Laporan</th>
                            <th style="padding: 15px; width: 15%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Status Verifikasi</th>
                            <th style="padding: 15px; width: 15%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Status Penanganan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $laporan)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 12px 15px; vertical-align: middle; text-align: center;">
                                    <a href="javascript:void(0)" class="show-laporan-details" 
                                       data-id="{{ $laporan->id }}"
                                       data-judul="{{ $laporan->judul_laporan }}"
                                       data-deskripsi="{{ $laporan->deskripsi_laporan }}"
                                       data-tanggal="{{ $laporan->tanggal_pelaporan }}"
                                       data-tempat="{{ $laporan->tempat_kejadian }}"
                                       data-status="{{ $laporan->status_verifikasi }}"
                                       data-kategori="{{ $laporan->kategori_laporan }}"
                                       data-jenis="{{ $laporan->jenis_kategori }}"
                                       data-status-penanganan="{{ $laporan->status_penanganan }}"
                                       style="color: #333; text-decoration: underline; cursor: pointer;">
                                        {{ $laporan->judul_laporan }}
                                    </a>
                                </td>
                                <td style="padding: 12px 15px; vertical-align: middle; text-align: center;">
                                    {{ \Illuminate\Support\Str::limit($laporan->deskripsi_laporan, 50) }}
                                </td>
                                <td style="padding: 12px 15px; vertical-align: middle; text-align: center;">
                                    {{ \Carbon\Carbon::parse($laporan->tanggal_pelaporan)->format('d-m-Y') }}
                                </td>
                                <td style="padding: 12px 15px; vertical-align: middle; text-align: center;">
                                    {{ $laporan->tempat_kejadian }}
                                </td>
                                <td style="padding: 12px 15px; vertical-align: middle; text-align: center;">
                                    {{ $laporan->kategori_laporan }}
                                </td>
                                <td style="padding: 12px 15px; vertical-align: middle; text-align: center;">
                                    <span class="badge" style="padding: 8px 12px; border-radius: 4px; font-size: 13px; font-weight: 500; 
                                        background-color: {{ $laporan->jenis_kategori == 'Positif' ? '#28a745' : '#dc3545' }}; 
                                        color: white; display: inline-block; width: 180px; text-align: center;">
                                        {{ $laporan->jenis_kategori == 'Positif' ? 'Laporan Positif' : 'Laporan Negatif' }}
                                    </span>
                                </td>
                                <td style="padding: 12px 15px; text-align: center; vertical-align: middle;">
                                    <span class="badge" style="padding: 8px 12px; border-radius: 4px; font-size: 13px; font-weight: 500; 
                                        background-color: {{ $laporan->status_verifikasi == 'Diverifikasi' ? '#28a745' : '#dc3545' }}; 
                                        color: white; display: inline-block; width: 180px; text-align: center;">
                                        {{ $laporan->status_verifikasi }}
                                    </span>
                                </td>
                                <td style="padding: 12px 15px; text-align: center; vertical-align: middle;">
                                    <span class="badge" style="padding: 8px 12px; border-radius: 4px; font-size: 13px; font-weight: 500; 
                                        background-color: {{ $laporan->status_penanganan == 'Sudah Ditangani' ? '#28a745' : '#dc3545' }}; 
                                        color: white; display: inline-block; width: 180px; text-align: center;">
                                        {{ $laporan->status_penanganan }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center" style="padding: 20px;">Tidak ada data laporan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
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
    });
</script>
@endsection
@extends('layouts.app')

@section('title', 'Verifikasi Laporan')

@section('content')
<div class="container-fluid pl-4">
    <div class="card" style="margin-left: 0; text-align: left;">
        <div class="card-header" style="text-align: left;">
            <div class="d-flex justify-content-between align-items-center">
                <h1 style="text-align: left;">Verifikasi Laporan</h1>
                <div class="dropdown">
                    <button class="btn" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #468B94; color: white; border-radius: 6px; padding: 6px 15px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1); min-width: 120px; width: auto;">
                        <i class="fa fa-filter mr-2"></i> Filter <i class="fa fa-caret-down ml-2"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="filterDropdown">
                        <a class="dropdown-item" href="{{ route('verifikasilap.index') }}">Semua Data</a>
                        <a class="dropdown-item" href="{{ route('verifikasilap.index', ['status' => 'Diverifikasi']) }}">Diverifikasi</a>
                        <a class="dropdown-item" href="{{ route('verifikasilap.index', ['status' => 'Belum Diverifikasi']) }}">Belum Diverifikasi</a>
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
                            <th style="padding: 15px; width: 25%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Judul Laporan</th>
                            <th style="padding: 15px; width: 15%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Tanggal Pelaporan</th>
                            <th style="padding: 15px; width: 20%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Tempat Kejadian</th>
                            <th style="padding: 15px; width: 15%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Status Verifikasi</th>
                            <th style="padding: 15px; width: 25%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Aksi</th>
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
                                       data-penanganan="{{ $laporan->status_penanganan }}"
                                       data-deskripsi_penanganan="{{ $laporan->deskripsi_penanganan }}"
                                       style="color: #333; text-decoration: underline; cursor: pointer;">
                                        {{ $laporan->judul_laporan }}
                                    </a>
                                </td>
                                <td style="padding: 12px 15px; vertical-align: middle; text-align: center;">
                                    {{ \Carbon\Carbon::parse($laporan->tanggal_pelaporan)->format('d-m-Y') }}
                                </td>
                                <td style="padding: 12px 15px; vertical-align: middle; text-align: center;">
                                    {{ $laporan->tempat_kejadian }}
                                </td>
                                <td style="padding: 12px 15px; text-align: center; vertical-align: middle;">
                                    <span class="badge" style="padding: 8px 12px; border-radius: 4px; font-size: 13px; font-weight: 500; 
                                        background-color: {{ $laporan->status_verifikasi == 'Diverifikasi' ? '#28a745' : '#dc3545' }}; 
                                        color: white; display: inline-block; width: 180px; text-align: center;">
                                        {{ $laporan->status_verifikasi }}
                                    </span>
                                </td>
                                <td style="padding: 12px 15px; text-align: center; vertical-align: middle;">
                                    @if($laporan->status_verifikasi == 'Belum Diverifikasi')
                                        <form action="{{ route('verifikasilap.verify', $laporan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn" style="background-color: #28a745; color: white; border-radius: 4px; padding: 8px 12px; width: 180px; font-size: 13px; height: 38px;">
                                                <i class="fa fa-check"></i> Verifikasi
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('verifikasilap.unverify', $laporan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn" style="background-color: #dc3545; color: white; border-radius: 4px; padding: 8px 12px; width: 180px; font-size: 13px; height: 38px;">
                                                <i class="fa fa-times"></i> Hapus Verifikasi
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center" style="padding: 20px;">Tidak ada data laporan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ url('/homepage') }}" class="btn btn-secondary" style="float: left;">
        Kembali ke Beranda
    </a>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const verifyForms = document.querySelectorAll('form[action*="verifikasilap"]');
        verifyForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const isVerify = this.action.includes('verify') && !this.action.includes('unverify');
                const title = isVerify ? 'Verifikasi Laporan' : 'Hapus Verifikasi';
                const text = isVerify 
                    ? 'Apakah Anda yakin ingin memverifikasi laporan ini?' 
                    : 'Apakah Anda yakin ingin menghapus status verifikasi laporan ini?';
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
        
        const laporanDetailLinks = document.querySelectorAll('.show-laporan-details');
        laporanDetailLinks.forEach(link => {
            link.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const judul = this.getAttribute('data-judul');
                const deskripsi = this.getAttribute('data-deskripsi');
                const tanggal = this.getAttribute('data-tanggal');
                const tempat = this.getAttribute('data-tempat');
                const status = this.getAttribute('data-status');
                const kategori = this.getAttribute('data-kategori');
                const penanganan = this.getAttribute('data-penanganan');
                const deskripsiPenanganan = this.getAttribute('data-deskripsi_penanganan');
                const isVerified = status === 'Diverifikasi';
                
                const htmlContent = `
                    <div class="text-left">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 40%;">ID Laporan</th>
                                <td>${id}</td>
                            </tr>
                            <tr>
                                <th>Judul Laporan</th>
                                <td>${judul}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>${deskripsi}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pelaporan</th>
                                <td>${tanggal}</td>
                            </tr>
                            <tr>
                                <th>Tempat Kejadian</th>
                                <td>${tempat}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>${kategori}</td>
                            </tr>
                            <tr>
                                <th>Status Penanganan</th>
                                <td>${penanganan}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi Penanganan</th>
                                <td>${deskripsiPenanganan}</td>
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
                
                Swal.fire({
                    title: 'Detail Laporan',
                    html: htmlContent,
                    width: 600,
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#6c757d'
                });
            });
        });
    });
</script>
@endsection
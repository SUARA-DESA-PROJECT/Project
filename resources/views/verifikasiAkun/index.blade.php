@extends('layouts.app-warga')

@section('title', 'Verifikasi Akun')

@section('content')
<div class="container-fluid pl-4">
    <div class="card" style="margin-left: 0; text-align: left;">
        <div class="card-header" style="text-align: left;">
            <div class="d-flex justify-content-between align-items-center">
                <h1 style="text-align: left;">Verifikasi Akun Pengguna</h1>
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
                            <th style="padding: 15px; width: 15%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Username</th>
                            <th style="padding: 15px; width: 30%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Nama Lengkap</th>
                            <th style="padding: 15px; width: 25%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Status Verifikasi</th>
                            <th style="padding: 15px; width: 30%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wargas as $warga)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 12px 15px; vertical-align: middle; text-align: center;">
                                    <a href="javascript:void(0)" class="show-warga-details" 
                                       data-username="{{ $warga->username }}"
                                       data-nama="{{ $warga->nama_lengkap }}"
                                       data-telepon="{{ $warga->nomor_telepon }}"
                                       data-alamat="{{ $warga->alamat }}"
                                       data-email="{{ $warga->email }}"
                                       data-status="{{ $warga->status_verifikasi }}"
                                       style="color: #333; text-decoration: none; cursor: pointer;">
                                        {{ $warga->username }}
                                    </a>
                                </td>
                                <td style="padding: 12px 15px; vertical-align: middle; text-align: center;">{{ $warga->nama_lengkap }}</td>
                                <td style="padding: 12px 15px; text-align: center; vertical-align: middle;">
                                    <span class="badge" style="padding: 8px 12px; border-radius: 4px; font-size: 13px; font-weight: 500; 
                                        background-color: {{ $warga->status_verifikasi == 'Terverifikasi' ? '#28a745' : '#dc3545' }}; 
                                        color: white; display: inline-block; width: 180px; text-align: center;">
                                        {{ $warga->status_verifikasi }}
                                    </span>
                                </td>
                                <td style="padding: 12px 15px; text-align: center; vertical-align: middle;">
                                    @if($warga->status_verifikasi == 'Belum diverifikasi')
                                        <form action="{{ route('warga.verify', $warga->username) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn" style="background-color: #28a745; color: white; border-radius: 4px; padding: 8px 12px; width: 180px; font-size: 13px; height: 38px;">
                                                <i class="fa fa-check"></i> Verifikasi
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('warga.unverify', $warga->username) }}" method="POST" class="d-inline">
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
                                <td colspan="4" class="text-center" style="padding: 20px;">Tidak ada data warga</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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
    });
</script>
@endsection
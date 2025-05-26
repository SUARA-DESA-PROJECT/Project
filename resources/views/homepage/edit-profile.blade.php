@extends('layouts.app-warga')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div style="background: #fff; border-radius: 12px; box-shadow: 0 4px 16px rgba(70,139,148,0.10), 0 1.5px 0 #468B94; border-top: 4px solid #468B94; padding: 32px 28px 28px 28px; width: 100%;">
                <h4 class="mb-4" style="font-weight: bold;"><i class="fa fa-user-edit" style="color: #468B94; margin-right: 8px;"></i>Edit Profile</h4>
                <style>
                    .edit-profile-form .form-control {
                        background: rgba(70,139,148,0.06) !important;
                        border: 1px solid #468B94 !important;
                        box-shadow: none !important;
                        font-size: 1rem;
                        color: #222;
                    }
                    .edit-profile-form .form-control:focus {
                        border-color: #2b5e63 !important;
                        background: rgba(70,139,148,0.10) !important;
                    }
                </style>
                <form method="POST" action="{{ route('profile.update') }}" class="edit-profile-form">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" value="{{ session('warga') ? session('warga')->username : '' }}" readonly>
                        <small class="text-muted">Username tidak dapat diubah</small>
                    </div>

                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                            id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', session('warga') ? session('warga')->nama_lengkap : '') }}">
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                            id="email" name="email" value="{{ old('email', session('warga') ? session('warga')->email : '') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" 
                            id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon', session('warga') ? session('warga')->nomor_telepon : '') }}">
                        @error('nomor_telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                            id="alamat" name="alamat" rows="3">{{ old('alamat', session('warga') ? session('warga')->alamat : '') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('homepage-warga') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#468B94',
                timer: 2000,
                showConfirmButton: false
            });
        });
    </script>
@endif
@endsection
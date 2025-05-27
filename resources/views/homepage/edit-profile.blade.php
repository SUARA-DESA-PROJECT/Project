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

                    <hr class="my-4">
                    <h5 class="mb-3">Ubah Password</h5>
                    
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                id="new_password" name="new_password">
                            <button class="btn border-0 bg-transparent" type="button" id="toggleNewPassword">
                                <i class="fa fa-eye"></i>
                            </button>
                            @error('new_password')

                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                                id="new_password_confirmation" name="new_password_confirmation">
                            <button class="btn border-0 bg-transparent" type="button" id="toggleConfirmPassword">
                                <i class="fa fa-eye"></i>
                            </button>
                            @error('new_password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="password-match-error" class="invalid-feedback" style="display: none;">
                                Password tidak cocok
                            </div>
                        </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleNewPassword = document.getElementById('toggleNewPassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('new_password_confirmation');
        const passwordMatchError = document.getElementById('password-match-error');
        const submitButton = document.querySelector('button[type="submit"]');

        // Function to check password match
        function checkPasswordMatch() {
            const newPassword = newPasswordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (confirmPassword && newPassword !== confirmPassword) {
                confirmPasswordInput.classList.add('is-invalid');
                passwordMatchError.style.display = 'block';
                submitButton.disabled = true;
            } else {
                confirmPasswordInput.classList.remove('is-invalid');
                passwordMatchError.style.display = 'none';
                submitButton.disabled = false;
            }
        }

        // Add event listeners for password matching
        newPasswordInput.addEventListener('input', checkPasswordMatch);
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);

        toggleNewPassword.addEventListener('click', function() {
            const type = newPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            newPasswordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
</script>
@endsection
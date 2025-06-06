@extends('layouts.app-warga')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid mt-4">
    <div class="edit-header">
        <div class="profile-icon">
            <i class="fa fa-user-circle"></i>
        </div>
        <h2>Edit Profile</h2>
    </div>
    <p class="description">Silakan ubah data profil Anda pada form di bawah ini.</p>

    <form method="POST" action="{{ route('profile.update') }}" class="edit-profile-form">
        @csrf
        @method('PUT')

        <div class="form-section">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" 
                    value="{{ session('warga') ? session('warga')->username : '' }}" readonly>
                <small class="text-muted">Username tidak dapat diubah</small>
            </div>

            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                    id="nama_lengkap" name="nama_lengkap" 
                    value="{{ old('nama_lengkap', session('warga') ? session('warga')->nama_lengkap : '') }}">
                @error('nama_lengkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                    id="email" name="email" 
                    value="{{ old('email', session('warga') ? session('warga')->email : '') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nomor_telepon">Nomor Telepon</label>
                <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" 
                    id="nomor_telepon" name="nomor_telepon" 
                    value="{{ old('nomor_telepon', session('warga') ? session('warga')->nomor_telepon : '') }}">
                @error('nomor_telepon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                    id="alamat" name="alamat" rows="3">{{ old('alamat', session('warga') ? session('warga')->alamat : '') }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-section password-section">
            <h5>Ubah Password</h5>
            
            <div class="form-group">
                <label for="new_password">Password Baru</label>
                <div class="input-group">
                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                        id="new_password" name="new_password">
                    <div class="input-group-append">
                        <button class="btn password-toggle" type="button" id="toggleNewPassword">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
                @error('new_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                <div class="input-group">
                    <input type="password" class="form-control" 
                        id="new_password_confirmation" name="new_password_confirmation">
                    <div class="input-group-append">
                        <button class="btn password-toggle" type="button" id="toggleConfirmPassword">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div id="password-match-error" class="invalid-feedback" style="display: none;">
                    Password tidak cocok
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('homepage-warga') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>

<style>
/* Base styles */
.container-fluid {
    background: #ffffff;
    padding: 2rem;
    min-height: 100vh;
    width: 100%;
}

/* Header styles */
.edit-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding: 0 1rem;
}

.profile-icon {
    color: #468B94;
    font-size: 2.5rem;
}

.edit-header h2 {
    margin: 0;
    color: #333;
    font-weight: 600;
    font-size: 2rem;
}

.description {
    color: #666;
    margin-bottom: 2rem;
    font-size: 1rem;
    line-height: 1.5;
    padding: 0 1rem;
}

/* Form styles */
.edit-profile-form {
    width: 100%;
    padding: 0 1rem;
}

.form-section {
    background: #fff;
    border: 1px solid rgba(70,139,148,0.15);
    border-radius: 10px;
    padding: 2rem;
    margin-bottom: 2rem;
    width: 100%;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 2px 8px rgba(70,139,148,0.05);
}

.form-section:hover {
    border-color: #468B94;
    box-shadow: 0 8px 24px rgba(70,139,148,0.12);
    transform: translateY(-5px);
}

.form-group {
    margin-bottom: 1.5rem;
    width: 100%;
}

.form-group label {
    display: block;
    color: #333333;
    margin-bottom: 0.5rem;
    font-weight: 500;
    text-align: left;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid rgba(70,139,148,0.2);
    border-radius: 8px;
    background: #f8f9fa;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* Add hover effect for specific fields */
input[type="text"]:not([readonly]),
input[type="email"] {
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

input[type="text"]:not([readonly]):hover,
input[type="email"]:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(70,139,148,0.1);
    border-color: #468B94;
    background: #fff;
}

input[type="text"]:not([readonly]):focus,
input[type="email"]:focus {
    outline: none;
    border-color: #468B94;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(70,139,148,0.1);
    transform: translateY(-3px);
}

/* Keep readonly input styling */
.form-control[readonly] {
    background-color: #f8f9fa;
    cursor: not-allowed;
    transition: none;
}

.form-control[readonly]:hover {
    transform: none;
    box-shadow: none;
    border-color: rgba(70,139,148,0.2);
}

/* Remove card hover effect */
.form-section {
    background: #fff;
    border: 1px solid rgba(70,139,148,0.15);
    border-radius: 10px;
    padding: 2rem;
    margin-bottom: 2rem;
    width: 100%;
}

.form-section:hover {
    transform: none;
    box-shadow: none;
}

/* Center align labels */
.form-group label {
    text-align: justify;
    width: 100%;
}

/* Style for readonly inputs */
.form-control[readonly] {
    background-color: #f8f9fa;
    cursor: not-allowed;
}

/* Password input group hover effect */
.input-group {
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.input-group:hover {
    transform: translateY(-3px);
}

.input-group:hover .form-control,
.input-group:hover .btn {
    border-color: #468B94;
    box-shadow: 0 4px 12px rgba(70,139,148,0.1);
}

/* Textarea hover effect */
textarea.form-control {
    min-height: 100px;
    resize: vertical;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

textarea.form-control:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(70,139,148,0.1);
    border-color: #468B94;
}

/* Password section */
.password-section {
    margin-top: 2rem;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.password-section:hover {
    border-color: #468B94;
    box-shadow: 0 8px 24px rgba(70,139,148,0.12);
    transform: translateY(-5px);
}

/* Buttons */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

.btn-primary {
    background: #468B94;
    color: white;
    border: none;
}

.btn-primary:hover {
    background: #3a757d;
    box-shadow: 0 4px 12px rgba(70,139,148,0.2);
}

.btn-secondary {
    background: #e9ecef;
    color: #495057;
    border: none;
}

.btn-secondary:hover {
    background: #dee2e6;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Helper text */
.text-muted {
    color: #6c757d;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Error states */
.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem 0;
    }
    
    .edit-header, 
    .description,
    .edit-profile-form {
        padding: 0 1rem;
    }
}
</style>

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
                popup: 'swal2-popup',
                title: 'swal2-title',
                content: 'swal2-content'
            }
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection
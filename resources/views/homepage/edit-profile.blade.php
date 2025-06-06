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
    animation: fadeInUp 0.8s ease-out;
}

/* Keyframe animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInFromLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes bounceIn {
    0% {
        opacity: 0;
        transform: scale(0.3);
    }
    50% {
        opacity: 1;
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(70,139,148,0.4);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(70,139,148,0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(70,139,148,0);
    }
}

/* Header styles with animation */
.edit-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding: 0 1rem;
    animation: slideInFromLeft 0.6s ease-out;
}

.profile-icon {
    color: #468B94;
    font-size: 2.5rem;
    animation: bounceIn 1s ease-out 0.3s both;
}

.edit-header h2 {
    margin: 0;
    color: #333;
    font-weight: 600;
    font-size: 2rem;
    animation: slideInFromLeft 0.8s ease-out 0.2s both;
}

.description {
    color: #666;
    margin-bottom: 2rem;
    font-size: 1rem;
    line-height: 1.5;
    padding: 0 1rem;
    animation: fadeInUp 0.8s ease-out 0.4s both;
}

/* Form styles with staggered animation */
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
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(70,139,148,0.05);
    animation: fadeInUp 0.6s ease-out both;
    transform: translateY(20px);
    opacity: 0;
}

.form-section:nth-child(1) {
    animation-delay: 0.6s;
}

.form-section:nth-child(2) {
    animation-delay: 0.8s;
}

.form-section:hover {
    border-color: #468B94;
    box-shadow: 0 8px 24px rgba(70,139,148,0.12);
    transform: translateY(-4px);
}

.form-group {
    margin-bottom: 1.5rem;
    width: 100%;
    opacity: 0;
    animation: fadeInUp 0.5s ease-out both;
}

.form-group:nth-child(1) { animation-delay: 1s; }
.form-group:nth-child(2) { animation-delay: 1.1s; }
.form-group:nth-child(3) { animation-delay: 1.2s; }
.form-group:nth-child(4) { animation-delay: 1.3s; }
.form-group:nth-child(5) { animation-delay: 1.4s; }

.form-group label {
    display: block;
    color: #333333;
    margin-bottom: 0.5rem;
    font-weight: 500;
    text-align: left;
    transition: all 0.3s ease;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid rgba(70,139,148,0.2);
    border-radius: 8px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

/* Enhanced hover effects for inputs - lebih halus */
input[type="text"]:not([readonly]),
input[type="email"],
input[type="password"] {
    transition: all 0.3s ease;
    position: relative;
}

input[type="text"]:not([readonly]):hover,
input[type="email"]:hover,
input[type="password"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(70,139,148,0.1);
    border-color: #468B94;
    background: #fff;
}

input[type="text"]:not([readonly]):focus,
input[type="email"]:focus,
input[type="password"]:focus {
    outline: none;
    border-color: #468B94;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(70,139,148,0.1);
    transform: translateY(-2px);
}

/* Enhanced input group animations - lebih smooth */
.input-group {
    transition: all 0.3s ease;
    position: relative;
}

.input-group:hover {
    transform: translateY(-2px);
}

.input-group:hover .form-control,
.input-group:hover .btn {
    border-color: #468B94;
    box-shadow: 0 4px 12px rgba(70,139,148,0.1);
}

/* Enhanced textarea animations - lebih halus */
textarea.form-control {
    min-height: 100px;
    resize: vertical;
    transition: all 0.3s ease;
}

textarea.form-control:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(70,139,148,0.1);
    border-color: #468B94;
}

textarea.form-control:focus {
    transform: translateY(-2px);
    box-shadow: 0 0 0 3px rgba(70,139,148,0.1);
}

/* Password section with enhanced animation - lebih halus */
.password-section {
    margin-top: 2rem;
    transition: all 0.3s ease;
}

.password-section:hover {
    border-color: #468B94;
    box-shadow: 0 8px 24px rgba(70,139,148,0.12);
    transform: translateY(-4px);
}

.password-section h5 {
    animation: slideInFromLeft 0.6s ease-out 1.5s both;
    opacity: 0;
}

/* Enhanced button animations - lebih smooth */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
    animation: fadeInUp 0.6s ease-out 1.8s both;
    opacity: 0;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn:hover::before {
    left: 100%;
}

.btn:hover {
    transform: translateY(-2px) scale(1.02);
}

.btn-primary {
    background: #468B94;
    color: white;
    border: none;
}

.btn-primary:hover {
    background: #3a757d;
    box-shadow: 0 6px 16px rgba(70,139,148,0.25);
}

.btn-secondary {
    background: #e9ecef;
    color: #495057;
    border: none;
}

.btn-secondary:hover {
    background: #dee2e6;
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
}

/* Password toggle button animation - lebih halus */
.password-toggle {
    transition: all 0.3s ease;
    border: 1px solid rgba(70,139,148,0.2);
    background: #f8f9fa;
}

.password-toggle:hover {
    background: #468B94;
    color: white;
    transform: scale(1.05);
}

/* Loading state animation */
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    animation: pulse 1.5s infinite;
}

/* Error message animation */
.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
    20%, 40%, 60%, 80% { transform: translateX(3px); }
}

/* Success message enhancement */
.text-muted {
    color: #6c757d;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    animation: fadeInUp 0.5s ease-out;
}

/* Responsive animations - disesuaikan */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem 0;
        animation: fadeInUp 0.6s ease-out;
    }
    
    .edit-header, 
    .description,
    .edit-profile-form {
        padding: 0 1rem;
    }
    
    .form-section:hover {
        transform: translateY(-2px);
    }
    
    .btn:hover {
        transform: translateY(-1px) scale(1.01);
    }
    
    input[type="text"]:not([readonly]):hover,
    input[type="email"]:hover,
    input[type="password"]:hover,
    textarea.form-control:hover {
        transform: translateY(-1px);
    }
}

/* Keep readonly input styling without animations */
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
</style>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
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

        // Enhanced password toggle with animation
        toggleNewPassword.addEventListener('click', function() {
            const type = newPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            newPasswordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.style.transform = 'scale(0)';
            
            setTimeout(() => {
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
                icon.style.transform = 'scale(1)';
            }, 150);
        });

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.style.transform = 'scale(0)';
            
            setTimeout(() => {
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
                icon.style.transform = 'scale(1)';
            }, 150);
        });

        // Add form submission animation
        const form = document.querySelector('.edit-profile-form');
        form.addEventListener('submit', function() {
            submitButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menyimpan...';
            submitButton.disabled = true;
        });
    });
</script>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        // Enhanced password toggle with animation
        toggleNewPassword.addEventListener('click', function() {
            const type = newPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            newPasswordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.style.transform = 'scale(0)';
            
            setTimeout(() => {
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
                icon.style.transform = 'scale(1)';
            }, 150);
        });

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.style.transform = 'scale(0)';
            
            setTimeout(() => {
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
                icon.style.transform = 'scale(1)';
            }, 150);
        });

        // Add form submission animation
        const form = document.querySelector('.edit-profile-form');
        form.addEventListener('submit', function() {
            submitButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menyimpan...';
            submitButton.disabled = true;
        });
    });
</script>
@endpush
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Warga Digital</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2E7D32;
            --secondary-color: #4CAF50;
            --accent-color: #81C784;
            --text-color: #2C3E50;
            --error-color: #DC3545;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                        url('../images/bg-regis.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .registration-container {
            max-width: 800px;
            width: 90%;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .registration-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .registration-header {
            text-align: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--accent-color);
        }

        .registration-header h1 {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .registration-header p {
            color: var(--text-color);
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.3rem;
            font-size: 0.9rem;
        }

        .form-control {
            border: 2px solid #E0E5EC;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.15);
        }

        .btn-register {
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
        }

        .row {
            row-gap: 1rem;
        }

        .form-group {
            margin-bottom: 0;
        }

        textarea.form-control {
            height: 38px;
            resize: none;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #E0E5EC;
            font-size: 0.9rem;
        }

        .form-icon {
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .registration-container {
                width: 95%;
                margin: 1rem auto;
            }

            .registration-card {
                padding: 1.5rem;
            }

            .registration-header h1 {
                font-size: 1.75rem;
            }
        }

        /* Animation */
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

        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease-out;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <div class="registration-card animate-fadeInUp">
            <div class="registration-header">
                <h1>Daftar Akun Warga</h1>
                <p>Bergabung dengan Portal Digital Desa</p>
            </div>

            <form method="POST" action="{{ route('registrasi.store') }}" id="register-form" class="needs-validation" novalidate>
                @csrf
                
                <div class="row g-4">
                    <!-- Username & Password -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username" class="form-label">
                                <i class="bi bi-person form-icon"></i>Username
                            </label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                   id="username" name="username" value="{{ old('username') }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock form-icon"></i>Password
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Nama & Email -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_lengkap" class="form-label">
                                <i class="bi bi-person-vcard form-icon"></i>Nama Lengkap
                            </label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                   id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope form-icon"></i>Email
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Nomor Telepon & Alamat -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nomor_telepon" class="form-label">
                                <i class="bi bi-phone form-icon"></i>Nomor Telepon
                            </label>
                            <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror"
                                   id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}" required>
                            @error('nomor_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="alamat" class="form-label">
                                <i class="bi bi-geo-alt form-icon"></i>Alamat
                            </label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                      id="alamat" name="alamat" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-register w-100 text-white">
                        <i class="bi bi-check2-circle me-2"></i>Daftar Sekarang
                    </button>
                </div>

                <div class="login-link">
                    <p>Sudah memiliki akun? <a href="{{ route('login-masyarakat') }}">Masuk di sini</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('register-form');
            const nomorTelepon = document.getElementById('nomor_telepon');
            const namaLengkap = document.getElementById('nama_lengkap');
            
            // Convert nama_lengkap to uppercase
            namaLengkap.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
            
            // Phone number validation
            function validatePhoneNumber(value) {
                return /^\d+$/.test(value);
            }
            
            nomorTelepon.addEventListener('input', function() {
                if (!validatePhoneNumber(this.value)) {
                    this.classList.add('is-invalid');
                    this.nextElementSibling.textContent = 'Nomor telepon hanya boleh berisi angka';
                } else {
                    this.classList.remove('is-invalid');
                }
            });
            
            // Form submission
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                
                if (!this.checkValidity()) {
                    event.stopPropagation();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Mohon lengkapi semua field yang diperlukan!'
                    });
                } else if (!validatePhoneNumber(nomorTelepon.value)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Format nomor telepon tidak valid!'
                    });
                } else {
                    this.submit();
                }
                
                this.classList.add('was-validated');
            });

            // Success message
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Registrasi Berhasil!',
                    text: 'Anda akan diarahkan ke halaman login...',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                }).then((result) => {
                    window.location.href = '{{ route('login-masyarakat') }}';
                });
            @endif
        });
    </script>
</body>
</html>
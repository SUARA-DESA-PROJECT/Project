<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrasi</title>
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background-image: url('{{ asset('images/bg-regis.jpeg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            padding: 40px 0;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }
        
        .card-container {
            width: 100%;
            max-width: 700px;
            position: relative;
            margin: 40px 0;
            z-index: 1;
        }
        
        .card {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px 40px 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .card-header {
            text-align: center;
            background-color: #f5f5f5;
            padding: 25px 20px;
            margin: -30px -40px 30px;
            border-radius: 10px 10px 0 0;
        }
        
        .card-header h2 {
            font-size: 28px;
            color: #444;
            margin: 0;
            font-weight: 600;
        }
        
        .card-header p {
            color: #666;
            margin: 8px 0 0;
            font-size: 16px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #444;
            font-size: 16px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: white;
            font-size: 15px;
            box-sizing: border-box;
            height: auto;
        }
        
        #nama_lengkap {
            text-transform: uppercase;
            font-weight: 500;
        }
        
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        
        textarea.form-control {
            height: 100px;
            resize: none;
        }
        
        .btn-primary {
            width: 100%;
            padding: 14px;
            background-color: #4e54c8;
            border: none;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        
        .btn-primary:hover {
            background-color: #3f44a9;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }
        
        .login-link {
            text-align: center;
            margin-top: 25px;
        }
        
        .login-link p {
            font-size: 15px;
            color: #555;
            margin: 0;
        }
        
        .login-link a {
            color: #4e54c8;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            display: none;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .modal-content i {
            font-size: 48px;
            color: #4CAF50;
            margin-bottom: 15px;
        }

        .modal-content h3 {
            margin: 0 0 10px;
            color: #333;
        }

        .modal-content p {
            color: #666;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card">
            <div class="card-header">
                <h2>Registrasi</h2>
                <p>Silahkan isi formulir pendaftaran</p>
            </div>

            <div class="alert" id="error-alert">
                Mohon lengkapi semua kolom yang diperlukan.
            </div>

            <form method="POST" action="{{ route('registrasi.store') }}" id="register-form">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" 
                            name="username" value="{{ old('username') }}" required>
                        @error('username')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <span class="invalid-feedback" id="username-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                            name="password" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <span class="invalid-feedback" id="password-error"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input id="nama_lengkap" type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                            name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                        @error('nama_lengkap')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <span class="invalid-feedback" id="nama-lengkap-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <span class="invalid-feedback" id="email-error"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nomor_telepon">Nomor Telepon</label>
                        <input id="nomor_telepon" type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" 
                            name="nomor_telepon" value="{{ old('nomor_telepon') }}" required>
                        @error('nomor_telepon')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <span class="invalid-feedback" id="nomor-telepon-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                            name="alamat" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <span class="invalid-feedback" id="alamat-error"></span>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        Daftar Sekarang
                    </button>
                </div>
                
                <div class="login-link">
                    <p>Sudah punya akun? <a href="{{ route('login-masyarakat') }}">Login di sini</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('register-form');
            const errorAlert = document.getElementById('error-alert');
            const nomorTelepon = document.getElementById('nomor_telepon');
            const nomorTeleponError = document.getElementById('nomor-telepon-error');
            const namaLengkap = document.getElementById('nama_lengkap');
            
            // Convert nama_lengkap to uppercase as the user types
            namaLengkap.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
            
            // Validate phone number on input
            nomorTelepon.addEventListener('input', function() {
                validatePhoneNumber();
            });
            
            // Validate phone number on blur
            nomorTelepon.addEventListener('blur', function() {
                validatePhoneNumber();
            });
            
            function validatePhoneNumber() {
                const value = nomorTelepon.value.trim();
                const onlyNumbers = /^\d+$/.test(value);
                
                if (value && !onlyNumbers) {
                    nomorTelepon.classList.add('is-invalid');
                    nomorTeleponError.textContent = 'Nomor telepon hanya boleh berisi angka';
                    nomorTeleponError.style.display = 'block';
                    return false;
                } else {
                    if (value) {
                        nomorTelepon.classList.remove('is-invalid');
                        nomorTeleponError.style.display = 'none';
                    }
                    return true;
                }
            }
            
            // Form submission validation
            form.addEventListener('submit', function(event) {
                let isValid = true;
                const requiredFields = form.querySelectorAll('[required]');
                
                // Reset validation state
                errorAlert.style.display = 'none';
                
                // Check each required field
                requiredFields.forEach(function(field) {
                    const errorElement = document.getElementById(field.id + '-error') || 
                                         document.querySelector(`[id="${field.id.replace('_', '-')}-error"]`);
                    
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        if (errorElement) {
                            errorElement.textContent = 'Kolom ini harus diisi';
                            errorElement.style.display = 'block';
                        }
                        isValid = false;
                    } else {
                        if (field.id !== 'nomor_telepon' || validatePhoneNumber()) {
                            field.classList.remove('is-invalid');
                            if (errorElement) {
                                errorElement.style.display = 'none';
                            }
                        } else {
                            isValid = false;
                        }
                    }
                });
                
                // Validate phone number specifically
                if (!validatePhoneNumber()) {
                    isValid = false;
                }
                
                // Show general error message if validation fails
                if (!isValid) {
                    errorAlert.style.display = 'block';
                    event.preventDefault();
                    window.scrollTo(0, 0);
                }
            });

            // Show success message with SweetAlert2
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Registrasi Berhasil!',
                    text: 'Anda akan diarahkan ke halaman utama...',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                }).then((result) => {
                    window.location.href = '{{ route('/') }}';
                });
            @endif
        });
    </script>
</body>
</html>

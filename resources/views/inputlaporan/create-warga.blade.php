<!-- resources/views/inputlaporan/create.blade.php -->
@extends('layouts.app-warga')

@section('content')
<div class="container mt-4">
    <h2>Input Laporan</h2>
    <p>Silahkan mengisi seluruh formulir berikut ini untuk memberikan informasi laporan :</p>

    <!-- @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif -->

    <form action="{{ route('laporan.store') }}" method="POST" id="formLaporan">
        @csrf
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Input tersembunyi untuk username warga -->
        <input type="hidden" name="warga_username" value="{{ $warga->username }}">
        <input type="hidden" name="tipe_pelapor" value="Warga">

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Laporan</label>
            <input type="text" name="judul_laporan" id="judul" class="form-control @error('judul') is-invalid @enderror" 
                value="{{ old('judul') }}" placeholder="Masukkan judul laporan">
            @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="deskripsi_laporan" class="form-label">Deskripsi Laporan</label>
            <textarea name="deskripsi_laporan" id="deskripsi_laporan" class="form-control auto-expand @error('deskripsi_laporan') is-invalid @enderror" 
                style="min-height: 200px; max-height: 500px; overflow-y: scroll;" 
                maxlength="10000">{{ old('deskripsi_laporan') }}</textarea>
            <small class="text-muted">Maksimal 10000 karakter. Sisa: <span id="charCount">10000</span> karakter</small>
            @error('deskripsi_laporan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_pelaporan" class="form-label">Waktu Kejadian</label>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label for="Date" class="form-label">Tanggal</label>    
                    <input type="date" name="tanggal_pelaporan" id="tanggal_pelaporan" class="form-control @error('tanggal_pelaporan') is-invalid @enderror" value="{{ old('tanggal_pelaporan') }}" placeholder="Pilih Tanggal">
                    @error('tanggal_pelaporan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="time" class="form-label">Jam</label>    
                    <input type="time" name="time_laporan" id="time_laporan" class="form-control @error('time_laporan') is-invalid @enderror" value="{{ old('time_laporan') }}" placeholder="Pilih Jam">
                    @error('time_laporan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="tempat_kejadian" class="form-label">Tempat Kejadian</label>
            <select name="tempat_kejadian" id="desa" class="form-control @error('desa') is-invalid @enderror">
                <option value="">Pilih Desa/Kelurahan</option>
                <option value="Bojongsari" {{ old('desa') == 'Bojongsari' ? 'selected' : '' }}>Bojongsari</option>
                <option value="Bojongsoang" {{ old('desa') == 'Bojongsoang' ? 'selected' : '' }}>Bojongsoang</option>
                <option value="Buahbatu" {{ old('desa') == 'Buahbatu' ? 'selected' : '' }}>Buahbatu</option>
                <option value="Cipagalo" {{ old('desa') == 'Cipagalo' ? 'selected' : '' }}>Cipagalo</option>
                <option value="Lengkong" {{ old('desa') == 'Lengkong' ? 'selected' : '' }}>Lengkong</option>
                <option value="Tegalluar" {{ old('desa') == 'Tegalluar' ? 'selected' : '' }}>Tegalluar</option>
            </select>
            @error('desa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="judul_laporan" class="form-label">Kategori Laporan</label>
            <select name="kategori_laporan" id="judul_laporan" class="form-control @error('judul_laporan') is-invalid @enderror">
                <option value="">Pilih Kategori Laporan</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->nama_kategori }}" {{ old('kategori_laporan') == $kategori->nama_kategori ? 'selected' : '' }}
                        data-jenis="{{ $kategori->jenis_kategori }}">
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
            @error('judul_laporan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="kategori_laporan" class="form-label">Jenis Laporan</label>
            <input type="text" name="jenis_laporan" id="kategori_laporan" class="form-control" readonly 
                value="{{ old('kategori_laporan') }}" placeholder="Jenis laporan akan muncul otomatis">
            @error('kategori_laporan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
{{-- 
        <div class="mb-3">
            <label for="tipe_pelapor" class="form-label">Tipe Pelapor</label>
            <input type="text" class="form-control" value="Warga" readonly>
        </div>

        <div class="mb-3">
            <label for="warga_username" class="form-label">Username Warga</label>
            <input type="text" class="form-control" value="{{ $warga->username }}" readonly>
        </div> --}}

        <a href="{{ url('/homepage') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary float-end">Simpan Laporan</button>
    </form>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('formLaporan').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Konfirmasi',
        text: "Apakah Anda yakin ingin menyimpan laporan ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#468B94',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create form and submit
            const form = this;
            const formData = new FormData(form);
            
            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Submit form normally
            form.submit();
        }
    });
});

// Check for flash messages
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#468B94'
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        confirmButtonColor: '#d33'
    });
@endif
</script>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kategoriSelect = document.getElementById('judul_laporan');
    const jenisLaporanInput = document.getElementById('kategori_laporan');

    kategoriSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value === "") {
            jenisLaporanInput.value = "";
            return;
        }
        
        const jenisKategori = selectedOption.getAttribute('data-jenis');
        jenisLaporanInput.value = jenisKategori === 'Negatif' ? 'Laporan Negatif' : 'Laporan Positif';
    });

    if (kategoriSelect.value) {
        const selectedOption = kategoriSelect.options[kategoriSelect.selectedIndex];
        const jenisKategori = selectedOption.getAttribute('data-jenis');
        jenisLaporanInput.value = jenisKategori === 'Negatif' ? 'Laporan Negatif' : 'Laporan Positif';
    }

    function autoExpandPenanganan(textarea) {
        textarea.style.height = 'auto';
        
        const newHeight = Math.min(textarea.scrollHeight, 500);
        
        textarea.style.height = newHeight + 'px';
        
        textarea.style.overflowY = 'scroll';
    }

    autoExpandPenanganan(document.getElementById('deskripsi_penanganan'));

    document.getElementById('deskripsi_penanganan').addEventListener('input', function() {
        autoExpandPenanganan(this);
        
        const maxLength = 10000;
        const currentLength = this.value.length;
        const remaining = maxLength - currentLength;
        document.getElementById('charCountPenanganan').textContent = remaining;
        
        if (remaining < 20) {
            document.getElementById('charCountPenanganan').style.color = '#dc3545';
        } else {
            document.getElementById('charCountPenanganan').style.color = '';
        }
    });

    document.getElementById('formLaporan').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success'
                }).then(() => {
                    window.location.href = data.redirect;
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan saat menyimpan data',
                icon: 'error'
            });
        });
    });
});
</script>

<style>
/* Animasi dasar */
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

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes slideInPop {
    0% {
        opacity: 0;
        transform: translateX(-10px) scale(0.98);
    }
    50% {
        transform: translateX(3px) scale(1.01);
    }
    100% {
        opacity: 1;
        transform: translateX(0) scale(1);
    }
}

/* Animasi untuk form sections */
.mb-3 {
    animation: slideInPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* Sequence animation untuk form fields */
.mb-3:nth-child(1) { animation-delay: 0.1s; }
.mb-3:nth-child(2) { animation-delay: 0.2s; }
.mb-3:nth-child(3) { animation-delay: 0.3s; }
.mb-3:nth-child(4) { animation-delay: 0.4s; }
.mb-3:nth-child(5) { animation-delay: 0.5s; }

/* Hover animation untuk form sections */
.mb-3:hover {
    transform: translateY(-3px);
}

/* Form control animations */
.form-control {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.form-control:focus {
    transform: translateY(-1px);
}

/* Button hover animation */
.btn {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

/* Title animation */
h2 {
    animation: fadeInUp 0.4s ease-out;
}

/* Error message animation */
.invalid-feedback {
    animation: slideInPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* Success state animation */
.is-valid {
    animation: scaleIn 0.3s ease-out;
}

/* Loading animation */
@keyframes formLoading {
    0% { opacity: 0.8; }
    50% { opacity: 0.5; }
    100% { opacity: 0.8; }
}

.form-loading:after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0.8);
    animation: formLoading 1s infinite;
}

/* Animasi untuk form elements */
.mb-3 {
    animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeInUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Animasi untuk feedback messages */
.invalid-feedback, .alert {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateY(-10px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Animasi untuk form inputs saat focus */
.form-control:focus {
    animation: pulseGlow 0.3s ease-out;
}

@keyframes pulseGlow {
    0% {
        box-shadow: 0 0 0 0 rgba(70,139,148,0.4);
    }
    70% {
        box-shadow: 0 0 0 6px rgba(70,139,148,0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(70,139,148,0);
    }
}

/* Animasi untuk buttons */
.btn {
    transition: all 0.3s ease;
}

.btn:active {
    animation: buttonClick 0.2s ease-out;
}

@keyframes buttonClick {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(0.95);
    }
    100% {
        transform: scale(1);
    }
}

/* Animasi untuk select dropdown */
select.form-control {
    transition: all 0.3s ease;
}

select.form-control:focus {
    animation: selectGlow 0.3s ease-out;
}

@keyframes selectGlow {
    0% {
        background-color: rgba(70,139,148,0.1);
    }
    100% {
        background-color: transparent;
    }
}

/* Container responsif dengan animasi */
.container {
    transition: all 0.3s ease;
}

@media (max-width: 768px) {
    .container {
        padding: 10px;
    }
    
    .mb-3 {
        margin-bottom: 15px;
    }
}

/* Animasi loading untuk form submission */
.form-loading {
    position: relative;
}

.form-loading:after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.8);
    animation: formLoading 1s infinite;
}

@keyframes formLoading {
    0% {
        opacity: 0.8;
    }
    50% {
        opacity: 0.5;
    }
    100% {
        opacity: 0.8;
    }
}

/* Animasi untuk textarea auto-expand */
.auto-expand {
    transition: height 0.2s ease-out;
}

/* Animasi untuk error states */
.is-invalid {
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    20%, 60% { transform: translateX(-5px); }
    40%, 80% { transform: translateX(5px); }
}

/* Animasi untuk success feedback */
.is-valid {
    animation: successPulse 0.5s ease-out;
}

@keyframes successPulse {
    0% { box-shadow: 0 0 0 0 rgba(40,167,69,0.4); }
    70% { box-shadow: 0 0 0 10px rgba(40,167,69,0); }
    100% { box-shadow: 0 0 0 0 rgba(40,167,69,0); }
}

/* Hover effects untuk form sections */
.mb-3:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2), 0 4px 8px rgba(70,139,148,0.15);
}

textarea::-webkit-scrollbar {
    width: 8px;
}

textarea::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

textarea::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

textarea::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.auto-expand {
    resize: none;
    transition: height 0.1s ease-out;
}

.container {
    max-width: 98vw;      
    margin: 0 auto;
    padding: 10px 12px;   
}

h2 {
    color: #333;
    margin-bottom: 10px;
    font-weight: 600;
}

.mb-3 {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15), 0 2px 4px rgba(70,139,148,0.1);  /* Increased shadow */
    margin-bottom: 20px;
    position: relative;
    border-left: 4px solid #468B94;
    transition: transform 0.3s, box-shadow 0.3s;  /* Smoother transition */
}

.mb-3:hover {
    transform: translateY(-3px);  /* Slightly more lift */
    box-shadow: 0 8px 16px rgba(0,0,0,0.2), 0 4px 8px rgba(70,139,148,0.15);  /* Bigger shadow on hover */
}

.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    display: block;
    transition: color 0.3s ease;  /* Added transition */
}

.form-control {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 8px 12px;
    transition: all 0.3s ease;  /* Enhanced transition */
}

.form-control:focus {
    border-color: #468B94;
    box-shadow: 0 0 0 0.2rem rgba(70,139,148,0.25), 0 2px 4px rgba(0,0,0,0.1);  /* Added subtle shadow */
}

select.form-control {
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1em;
    transition: all 0.3s ease;  /* Added transition */
}

.btn {
    padding: 10px 20px;
    border-radius: 4px;
    font-weight: 600;
    transition: all 0.3s ease;  /* Enhanced transition */
}

.btn-primary {
    background-color: #4a90e2;
    border-color: #4a90e2;
}

.btn-primary:hover {
    background-color: #357abd;
    border-color: #357abd;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 4px;
}

.text-muted {
    color: #6c757d !important;
    font-size: 0.875rem;
    margin-top: 4px;
}

/* Status badges */
.badge {
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 500;
}

.badge-negatif {
    background-color: #dc3545;
    color: white;
}

.badge-positif {
    background-color: #28a745;
    color: white;
}

/* Row styling */
.row {
    margin: 0 -10px;
}

.col-md-6 {
    padding: 0 10px;
}

/* Alert styling */
.alert {
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.form-section-header {
    border-bottom: 2px solid #eee;
    margin-bottom: 20px;
    padding-bottom: 10px;
}


.col-md-6 .form-label {
    font-size: 0.9rem;  
    margin-bottom: 4px;  
}

.col-md-6 .form-control {
    padding: 6px 10px;  
    font-size: 0.9rem;  
    height: 35px;      
}


.mb-3 .row .col-md-6 {
    margin-bottom: 0;    
}

.mb-3 > .form-label {
    margin-bottom: 12px; 
    font-size: 1rem;     
}
</style>
@endsection
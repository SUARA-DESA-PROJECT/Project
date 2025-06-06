<!-- resources/views/inputlaporan/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h2>Input Laporan</h2>
            <p>Silahkan mengisi seluruh formulir berikut ini untuk memberikan informasi laporan :</p>

            <form action="{{ route('laporan.store-pengurus') }}" method="POST" id="formLaporan">
                @csrf
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <input type="hidden" name="pengurus_lingkungan_username" value="{{ $pengurus->username }}">
                <input type="hidden" name="tipe_pelapor" value="Pengurus">

                <!-- Untuk input Judul Laporan -->
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Laporan</label>
                    <small class="text-muted">Berikan judul yang singkat dan jelas untuk laporan Anda</small>
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
                    <label for="status_penanganan" class="form-label">Status Penanganan</label>
                    <select name="status_penanganan" id="status_penanganan" class="form-control @error('status_penanganan') is-invalid @enderror">
                        <option value="Belum Ditangani" {{ old('status_penanganan') == 'Belum Ditangani' ? 'selected' : '' }}>Belum Ditangani</option>
                        <option value="Sedang Ditangani" {{ old('status_penanganan') == 'Sedang Ditangani' ? 'selected' : '' }}>Sedang Ditangani</option>
                        <option value="Selesai" {{ old('status_penanganan') == 'Selesai' ? 'selected' : '' }}>Selesai Ditangani</option>
                    </select>
                    @error('status_penanganan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deskripsi_penanganan" class="form-label">Deskripsi Penanganan</label>
                    <textarea name="deskripsi_penanganan" id="deskripsi_penanganan" class="form-control auto-expand @error('deskripsi_penanganan') is-invalid @enderror" 
                        style="min-height: 200px; max-height: 500px; overflow-y: scroll;" 
                        maxlength="10000">{{ old('deskripsi_penanganan') }}</textarea>
                    <small class="text-muted">Maksimal 10000 karakter. Sisa: <span id="charCountPenanganan">10000</span> karakter</small>
                    @error('deskripsi_penanganan')
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

                <div class="mb-3">
                    <label for="status_verifikasi" class="form-label">Status Verifikasi</label>
                    <select name="status_verifikasi" id="status_verifikasi" class="form-control @error('status_verifikasi') is-invalid @enderror">
                        <option value="Belum Diverifikasi"  {{ old('status_verifikasi') == 'Belum Diverifikasi' ? 'selected' : '' }}>Belum Diverifikasi</option>
                        <option value="Diverifikasi" {{ old('status_verifikasi') == 'Diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                    </select>
                    @error('status_verifikasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ url('/homepage') }}'">Kembali</button>
                    <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        
        // Hide all existing warnings
        document.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        // Validate required fields
        const requiredFields = [
            { id: 'judul', name: 'Judul Laporan' },
            { id: 'deskripsi_laporan', name: 'Deskripsi Laporan' },
            { id: 'tanggal_pelaporan', name: 'Tanggal Kejadian' },
            { id: 'time_laporan', name: 'Waktu Kejadian' },
            { id: 'desa', name: 'Tempat Kejadian' },
            { id: 'judul_laporan', name: 'Kategori Laporan' },
            { id: 'status_penanganan', name: 'Status Penanganan' },
            { id: 'deskripsi_penanganan', name: 'Deskripsi Penanganan' },
            { id: 'status_verifikasi', name: 'Status Verifikasi' }
        ];

        let isValid = true;
        let firstInvalidField = null;

        requiredFields.forEach(field => {
            const element = document.getElementById(field.id);
            if (element && !element.value.trim()) {
                isValid = false;
                element.classList.add('is-invalid');
                if (!firstInvalidField) firstInvalidField = element;
            }
        });

        if (!isValid) {
            firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Mohon isi semua field yang wajib!',
                showConfirmButton: true,
                confirmButtonColor: '#468B94'
            });
            return;
        }

        // Show confirmation dialog
        Swal.fire({
            title: 'Konfirmasi Simpan',
            text: "Apakah Anda yakin ingin menyimpan laporan ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#468B94',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'swal-popup-custom'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                this.classList.add('form-loading');
                
                // Submit form
                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    this.classList.remove('form-loading');
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Laporan Anda telah berhasil disimpan',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route("pengurus.riwayat.index") }}';
                    });
                })
                .catch(error => {
                    this.classList.remove('form-loading');
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menyimpan laporan.',
                        confirmButtonColor: '#468B94'
                    });
                });
            }
        });
    });
});
</script>
@endsection

@section('styles')
<style>
/* Add animation keyframes */
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

/* SweetAlert customization */
.swal2-popup {
    animation: scaleIn 0.3s ease-out;
}

.swal2-actions {
    width: 100% !important;
}

.swal2-confirm {
    order: 2 !important;
}

.swal2-cancel {
    order: 1 !important;
}

/* Form animations */
.mb-3 {
    animation: slideInPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* Sequence animation for form fields */
.mb-3:nth-child(1) { animation-delay: 0.1s; }
.mb-3:nth-child(2) { animation-delay: 0.2s; }
.mb-3:nth-child(3) { animation-delay: 0.3s; }
.mb-3:nth-child(4) { animation-delay: 0.4s; }
.mb-3:nth-child(5) { animation-delay: 0.5s; }

/* Hover animation for form sections */
.mb-3:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2), 0 4px 8px rgba(70,139,148,0.15);
}

/* Form control animations */
.form-control {
    transition: all 0.3s ease;
}

.form-control:focus {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(70,139,148,0.1);
}

/* Button animations */
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(70,139,148,0.1);
}

.btn:active {
    animation: buttonClick 0.2s ease-out;
}

@keyframes buttonClick {
    0% { transform: scale(1); }
    50% { transform: scale(0.95); }
    100% { transform: scale(1); }
}

/* Error state animations */
.is-invalid {
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    20%, 60% { transform: translateX(-5px); }
    40%, 80% { transform: translateX(5px); }
}

/* Success state animations */
.is-valid {
    animation: successPulse 0.5s ease-out;
}

@keyframes successPulse {
    0% { box-shadow: 0 0 0 0 rgba(40,167,69,0.4); }
    70% { box-shadow: 0 0 0 10px rgba(40,167,69,0); }
    100% { box-shadow: 0 0 0 0 rgba(40,167,69,0); }
}

/* Loading animation */
.form-loading:after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0.8);
    animation: formLoading 1s infinite;
}

@keyframes formLoading {
    0% { opacity: 0.8; }
    50% { opacity: 0.5; }
    100% { opacity: 0.8; }
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
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    position: relative;
    border-left: 4px solid #468B94;
}

.welcome-banner {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    text-align: center;
    margin-bottom: 30px;
    position: relative;
}

.welcome-banner h2 {
    color: #333;
    margin-bottom: 20px;
    font-size: 2em;
}

.welcome-banner p {
    color: #666;
    line-height: 1.6;
    margin-bottom: 15px;
}

.welcome-banner strong {
    color:rgb(37, 136, 60);
}

.decoration {
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: #28a745;
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
}

.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    display: block;
}

.form-control {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 8px 12px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
}

select.form-control {
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1em;
}

.btn {
    padding: 10px 20px;
    border-radius: 4px;
    font-weight: 600;
    transition: all 0.3s ease;
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
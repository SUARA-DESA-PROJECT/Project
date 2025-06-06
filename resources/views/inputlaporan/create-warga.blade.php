@extends('layouts.app-warga')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h2>Input Laporan</h2>
            
            @if($warga->status_verifikasi !== 'Terverifikasi')
                <!-- Tampilan untuk warga yang belum diverifikasi -->
                <div class="alert alert-warning-custom text-center">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3" style="color: #ffc107;"></i>
                    <h4>Akun Anda Belum Diverifikasi</h4>
                    <p>Maaf, Anda tidak dapat membuat laporan karena akun Anda belum diverifikasi oleh admin.</p>
                    <p><strong>Status saat ini:</strong> 
                        <span class="badge badge-warning">{{ $warga->status_verifikasi ?? 'Belum Diverifikasi' }}</span>
                    </p>
                    <hr>
                    <p class="mb-1"><small>Silakan tunggu proses verifikasi dari pengurus setempat atau hubungi untuk informasi lebih lanjut.</small></p>
                </div>
                
                <div class="mt-4 text-center">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ url('/homepage-warga') }}'">
                        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                    </button>
                </div>
            @else
                <!-- Tampilan form normal untuk warga yang sudah diverifikasi -->
                <p>Silahkan mengisi seluruh formulir berikut ini untuk memberikan informasi laporan :</p>

                <form action="{{ route('laporan.store') }}" method="POST" id="formLaporan">
                    @csrf
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <input type="hidden" name="warga_username" value="{{ $warga->username }}">
                    <input type="hidden" name="tipe_pelapor" value="Warga">

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

                    <!-- Untuk Deskripsi Laporan -->
                    <div class="mb-3">
                        <label for="deskripsi_laporan" class="form-label">Deskripsi Laporan</label>
                        <small class="text-muted">Jelaskan detail kejadian secara lengkap (maksimal 10000 karakter)</small>
                        <textarea name="deskripsi_laporan" id="deskripsi_laporan" class="form-control auto-expand @error('deskripsi_laporan') is-invalid @enderror" 
                            style="min-height: 200px; max-height: 500px; overflow-y: scroll;" 
                            maxlength="10000">{{ old('deskripsi_laporan') }}</textarea>
                        @error('deskripsi_laporan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Untuk Waktu Kejadian -->
                    <div class="mb-3">
                        <label for="tanggal_pelaporan" class="form-label">Waktu Kejadian</label>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="Date" class="form-label">Tanggal</label>   
                                <small class="text-muted">Pilih tanggal kejadian</small> 
                                <input type="date" name="tanggal_pelaporan" id="tanggal_pelaporan" class="form-control @error('tanggal_pelaporan') is-invalid @enderror" value="{{ old('tanggal_pelaporan') }}">
                                @error('tanggal_pelaporan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="time" class="form-label">Jam</label>
                                <small class="text-muted">Pilih waktu kejadian</small>    
                                <input type="time" name="time_laporan" id="time_laporan" class="form-control @error('time_laporan') is-invalid @enderror" value="{{ old('time_laporan') }}">
                                @error('time_laporan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Untuk Tempat Kejadian -->
                    <div class="mb-3">
                        <label for="tempat_kejadian" class="form-label">Tempat Kejadian</label>
                        <small class="text-muted">Pilih lokasi tempat kejadian</small>
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

                    <!-- Untuk Lokasi Koordinat -->
                    <div class="mb-3">
                        <label class="form-label">Lokasi Koordinat Kejadian</label>
                        <small class="text-muted">Klik pada peta untuk menentukan lokasi kejadian secara tepat</small>
                        
                        <!-- Map Container -->
                        <div id="locationMap" style="height: 300px; width: 100%; border: 1px solid #ddd; border-radius: 4px; margin: 10px 0;"></div>
                        
                        <!-- Koordinat Display -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control" 
                                       value="{{ old('latitude') }}" placeholder="Klik peta untuk mendapatkan koordinat" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control" 
                                       value="{{ old('longitude') }}" placeholder="Klik peta untuk mendapatkan koordinat" readonly>
                            </div>
                        </div>
                        
                        <!-- Reset Button -->
                        <div class="mt-2">
                            <button type="button" id="resetLocation" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-redo"></i> Reset Lokasi
                            </button>
                            <button type="button" id="getCurrentLocation" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-map-marker-alt"></i> Gunakan Lokasi Saat Ini
                            </button>
                        </div>
                    </div>

                    <!-- Untuk Kategori Laporan -->
                    <div class="mb-3">
                        <label for="judul_laporan" class="form-label">Kategori Laporan</label>
                        <small class="text-muted">Pilih kategori yang sesuai dengan laporan Anda</small>
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

                    <div class="mt-4">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ url('/homepage') }}'">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
@if($warga->status_verifikasi === 'Terverifikasi')
<!-- Leaflet CSS and JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map
    let map = L.map('locationMap').setView([-6.9803, 107.6640], 14); // Bojongsoang coordinates
    let currentMarker = null;

    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add click event to map
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        
        // Update input fields
        document.getElementById('latitude').value = lat.toFixed(8);
        document.getElementById('longitude').value = lng.toFixed(8);
        
        // Remove existing marker
        if (currentMarker) {
            map.removeLayer(currentMarker);
        }
        
        // Add new marker
        currentMarker = L.marker([lat, lng]).addTo(map)
            .bindPopup(`Lokasi: ${lat.toFixed(6)}, ${lng.toFixed(6)}`)
            .openPopup();
    });

    // Reset location button
    document.getElementById('resetLocation').addEventListener('click', function() {
        document.getElementById('latitude').value = '';
        document.getElementById('longitude').value = '';
        
        if (currentMarker) {
            map.removeLayer(currentMarker);
            currentMarker = null;
        }
    });

    // Get current location button
    document.getElementById('getCurrentLocation').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                // Update input fields
                document.getElementById('latitude').value = lat.toFixed(8);
                document.getElementById('longitude').value = lng.toFixed(8);
                
                // Remove existing marker
                if (currentMarker) {
                    map.removeLayer(currentMarker);
                }
                
                // Add new marker and center map
                currentMarker = L.marker([lat, lng]).addTo(map)
                    .bindPopup('Lokasi Anda Saat Ini')
                    .openPopup();
                    
                map.setView([lat, lng], 16);
                
                Swal.fire({
                    icon: 'success',
                    title: 'Lokasi Ditemukan!',
                    text: 'Lokasi saat ini berhasil dideteksi',
                    timer: 2000,
                    showConfirmButton: false
                });
            }, function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mendapatkan Lokasi',
                    text: 'Pastikan GPS aktif dan izinkan akses lokasi',
                    confirmButtonColor: '#468B94'
                });
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Geolocation Tidak Didukung',
                text: 'Browser Anda tidak mendukung fitur geolocation',
                confirmButtonColor: '#468B94'
            });
        }
    });

    // Load existing coordinates if available (for edit mode)
    const existingLat = document.getElementById('latitude').value;
    const existingLng = document.getElementById('longitude').value;
    
    if (existingLat && existingLng) {
        const lat = parseFloat(existingLat);
        const lng = parseFloat(existingLng);
        
        currentMarker = L.marker([lat, lng]).addTo(map)
            .bindPopup(`Lokasi: ${lat.toFixed(6)}, ${lng.toFixed(6)}`)
            .openPopup();
            
        map.setView([lat, lng], 16);
    }

    // Form validation and submission
    const form = document.getElementById('formLaporan');
    const requiredFields = [
        { id: 'judul', name: 'Judul Laporan' },
        { id: 'deskripsi_laporan', name: 'Deskripsi Laporan' },
        { id: 'tanggal_pelaporan', name: 'Tanggal Kejadian' },
        { id: 'time_laporan', name: 'Waktu Kejadian' },
        { id: 'desa', name: 'Tempat Kejadian' },
        { id: 'judul_laporan', name: 'Kategori Laporan' }
    ];

    // Add warning divs for each field
    requiredFields.forEach(field => {
        const element = document.getElementById(field.id);
        if (element) {
            const warningDiv = document.createElement('div');
            warningDiv.id = `warning-${field.id}`;
            warningDiv.className = 'text-danger mt-2 d-none';
            warningDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${field.name} wajib diisi`;
            element.parentNode.appendChild(warningDiv);
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;
        let emptyFields = [];

        // Hide all warnings first
        requiredFields.forEach(field => {
            const warningDiv = document.getElementById(`warning-${field.id}`);
            if (warningDiv) {
                warningDiv.classList.add('d-none');
            }
        });

        // Check each field
        requiredFields.forEach(field => {
            const element = document.getElementById(field.id);
            const warningDiv = document.getElementById(`warning-${field.id}`);
            
            if (element && !element.value.trim()) {
                isValid = false;
                emptyFields.push(field.name);
                if (warningDiv) {
                    warningDiv.classList.remove('d-none');
                }
                element.classList.add('is-invalid');
            } else if (element) {
                element.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Mohon isi semua field yang wajib!',
                confirmButtonColor: '#468B94'
            });

            // Scroll to first empty field
            const firstEmptyField = document.querySelector('.is-invalid');
            if (firstEmptyField) {
                firstEmptyField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }

        // If all valid, continue with confirmation
        Swal.fire({
            title: 'Konfirmasi Simpan',
            text: "Apakah Anda yakin ingin menyimpan laporan ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#468B94',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Sedang menyimpan laporan Anda',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

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
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Laporan Anda telah berhasil disimpan',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route("riwayat-laporan.index") }}';
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menyimpan laporan.',
                        icon: 'error',
                        confirmButtonColor: '#468B94'
                    });
                });
            }
        });
    });

    // Auto-fill jenis laporan based on kategori selection
    document.getElementById('judul_laporan').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const jenis = selectedOption.getAttribute('data-jenis');
        document.getElementById('kategori_laporan').value = jenis || '';
    });
});
</script>
@endif
@endsection

@section('styles')
<style>
/* Class khusus untuk warning message saja (tanpa garis hijau) */
.alert-warning-custom {
    background-color: #fff3cd;
    border-color: #ffeaa7;
    color: #856404;
    border-radius: 8px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid #ffeaa7;
    /* Tidak ada border-left */
    animation: fadeInUp 0.5s ease-out;
}

.badge-warning {
    background-color: #ffc107;
    color: #212529;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 500;
}

/* Animasi untuk pesan peringatan */
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

/* Kembalikan styling .mb-3 seperti semula */
.mb-3 {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15), 0 2px 4px rgba(70,139,148,0.1);
    margin-bottom: 20px;
    position: relative;
    border-left: 4px solid #468B94;
    transition: transform 0.3s, box-shadow 0.3s;
    animation: slideInPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
}

.mb-3:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2), 0 4px 8px rgba(70,139,148,0.15);
}

/* Sequence animation untuk form-section */
.mb-3:nth-child(1) { animation-delay: 0.1s; }
.mb-3:nth-child(2) { animation-delay: 0.2s; }
.mb-3:nth-child(3) { animation-delay: 0.3s; }
.mb-3:nth-child(4) { animation-delay: 0.4s; }
.mb-3:nth-child(5) { animation-delay: 0.5s; }
.mb-3:nth-child(6) { animation-delay: 0.6s; }
.mb-3:nth-child(7) { animation-delay: 0.7s; }

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
    color: #6c757d !important;
    font-size: 0.875rem;
    margin-top: 4px; {
}   border-bottom: 2px solid #eee;
    margin-bottom: 20px;
/* Status badges */ 10px;
.badge {
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 500;;  
}   margin-bottom: 4px;  
}
.badge-negatif {
    background-color: #dc3545;
    color: white;10px;  
}   font-size: 0.9rem;  
    height: 35px;      
.badge-positif {
    background-color: #28a745;
    color: white;
}mb-3 .row .col-md-6 {
    margin-bottom: 0;    
/* Row styling */
.row {
    margin: 0 -10px;{
}   margin-bottom: 12px; 
    font-size: 1rem;     
.col-md-6 {
    padding: 0 10px;
}endsection/* Alert styling */.alert {    padding: 15px;    border-radius: 4px;    margin-bottom: 20px;}.alert-success {    background-color: #d4edda;    border-color: #c3e6cb;    color: #155724;}.form-section-header {    border-bottom: 2px solid #eee;    margin-bottom: 20px;    padding-bottom: 10px;}.col-md-6 .form-label {    font-size: 0.9rem;      margin-bottom: 4px;  }.col-md-6 .form-control {    padding: 6px 10px;      font-size: 0.9rem;      height: 35px;      }.mb-3 .row .col-md-6 {    margin-bottom: 0;    }.mb-3 > .form-label {    margin-bottom: 12px;     font-size: 1rem;     }</style>@endsection
<!-- resources/views/inputlaporan/create.blade.php -->
@extends('layouts.app-warga')

@section('content')

<div class="container mt-4">
    <h2>Update Laporan</h2>
    <p>Halaman ini digunakan untuk mengupdate laporan yang telah dibuat sebelumnya.</p>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- filepath: c:\Users\HP\Documents\GitHub\Project\resources\views\riwayatlap\update.blade.php --}}
    <form action="{{ route('inputlaporan.update', $laporan->id) }}" method="POST" id="formLaporan">
        @csrf
        @method('PUT') <!-- Method spoofing untuk PUT -->

        <!-- Input tersembunyi untuk username warga -->
        <input type="hidden" name="warga_username" value="{{ $laporan->warga_username }}">
        <input type="hidden" name="tipe_pelapor" value="{{ $laporan->tipe_pelapor }}">

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Laporan</label>
            <input type="text" name="judul_laporan" id="judul" class="form-control @error('judul_laporan') is-invalid @enderror" 
                value="{{ old('judul_laporan', $laporan->judul_laporan) }}" placeholder="Masukkan judul laporan">
            @error('judul_laporan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="deskripsi_laporan" class="form-label">Deskripsi Laporan</label>
            <textarea name="deskripsi_laporan" id="deskripsi_laporan" class="form-control auto-expand @error('deskripsi_laporan') is-invalid @enderror" 
                style="min-height: 200px; max-height: 500px; overflow-y: scroll;" 
                maxlength="10000">{{ old('deskripsi_laporan', $laporan->deskripsi_laporan) }}</textarea>
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
                    <input type="date" name="tanggal_pelaporan" id="tanggal_pelaporan" class="form-control @error('tanggal_pelaporan') is-invalid @enderror" 
                        value="{{ old('tanggal_pelaporan', $laporan->tanggal_pelaporan) }}" placeholder="Pilih Tanggal">
                    @error('tanggal_pelaporan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="time" class="form-label">Jam</label>    
                    <input type="time" name="time_laporan" id="time_laporan" class="form-control @error('time_laporan') is-invalid @enderror" 
                        value="{{ old('time_laporan', $laporan->time_laporan) }}" placeholder="Pilih Jam">
                    @error('time_laporan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="tempat_kejadian" class="form-label">Tempat Kejadian</label>
            <select name="tempat_kejadian" id="desa" class="form-control @error('tempat_kejadian') is-invalid @enderror">
                <option value="">Pilih Desa/Kelurahan</option>
                <option value="Bojongsari" {{ old('tempat_kejadian', $laporan->tempat_kejadian) == 'Bojongsari' ? 'selected' : '' }}>Bojongsari</option>
                <option value="Bojongsoang" {{ old('tempat_kejadian', $laporan->tempat_kejadian) == 'Bojongsoang' ? 'selected' : '' }}>Bojongsoang</option>
                <option value="Buahbatu" {{ old('tempat_kejadian', $laporan->tempat_kejadian) == 'Buahbatu' ? 'selected' : '' }}>Buahbatu</option>
                <option value="Cipagalo" {{ old('tempat_kejadian', $laporan->tempat_kejadian) == 'Cipagalo' ? 'selected' : '' }}>Cipagalo</option>
                <option value="Lengkong" {{ old('tempat_kejadian', $laporan->tempat_kejadian) == 'Lengkong' ? 'selected' : '' }}>Lengkong</option>
                <option value="Tegalluar" {{ old('tempat_kejadian', $laporan->tempat_kejadian) == 'Tegalluar' ? 'selected' : '' }}>Tegalluar</option>
            </select>
            @error('tempat_kejadian')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="kategori_laporan" class="form-label">Kategori Laporan</label>
            <select name="kategori_laporan" id="judul_laporan" class="form-control @error('kategori_laporan') is-invalid @enderror">
                <option value="">Pilih Kategori Laporan</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->nama_kategori }}" {{ old('kategori_laporan', $laporan->kategori_laporan) == $kategori->nama_kategori ? 'selected' : '' }}
                        data-jenis="{{ $kategori->jenis_kategori }}">
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
            @error('kategori_laporan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="kategori_laporan" class="form-label">Jenis Laporan</label>
            <input type="text" name="jenis_laporan" id="kategori_laporan" class="form-control" readonly 
                value="{{ old('jenis_laporan', $laporan->jenis_laporan) }}" placeholder="Jenis laporan akan muncul otomatis">
            @error('kategori_laporan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <a href="{{ url('/homepage') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary float-end">Update Laporan</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Move the form submission handler outside of DOMContentLoaded
const formLaporan = document.getElementById('formLaporan');
if (formLaporan) {
    formLaporan.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: "Konfirmasi Simpan",
            text: "Apakah Anda yakin ingin menyimpan laporan ini?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#4a90e2",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                // Cek semua field yang wajib diisi
                const requiredFields = [
                    'judul_laporan',
                    'deskripsi_laporan',
                    'tanggal_pelaporan',
                    'time_laporan',
                    'tempat_kejadian',
                    'kategori_laporan'
                ];
                let isValid = true;
                for (let field of requiredFields) {
                    const el = document.getElementsByName(field)[0];
                    if (el && !el.value.trim()) {
                        isValid = false;
                        break;
                    }
                }

                if (!isValid) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Silahkan isi semua formulir!",
                    });
                    return;
                }

                Swal.fire({
                    title: "Berhasil!",
                    text: "Laporan Anda telah berhasil disimpan.",
                    icon: "success",
                    confirmButtonColor: "#4a90e2"
                }).then(() => {
                    this.submit();
                });
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const kategoriSelect = document.getElementById('judul_laporan');
    const jenisLaporanInput = document.getElementById('kategori_laporan');

    if (kategoriSelect) {
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
});
</script>

<style>
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
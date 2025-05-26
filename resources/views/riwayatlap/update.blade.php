@extends('layouts.app-warga')

@section('content')

<div class="update-container">
    <div class="update-header">
        <h2><i class="fas fa-edit"></i> Update Laporan</h2>
        <p class="update-subtitle">Perbarui informasi laporan Anda dengan data terbaru</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- filepath: c:\Users\HP\Documents\GitHub\Project\resources\views\riwayatlap\update.blade.php --}}
    <form action="{{ route('inputlaporan.update', $laporan->id) }}" method="POST" id="formLaporan" class="update-form">
        @csrf
        @method('PUT')

        <input type="hidden" name="warga_username" value="{{ $laporan->warga_username }}">
        <input type="hidden" name="tipe_pelapor" value="{{ $laporan->tipe_pelapor }}">

        <div class="form-grid">
            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-heading"></i>
                    <label for="judul" class="form-label">Judul Laporan</label>
                </div>
                <input type="text" name="judul_laporan" id="judul" class="form-control @error('judul_laporan') is-invalid @enderror" 
                    value="{{ old('judul_laporan', $laporan->judul_laporan) }}" placeholder="Masukkan judul laporan">
                @error('judul_laporan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-card full-width">
                <div class="form-header">
                    <i class="fas fa-align-left"></i>
                    <label for="deskripsi_laporan" class="form-label">Deskripsi Laporan</label>
                </div>
                <textarea name="deskripsi_laporan" id="deskripsi_laporan" class="form-control auto-expand @error('deskripsi_laporan') is-invalid @enderror" 
                    style="min-height: 200px; max-height: 500px; overflow-y: scroll;" 
                    maxlength="10000">{{ old('deskripsi_laporan', $laporan->deskripsi_laporan) }}</textarea>
                @error('deskripsi_laporan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-calendar-alt"></i>
                    <label for="tanggal_pelaporan" class="form-label">Tanggal Kejadian</label>
                </div>
                <input type="date" name="tanggal_pelaporan" id="tanggal_pelaporan" class="form-control @error('tanggal_pelaporan') is-invalid @enderror" 
                    value="{{ old('tanggal_pelaporan', $laporan->tanggal_pelaporan) }}" placeholder="Pilih Tanggal">
                @error('tanggal_pelaporan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-clock"></i>
                    <label for="time" class="form-label">Waktu Kejadian</label>
                </div>
                <input type="time" name="time_laporan" id="time_laporan" class="form-control @error('time_laporan') is-invalid @enderror" 
                    value="{{ old('time_laporan', $laporan->time_laporan) }}" placeholder="Pilih Jam">
                @error('time_laporan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-map-marker-alt"></i>
                    <label for="tempat_kejadian" class="form-label">Tempat Kejadian</label>
                </div>
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

            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-tags"></i>
                    <label for="kategori_laporan" class="form-label">Kategori Laporan</label>
                </div>
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

            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-info-circle"></i>
                    <label for="kategori_laporan" class="form-label">Jenis Laporan</label>
                </div>
                <input type="text" name="jenis_laporan" id="kategori_laporan" class="form-control" readonly 
                    value="{{ old('jenis_laporan', $laporan->jenis_laporan) }}" placeholder="Jenis laporan akan muncul otomatis">
                @error('kategori_laporan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ url('/homepage') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Laporan
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const formLaporan = document.getElementById('formLaporan');
if (formLaporan) {
    formLaporan.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: "Konfirmasi Update",
            text: "Apakah Anda yakin ingin mengupdate laporan ini?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#468B94",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Update!",
            cancelButtonText: "Batal",
            customClass: {
                popup: 'animated fadeInDown'
            }
        }).then((result) => {
            if (result.isConfirmed) {
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
                        customClass: {
                            popup: 'animated shake'
                        }
                    });
                    return;
                }

                Swal.fire({
                    title: "Berhasil!",
                    text: "Laporan Anda telah berhasil diupdate.",
                    icon: "success",
                    confirmButtonColor: "#468B94",
                    customClass: {
                        popup: 'animated fadeInDown'
                    }
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

    const textarea = document.getElementById('deskripsi_laporan');
    const charCount = document.getElementById('charCount');

    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            const maxLength = 10000;
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            charCount.textContent = remaining;
            
            if (remaining < 20) {
                charCount.style.color = '#dc3545';
            } else {
                charCount.style.color = '';
            }
        });
    }
});
</script>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

.update-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    background: #f8f9fa;
    min-height: 100vh;
}

.update-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.update-header h2 {
    color: #468B94;
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.update-subtitle {
    color: #666;
    font-size: 1.1rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.form-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s, box-shadow 0.2s;
}

.form-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.full-width {
    grid-column: 1 / -1;
}

.form-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    color: #468B94;
}

.form-header i {
    margin-right: 0.5rem;
    font-size: 1.2rem;
}

.form-label {
    font-weight: 600;
    color: #333;
    margin: 0;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.3s;
}

.form-control:focus {
    border-color: #468B94;
    box-shadow: 0 0 0 0.2rem rgba(70, 139, 148, 0.25);
}

.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s;
}

.btn i {
    font-size: 1.1rem;
}

.btn-primary {
    background-color: #468B94;
    border-color: #468B94;
}

.btn-primary:hover {
    background-color: #3a7a82;
    border-color: #3a7a82;
    transform: translateY(-1px);
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #5a6268;
    transform: translateY(-1px);
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.alert i {
    font-size: 1.2rem;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.text-muted {
    color: #6c757d;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: block;
}

/* Animations */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.animated {
    animation-duration: 0.5s;
    animation-fill-mode: both;
}

.fadeInDown {
    animation-name: fadeInDown;
}

.shake {
    animation-name: shake;
}

/* Responsive Design */
@media (max-width: 768px) {
    .update-container {
        padding: 1rem;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
        gap: 1rem;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}

/* Tambahan khusus untuk select agar teks tidak terpotong */
select.form-control {
    height: auto;
    min-height: 48px; /* atau sesuai kebutuhan */
    font-size: 1rem;
    padding-right: 2.5rem; /* ruang untuk icon dropdown */
    line-height: 1.5;
    box-sizing: border-box;
    /* Untuk memastikan teks tidak terpotong */
    overflow: visible;
    white-space: normal;
}
</style>
@endsection
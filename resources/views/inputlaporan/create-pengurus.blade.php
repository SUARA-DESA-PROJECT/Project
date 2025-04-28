@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-4">
    <h2>Input Laporan Pengurus</h2>
    <p>Silahkan mengisi seluruh formulir berikut ini untuk memberikan informasi laporan :</p>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('laporan.store-pengurus') }}" method="POST" id="formLaporan">
        @csrf
        <!-- Input tersembunyi untuk username pengurus -->
        <input type="hidden" name="pengurus_lingkungan_username" value="{{ $pengurus->username }}">
        <input type="hidden" name="tipe_pelapor" value="Pengurus">
        <input type="hidden" name="status_verifikasi" value="Terverifikasi">
        <input type="hidden" name="status_penanganan" value="Sedang Ditangani">
        <input type="hidden" name="deskripsi_penanganan" value="Ditangani oleh pengurus lingkungan">
        <input type="hidden" name="warga_username" value="-">

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

        <div class="mb-3">
            <label for="tipe_pelapor" class="form-label">Tipe Pelapor</label>
            <input type="text" class="form-control" value="Pengurus" readonly>
        </div>

        <div class="mb-3">
            <label for="pengurus_username" class="form-label">Username Pengurus</label>
            <input type="text" class="form-control" value="{{ $pengurus->username }}" readonly>
        </div>

        <a href="{{ url('/homepage') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary float-end">Simpan Laporan</button>
    </form>
</div>

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

    document.getElementById('formLaporan').addEventListener('submit', function(e) {
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
                this.submit();
            }
        });
    });
});
</script>
@endsection 
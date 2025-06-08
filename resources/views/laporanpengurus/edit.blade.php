@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-2">
                <div class="card-header" style="background-color: #468B94; color: white; border-bottom: 3px solid #3a7a82;">
                    <h3 class="mb-0 font-weight-bold">Edit Laporan</h3>
                </div>
                <div class="card-body" style="border: 2px solid #e9ecef; border-top: none;">
                    <form action="{{ route('pengurus.kelola-laporan.update', $laporan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="font-weight-bold">Judul Laporan</label>
                            <input type="text" name="judul_laporan" class="form-control border-2 @error('judul_laporan') is-invalid @enderror"
                                value="{{ old('judul_laporan', $laporan->judul_laporan) }}" style="border-color: #ced4da !important;">
                            @error('judul_laporan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Deskripsi Laporan</label>
                            <textarea name="deskripsi_laporan" class="form-control border-2 @error('deskripsi_laporan') is-invalid @enderror" 
                                rows="4" style="border-color: #ced4da !important;">{{ old('deskripsi_laporan', $laporan->deskripsi_laporan) }}</textarea>
                            @error('deskripsi_laporan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tanggal Kejadian</label>
                                    <input type="date" name="tanggal_pelaporan" class="form-control border-2 @error('tanggal_pelaporan') is-invalid @enderror"
                                        value="{{ old('tanggal_pelaporan', $laporan->tanggal_pelaporan) }}" style="border-color: #ced4da !important;">
                                    @error('tanggal_pelaporan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Waktu Kejadian</label>
                                    <input type="time" name="time_laporan" class="form-control border-2 @error('time_laporan') is-invalid @enderror"
                                        value="{{ old('time_laporan', $laporan->time_laporan) }}" style="border-color: #ced4da !important;">
                                    @error('time_laporan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Tempat Kejadian</label>
                            <select name="tempat_kejadian" class="form-control border-2 @error('tempat_kejadian') is-invalid @enderror"
                                style="border-color: #ced4da !important;">
                                <option value="">Pilih Tempat</option>
                                @foreach(['Bojongsari', 'Bojongsoang', 'Buahbatu', 'Cipagalo', 'Lengkong', 'Tegalluar'] as $tempat)
                                    <option value="{{ $tempat }}" {{ old('tempat_kejadian', $laporan->tempat_kejadian) == $tempat ? 'selected' : '' }}>
                                        {{ $tempat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tempat_kejadian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Kategori Laporan</label>
                            <select name="kategori_laporan" class="form-control border-2 @error('kategori_laporan') is-invalid @enderror"
                                style="border-color: #ced4da !important;">
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->nama_kategori }}" 
                                        {{ old('kategori_laporan', $laporan->kategori_laporan) == $kategori->nama_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_laporan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-0 d-flex justify-content-between">
                            <a href="{{ route('pengurus.kelola-laporan.index') }}" class="btn btn-secondary btn-lg border-2">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg border-2">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: 3px solid #468B94 !important;
    border-radius: 12px !important;
}

.card-header {
    border-radius: 8px 8px 0 0 !important;
}

.form-control:focus {
    border-color: #468B94 !important;
    box-shadow: 0 0 0 0.2rem rgba(70, 139, 148, 0.25) !important;
}

.btn {
    border-width: 2px !important;
    font-weight: 600 !important;
    padding: 12px 24px !important;
}

.btn-secondary {
    border-color: #6c757d !important;
}

.btn-primary {
    border-color: #468B94 !important;
    background-color: #468B94 !important;
}

label {
    color: #495057 !important;
    font-size: 14px !important;
}
</style>
@endsection
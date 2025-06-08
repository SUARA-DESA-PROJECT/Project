@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: #468B94; color: white;">
                    <h4 class="mb-0">Edit Laporan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengurus.kelola-laporan.update', $laporan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Judul Laporan</label>
                            <input type="text" name="judul_laporan" class="form-control @error('judul_laporan') is-invalid @enderror"
                                value="{{ old('judul_laporan', $laporan->judul_laporan) }}">
                            @error('judul_laporan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Deskripsi Laporan</label>
                            <textarea name="deskripsi_laporan" class="form-control @error('deskripsi_laporan') is-invalid @enderror" 
                                rows="4">{{ old('deskripsi_laporan', $laporan->deskripsi_laporan) }}</textarea>
                            @error('deskripsi_laporan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Kejadian</label>
                                    <input type="date" name="tanggal_pelaporan" class="form-control @error('tanggal_pelaporan') is-invalid @enderror"
                                        value="{{ old('tanggal_pelaporan', $laporan->tanggal_pelaporan) }}">
                                    @error('tanggal_pelaporan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Waktu Kejadian</label>
                                    <input type="time" name="time_laporan" class="form-control @error('time_laporan') is-invalid @enderror"
                                        value="{{ old('time_laporan', $laporan->time_laporan) }}">
                                    @error('time_laporan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Tempat Kejadian</label>
                            <select name="tempat_kejadian" class="form-control @error('tempat_kejadian') is-invalid @enderror">
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
                            <label>Kategori Laporan</label>
                            <select name="kategori_laporan" class="form-control @error('kategori_laporan') is-invalid @enderror">
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
                            <a href="{{ route('pengurus.kelola-laporan.index') }}" class="btn btn-secondary">
                                <i class="mb-0"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
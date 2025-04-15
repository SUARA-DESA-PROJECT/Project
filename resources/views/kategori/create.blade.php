<!-- resources/views/kategori/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tambah Kategori</h5>
                        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('kategori.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" 
                                   value="{{ old('nama_kategori') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="deskripsi_kategori" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi_kategori" name="deskripsi_kategori" rows="3">{{ old('deskripsi_kategori') }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="jenis_kategori" class="form-label">Status</label>
                            <select class="form-select" id="jenis_kategori" name="jenis_kategori" required>
                                <option value="">Pilih Status</option>
                                <option value="Positif" {{ old('j') == 'Positif' ? 'selected' : '' }}>Positif</option>
                                <option value="Negatif" {{ old('j') == 'Negatif' ? 'selected' : '' }}>Negatif</option>
                            </select>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
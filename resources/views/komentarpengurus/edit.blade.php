@extends('layouts.app')

@section('title', 'Edit Komentar')

@section('styles')
<style>
    .edit-container {
        max-width: 800px;
        margin: 0;
        padding: 20px;
    }
    
    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }
    
    .form-control {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #cfd9de;
        border-radius: 8px;
        font-size: 14px;
        resize: none;
    }
    
    .btn-container {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    
    .btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
    }
    
    .btn-primary {
        background-color: #468B94;
        color: white;
        border: none;
    }
</style>
@endsection

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Edit Komentar</h2>
            
            <div class="edit-container">
                <form action="{{ route('komentarpengurus.update', $komentar->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="isi_komentar">Komentar</label>
                        <textarea name="isi_komentar" id="isi_komentar" class="form-control" rows="4">{{ $komentar->isi_komentar }}</textarea>
                    </div>
                    
                    <div class="btn-container">
                        <a href="{{ route('komentarpengurus.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
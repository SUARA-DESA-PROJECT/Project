@extends('layouts.app')

@section('content')

<div class="container-fluid px-4">
    <h2 class="mt-4">Tambah Kategori</h2>
    <p class="text-muted">Silahkan isi form dibawah untuk menambahkan kategori baru</p>
    
    <div class="card mb-4">
        <div class="card-header">
            <div>
                <i class="fas fa-plus me-1"></i>
                Form Tambah Kategori
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
                <div class="mb-4">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" 
                           value="{{ old('nama_kategori') }}" required>
                </div>
                
                <div class="mb-4">
                    <label for="deskripsi_kategori" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi_kategori" name="deskripsi_kategori" 
                              rows="5" required>{{ old('deskripsi_kategori') }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label for="jenis_kategori" class="form-label">Jenis Kategori</label>
                    <select class="form-control" id="jenis_kategori" name="jenis_kategori" required>
                        <option value="">Pilih Status</option>
                        <option value="Positif" {{ old('jenis_kategori') == 'Positif' ? 'selected' : '' }}>Positif</option>
                        <option value="Negatif" {{ old('jenis_kategori') == 'Negatif' ? 'selected' : '' }}>Negatif</option>
                    </select>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('kategori.index') }}" class="btn-action back">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div>
                        <button type="submit" class="btn-action edit">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Animation Keyframes */
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

/* Title Styles */
h2 {
    color: #333333;
    font-weight: 600;
    margin-bottom: 10px;
    animation: fadeInUp 0.4s ease-out;
}

p {
    margin-bottom: 20px;
    animation: fadeInUp 0.4s ease-out 0.1s backwards;
}

/* Card Animation */
.card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    animation: scaleIn 0.4s ease-out;
    margin-top: 1rem;
}

/* Form Controls */
.form-control, .form-select {
    border: 1px solid #ced4da;
    border-radius: 6px;
    padding: 10px 15px;
    transition: all 0.3s ease;
    background-color: #fff;
    position: relative;
    transform-origin: center;
}

.form-control:hover, .form-select:hover {
    border-color: #468B94;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(70, 139, 148, 0.15);
}

.form-control:focus, .form-select:focus {
    border-color: #468B94;
    box-shadow: 0 0 0 0.2rem rgba(70, 139, 148, 0.25);
    transform: translateY(-2px);
}

/* Specific style for textarea */
textarea.form-control {
    min-height: 120px;
    resize: vertical;
    line-height: 1.5;
    transition: all 0.3s ease;
}

textarea.form-control:hover {
    border-color: #468B94;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(70, 139, 148, 0.15);
}

/* Action Buttons */
.btn-action {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: all 0.3s ease;
    width: 100px;
    height: 36px;
    text-decoration: none;
}

.btn-action.edit {
    background-color: #468B94;
    color: white;
}

.btn-action.back {
    background-color: #6c757d;
    color: white;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    color: white;
    text-decoration: none;
}

/* Add Button */
.add-btn {
    background-color: #468B94;
    color: white;
    border-radius: 6px;
    padding: 8px 16px;
    font-weight: 500;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.add-btn:hover {
    background-color: #3a7a82;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    color: white;
}

/* Form Groups */
.mb-4 {
    animation: fadeInUp 0.4s ease-out;
    animation-fill-mode: both;
}

.mb-4:nth-child(2) {
    animation-delay: 0.1s;
}

.mb-4:nth-child(3) {
    animation-delay: 0.2s;
}

.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 8px;
}
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Submit form
            this.submit();
        });

        // Show success message if exists
        

        // Show error message if exists
        @if(Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ Session::get('error') }}",
                showConfirmButton: true,
                confirmButtonColor: '#468B94',
                position: 'top-end',
                showClass: {
                    popup: 'animate__animated animate__fadeInRight'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutRight'
                }
            });
        @endif
    });
</script>
@endpush

<!-- Add these in the head section or at the end of your layout file -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
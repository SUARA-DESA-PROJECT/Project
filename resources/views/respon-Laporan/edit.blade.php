@extends('layouts.app')

@section('content')
<div class="update-container">
    <div class="update-header">
        <h2><i class="fas fa-edit"></i> Update Respon Laporan</h2>
        <p class="update-subtitle">Silahkan edit form dibawah untuk mengubah respon laporan</p>
    </div>

    <div class="form-grid">
        <div class="form-card">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('respon.update', $laporan->id) }}" id="updateForm">
                @csrf
                @method('PUT')

                <div class="form-card">
                    <div class="form-header">
                        <i class="fas fa-tasks"></i>
                        <label for="status_penanganan" class="form-label">Status Penanganan</label>
                    </div>
                    <select class="form-control @error('status_penanganan') is-invalid @enderror" 
                            id="status_penanganan" 
                            name="status_penanganan"
                            required
                            style="min-height: 50px; appearance: none;">
                        <option value="">Pilih Status</option>
                        <option value="Belum Ditangani" {{ $laporan->status_penanganan == 'Belum Ditangani' ? 'selected' : '' }}>Belum Ditangani</option>
                        <option value="Sedang Ditangani" {{ $laporan->status_penanganan == 'Sedang Ditangani' ? 'selected' : '' }}>Sedang Ditangani</option>
                        <option value="Sudah Ditangani" {{ $laporan->status_penanganan == 'Sudah Ditangani' ? 'selected' : '' }}>Sudah Ditangani</option>
                    </select>
                    @error('status_penanganan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-card full-width">
                    <div class="form-header">
                        <i class="fas fa-comment-alt"></i>
                        <label for="deskripsi_penanganan" class="form-label">Deskripsi Penanganan</label>
                    </div>
                    <textarea class="form-control @error('deskripsi_penanganan') is-invalid @enderror" 
                              id="deskripsi_penanganan" 
                              name="deskripsi_penanganan" 
                              rows="5" 
                              required
                              style="min-height: 200px;">{{ old('deskripsi_penanganan', $laporan->deskripsi_penanganan) }}</textarea>
                    @error('deskripsi_penanganan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('respon.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Respon
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

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

.update-container {
    width: 100%;
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
    animation: fadeInUp 0.4s ease-out;
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
    grid-template-columns: repeat(12, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.form-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    animation: slideInPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
    grid-column: span 12;
}

.form-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

/* Custom Select Styling */
select.form-control {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23468B94' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 16px 12px;
    padding-right: 2.5rem;
    cursor: pointer;
}

select.form-control option {
    padding: 1rem;
    font-size: 1rem;
    background-color: white;
    color: #333;
}

select.form-control:hover {
    border-color: #468B94;
    box-shadow: 0 4px 8px rgba(70, 139, 148, 0.15);
}

select.form-control:focus {
    border-color: #468B94;
    box-shadow: 0 0 0 0.2rem rgba(70, 139, 148, 0.25);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23468B94' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 11l6-6 6 6'/%3e%3c/svg%3e");
}

.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    animation: scaleIn 0.4s ease-out;
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
    color: white;
}

.btn-primary:hover {
    background-color: #3a7a82;
    border-color: #3a7a82;
    transform: translateY(-1px);
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
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
    animation: slideInPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .update-container {
        padding: 1rem;
    }

    .form-card {
        grid-column: span 12 !important;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('updateForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Ingin mengupdate respon ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#468B94',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Update!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
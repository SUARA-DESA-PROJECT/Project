@extends('layouts.app')

@section('content')
<div class="update-container">
    <div class="update-header">
        <h2><i class="fas fa-ban"></i> Tambah Keterangan Penolakan</h2>
        <p class="update-subtitle">Silahkan tambahkan keterangan untuk laporan yang ditolak</p>
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

            <!-- Info Laporan -->
            <div class="form-card mb-3">
                <div class="form-header">
                    <i class="fas fa-info-circle"></i>
                    <label class="form-label">Informasi Laporan</label>
                </div>
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Judul Laporan:</strong></td>
                        <td>{{ $laporan->judul_laporan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status Verifikasi:</strong></td>
                        <td>
                            <span class="status-badge rejected">
                                <i class="fas fa-times-circle"></i> {{ $laporan->status_verifikasi }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>

            <form method="POST" action="{{ route('respon.updateRejection', $laporan->id) }}" id="rejectionForm">
                @csrf
                @method('PUT')

                <div class="form-card full-width">
                    <div class="form-header">
                        <i class="fas fa-comment-alt"></i>
                        <label for="deskripsi_penolakan" class="form-label">Keterangan Penolakan</label>
                    </div>
                    <textarea class="form-control @error('deskripsi_penolakan') is-invalid @enderror" 
                              id="deskripsi_penolakan" 
                              name="deskripsi_penolakan" 
                              rows="5" 
                              required
                              placeholder="Jelaskan alasan mengapa laporan ini ditolak..."
                              style="min-height: 200px;">{{ old('deskripsi_penolakan', $laporan->deskripsi_penolakan) }}</textarea>
                    @error('deskripsi_penolakan')
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
                        <i class="fas fa-save"></i> Simpan Keterangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

/* Animation Keyframes - Tambah dari edit.blade.php */
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
    animation: fadeInUp 0.4s ease-out; /* Tambah animasi */
}

.update-header h2 {
    color: #dc3545;
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
    animation: slideInPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) backwards; /* Tambah animasi */
    grid-column: span 12;
}

.form-card:hover {
    transform: translateY(-2px); /* Tambah hover effect */
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

/* Tambah hover effect untuk textarea */
.form-control:hover {
    border-color: #468B94;
    box-shadow: 0 4px 8px rgba(70, 139, 148, 0.15);
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
}

.status-badge.rejected {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.status-badge i {
    margin-right: 6px;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    animation: scaleIn 0.4s ease-out; /* Tambah animasi */
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s;
    text-decoration: none;
    border: none; /* Tambah untuk consistency */
}

/* Tambah icon styling */
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
    border-color: #3a7a82; /* Tambah border-color */
    transform: translateY(-1px);
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #5a6268; /* Tambah border-color */
    transform: translateY(-1px);
    color: white;
}

.table td {
    padding: 0.5rem 0;
    border: none;
}

/* Tambah alert styling dengan animasi */
.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    animation: slideInPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* Tambah responsive design */
@media (max-width: 768px) {
    .update-container {
        padding: 1rem;
    }

    .form-card {
        grid-column: span 12 !important;
    }
    
    .update-header h2 {
        font-size: 2rem;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn {
        justify-content: center;
    }
}

/* Tambah staggered animation untuk form cards */
.form-card:nth-child(1) {
    animation-delay: 0.1s;
}

.form-card:nth-child(2) {
    animation-delay: 0.2s;
}

.form-card:nth-child(3) {
    animation-delay: 0.3s;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('rejectionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Ingin menambahkan keterangan penolakan?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#468B94',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>
@endsection
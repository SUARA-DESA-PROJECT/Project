<!-- resources/views/kategori/index.blade.php -->
@extends('layouts.app')

@section('content')
<script>
    @if(Session::has('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ Session::get('success') }}",
            showConfirmButton: true,
            confirmButtonColor: '#468B94',
            timer: 3000,
            timerProgressBar: true,
            position: 'center'
        });
    @endif
</script>
<div class="container-fluid px-4">
    <h2 class="mt-4">Daftar Kategori</h2>
    <p class="text-muted">Kelola kategori perilaku yang tersedia dalam sistem</p>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-list me-1"></i>
                    Daftar Kategori
                </div>
                <a href="{{ route('kategori.create') }}" class="btn add-btn">
                    <i class="fa fa-plus"></i> Tambah Kategori
                </a>
            </div>
        </div>
        
        <div class="card-body p-0">
            <!-- @if(session('success'))
                <div class="alert alert-success m-3">
                    {{ session('success') }}
                </div>
            @endif -->
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th width="25%">Nama Kategori</th>
                            <th width="30%">Deskripsi</th>
                            <th width="20%">Jenis Kategori</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $key => $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ $item->nama_kategori }}</td>
                            <td>{{ $item->deskripsi_kategori ?? '-' }}</td>
                            <td class="text-center align-middle">
                                <span class="status-badge {{ $item->jenis_kategori == 'Positif' ? 'verified' : 'unverified' }}">
                                    <i class="fas {{ $item->jenis_kategori == 'Positif' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                    {{ $item->jenis_kategori }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <a href="{{ route('kategori.edit', $item->nama_kategori) }}" 
                                       class="btn-action edit">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('kategori.destroy', $item->nama_kategori) }}" method="POST" class="d-inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action delete">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-list fa-3x mb-3"></i>
                                    <p>Tidak ada data kategori</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ubah selector dari '.delete-btn' menjadi '.btn-action.delete'
    const deleteButtons = document.querySelectorAll('.btn-action.delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus kategori ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

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

/* Table Styles */
.table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
    animation: fadeInUp 0.4s ease-out 0.2s backwards;
}

.table thead th {
    padding: 16px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    color: #495057;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    text-align: center;
    vertical-align: middle;
}

/* Row Animation */
.table tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #dee2e6;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateX(6px);
    box-shadow: -6px 0 0 0 #468B94;
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
    width: 100px;  /* Fixed width */
    height: 36px;  /* Fixed height */
}

.btn-action.edit {
    background-color: #468B94;
    color: white;
}

.btn-action.delete {
    background-color: #dc3545;
    color: white;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    color: white;
    text-decoration: none;
}

.btn-action i {
    font-size: 14px; /* Consistent icon size */
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    min-width: 120px;
    justify-content: center;
    transition: all 0.3s ease;
}

.status-badge.verified {
    background-color: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.status-badge.unverified {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.status-badge i {
    margin-right: 6px;
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

/* Table cell vertical alignment */
.table td {
    vertical-align: middle !important;
    white-space: normal;
}

/* Center content in cells */
.table td.text-center {
    text-align: center !important;
}

.table th {
    vertical-align: middle !important;
    text-align: center !important;
}

/* Empty State */
.empty-state {
    padding: 40px;
    text-align: center;
    color: #6c757d;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.empty-state p {
    margin: 0;
    font-size: 14px;
}

/* Additional Styles */
.table-responsive {
    overflow-x: hidden !important; /* Hide horizontal scrollbar */
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* Internet Explorer 10+ */
}

/* Hide webkit scrollbar */
.table-responsive::-webkit-scrollbar {
    display: none;
}

/* Make sure content doesn't cause horizontal scroll */
.container-fluid {
    overflow-x: hidden;
}
</style>
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
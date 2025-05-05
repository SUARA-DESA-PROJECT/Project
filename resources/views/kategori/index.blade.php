<!-- resources/views/kategori/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid pl-4">
    <div class="card" style="margin-left: 0; text-align: left;">
        <div class="card-header" style="text-align: left;">
            <div class="d-flex justify-content-between align-items-center">
                <h1 style="text-align: left;">Daftar Kategori</h1>
                <a href="{{ route('kategori.create') }}" class="btn" style="background-color: #468B94; color: white; border-radius: 6px; padding: 6px 15px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1); min-width: 120px; width: auto;">
                    <i class="fa fa-plus mr-2"></i> Tambah Kategori
                </a>
            </div>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-hover" style="text-align: left; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <thead style="background-color: #468B94; color: black; font-weight: bold;">
                        <tr>
                            <th style="padding: 15px; width: 10%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">No</th>
                            <th style="padding: 15px; width: 25%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Nama Kategori</th>
                            <th style="padding: 15px; width: 35%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Deskripsi</th>
                            <th style="padding: 15px; width: 15%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Jenis Kategori</th>
                            <th style="padding: 15px; width: 15%; font-size: 14px; font-weight: bold; color: black; text-align: center; vertical-align: middle;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $key => $item)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 12px 15px; vertical-align: middle; text-align: center;">{{ $key + 1 }}</td>
                                <td style="padding: 12px 15px; vertical-align: middle; text-align: center;">{{ $item->nama_kategori }}</td>
                                <td style="padding: 12px 15px; vertical-align: middle; text-align: center;">{{ $item->deskripsi_kategori ?? '-' }}</td>
                                <td style="padding: 12px 15px; text-align: center; vertical-align: middle;">
                                    <span class="badge" style="padding: 8px 12px; border-radius: 4px; font-size: 13px; font-weight: 500; 
                                        background-color: {{ $item->jenis_kategori == 'Positif' ? '#28a745' : '#dc3545' }}; 
                                        color: white; display: inline-block; width: 180px; text-align: center;">
                                        {{ ucfirst($item->jenis_kategori) }}
                                    </span>
                                </td>
                                <td style="padding: 12px 15px; text-align: center; vertical-align: middle;">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('kategori.edit', $item->nama_kategori) }}" 
                                           class="btn btn-sm" style="background-color: #468B94; color: white; border-radius: 4px; padding: 6px 12px; margin-right: 10px;">
                                            <i class="fa fa-edit mr-1"></i> Edit
                                        </a>
                                        <form action="{{ route('kategori.destroy', $item->nama_kategori) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" style="border-radius: 4px; padding: 6px 12px;">
                                                <i class="fa fa-trash mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center" style="padding: 20px;">Tidak ada data kategori</td>
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
    // Menangani klik tombol delete
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus kategori ini?",
                icon: 'warning',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonColor: '#28a745',
                denyButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                denyButtonText: 'Tidak',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user klik Yes
                    form.submit();
                } else if (result.isDenied) {
                    // Jika user klik No
                    Swal.fire('Dibatalkan', 'Kategori tidak jadi dihapus', 'info');
                }
                // Jika user klik Cancel, tidak ada aksi
            });
        });
    });
});
</script>
@endsection
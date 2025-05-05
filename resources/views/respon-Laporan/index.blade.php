@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Respon Laporan</h1>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-line me-1"></i>
            Daftar Laporan Terverifikasi
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Status Penanganan</th>
                        <th>Deskripsi Penanganan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporans as $index => $laporan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $laporan->tanggal_pelaporan }}</td>
                        <td>{{ $laporan->nama_pelapor }}</td>
                        <td>{{ $laporan->kategori_laporan }}</td>
                        <td>{{ $laporan->tempat_kejadian }}</td>
                        <td>{{ $laporan->status_penanganan }}</td>
                        <td>{{ $laporan->deskripsi_penanganan }}</td>
                        <td>
                            <a href="{{ route('respon.edit', $laporan->id) }}" class="btn btn-primary">
                                Update Respon
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="updateResponModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Respon Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateResponForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status Penanganan</label>
                        <select name="status_penanganan" class="form-select" required>
                            <option value="">Pilih Status</option>
                            <option value="Sudah ditangani">Sudah ditangani</option>
                            <option value="Belum ditangani">Belum ditangani</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Penanganan</label>
                        <textarea name="deskripsi_penanganan" class="form-control" required rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Respon</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const updateForm = document.getElementById('updateResponForm');
    
    updateForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Konfirmasi Update',
            text: 'Apakah anda yakin ingin mengupdate respon?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Update',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});

function openUpdateModal(id, currentStatus = '', currentDesc = '') {
    const form = document.getElementById('updateResponForm');
    form.action = `/respon-laporan/${id}`;
    form.querySelector('[name="status_penanganan"]').value = currentStatus;
    form.querySelector('[name="deskripsi_penanganan"]').value = currentDesc;
    
    new bootstrap.Modal(document.getElementById('updateResponModal')).show();
}

@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        timer: 3000,
        showConfirmButton: false
    });
@endif
</script>
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonColor: '#4e73df'
        });
    });
</script>
@endif
@endpush
@endsection
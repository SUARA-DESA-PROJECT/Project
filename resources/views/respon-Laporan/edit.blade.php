@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="border: 2px solid #C4D6C4;">
                <div class="card-header text-white" style="background-color: #C4D6C4;">
                    <h5 class="mb-0" style="font-family: 'Poppins', sans-serif;">Update Respon Laporan</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('respon.update', $laporan->id) }}" id="updateForm">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="status_penanganan" style="font-family: 'Poppins', sans-serif;">Status Penanganan</label>
                            <select class="form-control @error('status_penanganan') is-invalid @enderror" 
                                    id="status_penanganan" 
                                    name="status_penanganan"
                                    required
                                    style="font-family: 'Poppins', sans-serif;">
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

                        <div class="form-group mb-3">
                            <label for="deskripsi_penanganan" style="font-family: 'Poppins', sans-serif;">Deskripsi Penanganan</label>
                            <textarea class="form-control @error('deskripsi_penanganan') is-invalid @enderror" 
                                      id="deskripsi_penanganan" 
                                      name="deskripsi_penanganan" 
                                      rows="4" 
                                      required
                                      style="font-family: 'Poppins', sans-serif;">{{ old('deskripsi_penanganan', $laporan->deskripsi_penanganan) }}</textarea>
                            @error('deskripsi_penanganan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn text-white" style="background-color: #468B94; font-family: 'Poppins', sans-serif;">
                                Update Respon
                            </button>
                            <a href="{{ route('respon.index') }}" class="btn btn-secondary" style="font-family: 'Poppins', sans-serif;">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
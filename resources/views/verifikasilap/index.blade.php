@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4" style="padding-left:0; padding-right:0;">

    <div class="card" style="border-radius: 12px;">
        <div class="card-header bg-white">
            <h2 class="mb-0">Verifikasi Laporan</h2>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover" style="width:100%; margin-bottom:0; border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="padding-left: 8px; padding-right: 8px;">No</th>
                            <th style="padding-left: 8px; padding-right: 8px;">Judul Laporan</th>
                            <th style="padding-left: 8px; padding-right: 8px;">Deskripsi</th>
                            <th style="padding-left: 8px; padding-right: 8px;">Tanggal</th>
                            <th style="padding-left: 8px; padding-right: 8px;">Status</th>
                            <th style="padding-left: 8px; padding-right: 8px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $key => $laporan)
                            <tr>
                                <td style="padding-left: 8px; padding-right: 8px;">{{ $key + 1 }}</td>
                                <td style="padding-left: 8px; padding-right: 8px;">{{ $laporan->judul_laporan }}</td>
                                <td style="padding-left: 8px; padding-right: 8px;">{{ Str::limit($laporan->deskripsi_laporan, 40) }}</td>
                                <td style="padding-left: 8px; padding-right: 8px;">{{ \Carbon\Carbon::parse($laporan->created_at)->format('d-m-Y') }}</td>
                                <td style="padding-left: 8px; padding-right: 8px;">
                                    <span class="badge bg-danger text-white" style="font-size: 1rem; font-weight: normal;">
                                        {{ $laporan->status_verifikasi }}
                                    </span>
                                </td>
                                <td style="padding-left: 8px; padding-right: 8px;">
                                    <button 
                                        class="btn btn-info btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal"
                                        data-id="{{ $laporan->id_laporan }}"
                                        data-judul="{{ $laporan->judul_laporan }}"
                                        data-deskripsi="{{ $laporan->deskripsi_laporan }}"
                                        data-tanggal="{{ $laporan->tanggal_pelaporan }}"
                                        data-tempat="{{ $laporan->tempat_kejadian }}"
                                        data-kategori="{{ $laporan->kategori_laporan }}"
                                        data-status="{{ $laporan->status_verifikasi }}"
                                        data-penanganan="{{ $laporan->deskripsi_penanganan }}"
                                        data-tipe="{{ $laporan->tipe_pelapor }}"
                                        data-warga="{{ $laporan->warga_username }}"
                                        data-pengurus="{{ $laporan->pengurus_lingkungan_username }}"
                                    >
                                        <i class="fa fa-eye"></i> Lihat Selengkapnya
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada laporan yang perlu diverifikasi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <a href="{{ route('homepage') }}" class="btn btn-secondary mt-3" style="font-weight: bold;">
        Kembali
    </a>
</div>

<!-- Modal Detail Laporan -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel">Detail Laporan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <table class="table border-0">
            <tr>
                <th style="width: 180px;">Judul Laporan</th>
                <td id="modalJudul"></td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td id="modalDeskripsi"></td>
            </tr>
            <tr>
                <th>Tanggal Pelaporan</th>
                <td id="modalTanggal"></td>
            </tr>
            <tr>
                <th>Tempat Kejadian</th>
                <td id="modalTempat"></td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td id="modalKategori"></td>
            </tr>
            <tr>
                <th>Status Verifikasi</th>
                <td id="modalStatus"></td>
            </tr>
            <tr>
                <th>Deskripsi Penanganan</th>
                <td id="modalPenanganan"></td>
            </tr>
            <tr>
                <th>Tipe Pelapor</th>
                <td id="modalTipe"></td>
            </tr>
            <tr>
                <th>Username Warga</th>
                <td id="modalWarga"></td>
            </tr>
            <tr>
                <th>Username Pengurus</th>
                <td id="modalPengurus"></td>
            </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var detailModal = document.getElementById('detailModal');
    detailModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('modalJudul').textContent = button.getAttribute('data-judul');
        document.getElementById('modalDeskripsi').textContent = button.getAttribute('data-deskripsi');
        document.getElementById('modalTanggal').textContent = button.getAttribute('data-tanggal');
        document.getElementById('modalTempat').textContent = button.getAttribute('data-tempat');
        document.getElementById('modalKategori').textContent = button.getAttribute('data-kategori');
        document.getElementById('modalStatus').textContent = button.getAttribute('data-status');
        document.getElementById('modalPenanganan').textContent = button.getAttribute('data-penanganan');
        document.getElementById('modalTipe').textContent = button.getAttribute('data-tipe');
        document.getElementById('modalWarga').textContent = button.getAttribute('data-warga');
        document.getElementById('modalPengurus').textContent = button.getAttribute('data-pengurus');
    });
});
</script>
@endsection
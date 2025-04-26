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
                                        class="btn btn-info btn-sm lihat-selengkapnya"
                                        data-id="{{ $laporan->id_laporan }}"
                                        data-judul="{{ $laporan->judul_laporan }}"
                                        data-deskripsi="{{ $laporan->deskripsi_laporan }}"
                                        data-tanggal="{{ $laporan->created_at }}"
                                        data-tempat="{{ $laporan->tempat_kejadian }}"
                                        data-status_penanganan="{{ $laporan->status_penanganan }}"
                                        data-deskripsi_penanganan="{{ $laporan->deskripsi_penanganan }}"
                                        data-kategori="{{ $laporan->kategori_laporan }}"
                                        data-jenis="{{ $laporan->kategoriData->jenis_kategori ?? '-' }}"
                                        data-status_verifikasi="{{ $laporan->status_verifikasi }}"
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
        {{-- Tambahkan alert di sini --}}
        <div id="customAlert" class="alert alert-danger" role="alert">
            Saya ingin makan
        </div>
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
        document.getElementById('modalIdLaporan').textContent = button.getAttribute('data-id);
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.lihat-selengkapnya').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const idLaporan = btn.getAttribute('data-id');
            const judul = btn.getAttribute('data-judul');
            const deskripsi = btn.getAttribute('data-deskripsi');
            const tanggal = btn.getAttribute('data-tanggal');
            const tempat = btn.getAttribute('data-tempat');
            const statusPenanganan = btn.getAttribute('data-status_penanganan');
            let deskripsiPenanganan = btn.getAttribute('data-deskripsi_penanganan');
            const kategori = btn.getAttribute('data-kategori');
            const jenis = btn.getAttribute('data-jenis');
            const statusVerifikasi = btn.getAttribute('data-status_verifikasi');
            
            if (!deskripsiPenanganan || deskripsiPenanganan.trim() === "") {
                deskripsiPenanganan = "-";
            }

            // Build the select HTML for status verifikasi
            const selectStatus = `
                <select id="swal_status_verifikasi" class="form-control" style="margin-top:4px;">
                    <option value="Belum Diverifikasi" ${statusVerifikasi === 'Belum Diverifikasi' ? 'selected' : ''}>Belum Diverifikasi</option>
                    <option value="Diverifikasi" ${statusVerifikasi === 'Diverifikasi' ? 'selected' : ''}>Diverifikasi</option>
                </select>
            `;

            Swal.fire({
                title: judul,
                html: `
                    <b>Deskripsi:</b> ${deskripsi}<br>
                    <b>Waktu Kejadian:</b> ${tanggal}<br>
                    <b>Tempat Kejadian:</b> ${tempat}<br>
                    <b>Status Penanganan:</b> ${statusPenanganan}<br>
                    <b>Deskripsi Penanganan:</b> ${deskripsiPenanganan}<br>
                    <b>Kategori Laporan:</b> ${kategori}<br>
                    <b>Jenis Laporan:</b> ${jenis}<br>
                    <b>Status Verifikasi:</b> ${selectStatus}
                `,
                confirmButtonText: 'Kembali',
                allowOutsideClick: () => {
                    const popup = Swal.getPopup()
                    popup.classList.remove('swal2-show')
                    setTimeout(() => {
                        popup.classList.add('animate__animated', 'animate__headShake')
                    })
                    setTimeout(() => {
                        popup.classList.remove('animate__animated', 'animate__headShake')
                    }, 500)
                    return false
                },
                didOpen: () => {
                    // Store the original value for comparison
                    window._originalStatusVerifikasi = statusVerifikasi;
                },
                preConfirm: () => {
                    // Return the selected value for further processing
                    return document.getElementById('swal_status_verifikasi').value;
                }
            }).then((result) => {
                const newStatus = result.value;
                if (result.isConfirmed) {
                    // Only show confirmation if status changed
                    if (newStatus !== window._originalStatusVerifikasi) {
                        Swal.fire({
                            title: "Do you want to save the changes?",
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: "Save",
                            denyButtonText: `Don't save`
                        }).then((result2) => {
                            if (result2.isConfirmed) {
                                // AJAX update to backend
                                fetch("{{ url('/laporan/update-status') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({
                                        id: idLaporan,
                                        status_verifikasi: newStatus
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire("Saved!", "", "success").then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire("Failed to save!", data.message || "", "error");
                                    }
                                })
                                .catch(() => {
                                    Swal.fire("Failed to save!", "Server error.", "error");
                                });
                            } else if (result2.isDenied) {
                                Swal.fire("Changes are not saved", "", "info");
                            }
                        });
                    }
                }
            });
        });
    });
});
</script>
@endsection
@extends('layouts.app')

@section('title', 'Forum Diskusi')

@section('styles')
<style>
    h2 {
        color: #333;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .forum-container {
        max-width: 100%;
        margin: 0;
    }
    
    .report-card {
        /* background-color: #C4D6C4; */
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1), 0 2px 5px rgba(70,139,148,0.15);
        margin-bottom: 25px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.2);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .report-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15), 0 3px 8px rgba(70,139,148,0.2);
    }
    
    .report-header {
        padding: 15px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.3);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #468B94;
        color: white;
    }
    
    .report-title {
        font-size: 18px;
        font-weight: 600;
        color: white; /* Changed text color for better contrast */
        margin: 0;
    }
    
    .report-meta {
        color: #657786;
        font-size: 14px;
    }
    
    .report-content {
        padding: 20px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .report-description {
        font-size: 16px;
        line-height: 1.5;
        color: #14171a;
        margin-bottom: 15px;
    }
    
    .report-details {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-size: 14px;
        color: #657786;
    }
    
    .report-detail {
        display: flex;
        align-items: center;
    }
    
    .report-detail i {
        margin-right: 5px;
    }
    
    .comments-section {
        padding: 15px 20px;
    }
    
    .comment-form {
        margin-bottom: 20px;
    }
    
    .comment-input {
        width: 100%;
        border: 1px solid #cfd9de;
        border-radius: 20px;
        padding: 10px 15px;
        font-size: 14px;
        resize: none;
        transition: border-color 0.2s;
    }
    
    .comment-input:focus {
        border-color: #468B94;
        outline: none;
    }
    
    .comment-submit {
        background-color: #468B94;
        color: white;
        border: none;
        border-radius: 20px;
        padding: 8px 16px;
        font-weight: 600;
        cursor: pointer;
        float: right;
        margin-top: 10px;
        transition: background-color 0.2s;
    }
    
    .comment-submit:hover {
        background-color: #3a7279;
    }
    
    .comments-list {
        margin-top: 20px;
    }
    
    .comment {
        padding: 12px 0;
        border-top: 1px solid #f0f0f0;
    }
    
    .comment-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }
    
    .comment-user {
        font-weight: 600;
        color: #14171a;
    }
    
    .comment-time {
        color: #657786;
        font-size: 12px;
    }
    
    .comment-content {
        font-size: 14px;
        line-height: 1.4;
        color: #14171a;
    }
    
    .comment-actions {
        margin-top: 12px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .comment-action.edit-btn {
        margin-top: 3px;
        display: inline-block;
    }

    .comment-action {
        color: #657786;
        font-size: 12px;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        margin: 0;
        font-family: inherit;
        text-decoration: none;
        appearance: none;
        -webkit-appearance: none;
        outline: none;
    }
    
    .comment-action:hover {
        color: #468B94;
        text-decoration: underline;
    }
    
    .badge-verified {
        background-color: #92DEB7;
        color: #333;
        padding: 3px 8px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-category {
        background-color: #75B7B6;
        color: white;
        padding: 3px 8px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .no-reports {
        text-align: center;
        padding: 50px 0;
        color: #657786;
    }
    
    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }
    
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 15px;
        width: 80%;
        max-width: 500px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .modal-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }
    
    .close-modal {
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        color: #aaa;
    }
    
    .close-modal:hover {
        color: #333;
    }
    
    .modal-body {
        margin-bottom: 20px;
    }
    
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    
    .edit-comment-input {
        width: 100%;
        border: 1px solid #cfd9de;
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 14px;
        resize: none;
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h2>Forum Diskusi Laporan</h2>
            <p>Diskusikan laporan yang telah terverifikasi dengan warga lain dan petugas desa.</p>
            
            <div class="forum-container">
                @if($verifiedReports->count() > 0)
                    @foreach($verifiedReports as $report)
                    <div class="report-card">
                        <div class="report-header">
                            <h3 class="report-title">{{ $report->judul_laporan }}</h3>
                            <div class="report-meta">
                                <span class="badge badge-verified">Terverifikasi</span>
                                <span class="badge badge-category">{{ $report->kategori_laporan }}</span>
                            </div>
                        </div>
                        
                        <div class="report-content">
                            <p class="report-description">{{ $report->deskripsi_laporan }}</p>
                            <div class="report-details">
                                <div class="report-detail">
                                    <i class="fa fa-user"></i>
                                    <span>{{ $report->warga_username ?? $report->pengurus_lingkungan_username }}</span>
                                </div>
                                <div class="report-detail">
                                    <i class="fa fa-map-marker"></i>
                                    <span>{{ $report->tempat_kejadian }}</span>
                                </div>
                                <div class="report-detail">
                                    <i class="fa fa-calendar"></i>
                                    <span>{{ \Carbon\Carbon::parse($report->tanggal_pelaporan)->format('d M Y') }}</span>
                                </div>
                                <div class="report-detail">
                                    <i class="fa fa-comments"></i>
                                    <span>{{ $report->komentars->count() }} komentar</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="comments-section">
                            <form action="{{ route('komentarpengurus.store') }}" method="POST" class="comment-form">
                                @csrf
                                <input type="hidden" name="laporan_id" value="{{ $report->id }}">
                                <textarea name="isi_komentar" class="comment-input" rows="2" placeholder="Tulis komentar Anda..."></textarea>
                                <button type="submit" class="comment-submit">Kirim</button>
                                <div style="clear: both;"></div>
                            </form>
                            
                            <div class="comments-list">
                                @forelse($report->komentars->sortByDesc('created_at') as $komentar)
                                <div class="comment">
                                    <div class="comment-header">
                                        <div class="comment-user">
                                            {{ $komentar->username }}
                                            @if($komentar->tipe_user == 'pengurus')
                                            <i class="fa fa-check-circle verified-badge" title="Petugas Desa" style="color: #1DA1F2;"></i>
                                            @endif
                                        </div>
                                        <div class="comment-time">{{ \Carbon\Carbon::parse($komentar->created_at)->locale('id')->diffForHumans() }}</div>
                                    </div>
                                    <div class="comment-content">
                                        {{ $komentar->isi_komentar }}
                                    </div>
                                    @if(session('pengurusLingkungan') && $komentar->tipe_user == 'pengurus' && $komentar->username == session('pengurusLingkungan')->username)
                                    <div class="comment-actions">
                                        <a href="javascript:void(0)" onclick="openEditModal('{{ $komentar->id }}', '{{ addslashes($komentar->isi_komentar) }}')" class="comment-action edit-btn">Edit</a>
                                        <form action="{{ route('komentarpengurus.destroy', $komentar->id) }}" method="POST" style="display: inline-block; margin: 0; padding: 0; line-height: 1;" id="delete-form-{{ $komentar->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="comment-action" style="line-height: 1; vertical-align: baseline;" onclick="confirmDelete({{ $komentar->id }})">Hapus</button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                                @empty
                                <div class="comment">
                                    <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="no-reports">
                        <i class="fa fa-info-circle fa-3x mb-3"></i>
                        <h4>Belum ada laporan terverifikasi</h4>
                        <p>Laporan yang telah diverifikasi akan muncul di sini untuk didiskusikan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Add this at the end of your content section -->
    <div id="editCommentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Komentar</h3>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <form id="editCommentForm" method="POST">
                    @csrf
                    @method('PUT')
                    <textarea id="editCommentText" name="isi_komentar" class="edit-comment-input" rows="4"></textarea>
                    <div class="modal-footer">
                        <button type="button" class="comment-submit" style="background-color: #6c757d; float: none;" onclick="closeModal()">Batal</button>
                        <button type="submit" class="comment-submit" style="float: none;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Check for success message in session
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    @endif

    // Function to open SweetAlert edit modal
    function openEditModal(id, content) {
        Swal.fire({
            title: 'Edit Komentar',
            input: 'textarea',
            inputValue: content,
            inputAttributes: {
                rows: 5
            },
            showCancelButton: true,
            confirmButtonText: 'Simpan Perubahan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#468B94',
            cancelButtonColor: '#6c757d',
            reverseButtons: true,
            preConfirm: (text) => {
                if (!text) {
                    Swal.showValidationMessage('Komentar tidak boleh kosong')
                }
                return text
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('/komentarpengurus') }}/${id}`;
                form.style.display = 'none';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'PUT';
                
                const comment = document.createElement('input');
                comment.type = 'hidden';
                comment.name = 'isi_komentar';
                comment.value = result.value;
                
                form.appendChild(csrfToken);
                form.appendChild(method);
                form.appendChild(comment);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Komentar yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#468B94',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
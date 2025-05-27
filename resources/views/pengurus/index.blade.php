<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Akun</title>
    <!-- Add SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            padding: 2rem;
            background: linear-gradient(135deg, #e8ecef 0%, #d1d8e0 100%);
            opacity: 0;
            animation: pageLoad 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
            color: #2c3e50;
            position: relative;
        }

        .home-btn {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .home-btn:hover {
            background-color: #2980b9;
            transform: translateY(-50%) translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .header p {
            color: #4a5568;
        }

        .add-account-btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .add-account-btn:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .table-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
            overflow-x: auto;
        }

        .accounts-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .accounts-table th,
        .accounts-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e1e8f0;
        }

        .accounts-table th {
            background-color: #f8fafc;
            color: #2c3e50;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        .accounts-table tr:hover {
            background-color: #f8fafc;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .edit-btn, .delete-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
        }

        .edit-btn {
            background-color: #3498db;
            color: white;
        }

        .edit-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .table-container {
                padding: 1rem;
            }

            .accounts-table th,
            .accounts-table td {
                padding: 0.75rem;
            }

            .home-btn {
                position: static;
                transform: none;
                margin-bottom: 1rem;
                display: inline-block;
            }

            .home-btn:hover {
                transform: translateY(-2px);
            }
        }

        /* Page Transition Styles */
        .page-transition-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #e8ecef 0%, #d1d8e0 100%);
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .page-transition-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        /* SweetAlert2 Custom Styles */
        .swal2-container {
            padding: 0 !important;
            overflow-y: auto !important;
        }

        .swal2-shown {
            overflow: auto !important;
            padding-right: 0 !important;
        }

        body.swal2-shown {
            padding-right: 0 !important;
            overflow: auto !important;
        }

        .swal2-popup {
            position: relative;
            padding: 2rem;
            width: 32em;
            max-width: 90%;
            margin: 2rem auto;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        /* Delete confirmation specific styles */
        .swal2-warning {
            animation: warningIconScale 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes warningIconScale {
            0% {
                transform: scale(0.5);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        .swal2-title {
            color: #2c3e50 !important;
            font-size: 1.5rem !important;
            margin-bottom: 1rem !important;
        }

        .swal2-html-container {
            margin: 1rem 0 !important;
            color: #4a5568 !important;
            font-size: 1rem !important;
            line-height: 1.5 !important;
        }

        .swal2-html-container strong {
            color: #2c3e50;
            font-weight: 600;
        }

        .swal2-confirm.swal2-styled {
            background-color: #e74c3c !important;
            padding: 0.8rem 1.5rem !important;
            font-size: 1rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
        }

        .swal2-confirm.swal2-styled:hover {
            background-color: #c0392b !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3) !important;
        }

        .swal2-cancel.swal2-styled {
            background-color: #64748b !important;
            padding: 0.8rem 1.5rem !important;
            font-size: 1rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
        }

        .swal2-cancel.swal2-styled:hover {
            background-color: #475569 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 5px 15px rgba(100, 116, 139, 0.3) !important;
        }

        .swal2-popup.delete-confirmation {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .swal2-backdrop-show {
            animation: backdropFadeIn 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .swal2-html-container {
            margin: 0 !important;
            opacity: 0;
            animation: contentFadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            animation-delay: 0.3s;
        }

        @keyframes modalFadeIn {
            0% {
                opacity: 0;
                transform: translateY(-80px) scale(0.8);
            }
            60% {
                transform: translateY(10px) scale(1.02);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes backdropFadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes contentFadeIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            70% {
                opacity: 0.7;
                transform: translateY(-5px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* When closing */
        .swal2-hide {
            animation: modalFadeOut 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes modalFadeOut {
            0% {
                opacity: 1;
                transform: scale(1);
            }
            100% {
                opacity: 0;
                transform: scale(0.9) translateY(20px);
            }
        }

        .edit-form {
            text-align: left;
            margin: 1rem 0;
        }

        .form-group {
            margin-bottom: 1.25rem;
            opacity: 0;
            animation: formGroupFadeIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .form-group:nth-child(2) { animation-delay: 0.4s; }
        .form-group:nth-child(3) { animation-delay: 0.6s; }
        .form-group:nth-child(4) { animation-delay: 0.8s; }

        @keyframes formGroupFadeIn {
            0% {
                opacity: 0;
                transform: translateX(-30px);
            }
            70% {
                opacity: 0.7;
                transform: translateX(5px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4a5568;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 0.95rem;
            color: #2d3748;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-group input:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
            transform: translateY(-2px);
        }

        .swal2-actions {
            margin-top: 2rem !important;
            gap: 0.75rem;
            opacity: 0;
            animation: actionsFadeIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            animation-delay: 1s;
        }

        @keyframes actionsFadeIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            70% {
                opacity: 0.7;
                transform: translateY(-5px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .swal2-confirm, .swal2-cancel {
            padding: 0.75rem 1.5rem !important;
            font-weight: 500 !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .swal2-confirm:hover, .swal2-cancel:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Add initial page fade in */
        body {
            opacity: 0;
            animation: pageLoad 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes pageLoad {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- Add overlay div for transitions -->
    <div class="page-transition-overlay"></div>

    <div class="container">
        <div class="header">
            <a href="http://localhost:8000" class="home-btn">Home</a>
            <h1>Manajemen Akun</h1>
            <p>Lihat dan kelola akun pengguna</p>
            <a href="{{ route('pengurus.form') }}" class="add-account-btn">Tambah Akun Baru</a>
        </div>

        <div class="table-container">
            <table class="accounts-table">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Alamat</th>
                        <th>Nomor Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengurusData as $p)
                    <tr>
                        <td>{{ $p['nama_lengkap'] }}</td>
                        <td>{{ $p['username'] }}</td>
                        <td>{{ $p['alamat'] }}</td>
                        <td>{{ $p['nomor_telepon'] }}</td>
                        <td>
                            <div class="action-buttons">
                                <button onclick="openEditForm('{{ $p['username'] }}', '{{ $p['nama_lengkap'] }}', '{{ $p['alamat'] }}', '{{ $p['nomor_telepon'] }}')" class="edit-btn">Ubah</button>
                                <form action="{{ route('pengurus.destroy', $p['username']) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Add page transition handling
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all link clicks for transition
            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link && !e.ctrlKey && !e.shiftKey && !e.metaKey && !e.altKey) {
                    e.preventDefault();
                    const overlay = document.querySelector('.page-transition-overlay');
                    overlay.classList.add('active');
                    
                    setTimeout(() => {
                        window.location.href = link.href;
                    }, 300);
                }
            });

            // Handle form submissions for transition
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!e.target.classList.contains('no-transition')) {
                        const overlay = document.querySelector('.page-transition-overlay');
                        overlay.classList.add('active');
                    }
                });
            });
        });

        function openEditForm(username, namaLengkap, alamat, nomorTelepon) {
            Swal.fire({
                title: 'Ubah Akun',
                html: `
                    <form id="editForm" class="edit-form">
                        <input type="hidden" id="username" value="${username}">
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" value="${namaLengkap}" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" id="alamat" value="${alamat}" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_telepon">Nomor Telepon</label>
                            <input type="tel" id="nomor_telepon" value="${nomorTelepon}" required>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#4CAF50',
                cancelButtonColor: '#64748b',
                focusConfirm: false,
                allowOutsideClick: true,
                allowEscapeKey: true,
                allowEnterKey: true,
                scrollbarPadding: false,
                heightAuto: true,
                customClass: {
                    container: 'swal2-container',
                    popup: 'swal2-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('username', document.getElementById('username').value);
                    formData.append('nama_lengkap', document.getElementById('nama_lengkap').value);
                    formData.append('alamat', document.getElementById('alamat').value);
                    formData.append('nomor_telepon', document.getElementById('nomor_telepon').value);
                    formData.append('_method', 'PUT');
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                    fetch(`/pengurus/${username}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal memperbarui akun');
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data akun berhasil diperbarui',
                            icon: 'success',
                            confirmButtonColor: '#4CAF50'
                        }).then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        Swal.showValidationMessage(error.message);
                    });
                }
            });
        }

        function confirmDelete(form, nama) {
            const swalConfig = {
                title: 'Hapus Akun?',
                html: `Apakah Anda yakin ingin menghapus akun <strong>${nama}</strong>?<br>Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#64748b',
                customClass: {
                    popup: 'swal2-popup delete-confirmation',
                    confirmButton: 'swal2-confirm swal2-styled',
                    cancelButton: 'swal2-cancel swal2-styled'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                },
                allowOutsideClick: true,
                allowEscapeKey: true,
                allowEnterKey: true,
                scrollbarPadding: false
            };

            Swal.fire(swalConfig).then((result) => {
                if (result.isConfirmed) {
                    const overlay = document.querySelector('.page-transition-overlay');
                    overlay.classList.add('active');
                    setTimeout(() => {
                        form.submit();
                    }, 300);
                }
            });
        }
    </script>
</body>
</html>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Riwayat Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #468B94;
            padding-bottom: 10px;
        }
        .logo-container {
            margin-bottom: 10px;
        }
        h1 {
            font-size: 24px;
            margin: 5px 0;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px 8px;
            text-align: center;
            font-size: 12px;
        }
        th {
            background-color: #468B94;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .badge-success {
            color: #28a745;
            font-weight: bold;
        }
        .badge-danger {
            color: #dc3545;
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 5px;
            width: 100%;
        }
        .page-number {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 11px;
            color: #666;
        }
        .deskripsi-cell {
            text-align: left;
            max-width: 200px;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <!-- Logo bisa ditambahkan di sini jika ada -->
        </div>
        <h1>Riwayat Laporan</h1>
        <div class="subtitle">Sistem Informasi Suara Desa</div>
        <div class="subtitle">Laporan Aktivitas Masyarakat</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="15%">Judul Laporan</th>
                <th width="20%">Deskripsi Laporan</th>
                <th width="10%">Tanggal Pelaporan</th>
                <th width="12%">Tempat Kejadian</th>
                <th width="12%">Kategori Laporan</th>
                <th width="10%">Jenis Laporan</th>
                <th width="10%">Status Verifikasi</th>
                <th width="11%">Status Penanganan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporans as $laporan)
                <tr>
                    <td>{{ $laporan->judul_laporan }}</td>
                    <td class="deskripsi-cell">{{ $laporan->deskripsi_laporan }}</td>
                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal_pelaporan)->format('d-m-Y') }}</td>
                    <td>{{ $laporan->tempat_kejadian }}</td>
                    <td>{{ $laporan->kategori_laporan }}</td>
                    <td>
                        <span class="{{ $laporan->jenis_kategori == 'Positif' ? 'badge-success' : 'badge-danger' }}">
                            {{ $laporan->jenis_kategori == 'Positif' ? 'Laporan Positif' : 'Laporan Negatif' }}
                        </span>
                    </td>
                    <td>
                        <span class="{{ $laporan->status_verifikasi == 'Diverifikasi' ? 'badge-success' : 'badge-danger' }}">
                            {{ $laporan->status_verifikasi }}
                        </span>
                    </td>
                    <td>
                        <span class="{{ $laporan->status_penanganan == 'Sudah Ditangani' ? 'badge-success' : 'badge-danger' }}">
                            {{ $laporan->status_penanganan }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada data laporan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->addHours(7)->format('d-m-Y H:i:s') }} | Dokumen ini dicetak dari Sistem Informasi Suara Desa
    </div>
    
    <div class="page-number">
        Halaman 1
    </div>
</body>
</html>
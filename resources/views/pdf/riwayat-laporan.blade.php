<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Riwayat Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }
        th {
            background-color: #468B94;
            color: black;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .badge-success {
            color: #28a745;
            font-size: 12px;
            font-weight: normal;
        }
        .badge-danger {
            color: #dc3545;
            font-size: 12px;
            font-weight: normal;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            text-align: left;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h1>Riwayat Laporan</h1>
    
    <table>
        <thead>
            <tr>
                <th>Judul Laporan</th>
                <th>Deskripsi Laporan</th>
                <th>Tanggal Pelaporan</th>
                <th>Tempat Kejadian</th>
                <th>Kategori Laporan</th>
                <th>Jenis Laporan</th>
                <th>Status Verifikasi</th>
                <th>Status Penanganan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporans as $laporan)
                <tr>
                    <td>{{ $laporan->judul_laporan }}</td>
                    <td>{{ $laporan->deskripsi_laporan }}</td>
                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal_pelaporan)->format('d-m-Y') }}</td>
                    <td>{{ $laporan->tempat_kejadian }}</td>
                    <td>{{ $laporan->kategori_laporan }}</td>
                    <td>
                        {{ $laporan->jenis_kategori == 'Positif' ? 'Laporan Positif' : 'Laporan Negatif' }}
                    </td>
                    <td>
                        {{ $laporan->status_verifikasi }}
                    </td>
                    <td>
                        {{ $laporan->status_penanganan }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data laporan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->addHours(7)->format('d-m-Y H:i:s') }}
    </div>
</body>
</html>
<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    /**
     * Show the map view for warga
     */
    public function persebaranWarga()
    {
        return view('peta.persebaran-warga');
    }

    /**
     * Show the map view for admin/pengurus
     */
    public function persebaranAdmin()
    {
        return view('peta.persebaran-admin');
    }

    /**
     * Get map data for laporan coordinates
     */
    public function getMapData(Request $request)
    {
        try {
            // Get all laporan with coordinates and related data
            $laporans = Laporan::with(['warga', 'pengurusLingkungan', 'kategoriData'])
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->select([
                    'id',
                    'judul_laporan',
                    'deskripsi_laporan',
                    'tanggal_pelaporan',
                    'tempat_kejadian',
                    'latitude',
                    'longitude',
                    'status_verifikasi',
                    'status_penanganan',
                    'kategori_laporan',
                    'tipe_pelapor',
                    'warga_username',
                    'pengurus_lingkungan_username'
                ])
                ->get();

            // Transform data for leaflet
            $mapData = [
                'type' => 'FeatureCollection',
                'features' => []
            ];

            foreach ($laporans as $laporan) {
                // Determine marker color based on status
                $markerColor = $this->getMarkerColor($laporan->status_verifikasi, $laporan->status_penanganan);
                
                // Get reporter name
                $reporterName = $laporan->tipe_pelapor === 'Warga' 
                    ? ($laporan->warga ? $laporan->warga->nama_lengkap : 'Warga')
                    : ($laporan->pengurusLingkungan ? $laporan->pengurusLingkungan->nama_lengkap : 'Pengurus');

                $feature = [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [
                            (float) $laporan->longitude,
                            (float) $laporan->latitude
                        ]
                    ],
                    'properties' => [
                        'id' => $laporan->id,
                        'title' => $laporan->judul_laporan,
                        'description' => $laporan->deskripsi_laporan,
                        'date' => $laporan->tanggal_pelaporan,
                        'location' => $laporan->tempat_kejadian,
                        'category' => $laporan->kategori_laporan,
                        'verification_status' => $laporan->status_verifikasi,
                        'handling_status' => $laporan->status_penanganan,
                        'reporter_type' => $laporan->tipe_pelapor,
                        'reporter_name' => $reporterName,
                        'marker_color' => $markerColor,
                        'popup_content' => $this->generatePopupContent($laporan, $reporterName)
                    ]
                ];

                $mapData['features'][] = $feature;
            }

            return response()->json($mapData);

        } catch (\Exception $e) {
            \Log::error('Error fetching map data: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch map data',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get marker color based on status
     */
    private function getMarkerColor($verificationStatus, $handlingStatus)
    {
        // Priority: Verification status first, then handling status
        switch ($verificationStatus) {
            case 'Diverifikasi':
                switch ($handlingStatus) {
                    case 'Sudah ditangani':
                        return 'green';
                    case 'Belum ditangani':
                        return 'orange';
                    case 'Sedang ditangani':
                        return 'blue';
                    default:
                        return 'lightgreen';
                }
            case 'Ditolak':
                return 'red';
            case 'Belum Diverifikasi':
            default:
                return 'gray';
        }
    }

    /**
     * Generate popup content for markers
     */
    private function generatePopupContent($laporan, $reporterName)
    {
        $statusVerifikasiClass = match($laporan->status_verifikasi) {
            'Diverifikasi' => 'badge bg-success',
            'Ditolak' => 'badge bg-danger',
            'Belum Diverifikasi' => 'badge bg-warning text-dark',
            default => 'badge bg-secondary'
        };

        $statusPenangananClass = match($laporan->status_penanganan) {
            'Sudah ditangani' => 'badge bg-success',
            'Belum ditangani' => 'badge bg-warning text-dark',
            'Sedang ditangani' => 'badge bg-info',
            default => 'badge bg-secondary'
        };

        return '
            <div class="popup-content" style="min-width: 250px;">
                <h6 class="mb-2 text-primary">' . htmlspecialchars($laporan->judul_laporan) . '</h6>
                <p class="mb-2 small">' . htmlspecialchars(substr($laporan->deskripsi_laporan, 0, 100)) . (strlen($laporan->deskripsi_laporan) > 100 ? '...' : '') . '</p>
                <div class="mb-2">
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>' . $laporan->tanggal_pelaporan . '<br>
                        <i class="fas fa-map-marker-alt me-1"></i>' . htmlspecialchars($laporan->tempat_kejadian) . '<br>
                        <i class="fas fa-tag me-1"></i>' . htmlspecialchars($laporan->kategori_laporan) . '<br>
                        <i class="fas fa-user me-1"></i>' . htmlspecialchars($reporterName) . ' (' . $laporan->tipe_pelapor . ')
                    </small>
                </div>
                <div class="mb-2">
                    <span class="' . $statusVerifikasiClass . ' me-1">' . $laporan->status_verifikasi . '</span>
                    <span class="' . $statusPenangananClass . '">' . ($laporan->status_penanganan ?: 'Belum ada status') . '</span>
                </div>
            </div>
        ';
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        try {
            $stats = [
                'total_laporan' => Laporan::whereNotNull('latitude')->whereNotNull('longitude')->count(),
                'by_verification' => [
                    'diverifikasi' => Laporan::where('status_verifikasi', 'Diverifikasi')
                        ->whereNotNull('latitude')->whereNotNull('longitude')->count(),
                    'ditolak' => Laporan::where('status_verifikasi', 'Ditolak')
                        ->whereNotNull('latitude')->whereNotNull('longitude')->count(),
                    'belum_diverifikasi' => Laporan::where('status_verifikasi', 'Belum Diverifikasi')
                        ->whereNotNull('latitude')->whereNotNull('longitude')->count(),
                ],
                'by_handling' => [
                    'sudah_ditangani' => Laporan::where('status_penanganan', 'Sudah ditangani')
                        ->whereNotNull('latitude')->whereNotNull('longitude')->count(),
                    'belum_ditangani' => Laporan::where('status_penanganan', 'Belum ditangani')
                        ->whereNotNull('latitude')->whereNotNull('longitude')->count(),
                    'sedang_ditangani' => Laporan::where('status_penanganan', 'Sedang ditangani')
                        ->whereNotNull('latitude')->whereNotNull('longitude')->count(),
                ],
                'by_location' => Laporan::whereNotNull('latitude')->whereNotNull('longitude')
                    ->select('tempat_kejadian')
                    ->selectRaw('count(*) as total')
                    ->groupBy('tempat_kejadian')
                    ->get()
            ];

            return response()->json($stats);

        } catch (\Exception $e) {
            \Log::error('Error fetching statistics: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch statistics'
            ], 500);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Laporan;
use App\Models\Warga;
use App\Models\PengurusLingkungan;
use Carbon\Carbon;

class LaporanSeeder extends Seeder
{
    /**
     * Definisi batas koordinat untuk setiap wilayah di Kabupaten Bandung
     */
    private function getRegionBounds()
    {
        return [
            'Buahbatu' => [
                'lat_min' => -6.964035,
                'lat_max' => -6.932938,
                'lng_min' => 107.641444,
                'lng_max' => 107.669485
            ],
            'Cipagalo' => [
                'lat_min' => -6.971052,
                'lat_max' => -6.968581,
                'lng_min' => 107.636253,
                'lng_max' => 107.664362 
            ],
            'Bojongsoang' => [
                'lat_min' => -7.006330,
                'lat_max' => -6.968333,
                'lng_min' => 107.642773,
                'lng_max' => 107.673500
            ],
            'Lengkong' => [
                'lat_min' => -6.9400,
                'lat_max' => -6.918750,
                'lng_min' => 107.609449,
                'lng_max' => 107.636056
            ],
            'Bojongsari' => [
                'lat_min' => -7.011031,
                'lat_max' => -6.947293,
                'lng_min' => 107.631611,
                'lng_max' => 107.654055, 
            ],
            'Tegalluar' => [
                'lat_min' => -6.993707,
                'lat_max' => -6.965193,
                'lng_min' => 107.673792,
                'lng_max' => 107.709793, 
            ]
        ];
    }

    /**
     * Generate koordinat random dalam batas wilayah tertentu
     */
    private function generateCoordinatesInRegion($region)
    {
        $bounds = $this->getRegionBounds();
        
        if (!isset($bounds[$region])) {
            // Fallback ke Buahbatu jika region tidak ditemukan
            $region = 'Buahbatu';
        }
        
        $regionBounds = $bounds[$region];
        
        // Generate random coordinates dalam batas wilayah
        $latitude = $regionBounds['lat_min'] + 
                   (($regionBounds['lat_max'] - $regionBounds['lat_min']) * (rand(0, 5000) / 10000));
        
        $longitude = $regionBounds['lng_min'] + 
                    (($regionBounds['lng_max'] - $regionBounds['lng_min']) * (rand(0, 5000) / 10000));
        
        return [
            'latitude' => round($latitude, 8),
            'longitude' => round($longitude, 8)
        ];
    }

    /**
     * Mengecek koordinat masuk ke wilayah mana
     */
    private function getRegionFromCoordinates($lat, $lng)
    {
        $bounds = $this->getRegionBounds();
        
        foreach ($bounds as $region => $bound) {
            if ($lat >= $bound['lat_min'] && $lat <= $bound['lat_max'] &&
                $lng >= $bound['lng_min'] && $lng <= $bound['lng_max']) {
                return $region;
            }
        }
        
        return 'Unknown'; // Jika tidak masuk ke wilayah manapun
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil username yang benar-benar ada di database
        $wargaUsernames = Warga::pluck('username')->toArray();
        $pengurusUsernames = PengurusLingkungan::pluck('username')->toArray();
        
        $tempatKejadian = ['Bojongsari', 'Bojongsoang', 'Buahbatu', 'Cipagalo', 'Lengkong', 'Tegalluar'];
        $statusVerifikasi = ['Ditolak', 'Diverifikasi', 'Belum Diverifikasi'];
        $statusPenanganan = ['Sudah ditangani', 'Belum ditangani', 'Sedang ditangani'];
        $kategoriPositif = ['Kegiatan Sosial', 'Pembangunan', 'Kegiatan Budaya', 'Inisiatif Lingkungan', 'Kesehatan Masyarakat'];
        $kategoriNegatif = ['Kejahatan', 'Kecelakaan', 'Bencana Alam', 'Pelanggaran Hukum', 'Masalah Sosial'];
        
        $judulLaporanPositif = [
            'Gotong Royong Membersihkan Selokan',
            'Kegiatan Posyandu Balita',
            'Festival Budaya Daerah',
            'Penanaman Pohon di Taman',
            'Pembangunan Mushola Baru',
            'Kegiatan Senam Pagi',
            'Perbaikan Jalan Kampung',
            'Bakti Sosial untuk Lansia',
            'Workshop Daur Ulang Sampah',
            'Renovasi Balai Warga'
        ];
        
        $judulLaporanNegatif = [
            'Pencurian Sepeda Motor',
            'Kecelakaan Lalu Lintas',
            'Kebakaran Rumah Warga',
            'Vandalisme di Taman',
            'Banjir di Pemukiman',
            'Konflik Antar Warga',
            'Jalan Rusak Berlubang',
            'Gangguan Ketertiban',
            'Sampah Menumpuk',
            'Pelanggaran Parkir'
        ];
        
        $deskripsiPositif = [
            'Kegiatan gotong royong pembersihan lingkungan berjalan lancar dengan partisipasi warga',
            'Pelaksanaan posyandu rutin untuk kesehatan balita dan ibu hamil',
            'Festival budaya untuk melestarikan tradisi dan kesenian daerah',
            'Program penghijauan dengan menanam berbagai jenis pohon',
            'Pembangunan mushola untuk memfasilitasi ibadah warga',
            'Kegiatan senam pagi untuk meningkatkan kesehatan masyarakat',
            'Perbaikan infrastruktur jalan untuk kenyamanan warga',
            'Kegiatan sosial untuk membantu dan memperhatikan lansia',
            'Edukasi dan praktek daur ulang sampah untuk lingkungan',
            'Renovasi balai warga untuk kegiatan kemasyarakatan'
        ];
        
        $deskripsiNegatif = [
            'Terjadi pencurian kendaraan bermotor di area parkir',
            'Kecelakaan lalu lintas mengakibatkan kemacetan dan korban',
            'Kebakaran merusak properti dan mengancam keselamatan',
            'Aksi vandalisme merusak fasilitas umum',
            'Banjir menggenangi pemukiman warga',
            'Terjadi konflik yang mengganggu keharmonisan',
            'Kondisi jalan rusak membahayakan pengguna',
            'Gangguan ketertiban mengganggu kenyamanan warga',
            'Penumpukan sampah mencemari lingkungan',
            'Pelanggaran aturan parkir mengganggu akses jalan'
        ];

        $laporanData = [];
        $regionStats = []; // Untuk tracking distribusi laporan per wilayah

        for ($i = 1; $i <= 100; $i++) { // Tingkatkan jadi 100 untuk lebih banyak data
            $isPositive = rand(0, 1); // 50% chance positif atau negatif
            $statusVerif = $statusVerifikasi[array_rand($statusVerifikasi)];
            
            // Status penanganan hanya diset jika status verifikasi "Diverifikasi"
            $statusPenang = null;
            if ($statusVerif === 'Diverifikasi') {
                $statusPenang = $statusPenanganan[array_rand($statusPenanganan)];
            }
            
            // Alternating antara Warga dan Pengurus Lingkungan
            $isWarga = ($i % 2 == 1); // Ganjil = Warga, Genap = Pengurus
            
            $wargaUsername = null;
            $pengurusUsername = null;
            $tipe = '';
            
            if ($isWarga && !empty($wargaUsernames)) {
                $wargaUsername = $wargaUsernames[array_rand($wargaUsernames)];
                $tipe = 'Warga';
            } elseif (!$isWarga && !empty($pengurusUsernames)) {
                $pengurusUsername = $pengurusUsernames[array_rand($pengurusUsernames)];
                $tipe = 'Pengurus Lingkungan';
            }
            
            // Pilih kategori berdasarkan jenis
            $kategori = $isPositive ? 
                $kategoriPositif[array_rand($kategoriPositif)] : 
                $kategoriNegatif[array_rand($kategoriNegatif)];
            
            // Pilih judul dan deskripsi
            $judul = $isPositive ? 
                $judulLaporanPositif[array_rand($judulLaporanPositif)] : 
                $judulLaporanNegatif[array_rand($judulLaporanNegatif)];
                
            $deskripsi = $isPositive ? 
                $deskripsiPositif[array_rand($deskripsiPositif)] : 
                $deskripsiNegatif[array_rand($deskripsiNegatif)];
            
            // Generate tanggal random dalam 3 bulan terakhir
            $tanggal = Carbon::now()->subDays(rand(1, 90))->format('Y-m-d');
            
            // Pilih wilayah secara random
            $selectedRegion = $tempatKejadian[array_rand($tempatKejadian)];
            
            // Generate koordinat yang sesuai dengan wilayah
            $coordinates = $this->generateCoordinatesInRegion($selectedRegion);
            
            // Verifikasi koordinat (untuk debugging)
            $detectedRegion = $this->getRegionFromCoordinates(
                $coordinates['latitude'], 
                $coordinates['longitude']
            );
            
            // Update stats untuk tracking
            if (!isset($regionStats[$selectedRegion])) {
                $regionStats[$selectedRegion] = 0;
            }
            $regionStats[$selectedRegion]++;
            
            $laporan = [
                'judul_laporan' => $judul . ' RT ' . sprintf('%02d', rand(1, 15)),
                'deskripsi_laporan' => $deskripsi,
                'tanggal_pelaporan' => $tanggal,
                'tempat_kejadian' => $selectedRegion, // Pastikan konsisten dengan koordinat
                'latitude' => $coordinates['latitude'],
                'longitude' => $coordinates['longitude'],
                'status_verifikasi' => $statusVerif,
                'status_penanganan' => $statusPenang,
                'tipe_pelapor' => $tipe,
                'warga_username' => $wargaUsername,
                'pengurus_lingkungan_username' => $pengurusUsername,
                'kategori_laporan' => $kategori,
                'time_laporan' => sprintf('%02d:%02d', rand(0, 23), rand(0, 59)) // Random time
            ];
            
            // Tambahkan deskripsi penanganan hanya jika status verifikasi "Diverifikasi" DAN status penanganan "Sudah ditangani"
            if ($statusVerif === 'Diverifikasi' && $statusPenang === 'Sudah ditangani') {
                $deskripsiPenanganan = [
                    'Masalah telah diselesaikan dengan koordinasi RT/RW',
                    'Telah ditindaklanjuti oleh pihak berwenang',
                    'Sudah dilakukan perbaikan dan normalisasi',
                    'Telah diselesaikan melalui musyawarah warga',
                    'Sudah ditangani oleh tim teknis terkait'
                ];
                $laporan['deskripsi_penanganan'] = $deskripsiPenanganan[array_rand($deskripsiPenanganan)];
            } else {
                $laporan['deskripsi_penanganan'] = null;
            }
            
            // Tambahkan deskripsi penolakan hanya jika ditolak
            if ($statusVerif === 'Ditolak') {
                $deskripsiPenolakan = [
                    'Laporan tidak sesuai dengan format yang diminta',
                    'Informasi yang diberikan kurang lengkap',
                    'Kejadian tidak terjadi di wilayah yang bersangkutan',
                    'Laporan duplikat dengan laporan sebelumnya',
                    'Data pendukung tidak memadai'
                ];
                $laporan['deskripsi_penolakan'] = $deskripsiPenolakan[array_rand($deskripsiPenolakan)];
            } else {
                $laporan['deskripsi_penolakan'] = null;
            }
            
            $laporanData[] = $laporan;
        }

        // Insert data ke database
        foreach ($laporanData as $laporan) {
            Laporan::create($laporan);
        }
        
        // Log distribusi untuk debugging
        echo "\n=== Distribusi Laporan per Wilayah ===\n";
        foreach ($regionStats as $region => $count) {
            echo "$region: $count laporan\n";
        }
        echo "Total: " . array_sum($regionStats) . " laporan\n";
    }
}
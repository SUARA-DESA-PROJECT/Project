<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Komentar;
use App\Models\Laporan;
use App\Models\Warga;
use App\Models\PengurusLingkungan;
use Carbon\Carbon;

class KomentarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua laporan, warga, dan pengurus
        $laporans = Laporan::all();
        $wargaUsernames = Warga::pluck('username')->toArray();
        $pengurusUsernames = PengurusLingkungan::pluck('username')->toArray();
        
        // Template komentar untuk laporan positif
        $komentarPositif = [
            'Sangat bagus! Kegiatan seperti ini perlu terus dikembangkan.',
            'Terima kasih atas inisiatif yang luar biasa ini.',
            'Semoga kegiatan ini bisa menjadi contoh untuk RT lainnya.',
            'Apresiasi tinggi untuk semua pihak yang terlibat.',
            'Program yang sangat bermanfaat untuk masyarakat.',
            'Luar biasa! Mari kita dukung kegiatan positif seperti ini.',
            'Kegiatan yang sangat menginspirasi, semoga berkelanjutan.',
            'Dengan gotong royong seperti ini, lingkungan kita akan lebih baik.',
            'Alhamdulillah, senang melihat partisipasi warga yang tinggi.',
            'Semoga bisa rutin dilaksanakan kegiatan seperti ini.',
            'Mantap! Ini contoh kebersamaan yang sesungguhnya.',
            'Bangga dengan kesadaran warga yang tinggi.',
        ];
        
        // Template komentar untuk laporan negatif
        $komentarNegatif = [
            'Semoga kejadian seperti ini tidak terulang lagi.',
            'Perlu peningkatan keamanan di area tersebut.',
            'Mari kita semua lebih waspada dan saling menjaga.',
            'Terima kasih laporannya, akan kami tindaklanjuti.',
            'Sudah koordinasi dengan RT/RW untuk penanganan.',
            'Perlu ada tindakan preventif untuk mencegah kejadian serupa.',
            'Mari bersama-sama menjaga keamanan lingkungan.',
            'Akan kita tingkatkan patroli di area tersebut.',
            'Terima kasih informasinya, sangat membantu.',
            'Perlu ada sosialisasi keamanan untuk warga.',
            'Kejadian ini mengingatkan kita untuk lebih hati-hati.',
            'Akan dikoordinasikan dengan pihak berwenang.',
        ];
        
        // Template komentar umum/netral
        $komentarUmum = [
            'Terima kasih atas laporannya.',
            'Informasi yang sangat berharga.',
            'Akan segera ditindaklanjuti.',
            'Apresiasi atas kepedulian terhadap lingkungan.',
            'Semoga masalah ini segera teratasi.',
            'Terima kasih sudah melapor.',
            'Noted, akan kita proses lebih lanjut.',
            'Informasi diterima dengan baik.',
            'Akan kita koordinasikan dengan pihak terkait.',
            'Terima kasih atas partisipasinya.',
        ];
        
        // Template komentar pengurus (lebih formal)
        $komentarPengurus = [
            'Terima kasih atas laporannya. Akan segera kami tindaklanjuti melalui jalur yang tepat.',
            'Laporan ini sudah kami terima dan akan dikoordinasikan dengan RT/RW setempat.',
            'Akan kami sampaikan ke forum rapat RT untuk dibahas bersama.',
            'Terima kasih informasinya. Akan kami koordinasikan dengan instansi terkait.',
            'Laporan akan kami proses sesuai dengan prosedur yang berlaku.',
            'Akan kami jadwalkan survei lapangan untuk menindaklanjuti laporan ini.',
            'Terima kasih. Akan kami koordinasikan dengan kepala lingkungan.',
            'Laporan diterima, akan kami bahas dalam rapat koordinasi mingguan.',
            'Akan kami lakukan verifikasi lapangan terlebih dahulu.',
            'Terima kasih laporannya. Akan segera kami proses sesuai prosedur.',
        ];
        
        $komentarData = [];
        
        foreach ($laporans as $laporan) {
            // Random jumlah komentar per laporan (1-4)
            $jumlahKomentar = rand(1, 4);
            
            // Tentukan jenis laporan berdasarkan kategori
            $isPositive = in_array($laporan->kategori_laporan, [
                'Kegiatan Sosial', 'Pembangunan', 'Kegiatan Budaya', 
                'Inisiatif Lingkungan', 'Kesehatan Masyarakat'
            ]);
            
            for ($i = 0; $i < $jumlahKomentar; $i++) {
                // Random apakah komentar dari warga atau pengurus (60% warga, 40% pengurus)
                $isFromWarga = rand(1, 100) <= 60;
                
                $username = null;
                $tipeUser = '';
                
                if ($isFromWarga && !empty($wargaUsernames)) {
                    $username = $wargaUsernames[array_rand($wargaUsernames)];
                    $tipeUser = 'warga';
                } elseif (!$isFromWarga && !empty($pengurusUsernames)) {
                    $username = $pengurusUsernames[array_rand($pengurusUsernames)];
                    $tipeUser = 'pengurus';
                }
                
                // Skip jika tidak ada username yang valid
                if (empty($username)) {
                    continue;
                }
                
                // Pilih template komentar berdasarkan jenis laporan dan tipe user
                $komentar = '';
                if ($tipeUser === 'pengurus') {
                    $komentar = $komentarPengurus[array_rand($komentarPengurus)];
                } elseif ($isPositive) {
                    $komentar = $komentarPositif[array_rand($komentarPositif)];
                } else {
                    // Mix antara komentar negatif dan umum untuk variasi
                    $allNegativeComments = array_merge($komentarNegatif, $komentarUmum);
                    $komentar = $allNegativeComments[array_rand($allNegativeComments)];
                }
                
                // Generate tanggal komentar (setelah tanggal laporan)
                $tanggalLaporan = Carbon::parse($laporan->tanggal_pelaporan);
                $tanggalKomentar = $tanggalLaporan->copy()->addDays(rand(0, 30))->format('Y-m-d');
                $waktuKomentar = sprintf('%02d:%02d:%02d', rand(0, 23), rand(0, 59), rand(0, 59));
                
                $komentarData[] = [
                    'laporan_id' => $laporan->id,        // Menggunakan id_laporan sesuai database
                    'isi_komentar' => $komentar,
                    'username' => $username,              // Menggunakan username tunggal
                    'tipe_user' => $tipeUser,            // Menggunakan tipe_user
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // Insert semua komentar ke database dengan batch insert untuk performa
        if (!empty($komentarData)) {
            Komentar::insert($komentarData);
            
            // Log hasil
            $totalKomentar = count($komentarData);
            $komentarWarga = collect($komentarData)->where('tipe_user', 'warga')->count();
            $komentarPengurus = collect($komentarData)->where('tipe_user', 'pengurus')->count();
            
            echo "\n=== Statistik Komentar ===\n";
            echo "Total Laporan: " . $laporans->count() . "\n";
            echo "Total Komentar: $totalKomentar\n";
            echo "Komentar dari Warga: $komentarWarga\n";
            echo "Komentar dari Pengurus: $komentarPengurus\n";
            echo "Rata-rata komentar per laporan: " . round($totalKomentar / $laporans->count(), 1) . "\n";
        } else {
            echo "Tidak ada komentar yang dibuat. Pastikan ada data Laporan, Warga, dan Pengurus.\n";
        }
    }
}
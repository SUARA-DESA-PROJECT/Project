<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Warga;
use App\Models\PengurusLingkungan;
use App\Models\Kategori;
use App\Models\Laporan;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            LocationSeeder::class,
        ]);

        // Create Pengurus Lingkungan
        $pengurusData = [
            [
                'username' => 'pengurus1',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Ahmad Subarjo',
                'nomor_telepon' => '081234567890',
                'alamat' => 'Jl. Melati No. 1, RT 01/RW 01'
            ],
            [
                'username' => 'pengurus2',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Siti Aminah',
                'nomor_telepon' => '081234567891',
                'alamat' => 'Jl. Mawar No. 2, RT 02/RW 01'
            ],
            [
                'username' => 'pengurus3',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Budi Santoso',
                'nomor_telepon' => '081234567892',
                'alamat' => 'Jl. Anggrek No. 3, RT 03/RW 01'
            ],
            [
                'username' => 'pengurus4',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Dewi Kartika',
                'nomor_telepon' => '081234567893',
                'alamat' => 'Jl. Flamboyan No. 4, RT 04/RW 01'
            ],
            [
                'username' => 'pengurus5',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Hendra Wijaya',
                'nomor_telepon' => '081234567894',
                'alamat' => 'Jl. Cempaka No. 5, RT 05/RW 01'
            ],
            [
                'username' => 'pengurus6',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Maya Sari',
                'nomor_telepon' => '081234567895',
                'alamat' => 'Jl. Teratai No. 6, RT 06/RW 01'
            ],
            [
                'username' => 'pengurus7',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Rudi Hartono',
                'nomor_telepon' => '081234567896',
                'alamat' => 'Jl. Lotus No. 7, RT 07/RW 01'
            ],
            [
                'username' => 'pengurus8',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Rina Susanti',
                'nomor_telepon' => '081234567897',
                'alamat' => 'Jl. Sakura No. 8, RT 08/RW 01'
            ]
        ];

        foreach ($pengurusData as $pengurus) {
            PengurusLingkungan::create($pengurus);
        }

        // Create Warga
        $wargaData = [
            [
                'username' => 'warga1',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Joko Widodo',
                'nomor_telepon' => '081345678901',
                'alamat' => 'Jl. Kenanga No. 1, RT 01/RW 02',
                'email' => 'joko.widodo@example.com'
            ],
            [
                'username' => 'warga2',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Sri Wahyuni',
                'nomor_telepon' => '081345678902',
                'alamat' => 'Jl. Dahlia No. 2, RT 02/RW 02',
                'email' => 'sri.wahyuni@example.com'
            ],
            [
                'username' => 'warga3',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Rudi Hermawan',
                'nomor_telepon' => '081345678903',
                'alamat' => 'Jl. Tulip No. 3, RT 03/RW 02',
                'email' => 'rudi.hermawan@example.com'
            ],
            [
                'username' => 'warga4',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Nina Septiani',
                'nomor_telepon' => '081345678904',
                'alamat' => 'Jl. Bougenville No. 4, RT 04/RW 02',
                'email' => 'nina.septiani@example.com'
            ],
            [
                'username' => 'warga5',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Agus Setiawan',
                'nomor_telepon' => '081345678905',
                'alamat' => 'Jl. Kamboja No. 5, RT 05/RW 02',
                'email' => 'agus.setiawan@example.com'
            ],
        ];

        foreach ($wargaData as $warga) {
            Warga::create($warga);
        }

        // Create Kategori
        $kategoriData = [
            // Kategori Negatif
            [
                'nama_kategori' => 'Kejahatan',
                'deskripsi_kategori' => 'Laporan terkait tindak kriminal seperti pencurian, perampokan, vandalisme, dan kejahatan lainnya di lingkungan.',
                'jenis_kategori' => 'Negatif'
            ],
            [
                'nama_kategori' => 'Kecelakaan',
                'deskripsi_kategori' => 'Laporan mengenai kecelakaan lalu lintas, kecelakaan kerja, atau kecelakaan lainnya yang terjadi di area lingkungan.',
                'jenis_kategori' => 'Negatif'
            ],
            [
                'nama_kategori' => 'Bencana Alam',
                'deskripsi_kategori' => 'Laporan tentang banjir, longsor, kebakaran, atau bencana alam lainnya yang mempengaruhi lingkungan.',
                'jenis_kategori' => 'Negatif'
            ],
            [
                'nama_kategori' => 'Pelanggaran Hukum',
                'deskripsi_kategori' => 'Laporan pelanggaran peraturan lingkungan, perizinan, ketertiban umum, atau pelanggaran hukum lainnya.',
                'jenis_kategori' => 'Negatif'
            ],
            [
                'nama_kategori' => 'Masalah Sosial',
                'deskripsi_kategori' => 'Laporan konflik warga, kenakalan remaja, gangguan ketertiban, atau permasalahan sosial lainnya.',
                'jenis_kategori' => 'Negatif'
            ],

            // Kategori Positif
            [
                'nama_kategori' => 'Kegiatan Sosial',
                'deskripsi_kategori' => 'Laporan kegiatan gotong royong, bakti sosial, atau kegiatan kemasyarakatan lainnya.',
                'jenis_kategori' => 'Positif'
            ],
            [
                'nama_kategori' => 'Pembangunan',
                'deskripsi_kategori' => 'Laporan kegiatan pembangunan infrastruktur, perbaikan fasilitas, atau pengembangan lingkungan.',
                'jenis_kategori' => 'Positif'
            ],
            [
                'nama_kategori' => 'Kegiatan Budaya',
                'deskripsi_kategori' => 'Laporan kegiatan seni, budaya, tradisi, atau acara adat istiadat di lingkungan.',
                'jenis_kategori' => 'Positif'
            ],
            [
                'nama_kategori' => 'Inisiatif Lingkungan',
                'deskripsi_kategori' => 'Laporan kegiatan penghijauan, kebersihan lingkungan, daur ulang, atau program ramah lingkungan.',
                'jenis_kategori' => 'Positif'
            ],
            [
                'nama_kategori' => 'Kesehatan Masyarakat',
                'deskripsi_kategori' => 'Laporan kegiatan posyandu, vaksinasi, penyuluhan kesehatan, atau program kesehatan masyarakat.',
                'jenis_kategori' => 'Positif'
            ]
        ];

        foreach ($kategoriData as $kategori) {
            Kategori::create($kategori);
        }

        // Create Laporan
        $laporanData = [
            [
                'judul_laporan' => 'Pencurian Sepeda Motor',
                'deskripsi_laporan' => 'Telah terjadi pencurian sepeda motor Honda Beat warna merah di depan warung RT 02',
                'tanggal_pelaporan' => '2024-03-19',
                'tempat_kejadian' => 'Buahbatu',
                'status_verifikasi' => 'Diverifikasi',
                'status_penanganan' => 'Sudah ditangani',
                'deskripsi_penanganan' => 'Sudah dilaporkan ke pihak kepolisian dan dalam proses penyelidikan',
                'tipe_pelapor' => 'Pengurus Lingkungan',
                'pengurus_lingkungan_username' => 'pengurus1',
                'kategori_laporan' => 'Kejahatan'
            ],
            [
                'judul_laporan' => 'Festival Budaya RT 03',
                'deskripsi_laporan' => 'Penyelenggaraan festival budaya dan pagelaran seni tradisional',
                'tanggal_pelaporan' => '2024-03-20',
                'tempat_kejadian' => 'Buahbatu',
                'status_verifikasi' => 'Belum Diverifikasi',
                'status_penanganan' => 'Belum ditangani',
                'tipe_pelapor' => 'Warga',
                'warga_username' => 'warga3',
                'kategori_laporan' => 'Kegiatan Budaya'
            ],
            [
                'judul_laporan' => 'Rencana perbaikan Jalan RT 04',
                'deskripsi_laporan' => 'Rencana perbaikan jalan berlubang dan pemasangan paving block',
                'tanggal_pelaporan' => '2024-03-21',
                'tempat_kejadian' => 'Cipagalo',
                'status_verifikasi' => 'Diverifikasi',
                'status_penanganan' => 'Belum ditangani',
                'tipe_pelapor' => 'Warga',
                'warga_username' => 'warga4',
                'kategori_laporan' => 'Pembangunan'
            ]
        ];

        foreach ($laporanData as $laporan) {
            Laporan::create($laporan);
        }
    }
}
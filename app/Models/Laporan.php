<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
<<<<<<< HEAD
{
    //
    use HasFactory;
=======
{    use HasFactory;
>>>>>>> main

    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
<<<<<<< HEAD
        'id_laporan',
=======
>>>>>>> main
        'judul_laporan',
        'deskripsi_laporan',
        'tanggal_pelaporan',
        'tempat_kejadian',
        'status_verifikasi',
        'status_penanganan',
        'deskripsi_penanganan',
        'tipe_pelapor',
        'pengurus_lingkungan_username',
        'warga_username',
<<<<<<< HEAD
        'kategori_laporan'
=======
        'kategori_laporan',
        'time_laporan' 
>>>>>>> main
    ];

    protected $casts = [
        'tanggal_pelaporan' => 'date',
        'status_verifikasi' => 'string',
<<<<<<< HEAD
        'status_penanganan' => 'string'
    ];

    // Laporan belongs to one Warga
=======
        'status_penanganan' => 'string',
        'time_laporan' => 'string' 
    ];

>>>>>>> main
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_username', 'username');
    }

<<<<<<< HEAD
    // Laporan belongs to one Pengurus Lingkungan
=======
>>>>>>> main
    public function pengurusLingkungan()
    {
        return $this->belongsTo(PengurusLingkungan::class, 'pengurus_lingkungan_username', 'username');
    }

<<<<<<< HEAD
    // Laporan belongs to one Kategori
=======
>>>>>>> main
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_laporan', 'nama_kategori');
    }
}

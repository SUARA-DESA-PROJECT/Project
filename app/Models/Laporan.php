<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{    use HasFactory;

    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
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
        'kategori_laporan',
        'time_laporan' 
    ];

    protected $casts = [
        'tanggal_pelaporan' => 'date',
        'status_verifikasi' => 'string',
        'status_penanganan' => 'string',
        'time_laporan' => 'string' 
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_username', 'username');
    }

    public function pengurusLingkungan()
    {
        return $this->belongsTo(PengurusLingkungan::class, 'pengurus_lingkungan_username', 'username');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_laporan', 'nama_kategori');
    }
}

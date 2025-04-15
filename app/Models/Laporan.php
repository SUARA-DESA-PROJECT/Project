<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    //
    use HasFactory;

    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'judul_laporan',
        'deskripsi_laporan',
        'tanggal_pelaporan',
        'tempat_kejadian',
        'status_penanganan',
        'deskripsi_penanganan',
        'kategori_laporan',
        'status_verifikasi',
        'tipe_pelapor',
        'pengurus_lingkungan_username',
        'warga_username'
    ];

    protected $casts = [
        'tanggal_pelaporan' => 'date',
        'status_verifikasi' => 'string',
        'status_penanganan' => 'string'
    ];

    // Laporan belongs to one Warga
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_username', 'username');
    }

    // Laporan belongs to one Pengurus Lingkungan
    public function pengurusLingkungan()
    {
        return $this->belongsTo(PengurusLingkungan::class, 'pengurus_lingkungan_username', 'username');
    }

    // Laporan belongs to one Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_laporan', 'nama_kategori');
    }
}

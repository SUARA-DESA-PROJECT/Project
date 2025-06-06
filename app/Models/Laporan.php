<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    
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
        'time_laporan',
        'deskripsi_penolakan'
    ];

    /**
     * Get the location associated with this laporan
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'tempat_kejadian', 'name');
    }

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_username', 'username');
    }

    public function pengurusLingkungan()
    {
        return $this->belongsTo(PengurusLingkungan::class, 'pengurus_lingkungan_username', 'username');
    }

    public function kategoriData()
    {
        return $this->belongsTo(Kategori::class, 'kategori_laporan', 'nama_kategori');
    }

    /**
     * Get the comments for this laporan.
     */
    public function komentars()
    {
        return $this->hasMany(Komentar::class, 'laporan_id');
    }
}
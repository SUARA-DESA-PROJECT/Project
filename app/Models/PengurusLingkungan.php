<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengurusLingkungan extends Model
{
    //
    use HasFactory;

    protected $table = 'pengurus_lingkungan';
    protected $primaryKey = 'username';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'nomor_telepon',
        'alamat'
    ];

    // One Pengurus Lingkungan has many Laporan
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'pengurus_lingkungan_username', 'username');
    }
}

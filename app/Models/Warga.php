<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    //
    use HasFactory;

    protected $table = 'warga';
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

    // One Warga has many Laporan
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'warga_username', 'username');
    }
}

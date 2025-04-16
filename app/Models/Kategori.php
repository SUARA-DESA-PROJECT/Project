<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'nama_kategori';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_kategori',
<<<<<<< HEAD
        'deskripsi_kategori',
        'jenis_kategori'
    ];

    // One Kategori has many Laporan
=======
        'jenis_laporan'
    ];

>>>>>>> main
    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'kategori_laporan', 'nama_kategori');
    }

<<<<<<< HEAD
    // Scope untuk filter kategori positif
=======
>>>>>>> main
    public function scopePositif($query)
    {
        return $query->where('jenis_kategori', 'Positif');
    }

<<<<<<< HEAD
    // Scope untuk filter kategori negatif
=======
>>>>>>> main
    public function scopeNegatif($query)
    {
        return $query->where('jenis_kategori', 'Negatif');
    }
} 
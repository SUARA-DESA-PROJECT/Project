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
        'jenis_laporan'
    ];

    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'kategori_laporan', 'nama_kategori');
    }

    public function scopePositif($query)
    {
        return $query->where('jenis_kategori', 'Positif');
    }

    public function scopeNegatif($query)
    {
        return $query->where('jenis_kategori', 'Negatif');
    }
} 
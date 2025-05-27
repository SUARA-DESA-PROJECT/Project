<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'latitude',
        'longitude'
    ];

    /**
     * Get all laporan records for this location
     */
    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'tempat_kejadian', 'name');
    }
}

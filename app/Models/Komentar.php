<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'komentar';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'laporan_id',
        'isi_komentar',
        'username',
        'tipe_user',
    ];

    /**
     * Get the laporan that owns the komentar.
     */
    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }
}
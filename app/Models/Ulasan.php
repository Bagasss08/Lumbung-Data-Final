<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';

    protected $fillable = [
        'lapak_id',
        'nama',
        'rating',
        'komentar',
    ];

    // Relasi ke Lapak
    public function lapak()
    {
        return $this->belongsTo(Lapak::class);
    }
}

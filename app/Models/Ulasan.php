<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';

    protected $fillable = [
        'lapak_id',
        'wisata_id', // 🔥 TAMBAH INI
        'nama',
        'rating',
        'komentar',
    ];

    public function lapak()
    {
        return $this->belongsTo(Lapak::class);
    }

    public function wisata()
    {
        return $this->belongsTo(Wisata::class);
    }
}
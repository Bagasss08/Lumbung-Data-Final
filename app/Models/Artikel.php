<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $table = 'artikel';

    protected $fillable = [
        'nama',
        'deskripsi',
        'gambar',
        'publish_at',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
    ];
}

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
    
    public function komentars()
    {
        return $this->hasMany(KomentarArtikel::class);
    }

    // Fungsi bantuan untuk menghitung komentar yang sudah disetujui
    public function approvedKomentars()
    {
        return $this->hasMany(KomentarArtikel::class)->where('status', 'approved');
    }
}

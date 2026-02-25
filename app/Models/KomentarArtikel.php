<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pengaduan;
use App\Models\KomentarArtikel;

class KomentarArtikel extends Model
{
    protected $fillable = [
        'artikel_id', 'nama', 'email', 'isi_komentar', 'status'
    ];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class);
    }
}
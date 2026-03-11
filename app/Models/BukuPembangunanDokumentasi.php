<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BukuPembangunanDokumentasi extends Model
{
    protected $table = 'buku_pembangunan_dokumentasi';

    protected $fillable = [
        'id_pembangunan',
        'tanggal',
        'persentase',
        'keterangan',
        'foto',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'persentase' => 'integer',
    ];

    /**
     * Relasi ke tabel pembangunan (parent)
     */
    public function pembangunan(): BelongsTo
    {
        return $this->belongsTo(BukuPembangunan::class, 'id_pembangunan');
    }
}


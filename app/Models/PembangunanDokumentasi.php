<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembangunanDokumentasi extends Model
{
    protected $table = 'pembangunan_dokumentasi';

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
     * Relasi ke tabel pembangunan (Parent)
     */
    public function pembangunan(): BelongsTo
    {
        return $this->belongsTo(Pembangunan::class, 'id_pembangunan');
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalisisKlasifikasi extends Model {
    protected $table = 'analisis_klasifikasi';

    protected $fillable = [
        'id_master',
        'nama',
        'skor_min',
        'skor_max',
        'warna',
        'urutan',
    ];

    protected $casts = [
        'skor_min' => 'decimal:2',
        'skor_max' => 'decimal:2',
    ];

    public function master(): BelongsTo {
        return $this->belongsTo(AnalisisMaster::class, 'id_master');
    }

    public function containsSkor(float $skor): bool {
        return $skor >= $this->skor_min && $skor <= $this->skor_max;
    }
}

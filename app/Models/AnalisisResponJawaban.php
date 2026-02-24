<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalisisResponJawaban extends Model {
    protected $table = 'analisis_respon_jawaban';

    protected $fillable = [
        'id_responden',
        'id_indikator',
        'id_jawaban',
        'jawaban_teks',
        'nilai',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
    ];

    public function responden(): BelongsTo {
        return $this->belongsTo(AnalisisResponden::class, 'id_responden');
    }

    public function indikator(): BelongsTo {
        return $this->belongsTo(AnalisisIndikator::class, 'id_indikator');
    }

    public function jawaban(): BelongsTo {
        return $this->belongsTo(AnalisisJawaban::class, 'id_jawaban');
    }
}

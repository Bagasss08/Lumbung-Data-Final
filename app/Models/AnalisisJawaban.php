<?php
// ── AnalisisJawaban ──────────────────────────────────────────────────────────
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalisisJawaban extends Model {
    protected $table = 'analisis_jawaban';

    protected $fillable = [
        'id_indikator',
        'jawaban',
        'nilai',
        'urutan',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
    ];

    public function indikator(): BelongsTo {
        return $this->belongsTo(AnalisisIndikator::class, 'id_indikator');
    }
}

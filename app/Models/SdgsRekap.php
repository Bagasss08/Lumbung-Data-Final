<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SdgsRekap extends Model {
    protected $table = 'sdgs_rekap';

    protected $fillable = ['tahun', 'skor_sdgs'];

    protected $casts = [
        'tahun'     => 'integer',
        'skor_sdgs' => 'float',
    ];

    public function tujuan(): HasMany {
        return $this->hasMany(SdgsTujuan::class, 'tahun', 'tahun');
    }
}

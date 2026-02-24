<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnalisisIndikator extends Model {
    protected $table = 'analisis_indikator';

    protected $fillable = [
        'id_master',
        'pertanyaan',
        'jenis',
        'aktif',
        'urutan',
    ];

    public function master(): BelongsTo {
        return $this->belongsTo(AnalisisMaster::class, 'id_master');
    }

    public function jawaban(): HasMany {
        return $this->hasMany(AnalisisJawaban::class, 'id_indikator')->orderBy('urutan');
    }

    public function responJawaban(): HasMany {
        return $this->hasMany(AnalisisResponJawaban::class, 'id_indikator');
    }

    public function isChoice(): bool {
        return in_array($this->jenis, ['OPTION', 'RADIO']);
    }

    public function getJenisLabelAttribute(): string {
        return match ($this->jenis) {
            'OPTION'   => 'Pilihan Ganda',
            'RADIO'    => 'Pilihan Tunggal',
            'TEXT'     => 'Teks Singkat',
            'TEXTAREA' => 'Teks Panjang',
            'DATE'     => 'Tanggal',
            'NUMBER'   => 'Angka',
            default    => $this->jenis,
        };
    }
}

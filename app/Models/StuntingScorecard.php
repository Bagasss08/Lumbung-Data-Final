<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StuntingScorecard extends Model {
    use HasFactory;

    protected $table = 'stunting_scorecard';

    protected $fillable = [
        'kia_id',
        'triwulan',
        'tahun',
        'fe90',
        'ifa',
        'pmtbumil',
        'pemeriksaan_kehamilan',
        'akt_bumil',
        'imunisasi_dasar',
        'pmtbalita',
        'vit_a',
        'stimulasi',
        'paud',
        'jkn',
        'air_bersih',
        'sanitasi',
        'perlindungan_sosial',
        'skor_konvergensi',
        'keterangan',
    ];

    protected $casts = [
        'triwulan' => 'integer',
        'tahun' => 'integer',
        'skor_konvergensi' => 'integer',
    ];

    // Field indikator untuk hitung skor otomatis
    private array $indikatorFields = [
        'fe90',
        'ifa',
        'pmtbumil',
        'pemeriksaan_kehamilan',
        'akt_bumil',
        'imunisasi_dasar',
        'pmtbalita',
        'vit_a',
        'stimulasi',
        'paud',
        'jkn',
        'air_bersih',
        'sanitasi',
        'perlindungan_sosial',
    ];

    // Hitung skor sebelum simpan
    protected static function booted() {
        static::saving(function ($model) {
            $skor = 0;
            foreach ($model->indikatorFields as $field) {
                if ($model->$field === 'ya') $skor++;
            }
            $model->skor_konvergensi = $skor;
        });
    }

    // Relasi
    public function kia() {
        return $this->belongsTo(Kia::class);
    }

    // Accessor
    public function getTriwulanLabelAttribute(): string {
        return 'Triwulan ' . $this->triwulan . ' / ' . $this->tahun;
    }

    public function getPersentaseSkorAttribute(): float {
        return round(($this->skor_konvergensi / 14) * 100, 1);
    }

    public function getKategoriSkorAttribute(): string {
        $persen = $this->persentase_skor;
        if ($persen >= 80) return 'Sangat Baik';
        if ($persen >= 60) return 'Baik';
        if ($persen >= 40) return 'Cukup';
        return 'Kurang';
    }
}

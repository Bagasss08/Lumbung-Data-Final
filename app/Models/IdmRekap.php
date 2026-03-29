<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IdmRekap extends Model {
    protected $table = 'idm_rekap';

    protected $fillable = [
        'tahun',
        'skor_idm',
        'status_idm',
        'skor_idm_minimal',
        'target_status',
        'skor_iks',
        'skor_ike',
        'skor_ikl',
    ];

    protected $casts = [
        'tahun'            => 'integer',
        'skor_idm'         => 'float',
        'skor_idm_minimal' => 'float',
        'skor_iks'         => 'float',
        'skor_ike'         => 'float',
        'skor_ikl'         => 'float',
    ];

    public function indikator(): HasMany {
        return $this->hasMany(IdmIndikator::class, 'tahun', 'tahun');
    }

    public function getPieChartDataAttribute(): array {
        $total = $this->skor_iks + $this->skor_ike + $this->skor_ikl;
        if ($total == 0) return ['iks' => 0, 'ike' => 0, 'ikl' => 0];

        return [
            'iks' => round(($this->skor_iks / $total) * 100, 1),
            'ike' => round(($this->skor_ike / $total) * 100, 1),
            'ikl' => round(($this->skor_ikl / $total) * 100, 1),
        ];
    }

    public function getBadgeColorAttribute(): string {
        return match ($this->status_idm) {
            'MANDIRI'           => 'success',
            'MAJU'              => 'warning',
            'BERKEMBANG'        => 'info',
            'TERTINGGAL'        => 'danger',
            'SANGAT TERTINGGAL' => 'dark',
            default             => 'secondary',
        };
    }

    public static function statusDariSkor(float $skor): string {
        if ($skor >= 0.8155) return 'MANDIRI';
        if ($skor >= 0.7072) return 'MAJU';
        if ($skor >= 0.5989) return 'BERKEMBANG';
        if ($skor >= 0.4907) return 'TERTINGGAL';
        return 'SANGAT TERTINGGAL';
    }

    public static function skorMinimalBerikutnya(string $status): array {
        return match ($status) {
            'SANGAT TERTINGGAL' => ['skor' => 0.4907, 'target' => 'TERTINGGAL'],
            'TERTINGGAL'        => ['skor' => 0.5989, 'target' => 'BERKEMBANG'],
            'BERKEMBANG'        => ['skor' => 0.7072, 'target' => 'MAJU'],
            'MAJU'              => ['skor' => 0.8155, 'target' => 'MANDIRI'],
            default             => ['skor' => 0.8155, 'target' => 'MANDIRI'],
        };
    }
}

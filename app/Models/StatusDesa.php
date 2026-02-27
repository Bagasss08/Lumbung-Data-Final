<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusDesa extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'status_desa';

    protected $fillable = [
        'nama_status',
        'tahun',
        'nilai',
        'status',
        'skor_ketahanan_sosial',
        'skor_ketahanan_ekonomi',
        'skor_ketahanan_ekologi',
        'status_target',
        'nilai_target',
        'keterangan',
        'dokumen',
        'config_id',
    ];

    protected $casts = [
        'tahun'                  => 'integer',
        'nilai'                  => 'decimal:4',
        'skor_ketahanan_sosial'  => 'decimal:4',
        'skor_ketahanan_ekonomi' => 'decimal:4',
        'skor_ketahanan_ekologi' => 'decimal:4',
        'nilai_target'           => 'decimal:4',
    ];

    // ── Konstanta Status ──────────────────────────────────────────

    const STATUS_LIST = [
        'Sangat Tertinggal',
        'Tertinggal',
        'Berkembang',
        'Maju',
        'Mandiri',
    ];

    /**
     * Rentang nilai per status (berdasarkan Permendesa No.2/2016)
     */
    const STATUS_RANGE = [
        'Sangat Tertinggal' => [0,      0.4907],
        'Tertinggal'        => [0.4908, 0.5989],
        'Berkembang'        => [0.5990, 0.7072],
        'Maju'              => [0.7073, 0.8155],
        'Mandiri'           => [0.8156, 1.0000],
    ];

    public static function daftarStatus(): array {
        return self::STATUS_LIST;
    }

    // ── Accessor / Computed ───────────────────────────────────────

    /**
     * Auto-hitung status dari nilai jika tidak diset manual
     */
    public function getStatusOtomatisAttribute(): string {
        foreach (self::STATUS_RANGE as $status => [$min, $max]) {
            if ($this->nilai >= $min && $this->nilai <= $max) {
                return $status;
            }
        }
        return 'Tidak Diketahui';
    }

    /**
     * Warna badge Tailwind berdasarkan status
     */
    public function getBadgeClassAttribute(): string {
        return match ($this->status) {
            'Mandiri'           => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            'Maju'              => 'bg-blue-100 text-blue-700 border-blue-200',
            'Berkembang'        => 'bg-yellow-100 text-yellow-700 border-yellow-200',
            'Tertinggal'        => 'bg-orange-100 text-orange-700 border-orange-200',
            'Sangat Tertinggal' => 'bg-red-100 text-red-700 border-red-200',
            default             => 'bg-gray-100 text-gray-600 border-gray-200',
        };
    }

    /**
     * Persentase kemajuan nilai (0–1 → 0–100%)
     */
    public function getProgressPersenAttribute(): float {
        return min(100, round((float) $this->nilai * 100, 2));
    }

    /**
     * Selisih nilai dengan target (positif = sudah melampaui, negatif = kurang)
     */
    public function getSelisihTargetAttribute(): ?float {
        if ($this->nilai_target === null) return null;
        return round((float) $this->nilai - (float) $this->nilai_target, 4);
    }

    // ── Scopes ───────────────────────────────────────────────────

    public function scopeTerbaru($query) {
        return $query->orderByDesc('tahun')->orderByDesc('id');
    }

    public function scopeTahun($query, int $tahun) {
        return $query->where('tahun', $tahun);
    }

    // ── Static Helpers ────────────────────────────────────────────

    /**
     * Data untuk grafik tren nilai per tahun
     * Returns: [ ['tahun' => 2022, 'nilai' => 0.65, 'status' => 'Berkembang'], ... ]
     */
    public static function dataTren(int $configId = 1): array {
        return static::where('config_id', $configId)
            ->orderBy('tahun')
            ->get([
                'tahun',
                'nilai',
                'status',
                'skor_ketahanan_sosial',
                'skor_ketahanan_ekonomi',
                'skor_ketahanan_ekologi'
            ])
            ->map(fn($r) => [
                'tahun'   => $r->tahun,
                'nilai'   => (float) $r->nilai,
                'status'  => $r->status,
                'iks'     => (float) $r->skor_ketahanan_sosial,
                'ike'     => (float) $r->skor_ketahanan_ekonomi,
                'ikl'     => (float) $r->skor_ketahanan_ekologi,
            ])
            ->values()
            ->toArray();
    }
}

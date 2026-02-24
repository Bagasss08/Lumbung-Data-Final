<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnalisisMaster extends Model {
    use SoftDeletes;

    protected $table = 'analisis_master';

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'subjek',
        'status',
        'lock',
        'periode',
    ];

    protected $casts = [
        'lock' => 'boolean',
    ];

    // ── Relasi ──────────────────────────────────────────────

    public function indikator(): HasMany {
        return $this->hasMany(AnalisisIndikator::class, 'id_master')->orderBy('urutan');
    }

    public function periodeList(): HasMany {
        return $this->hasMany(AnalisisPeriode::class, 'id_master');
    }

    public function klasifikasi(): HasMany {
        return $this->hasMany(AnalisisKlasifikasi::class, 'id_master')->orderBy('urutan');
    }

    public function responden(): HasMany {
        return $this->hasMany(AnalisisResponden::class, 'id_master');
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopeAktif($query) {
        return $query->where('status', 'AKTIF');
    }

    // ── Helpers ─────────────────────────────────────────────

    public function getSubjekLabelAttribute(): string {
        return match ($this->subjek) {
            'PENDUDUK'     => 'Penduduk',
            'KELUARGA'     => 'Keluarga',
            'RUMAH_TANGGA' => 'Rumah Tangga',
            'KELOMPOK'     => 'Kelompok',
            default        => $this->subjek,
        };
    }

    public function getStatusBadgeAttribute(): array {
        return $this->status === 'AKTIF'
            ? ['label' => 'Aktif',       'class' => 'bg-emerald-100 text-emerald-700']
            : ['label' => 'Tidak Aktif', 'class' => 'bg-gray-100 text-gray-600'];
    }

    public function getTotalRespondenAttribute(): int {
        return $this->responden()->count();
    }
}

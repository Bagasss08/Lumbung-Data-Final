<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerangkatDesa extends Model {
    use SoftDeletes;

    protected $table = 'perangkat_desa';

    protected $fillable = [
        'penduduk_id',
        'jabatan_id',
        'nama',
        'nik',
        'foto',
        'no_sk',
        'tanggal_sk',
        'periode_mulai',
        'periode_selesai',
        'status',
        'keterangan',
        'urutan',
    ];

    protected $casts = [
        'tanggal_sk'      => 'date',
        'periode_mulai'   => 'date',
        'periode_selesai' => 'date',
    ];

    // ── Constants ──────────────────────────────────────────────
    const STATUS_AKTIF    = '1';
    const STATUS_NONAKTIF = '2';

    // ── Relationships ──────────────────────────────────────────
    public function jabatan() {
        return $this->belongsTo(JabatanPerangkat::class, 'jabatan_id');
    }

    public function penduduk() {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    // ── Accessors ──────────────────────────────────────────────
    public function getLabelStatusAttribute(): string {
        return $this->status === self::STATUS_AKTIF ? 'Aktif' : 'Non-Aktif';
    }

    public function getBadgeStatusAttribute(): string {
        return $this->status === self::STATUS_AKTIF
            ? 'bg-emerald-100 text-emerald-700'
            : 'bg-red-100 text-red-600';
    }

    public function getFotoUrlAttribute(): string {
        if ($this->foto && file_exists(public_path('storage/' . $this->foto))) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-avatar.png');
    }

    public function getPeriodeAttribute(): string {
        if ($this->periode_mulai && $this->periode_selesai) {
            return $this->periode_mulai->format('d/m/Y') . ' – ' . $this->periode_selesai->format('d/m/Y');
        }
        return '-';
    }

    // ── Scopes ─────────────────────────────────────────────────
    public function scopeAktif($query) {
        return $query->where('status', self::STATUS_AKTIF);
    }

    public function scopeOrderedByUrutan($query) {
        return $query->orderBy('urutan')->orderBy('id');
    }
}

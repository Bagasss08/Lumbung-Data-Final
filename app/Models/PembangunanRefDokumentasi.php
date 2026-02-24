<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Dokumentasi Kegiatan Pembangunan.
 * Nama tabel: pembangunan_ref_dokumentasi (PERSIS OpenSID)
 *
 * Kolom `persentase` adalah tempat menyimpan progres pembangunan.
 * Ini berbeda dari sistem biasa — progres TIDAK ada di tabel pembangunan,
 * melainkan di setiap record dokumentasi yang ditambahkan.
 */
class PembangunanRefDokumentasi extends Model {
    protected $table = 'pembangunan_ref_dokumentasi';

    protected $fillable = [
        'id_pembangunan',
        'judul',
        'foto',
        'persentase',
        'tanggal',
        'uraian',
    ];

    protected $casts = [
        'tanggal'    => 'date',
        'persentase' => 'integer',
    ];

    // ──────────────────────────────────────────────────────────
    // Relations
    // ──────────────────────────────────────────────────────────

    public function pembangunan(): BelongsTo {
        return $this->belongsTo(Pembangunan::class, 'id_pembangunan');
    }

    // ──────────────────────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────────────────────

    public function getFotoUrlAttribute(): ?string {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }

    /**
     * Badge warna berdasarkan persentase.
     */
    public function getPersentaseBadgeAttribute(): string {
        $pct = $this->persentase;

        $color = match (true) {
            $pct >= 100 => 'emerald',
            $pct >= 75  => 'blue',
            $pct >= 50  => 'indigo',
            $pct >= 25  => 'amber',
            default     => 'gray',
        };

        return "<span class=\"inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-{$color}-100 text-{$color}-700\">{$pct}%</span>";
    }
}

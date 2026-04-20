<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenPenduduk extends Model {
    protected $table = 'dokumen_penduduk';

    protected $fillable = [
        'penduduk_id',
        'nama_dokumen',
        'jenis_dokumen',
        'file_path',
        'mime_type',
        'ukuran',
        'uploaded_by',
    ];

    protected $casts = [
        'ukuran'      => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // ── Relasi ────────────────────────────────────────────────────────────
    public function penduduk(): BelongsTo {
        return $this->belongsTo(Penduduk::class);
    }

    public function uploader(): BelongsTo {
        return $this->belongsTo(\App\Models\User::class, 'uploaded_by');
    }

    // ── Accessors ─────────────────────────────────────────────────────────
    /**
     * Ukuran file dalam format human-readable (KB / MB)
     */
    public function getUkuranReadableAttribute(): string {
        if (!$this->ukuran) return '-';
        if ($this->ukuran >= 1_048_576) {
            return number_format($this->ukuran / 1_048_576, 2) . ' MB';
        }
        return number_format($this->ukuran / 1_024, 1) . ' KB';
    }

    /**
     * Apakah file ini berupa gambar?
     */
    public function getIsImageAttribute(): bool {
        return in_array($this->mime_type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }

    /**
     * Apakah file ini berupa PDF?
     */
    public function getIsPdfAttribute(): bool {
        return $this->mime_type === 'application/pdf';
    }
}
    
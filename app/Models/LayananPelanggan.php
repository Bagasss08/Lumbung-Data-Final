<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LayananPelanggan extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'layanan_pelanggan';

    protected $fillable = [
        'nama_layanan',
        'jenis_layanan',
        'deskripsi',
        'persyaratan',
        'penanggung_jawab',
        'waktu_penyelesaian',
        'biaya',
        'status',
        'urutan',
        'surat_format_id',
        'kode_layanan',
        'dasar_hukum',
        'config_id',
    ];

    protected $casts = [
        'urutan'          => 'integer',
        'surat_format_id' => 'integer',
    ];

    public static function daftarJenis(): array {
        return [
            'Administrasi Kependudukan',
            'Administrasi Pertanahan',
            'Sosial',
            'Kesehatan',
            'Ekonomi',
            'Pendidikan',
            'Keamanan & Ketertiban',
            'Lainnya',
        ];
    }

    // ── Relasi ke SuratFormat (opsional) ─────────────────────────

    /**
     * Cek apakah modul surat tersedia — dilakukan sekali, di-cache.
     */
    public static function modulSuratTersedia(): bool {
        static $cache = null;

        if ($cache === null) {
            try {
                $cache = class_exists(\App\Models\SuratFormat::class)
                    && \Illuminate\Support\Facades\Schema::hasTable('surat_format');
            } catch (\Throwable $e) {
                $cache = false;
            }
        }

        return $cache;
    }

    /**
     * Relasi ke SuratFormat — hanya jika modul ada.
     * Panggil: $layanan->suratFormat (sudah aman, tidak error)
     */
    public function suratFormat() {
        if (!static::modulSuratTersedia()) {
            // Kembalikan null-object agar ->suratFormat tidak error
            return $this->belongsTo(self::class, 'surat_format_id')
                ->whereRaw('0 = 1'); // selalu null
        }

        return $this->belongsTo(\App\Models\SuratFormat::class, 'surat_format_id');
    }

    // ── Accessor ─────────────────────────────────────────────────

    public function getMembutuhkanSuratAttribute(): bool {
        return $this->surat_format_id !== null;
    }

    public function getPersyaratanArrayAttribute(): array {
        if (!$this->persyaratan) return [];

        return collect(explode("\n", $this->persyaratan))
            ->map(fn($s) => trim($s))
            ->filter()
            ->values()
            ->toArray();
    }

    // ── Scopes ───────────────────────────────────────────────────

    public function scopeAktif($query) {
        return $query->where('status', 'aktif');
    }

    public function scopeUrut($query) {
        return $query->orderBy('urutan')->orderBy('nama_layanan');
    }
}

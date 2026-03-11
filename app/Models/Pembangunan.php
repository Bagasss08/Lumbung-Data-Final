<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Pembangunan - untuk tabel pembangunan (Struktur OpenSID)
 * 
 * Kolom sesuai tabel asli OpenSID:
 * - id, config_id, id_bidang, id_sasaran, id_sumber_dana, id_lokasi
 * - tahun_anggaran (year), nama, pelaksana, volume, satuan, waktu
 * - mulai_pelaksanaan, akhir_pelaksanaan
 * - dana_pemerintah, dana_provinsi, dana_kabkota, swadaya, sumber_lain
 * - lat, lng, foto, dokumentasi, status, created_at, updated_at
 */
class Pembangunan extends Model
{
    protected $table = 'pembangunan';

    protected $fillable = [
        'config_id',
        'id_bidang',
        'id_sasaran',
        'id_sumber_dana',
        'id_lokasi',
        'tahun_anggaran',
        'nama',
        'pelaksana',
        'volume',
        'satuan',
        'waktu',
        'mulai_pelaksanaan',
        'akhir_pelaksanaan',
        'dana_pemerintah',
        'dana_provinsi',
        'dana_kabkota',
        'swadaya',
        'sumber_lain',
        'lat',
        'lng',
        'foto',
        'dokumentasi',
        'status',
    ];

    protected $casts = [
        'tahun_anggaran' => 'integer',
        'mulai_pelaksanaan' => 'date',
        'akhir_pelaksanaan' => 'date',
        'dana_pemerintah' => 'decimal:2',
        'dana_provinsi' => 'decimal:2',
        'dana_kabkota' => 'decimal:2',
        'swadaya' => 'decimal:2',
        'sumber_lain' => 'decimal:2',
        'lat' => 'decimal:10',
        'lng' => 'decimal:11',
        'status' => 'integer',
    ];

    // ──────────────────────────────────────────────────────────
    // Relations
    // ──────────────────────────────────────────────────────────

    /**
     * Relasi ke dokumentasi pembangunan (1:N)
     */
    public function dokumentasis(): HasMany
    {
        return $this->hasMany(PembangunanRefDokumentasi::class, 'id_pembangunan')
            ->orderBy('tanggal', 'desc');
    }

    /**
     * Relasi ke bidang pembangunan
     */
    public function bidang(): BelongsTo
    {
        return $this->belongsTo(RefPembangunanBidang::class, 'id_bidang');
    }

    /**
     * Relasi ke sasaran pembangunan
     */
    public function sasaran(): BelongsTo
    {
        return $this->belongsTo(RefPembangunanSasaran::class, 'id_sasaran');
    }

    /**
     * Relasi ke sumber dana
     */
    public function sumberDana(): BelongsTo
    {
        return $this->belongsTo(RefPembangunanSumberDana::class, 'id_sumber_dana');
    }

    // ──────────────────────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────────────────────

    /**
     * Scope untuk data aktif saja (status = 1)
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope untuk filter berdasarkan tahun anggaran
     */
    public function scopeTahun($query, $tahun)
    {
        return $query->where('tahun_anggaran', $tahun);
    }

    // ──────────────────────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────────────────────

    /**
     * Total anggaran = dana_pemerintah + dana_provinsi + dana_kabkota + swadaya + sumber_lain
     */
    public function getTotalAnggaranAttribute(): float
    {
        return (float) $this->dana_pemerintah 
            + (float) $this->dana_provinsi 
            + (float) $this->dana_kabkota 
            + (float) $this->swadaya 
            + (float) $this->sumber_lain;
    }

    /**
     * Persentase progres terkini diambil dari dokumentasi terakhir
     */
    public function getPersentaseTerkiniAttribute(): int
    {
        if ($this->relationLoaded('dokumentasis') && $this->dokumentasis->isNotEmpty()) {
            return (int) $this->dokumentasis->first()->persentase;
        }
        return 0;
    }

    /**
     * Foto URL accessor
     */
    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}


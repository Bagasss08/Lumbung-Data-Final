<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BukuPembangunan extends Model
{
    protected $table = 'buku_pembangunan';

    protected $fillable = [
        'config_id',
        'nama',
        'id_lokasi',
        'tahun_anggaran',
        'bidang',
        'sasaran',
        'volume',
        'satuan',
        'pelaksana',
        'sumber_dana',
        'anggaran_pemerintah',
        'anggaran_provinsi',
        'anggaran_kabkota',
        'anggaran_swakelola',
        'keterangan',
        'aktif',
    ];

    protected $casts = [
        'anggaran_pemerintah' => 'decimal:2',
        'anggaran_provinsi' => 'decimal:2',
        'anggaran_kabkota' => 'decimal:2',
        'anggaran_swakelola' => 'decimal:2',
        'aktif' => 'integer',
        'tahun_anggaran' => 'integer',
    ];

    /**
     * Relasi ke dokumentasi pembangunan (1:N)
     */
    public function dokumentasis(): HasMany
    {
        return $this->hasMany(BukuPembangunanDokumentasi::class, 'id_pembangunan')
            ->orderBy('tanggal', 'desc');
    }

    /**
     * Scope untuk data aktif saja
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', 1);
    }

    /**
     * Scope untuk filter berdasarkan tahun anggaran
     */
    public function scopeTahun($query, int $tahun)
    {
        return $query->where('tahun_anggaran', $tahun);
    }

    /**
     * Scope untuk data yang sudah selesai (aktif=1)
     */
    public function scopeSelesai($query)
    {
        return $query->where('aktif', 1);
    }

    /**
     * Total anggaran = pemerintah + provinsi + kabkota + swakelola
     */
    public function getTotalAnggaranAttribute(): float
    {
        return (float) $this->anggaran_pemerintah 
            + (float) $this->anggaran_provinsi 
            + (float) $this->anggaran_kabkota 
            + (float) $this->anggaran_swakelola;
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
}


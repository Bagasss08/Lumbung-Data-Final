<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KaderPemberdayaanMasyarakat extends Model
{
    protected $table = 'buku_kader_pemberdayaan_masyarakat';

    protected $fillable = [
        'nama',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'pendidikan',
        'bidang_tugas',
        'tahun_aktif',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * Scope untuk data aktif berdasarkan tahun aktif
     */
    public function scopeAktif($query)
    {
        return $query->whereNotNull('tahun_aktif');
    }

    /**
     * Scope untuk filter berdasarkan tahun aktif
     */
    public function scopeTahun($query, int $tahun)
    {
        return $query->where('tahun_aktif', $tahun);
    }

    /**
     * Scope untuk filter berdasarkan jenis kelamin
     */
    public function scopeJenisKelamin($query, string $jk)
    {
        return $query->where('jenis_kelamin', $jk);
    }

    /**
     * Accessor untuk label jenis kelamin
     */
    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}


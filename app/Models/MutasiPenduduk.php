<?php
// app/Models/MutasiPenduduk.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MutasiPenduduk extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'mutasi_penduduk';

    protected $fillable = [
        'penduduk_id',
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'no_kk',
        'jenis_mutasi',
        'tanggal_mutasi',
        'asal',
        'tujuan',
        'no_surat',
        'alasan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_lahir'  => 'date',
        'tanggal_mutasi' => 'date',
    ];

    // Relasi ke penduduk
    public function penduduk() {
        return $this->belongsTo(Penduduk::class);
    }

    // Scope filter jenis mutasi
    public function scopePindahMasuk($query) {
        return $query->where('jenis_mutasi', 'pindah_masuk');
    }

    public function scopePindahKeluar($query) {
        return $query->where('jenis_mutasi', 'pindah_keluar');
    }
}

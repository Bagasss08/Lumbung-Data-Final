<?php

namespace App\Models\InfoDesa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LembagaAnggota extends Model {
    use SoftDeletes;

    protected $table = 'lembaga_anggota';

    protected $fillable = [
        'lembaga_id',
        'penduduk_id',
        'no_anggota',
        'jabatan',
        'nomor_sk_jabatan',
        'nomor_sk_pengangkatan',
        'tanggal_sk_pengangkatan',
        'nomor_sk_pemberhentian',
        'tanggal_sk_pemberhentian',
        'masa_jabatan',
        'keterangan',
    ];

    public function lembaga() {
        return $this->belongsTo(LembagaDesa::class, 'lembaga_id');
    }

    public function penduduk() {
        return $this->belongsTo(\App\Models\Penduduk::class, 'penduduk_id');
    }
}   
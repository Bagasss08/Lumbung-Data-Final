<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model {
    protected $table = 'wilayah';

    protected $fillable = [
        'desa_id',
        'dusun',
        'rw',
        'rt',
        'ketua_rt',
        'ketua_rw',
        'jumlah_kk',
        'jumlah_penduduk',
        'laki_laki',
        'perempuan',
    ];

    public function penduduk() {
        return $this->hasMany(Penduduk::class);
    }

    public function keluarga() {
        return $this->hasMany(Keluarga::class);
    }

    public function desa() {
        return $this->belongsTo(Desa::class);
    }
}

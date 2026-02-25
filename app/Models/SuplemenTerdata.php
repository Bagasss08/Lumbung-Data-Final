<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuplemenTerdata extends Model {
    protected $table = 'tweb_suplemen_terdata';

    protected $fillable = [
        'id_suplemen',
        'id_pend',   // menyimpan NIK penduduk (string 16 digit)
        'no_kk',     // menyimpan No. KK (sasaran keluarga)
        'keterangan',
    ];

    // ─── Relasi ke Suplemen Induk ───────────────────────────────────
    public function suplemen() {
        return $this->belongsTo(DataSuplemen::class, 'id_suplemen');
    }

    // ─── Relasi ke Penduduk via NIK ─────────────────────────────────
    // id_pend di tabel ini menyimpan NIK → referensi ke kolom 'nik' di tabel penduduk
    public function penduduk() {
        return $this->belongsTo(Penduduk::class, 'id_pend', 'nik');
    }

    // ─── Relasi ke Keluarga via No. KK ─────────────────────────────
    // Untuk sasaran keluarga: no_kk → referensi ke kolom 'no_kk' di tabel keluarga
    public function keluarga() {
        return $this->belongsTo(Keluarga::class, 'no_kk', 'no_kk');
    }
}

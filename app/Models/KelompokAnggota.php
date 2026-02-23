<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokAnggota extends Model {
    use HasFactory;

    protected $table = 'kelompok_anggota';

    protected $fillable = [
        'id_kelompok',
        'nik',
        'jabatan',
        'tgl_masuk',
        'tgl_keluar',
        'aktif',
        'keterangan',
    ];

    protected $casts = [
        'tgl_masuk'  => 'date',
        'tgl_keluar' => 'date',
    ];

    public static $jabatanOptions = [
        'Ketua',
        'Wakil Ketua',
        'Sekretaris',
        'Bendahara',
        'Anggota',
    ];

    public function kelompok() {
        return $this->belongsTo(Kelompok::class, 'id_kelompok');
    }

    /**
     * Relasi ke Penduduk via NIK (bukan id)
     * Model Penduduk menggunakan kolom 'nik' sebagai natural key
     */
    public function penduduk() {
        return $this->belongsTo(Penduduk::class, 'nik', 'nik');
    }

    /**
     * Accessor: ambil nama penduduk dari relasi
     */
    public function getNamaPendudukAttribute(): string {
        return optional($this->penduduk)->nama ?? '-';
    }
}

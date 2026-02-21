<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KehadiranBulanan extends Model {
    protected $table      = 'kehadiran_bulanan';
    protected $primaryKey = 'id';
    public    $timestamps = true;

    protected $fillable = [
        'id_pegawai',
        'bulan',
        'tahun',
        'jumlah_hadir',
        'jumlah_izin',
        'jumlah_sakit',      // ✅ TAMBAH INI
        'jumlah_cuti',       // ✅ TAMBAH INI
        'jumlah_alpha',
        'jumlah_dinas_luar',
        'total_hari_kerja',
        'presentase_kehadiran',
    ];

    protected $casts = [
        'bulan' => 'integer', 
        'presentase_kehadiran' => 'float',
    ];

    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id');
    }
}

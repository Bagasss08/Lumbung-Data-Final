<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KehadiranTahunan extends Model {
    use HasFactory;

    protected $table = 'kehadiran_tahunan';

    protected $fillable = [
        'id_pegawai',
        'tahun',
        'total_hari_kerja',
        'total_hadir',
        'total_tidak_hadir',
        'presentase_kehadiran',
        'catatan_evaluasi',
    ];

    protected $casts = [
        'presentase_kehadiran' => 'decimal:2',
    ];

    // Relasi ke pegawai
    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}

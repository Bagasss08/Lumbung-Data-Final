<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekapitulasi extends Model {
    use HasFactory;

    protected $table = 'kehadiran_harian';

    protected $fillable = [
        'id_pegawai',
        'tanggal',
        'hari',
        'jam_masuk',
        'jam_pulang',
        'id_jenis_kehadiran',
        'lokasi_absen',
        'metode_absen',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i',
        'jam_pulang' => 'datetime:H:i',
    ];

    // Relasi ke pegawai
    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    // Relasi ke jenis kehadiran
    public function jenisKehadiran() {
        return $this->belongsTo(JenisKehadiran::class, 'id_jenis_kehadiran');
    }
}

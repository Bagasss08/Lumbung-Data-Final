<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keterangan extends Model {
    use HasFactory;

    protected $table = 'keterangan';

    protected $fillable = [
        'id_pegawai',
        'jenis_absensi',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'surat_pendukung',
        'status_persetujuan',
        'pejabar_penyetuju',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    // Relasi ke pegawai
    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}

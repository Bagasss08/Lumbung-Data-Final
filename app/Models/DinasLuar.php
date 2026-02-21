<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DinasLuar extends Model {
    use HasFactory;

    protected $table = 'dinas_luar';

    protected $fillable = [
        'id_pegawai',
        'nama_kegiatan',
        'lokasi_kegiatan',
        'tanggal_selesai',
        'instasi_tujuan',
        'surat_tugas',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_selesai' => 'date',
    ];

    // Relasi ke pegawai
    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPermohonan extends Model
{
    protected $table = 'surat_permohonan';
    protected $guarded = ['id'];

    // Casting JSON untuk kolom data_isian (agar otomatis menjadi array di PHP)
    protected $casts = [
        'data_isian' => 'array',
        'tanggal_permohonan' => 'date'
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasifikasiSurat extends Model
{
    use HasFactory;

    protected $table = 'klasifikasi_surats';

    protected $fillable = [
        'kode',
        'nama_klasifikasi',
        'kategori',
        'retensi_aktif',
        'retensi_inaktif',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'status' => 'boolean',
        'retensi_aktif' => 'integer',
        'retensi_inaktif' => 'integer',
    ];
}

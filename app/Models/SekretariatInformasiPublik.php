<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SekretariatInformasiPublik extends Model {
    use HasFactory;

    protected $table = 'sekretariat_informasi_publik';

    protected $fillable = [
        'judul_dokumen',
        'tipe_dokumen',
        'unggah_dokumen',
        'retensi_dokumen',
        'satuan_retensi',
        'kategori_info_publik',
        'keterangan',
        'tahun',
        'tanggal_terbit',
        'status_terbit',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tahun' => 'integer',
        'retensi_dokumen' => 'integer',
    ];
}

<?php
// app/Models/LaporanPenduduk.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPenduduk extends Model {
    protected $table = 'laporan_penduduk';

    protected $fillable = [
        'judul',
        'tahun',
        'bulan',
        'file',
        'tgl_upload',
        'tgl_kirim',
    ];

    protected $casts = [
        'tgl_upload' => 'datetime',
        'tgl_kirim'  => 'datetime',
        'tahun'      => 'integer',
        'bulan'      => 'integer',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model {
    use HasFactory;

    protected $fillable = [
        'nomor_dokumen',
        'tanggal_dokumen',
        'nama_dokumen',
        'jenis_dokumen',
        'lokasi_arsip',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_dokumen' => 'date',
    ];
}

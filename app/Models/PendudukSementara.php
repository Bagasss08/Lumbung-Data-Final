<?php
// app/Models/PendudukSementara.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendudukSementara extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'penduduk_sementara';

    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pekerjaan',
        'kewarganegaraan',
        'asal_daerah',
        'tujuan_kedatangan',
        'tanggal_datang',
        'tanggal_pergi',
        'no_surat_ket',
        'tempat_menginap',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_lahir'  => 'date',
        'tanggal_datang' => 'date',
        'tanggal_pergi'  => 'date',
    ];

    // Masih berada di desa (belum pergi)
    public function scopeMasihAda($query) {
        return $query->whereNull('tanggal_pergi');
    }

    public function scopeSudahPergi($query) {
        return $query->whereNotNull('tanggal_pergi');
    }
}

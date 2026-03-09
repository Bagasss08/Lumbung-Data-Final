<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuKeputusan extends Model
{
    use HasFactory;

    // Menyesuaikan dengan nama tabel di migration
    protected $table = 'buku_keputusan';

    // Mengizinkan mass assignment untuk kolom-kolom ini
    protected $fillable = [
        'nomor_keputusan',
        'tanggal_keputusan',
        'tentang',
        'uraian_singkat',
        'nomor_dilaporkan',
        'tanggal_dilaporkan',
        'keterangan',
    ];
}
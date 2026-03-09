<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuEkspedisi extends Model
{
    use HasFactory;

    protected $table = 'buku_ekspedisi';

    protected $fillable = [
        'tanggal_pengiriman', 'tanggal_surat', 'nomor_surat', 
        'isi_singkat', 'tujuan', 'keterangan'
    ];
}
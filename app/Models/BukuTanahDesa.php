<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTanahDesa extends Model
{
    use HasFactory;

    protected $table = 'buku_tanah_desa';

    protected $fillable = [
        'nama_pemilik', 'luas_tanah', 'status_hak_tanah', 
        'penggunaan_tanah', 'letak_tanah', 'keterangan'
    ];
}
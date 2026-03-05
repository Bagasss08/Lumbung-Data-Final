<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaDesa extends Model
{
    use HasFactory;

    protected $table = 'rencana_desa';

    protected $fillable = [
        'nama_proyek',
        'lokasi',
        'dana_pemerintah',
        'dana_provinsi',
        'dana_kab_kota',
        'dana_swadaya',
        'jumlah_total',
        'pelaksana',
        'manfaat',
        'keterangan',
    ];
}
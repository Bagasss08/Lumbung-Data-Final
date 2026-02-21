<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    protected $table = 'hari_libur';

    protected $fillable = [
        'tanggal',
        'nama_libur',
        'jenis',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public $timestamps = true;
}

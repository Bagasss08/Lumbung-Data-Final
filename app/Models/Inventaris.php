<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $fillable = [
        'nama_barang',
        'deskripsi',
        'kategori',
        'jumlah',
        'kondisi',
        'lokasi',
        'harga_perolehan',
        'tanggal_perolehan',
        'sumber_perolehan',
        'keterangan'
    ];

    protected $casts = [
        'harga_perolehan' => 'decimal:2',
        'tanggal_perolehan' => 'date',
        'jumlah' => 'integer'
    ];
}

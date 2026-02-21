<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiAnggaran extends Model {
    protected $table = 'realisasi_anggaran';

    protected $fillable = [
        'apbdes_id',
        'tanggal',
        'jumlah',
        'keterangan',
        'bukti'
    ];

    public function apbdes() {
        return $this->belongsTo(Apbdes::class, 'apbdes_id');
    }
}

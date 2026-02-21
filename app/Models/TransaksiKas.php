<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKas extends Model {
    protected $table = 'transaksi_kas';

    protected $fillable = [
        'kas_id',
        'realisasi_id',
        'tanggal',
        'tipe',
        'jumlah',
        'keterangan'
    ];

    public function kas() {
        return $this->belongsTo(KasDesa::class, 'kas_id');
    }

    public function realisasi() {
        return $this->belongsTo(RealisasiAnggaran::class, 'realisasi_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanAnggaran extends Model {
    protected $table = 'kegiatan_anggaran';

    protected $fillable = [
        'bidang_id',
        'nama_kegiatan',
        'kode',  // tambahkan jika pakai Opsi A pada masalah 2
    ];

    public function bidang() {
        return $this->belongsTo(BidangAnggaran::class, 'bidang_id');
    }

    public function apbdes() {
        return $this->hasMany(Apbdes::class, 'kegiatan_id');
    }
}

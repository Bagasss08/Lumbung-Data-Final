<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apbdes extends Model {
    protected $table = 'apbdes';

    protected $fillable = [
        'tahun_id',
        'kegiatan_id',
        'sumber_dana_id',
        'anggaran',
        'kategori',  // ✅ TAMBAH INI
    ];

    protected $casts = [
        'anggaran' => 'integer',
    ];

    public function tahun() {
        return $this->belongsTo(TahunAnggaran::class, 'tahun_id');
    }

    // ✅ GANTI NAMA dari kegiatan() ke kegiatanAnggaran() agar cocok dengan view
    public function kegiatanAnggaran() {
        return $this->belongsTo(KegiatanAnggaran::class, 'kegiatan_id');
    }

    public function sumberDana() {
        return $this->belongsTo(SumberDana::class, 'sumber_dana_id');
    }

    public function realisasi() {
        return $this->hasMany(RealisasiAnggaran::class, 'apbdes_id');
    }

    // ✅ Accessor untuk total realisasi (dipakai di view)
    public function getTotalRealisasiAttribute() {
        return $this->realisasi->sum('jumlah');
    }
}

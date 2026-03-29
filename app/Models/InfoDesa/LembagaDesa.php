<?php

namespace App\Models\InfoDesa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LembagaDesa extends Model {
    use SoftDeletes;

    protected $table = 'lembaga_desas';

    protected $fillable = [
        'kategori_id',
        'nama',
        'kode',
        'no_sk',
        'ketua',
        'jumlah_anggota',
        'deskripsi',
        'logo',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function kategori() {
        return $this->belongsTo(LembagaKategori::class, 'kategori_id');
    }

    // Tambahkan ini
    public function anggota() {
        return $this->hasMany(LembagaAnggota::class, 'lembaga_id');
    }
}

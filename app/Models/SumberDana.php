<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SumberDana extends Model {
    protected $table = 'sumber_dana';

    // ⚠️ Perhatian: kolom di migration adalah 'nama_sumber', BUKAN 'nama'
    protected $fillable = ['nama_sumber', 'keterangan'];

    public function apbdes() {
        return $this->hasMany(Apbdes::class, 'sumber_dana_id');
    }
}

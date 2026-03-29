<?php

namespace App\Models\InfoDesa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LembagaKategori extends Model
{
    use SoftDeletes;

    protected $table = 'lembaga_kategoris';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function lembagaDesa()
    {
        return $this->hasMany(LembagaDesa::class, 'kategori_id');
    }

    public function getJumlahLembagaAttribute()
    {
        return $this->lembagaDesa()->count();
    }
}

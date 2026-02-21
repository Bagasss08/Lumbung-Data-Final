<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;

    protected $table = 'desa';

    protected $fillable = [
        'kode_desa',
        'nama_desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'luas_wilayah',
        'jumlah_penduduk',
        'jumlah_kk',
        'klasifikasi_desa',
        'alamat_kantor',
        'telp',
        'email',
        'website',
        'logo',
    ];

    public function wilayahs()
    {
        return $this->hasMany(Wilayah::class);
    }
}

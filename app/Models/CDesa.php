<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CDesa extends Model
{
    protected $table = 'c_desa';
    protected $guarded = ['id'];

    // Relasi ke Penduduk (Jika Warga Desa)
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    // Relasi ke tabel Persil
    public function persil()
    {
        return $this->hasMany(CDesaPersil::class, 'c_desa_id');
    }

    // Accessor untuk mendapatkan Nama Pemilik secara dinamis
    public function getNamaPemilikAttribute()
    {
        return $this->jenis_pemilik == 'warga_desa' ? ($this->penduduk->nama ?? 'Tidak Ditemukan') : $this->nama_luar;
    }

    // Accessor untuk mendapatkan NIK Pemilik secara dinamis
    public function getNikPemilikAttribute()
    {
        return $this->jenis_pemilik == 'warga_desa' ? ($this->penduduk->nik ?? '-') : $this->nik_luar;
    }

    // Accessor untuk mendapatkan Alamat Pemilik
    public function getAlamatPemilikAttribute()
    {
        return $this->jenis_pemilik == 'warga_desa' ? ($this->penduduk->alamat ?? 'Desa Setempat') : $this->alamat_luar;
    }
}

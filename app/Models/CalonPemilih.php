<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalonPemilih extends Model {
    protected $table = 'tweb_calon_pemilih';

    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'rt',
        'rw',
        'dusun',
        'status_perkawinan',
        'no_kk',
        'keterangan',
        'aktif',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'aktif'         => 'boolean',
    ];

    public function getJenisKelaminLabelAttribute(): string {
        return $this->jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan';
    }

    public function getUmurAttribute(): int {
        return $this->tanggal_lahir
            ? $this->tanggal_lahir->age
            : 0;
    }
}

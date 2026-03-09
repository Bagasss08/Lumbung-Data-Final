<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKk extends Model {
    protected $table = 'anggota_kk';

    protected $fillable = [
        'buku_kk_id',
        'nik',
        'nama_lengkap',
        'hubungan_keluarga',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan',
        'pekerjaan',
        'status_perkawinan',
        'kewarganegaraan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function kartuKeluarga() {
        return $this->belongsTo(BukuKk::class, 'buku_kk_id');
    }
}

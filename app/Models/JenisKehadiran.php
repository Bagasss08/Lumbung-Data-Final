<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKehadiran extends Model {
    use HasFactory;

    protected $table = 'jenis_kehadiran';

    protected $fillable = [
        'kode_kehadiran',
        'nama_kehadiran',
        'keterangan',
    ];

    // Relasi ke kehadiran harian
    public function kehadiranHarian() {
        return $this->hasMany(KehadiranHarian::class, 'id_jenis_kehadiran');
    }
}

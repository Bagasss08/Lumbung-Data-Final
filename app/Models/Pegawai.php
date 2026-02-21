<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model {
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = [
        'nik',
        'nip',
        'nama_lengkap',
        'jabatan',
        'unit_kerja',
        'status_kepegawaian',
        'alamat',
        'nomor_telepon',
        'status_aktif',
    ];

    // Relasi ke kehadiran harian
    public function kehadiranHarian() {
        return $this->hasMany(KehadiranHarian::class, 'id_pegawai');
    }

    // Relasi ke keterangan
    public function keterangan() {
        return $this->hasMany(Keterangan::class, 'id_pegawai');
    }

    // Relasi ke dinas luar
    public function dinasLuar() {
        return $this->hasMany(DinasLuar::class, 'id_pegawai');
    }

    // Relasi ke kehadiran bulanan
    public function kehadiranBulanan() {
        return $this->hasMany(KehadiranBulanan::class, 'id_pegawai');
    }

    // Relasi ke kehadiran tahunan
    public function kehadiranTahunan() {
        return $this->hasMany(KehadiranTahunan::class, 'id_pegawai');
    }
}

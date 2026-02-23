<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model {
    
    protected $table = 'penduduk';

    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'golongan_darah',
        'agama',
        'pendidikan',
        'pekerjaan',
        'status_kawin',
        'status_hidup',
        'kewarganegaraan',
        'no_telp',
        'email',
        'alamat',
        'wilayah_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // ==================
    // RELASI — DATA DASAR & AKUN
    // ==================

    // Relasi ke User (Akun Login)
    public function user()
    {
        return $this->hasOne(User::class, 'penduduk_id');
    }

    // Relasi ke Wilayah
    public function wilayah() {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    // Relasi Many-to-many ke Keluarga via pivot keluarga_anggota
    public function keluargas() {
        return $this->belongsToMany(Keluarga::class, 'keluarga_anggota')
                    ->withPivot('hubungan_keluarga')
                    ->withTimestamps();
    }

    // Relasi Many-to-many ke RumahTangga via pivot rumah_tangga_penduduk
    public function rumahTanggas() {
        return $this->belongsToMany(RumahTangga::class, 'rumah_tangga_penduduk')
                    ->withPivot('hubungan_rumah_tangga')
                    ->withTimestamps();
    }

    // ==================
    // RELASI — KESEHATAN
    // ==================

    // Data KIA dimana penduduk ini sebagai IBU
    public function kiaAsIbu() {
        return $this->hasMany(Kia::class, 'penduduk_id_ibu');
    }

    // Data KIA dimana penduduk ini sebagai ANAK
    public function kiaAsAnak() {
        return $this->hasMany(Kia::class, 'penduduk_id_anak');
    }

    // Data vaksin yang diterima penduduk ini
    public function vaksins() {
        return $this->hasMany(Vaksin::class, 'penduduk_id');
    }

    // ==================
    // HELPER
    // ==================

    // Ambil keluarga utama (dimana dia jadi Kepala Keluarga)
    public function getKeluargaUtama() {
        return $this->keluargas()
            ->wherePivot('hubungan_keluarga', 'kepala_keluarga')
            ->first();
    }

    // Ambil rumah tangga utama (dimana dia jadi Kepala Rumah Tangga)
    public function getRumahTanggaUtama() {
        return $this->rumahTanggas()
            ->wherePivot('hubungan_rumah_tangga', 'kepala_rumah_tangga')
            ->first();
    }

    // ==================
    // RELASI — KELOMPOK
    // ==================

    /**
     * Kelompok yang diikuti penduduk ini (via tabel kelompok_anggota)
     */
    public function kelompokAnggota() {
        return $this->hasMany(\App\Models\KelompokAnggota::class, 'nik', 'nik');
    }

    /**
     * Shortcut: hanya kelompok yang masih aktif diikuti
     */
    public function kelompokAktif() {
        return $this->hasMany(\App\Models\KelompokAnggota::class, 'nik', 'nik')
            ->where('aktif', '1');
    }
}

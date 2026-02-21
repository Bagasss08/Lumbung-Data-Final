<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KehadiranHarian extends Model {
    protected $table      = 'kehadiran_harian';
    protected $primaryKey = 'id';
    public    $timestamps = true;

    protected $fillable = [
        'id_pegawai',
        'tanggal',
        'hari',
        'jam_masuk',
        'jam_pulang',
        'id_jenis_kehadiran',
        'lokasi_absen',
        'metode_absen',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // ── Relasi ke tabel pegawai ──────────────────────────────
    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id');
    }

    // ── Relasi ke tabel jenis_kehadiran ──────────────────────
    // Nama method: jenisKehadiran (camelCase)
    // Foreign key: id_jenis_kehadiran
    // Owner key  : id
    public function jenisKehadiran() {
        return $this->belongsTo(JenisKehadiran::class, 'id_jenis_kehadiran', 'id');
    }

    // ── Alias snake_case (opsional, untuk backward compat) ───
    public function jenis_kehadiran() {
        return $this->jenisKehadiran();
    }
}

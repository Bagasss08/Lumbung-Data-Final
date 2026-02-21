<?php
// app/Models/Pengaduan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model {
    protected $table = 'pengaduan';

    protected $fillable = [
        'penduduk_id',
        'nama',
        'email',
        'subjek',
        'isi',
        'lampiran',
        'ip_address',
        'status',
        'tanggapan',
        'petugas_id',
    ];

    // Konstanta status (mengacu OpenSID)
    const STATUS_BARU     = 1;
    const STATUS_PROSES   = 2;
    const STATUS_SELESAI  = 3;
    const STATUS_DITOLAK  = 4;

    public static $statusLabel = [
        1 => 'Baru',
        2 => 'Proses',
        3 => 'Selesai',
        4 => 'Ditolak',
    ];

    public static $statusBadge = [
        1 => 'warning',
        2 => 'info',
        3 => 'success',
        4 => 'danger',
    ];

    public function getStatusLabelAttribute(): string {
        return self::$statusLabel[$this->status] ?? 'Tidak Diketahui';
    }

    public function getStatusBadgeAttribute(): string {
        return self::$statusBadge[$this->status] ?? 'secondary';
    }

    public function penduduk() {
        return $this->belongsTo(Penduduk::class);
    }

    public function petugas() {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}

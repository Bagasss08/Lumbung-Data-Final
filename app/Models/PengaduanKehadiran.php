<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengaduanKehadiran extends Model {
    protected $table = 'kehadiran_pengaduan';

    protected $fillable = [
        'perangkat_id',
        'tanggal_kehadiran',
        'jenis_pengaduan',
        'jam_masuk_diajukan',
        'jam_keluar_diajukan',
        'status_diajukan',
        'alasan',
        'bukti_file',
        'status',
        'catatan_admin',
        'diproses_oleh',
        'diproses_pada',
    ];

    protected $casts = [
        'tanggal_kehadiran' => 'date',
        'diproses_pada'     => 'datetime',
    ];

    public static array $statusLabel = [
        'pending'   => 'Menunggu',
        'disetujui' => 'Disetujui',
        'ditolak'   => 'Ditolak',
    ];

    public static array $statusColor = [
        'pending'   => 'amber',
        'disetujui' => 'emerald',
        'ditolak'   => 'red',
    ];

    public function perangkat(): BelongsTo {
        return $this->belongsTo(PerangkatDesa::class, 'perangkat_id');
    }

    public function pemroses(): BelongsTo {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    public function getStatusLabelAttribute(): string {
        return static::$statusLabel[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string {
        return static::$statusColor[$this->status] ?? 'gray';
    }

    public function scopePending($query) {
        return $query->where('status', 'pending');
    }
}

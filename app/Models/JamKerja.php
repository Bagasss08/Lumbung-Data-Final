<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JamKerja extends Model {
    protected $table = 'kehadiran_jam_kerja';

    protected $fillable = [
        'nama_shift',
        'jam_masuk',
        'jam_keluar',
        'jam_istirahat_mulai',
        'jam_istirahat_selesai',
        'toleransi_menit',
        'is_aktif',
        'keterangan',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
        'toleransi_menit' => 'integer',
    ];

    public function kehadiranPegawai(): HasMany {
        return $this->hasMany(KehadiranPegawai::class, 'jam_kerja_id');
    }

    /**
     * Hitung durasi kerja dalam menit
     */
    public function getDurasiKerjaAttribute(): int {
        $masuk  = \Carbon\Carbon::parse($this->jam_masuk);
        $keluar = \Carbon\Carbon::parse($this->jam_keluar);
        $istirahat = 0;

        if ($this->jam_istirahat_mulai && $this->jam_istirahat_selesai) {
            $istirahatMulai   = \Carbon\Carbon::parse($this->jam_istirahat_mulai);
            $istirahatSelesai = \Carbon\Carbon::parse($this->jam_istirahat_selesai);
            $istirahat        = $istirahatMulai->diffInMinutes($istirahatSelesai);
        }

        return $masuk->diffInMinutes($keluar) - $istirahat;
    }

    public function scopeAktif($query) {
        return $query->where('is_aktif', true);
    }
}

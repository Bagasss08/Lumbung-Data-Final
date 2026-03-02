<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HariLibur extends Model {
    protected $table = 'kehadiran_hari_libur';

    protected $fillable = [
        'nama',
        'tanggal',
        'tanggal_selesai',
        'jenis',
        'is_aktif',
        'keterangan',
    ];

    protected $casts = [
        'tanggal'         => 'date',
        'tanggal_selesai' => 'date',
        'is_aktif'        => 'boolean',
    ];

    public function scopeAktif($query) {
        return $query->where('is_aktif', true);
    }

    public function scopeTahun($query, int $tahun) {
        return $query->whereYear('tanggal', $tahun);
    }

    public function getDurasiHariAttribute(): int {
        if (!$this->tanggal_selesai) return 1;
        return $this->tanggal->diffInDays($this->tanggal_selesai) + 1;
    }

    /**
     * Cek apakah tanggal tertentu adalah hari libur
     */
    public static function isHariLibur(Carbon $tanggal): bool {
        return static::aktif()
            ->where('tanggal', '<=', $tanggal->toDateString())
            ->where(function ($q) use ($tanggal) {
                $q->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', $tanggal->toDateString());
            })
            ->exists();
    }
}

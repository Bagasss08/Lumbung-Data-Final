<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class KehadiranPegawai extends Model {
    protected $table = 'kehadiran_pegawai';

    protected $fillable = [
        'perangkat_id',
        'tanggal',
        'jam_kerja_id',
        'jam_masuk_aktual',
        'jam_keluar_aktual',
        'status',
        'menit_terlambat',
        'metode_masuk',
        'metode_keluar',
        'lat_masuk',
        'lng_masuk',
        'lat_keluar',
        'lng_keluar',
        'keterangan',
        'dicatat_oleh',
    ];

    protected $casts = [
        'tanggal'          => 'date',
        'menit_terlambat'  => 'integer',
        'lat_masuk'        => 'float',
        'lng_masuk'        => 'float',
        'lat_keluar'       => 'float',
        'lng_keluar'       => 'float',
    ];

    public static array $statusLabel = [
        'hadir'      => 'Hadir',
        'terlambat'  => 'Terlambat',
        'izin'       => 'Izin',
        'sakit'      => 'Sakit',
        'alpa'       => 'Alpa',
        'dinas_luar' => 'Dinas Luar',
        'cuti'       => 'Cuti',
        'libur'      => 'Libur',
    ];

    public static array $statusColor = [
        'hadir'      => 'emerald',
        'terlambat'  => 'amber',
        'izin'       => 'blue',
        'sakit'      => 'cyan',
        'alpa'       => 'red',
        'dinas_luar' => 'purple',
        'cuti'       => 'indigo',
        'libur'      => 'gray',
    ];

    public function perangkat(): BelongsTo {
        return $this->belongsTo(PerangkatDesa::class, 'perangkat_id');
    }

    public function jamKerja(): BelongsTo {
        return $this->belongsTo(JamKerja::class, 'jam_kerja_id');
    }

    public function pencatat(): BelongsTo {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }

    public function getStatusLabelAttribute(): string {
        return static::$statusLabel[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string {
        return static::$statusColor[$this->status] ?? 'gray';
    }

    /**
     * Hitung menit terlambat berdasarkan jam kerja
     */
    public function hitungKeterlambatan(): int {
        if (!$this->jamKerja || !$this->jam_masuk_aktual) return 0;

        $batasmasuk = Carbon::parse($this->jamKerja->jam_masuk)
            ->addMinutes($this->jamKerja->toleransi_menit);
        $aktual = Carbon::parse($this->jam_masuk_aktual);

        return max(0, $batasmasuk->diffInMinutes($aktual, false));
    }

    public function scopeBulan($query, int $bulan, int $tahun) {
        return $query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
    }

    public function scopePerangkat($query, int $perangkatId) {
        return $query->where('perangkat_id', $perangkatId);
    }
}

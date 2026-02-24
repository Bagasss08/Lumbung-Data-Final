<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnalisisResponden extends Model {
    protected $table = 'analisis_responden';

    protected $fillable = [
        'id_master',
        'id_periode',
        'id_penduduk',
        'id_keluarga',
        'id_rtm',
        'id_kelompok',
        'total_skor',
        'kategori_hasil',
        'tgl_survei',
    ];

    protected $casts = [
        'total_skor' => 'decimal:2',
        'tgl_survei' => 'datetime',
    ];

    public function master(): BelongsTo {
        return $this->belongsTo(AnalisisMaster::class, 'id_master');
    }

    public function periode(): BelongsTo {
        return $this->belongsTo(AnalisisPeriode::class, 'id_periode');
    }

    public function responJawaban(): HasMany {
        return $this->hasMany(AnalisisResponJawaban::class, 'id_responden');
    }

    /**
     * Hitung ulang total skor dan simpan ke DB
     */
    public function hitungUlangSkor(): void {
        $total = $this->responJawaban()->sum('nilai');
        $this->total_skor = $total;

        // Tentukan kategori berdasarkan klasifikasi master
        $klasifikasi = AnalisisKlasifikasi::where('id_master', $this->id_master)
            ->orderBy('skor_min')
            ->get()
            ->first(fn($k) => $k->containsSkor((float) $total));

        $this->kategori_hasil = $klasifikasi?->nama;
        $this->save();
    }

    /**
     * Nama subjek (bergantung tipe subjek di master)
     */
    public function getNamaSubjekAttribute(): string {
        return match (true) {
            !is_null($this->id_penduduk) => 'Penduduk #' . $this->id_penduduk,
            !is_null($this->id_keluarga) => 'Keluarga #' . $this->id_keluarga,
            !is_null($this->id_rtm)      => 'RTM #'      . $this->id_rtm,
            !is_null($this->id_kelompok) => 'Kelompok #' . $this->id_kelompok,
            default                      => '-',
        };
    }
}

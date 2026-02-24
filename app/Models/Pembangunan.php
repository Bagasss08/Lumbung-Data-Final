<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Pembangunan — mengikuti tabel `pembangunan` di OpenSID.
 *
 * Relasi:
 *  - bidang      → ref_pembangunan_bidang
 *  - sasaran     → ref_pembangunan_sasaran
 *  - sumberDana  → ref_pembangunan_sumber_dana
 *  - lokasi      → tweb_wil_clusterdesa (wilayah administratif desa)
 *  - dokumentasi → pembangunan_ref_dokumentasi (1:N)
 */
class Pembangunan extends Model {
    protected $table = 'pembangunan';

    protected $fillable = [
        'config_id',
        'id_bidang',
        'id_sasaran',
        'id_sumber_dana',
        'id_lokasi',
        'tahun_anggaran',
        'nama',
        'pelaksana',
        'volume',
        'satuan',
        'waktu',
        'mulai_pelaksanaan',
        'akhir_pelaksanaan',
        'dana_pemerintah',
        'dana_provinsi',
        'dana_kabkota',
        'swadaya',
        'sumber_lain',
        'lat',
        'lng',
        'foto',
        'dokumentasi',
        'status',
    ];

    protected $casts = [
        'mulai_pelaksanaan' => 'date',
        'akhir_pelaksanaan' => 'date',
        'dana_pemerintah'   => 'float',
        'dana_provinsi'     => 'float',
        'dana_kabkota'      => 'float',
        'swadaya'           => 'float',
        'sumber_lain'       => 'float',
        'volume'            => 'float',
        'lat'               => 'float',
        'lng'               => 'float',
        'tahun_anggaran'    => 'integer',
    ];

    // ──────────────────────────────────────────────────────────
    // Relations
    // ──────────────────────────────────────────────────────────

    public function bidang(): BelongsTo {
        return $this->belongsTo(RefPembangunanBidang::class, 'id_bidang');
    }

    public function sasaran(): BelongsTo {
        return $this->belongsTo(RefPembangunanSasaran::class, 'id_sasaran');
    }

    public function sumberDana(): BelongsTo {
        return $this->belongsTo(RefPembangunanSumberDana::class, 'id_sumber_dana');
    }

    /**
     * Relasi ke wilayah administratif desa.
     * Menggunakan tabel wilayah (dusun/RW/RT)
     */
    public function lokasi(): BelongsTo {
        return $this->belongsTo(Wilayah::class, 'id_lokasi');
    }

    /**
     * Dokumentasi foto kegiatan (1:N).
     * Progres/persentase pembangunan disimpan di sini (bukan di tabel induk).
     */
    public function dokumentasis(): HasMany {
        return $this->hasMany(PembangunanRefDokumentasi::class, 'id_pembangunan')
            ->orderBy('tanggal');
    }

    // ──────────────────────────────────────────────────────────
    // Accessors / Computed properties
    // ──────────────────────────────────────────────────────────

    /**
     * Total anggaran = pemerintah + provinsi + kab/kota + swadaya + sumber lain.
     * Sesuai OpenSID issue #4793: "Jumlah Anggaran = [Pemerintah]+[Provinsi]+[Kab/Kota]+[Swakelola]"
     */
    public function getTotalAnggaranAttribute(): float {
        return $this->dana_pemerintah
            + $this->dana_provinsi
            + $this->dana_kabkota
            + $this->swadaya
            + $this->sumber_lain;
    }

    /**
     * Persentase progres terkini diambil dari dokumentasi terakhir.
     * Sesuai OpenSID issue #4180: persentase ada di pembangunan_ref_dokumentasi.persentase
     */
    public function getPersentaseTerkiniAttribute(): int {
        if ($this->relationLoaded('dokumentasis') && $this->dokumentasis->isNotEmpty()) {
            return (int) $this->dokumentasis->last()->persentase;
        }
        return 0;
    }

    public function getFotoUrlAttribute(): ?string {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }

    public function getStatusLabelAttribute(): string {
        return $this->status ? 'Aktif' : 'Arsip';
    }

    public function getStatusBadgeAttribute(): string {
        return $this->status
            ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Aktif</span>'
            : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Arsip</span>';
    }

    // ──────────────────────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────────────────────

    public function scopeAktif($query) {
        return $query->where('status', 1);
    }

    public function scopeTahun($query, int $tahun) {
        return $query->where('tahun_anggaran', $tahun);
    }

    public function scopeSelesai($query) {
        // Selesai = punya dokumentasi dengan persentase 100
        // Sesuai logika OpenSID issue #4180
        return $query->whereHas('dokumentasis', fn($q) => $q->where('persentase', 100));
    }

    public function scopeBidang($query, int $idBidang) {
        return $query->where('id_bidang', $idBidang);
    }
}

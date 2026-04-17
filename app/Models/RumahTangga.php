<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RumahTangga extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'rumah_tangga';

    protected $fillable = [
        'no_rumah_tangga',
        'kepala_penduduk_id',
        'bdt',
        'is_dtks',
        'alamat',
        'wilayah_id',
        'klasifikasi_ekonomi',
        'tgl_terdaftar',
        'jenis_bantuan_aktif',
    ];

    protected $casts = [
        'tgl_terdaftar' => 'date',
    ];

    // =========================================================================
    // RELASI
    // =========================================================================

    /**
     * Semua KK yang tergabung dalam rumah tangga ini.
     * Ini adalah relasi utama — penduduk diakses VIA keluarga.
     * Tidak ada pivot rumah_tangga_penduduk; sesuai pola OpenSID.
     */
    public function keluarga() {
        return $this->hasMany(Keluarga::class, 'rumah_tangga_id');
    }

    /**
     * Wilayah (RT/RW/Dusun)
     */
    public function wilayah() {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    // =========================================================================
    // HELPER METHODS
    // =========================================================================

    /**
     * Kepala Rumah Tangga = Kepala KK dari KK pertama yang terdaftar.
     * Di OpenSID, kepala RT adalah kepala KK pertama dalam RT tersebut.
     */
    public function getKepalaRumahTangga(): ?Penduduk {
        $kkPertama = $this->relationLoaded('keluarga')
            ? $this->keluarga->first()
            : $this->keluarga()->oldest()->first();

        return $kkPertama?->getKepalaKeluarga();
    }

    /**
     * Total KK dalam rumah tangga ini.
     */
    public function getTotalKk(): int {
        return $this->relationLoaded('keluarga')
            ? $this->keluarga->count()
            : $this->keluarga()->count();
    }

    /**
     * Total anggota (semua penduduk dari semua KK dalam RT ini).
     * Dihitung dinamis via join.
     */
    public function getTotalAnggota(): int {
        return Penduduk::whereIn(
            'keluarga_id',
            $this->keluarga()->pluck('id')
        )->count();
    }

    /**
     * Total laki-laki di seluruh KK dalam RT ini.
     */
    public function getTotalLakiLaki(): int {
        return Penduduk::whereIn(
            'keluarga_id',
            $this->keluarga()->pluck('id')
        )->where('jenis_kelamin', 'L')->count();
    }

    /**
     * Total perempuan di seluruh KK dalam RT ini.
     */
    public function getTotalPerempuan(): int {
        return Penduduk::whereIn(
            'keluarga_id',
            $this->keluarga()->pluck('id')
        )->where('jenis_kelamin', 'P')->count();
    }

    // =========================================================================
    // ACCESSORS
    // =========================================================================

    public function getRtAttribute(): string {
        return $this->wilayah?->rt ?? '-';
    }

    public function getRwAttribute(): string {
        return $this->wilayah?->rw ?? '-';
    }

    public function getDusunAttribute(): string {
        return $this->wilayah?->dusun ?? '-';
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    public function scopeMiskin($query) {
        return $query->where('klasifikasi_ekonomi', 'miskin');
    }

    public function scopeRendan($query) {
        return $query->where('klasifikasi_ekonomi', 'rentan');
    }

    public function scopeMampu($query) {
        return $query->where('klasifikasi_ekonomi', 'mampu');
    }

    // =========================================================================
    // BOOT
    // =========================================================================

    protected static function boot() {
        parent::boot();

        /**
         * Cegah hapus RT yang masih punya KK terdaftar.
         */
        static::forceDeleting(function ($rt) {
            $jumlah = $rt->keluarga()->count();
            if ($jumlah > 0) {
                throw new \Exception("Rumah tangga {$rt->no_rumah_tangga} tidak bisa dihapus permanen karena masih memiliki {$jumlah} KK.");
            }
        });
    }
}

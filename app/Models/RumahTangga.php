<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahTangga extends Model
{
    use HasFactory;

    protected $table = 'rumah_tangga';

    protected $fillable = [
        'no_rumah_tangga',
        'alamat',
        'wilayah_id',
        'jumlah_anggota',
        'klasifikasi_ekonomi',
        'tgl_terdaftar',
        'jenis_bantuan_aktif',
    ];

    protected $casts = [
        'tgl_terdaftar' => 'date',
    ];

    // Accessor for kode_rumah_tangga to match view
    public function getKodeRumahTanggaAttribute()
    {
        return $this->no_rumah_tangga;
    }

    // Accessor for anggota_count
    public function getAnggotaCountAttribute()
    {
        return $this->jumlah_anggota;
    }

    // Accessor for status to match view (pindah instead of tidak_aktif)
    public function getStatusAttribute($value)
    {
        return $value === 'tidak_aktif' ? 'pindah' : $value;
    }

    // Many-to-many relationship with Penduduk via rumah_tangga_penduduk pivot
    public function anggota()
    {
        return $this->belongsToMany(Penduduk::class, 'rumah_tangga_penduduk')
                    ->withPivot('hubungan_rumah_tangga')
                    ->withTimestamps();
    }

    // Helper method to get kepala rumah tangga
    public function kepalaRumahTangga()
    {
        return $this->anggota()->wherePivot('hubungan_rumah_tangga', 'kepala_rumah_tangga')->first();
    }

    // Helper method to get all anggota except kepala rumah tangga
    public function anggotaRumahTangga()
    {
        return $this->anggota()->wherePivot('hubungan_rumah_tangga', '!=', 'kepala_rumah_tangga');
    }

    // Get kepala_rumah_tangga id for backward compatibility
    public function getKepalaRumahTanggaAttribute()
    {
        return $this->kepalaRumahTangga()?->id;
    }

    // Get kepala_rumah_tangga name
    public function getKepalaRumahTanggaNameAttribute()
    {
        return $this->kepalaRumahTangga()?->nama ?? '-';
    }

    // Relation to Wilayah
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }

    // Accessors for rt, rw, dusun
    public function getRtAttribute()
    {
        return $this->wilayah ? $this->wilayah->rt : '-';
    }

    public function getRwAttribute()
    {
        return $this->wilayah ? $this->wilayah->rw : '-';
    }

    public function getDusunAttribute()
    {
        return $this->wilayah ? $this->wilayah->dusun : '-';
    }

    // Validation: Prevent deletion if still has anggota
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($rumahTangga) {
            // Prevent deletion if still has anggota
            if ($rumahTangga->anggota()->count() > 0) {
                throw new \Exception('Rumah tangga tidak boleh dihapus jika masih memiliki anggota');
            }
        });
    }
}

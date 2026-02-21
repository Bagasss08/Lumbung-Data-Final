<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keluarga extends Model
{
    use SoftDeletes;

    protected $table = 'keluarga';

    protected $fillable = [
        'no_kk',
        'alamat',
        'wilayah_id',
        'tgl_terdaftar',
        'klasifikasi_ekonomi',
        'jenis_bantuan_aktif',
    ];

    protected $casts = [
        'tgl_terdaftar' => 'date',
    ];

    // Many-to-many relationship with Penduduk via keluarga_anggota pivot
    public function anggota()
    {
        return $this->belongsToMany(Penduduk::class, 'keluarga_anggota')
                    ->withPivot('hubungan_keluarga')
                    ->withTimestamps();
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }

    // Helper method to get kepala keluarga
    public function getKepalaKeluarga()
    {
        return $this->anggota()->wherePivot('hubungan_keluarga', 'kepala_keluarga')->first();
    }

    // Helper method to get all anggota keluarga except kepala
    public function getAnggotaKeluarga()
    {
        return $this->anggota()->wherePivot('hubungan_keluarga', '!=', 'kepala_keluarga');
    }

    // Helper method to check if keluarga has kepala keluarga
    public function hasKepalaKeluarga()
    {
        return $this->anggota()->wherePivot('hubungan_keluarga', 'kepala_keluarga')->exists();
    }

    // Helper method to get total anggota
    public function getTotalAnggota()
    {
        return $this->anggota()->count();
    }

    // Validation: Ensure exactly one kepala keluarga
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($keluarga) {
            // Check if there's exactly one kepala keluarga
            $kepalaCount = $keluarga->anggota()->wherePivot('hubungan_keluarga', 'kepala_keluarga')->count();
            if ($kepalaCount > 1) {
                throw new \Exception('Keluarga hanya boleh memiliki satu kepala keluarga');
            }
        });

        static::deleting(function ($keluarga) {
            // Prevent deletion if still has anggota
            if ($keluarga->anggota()->count() > 0) {
                throw new \Exception('Keluarga tidak boleh dihapus jika masih memiliki anggota');
            }
        });
    }
}

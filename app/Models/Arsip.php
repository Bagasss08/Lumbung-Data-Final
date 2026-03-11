<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Arsip extends Model {
    use HasFactory;

    protected $table = 'arsip';

    protected $fillable = [
        'nomor_dokumen',
        'tanggal_dokumen',
        'nama_dokumen',
        'jenis_dokumen',
        'lokasi_arsip',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_dokumen' => 'date',
    ];

    // Daftar jenis dokumen (sesuai OpenSID)
    public static function daftarJenis(): array {
        return [
            'surat_masuk'      => 'Surat Masuk',
            'surat_keluar'     => 'Surat Keluar',
            'keputusan_kades'  => 'Keputusan Kades',
            'peraturan_desa'   => 'Peraturan Desa',
            'kependudukan'     => 'Kependudukan',
            'lainnya'          => 'Lainnya',
        ];
    }

    // Accessor label jenis dokumen
    public function getJenisLabelAttribute(): string {
        return self::daftarJenis()[$this->jenis_dokumen] ?? 'Lainnya';
    }

    // Accessor warna badge per jenis
    public function getBadgeColorAttribute(): string {
        return match ($this->jenis_dokumen) {
            'surat_masuk'     => 'cyan',
            'surat_keluar'    => 'blue',
            'keputusan_kades' => 'purple',
            'peraturan_desa'  => 'amber',
            'kependudukan'    => 'green',
            default           => 'gray',
        };
    }
}

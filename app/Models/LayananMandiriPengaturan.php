<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananMandiriPengaturan extends Model {
    protected $table = 'layanan_mandiri_pengaturan';

    protected $fillable = [
        'aktif',
        'tampilkan_pendaftaran',
        'tampilkan_ektp',
        'latar_login',
    ];

    /**
     * Cek apakah Layanan Mandiri aktif.
     */
    public function isAktif(): bool {
        return $this->aktif === 'Ya';
    }

    /**
     * Cek apakah pendaftaran mandiri ditampilkan.
     */
    public function isPendaftaranAktif(): bool {
        return $this->tampilkan_pendaftaran === 'Ya';
    }

    /**
     * Cek apakah tombol Login E-KTP ditampilkan.
     */
    public function isEktpAktif(): bool {
        return $this->tampilkan_ektp === 'Ya';
    }
}

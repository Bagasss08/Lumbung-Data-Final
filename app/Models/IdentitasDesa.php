<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentitasDesa extends Model {
    protected $table = 'identitas_desa';

    protected $fillable = [
        'user_id',
        'nama_desa',
        'kode_desa',
        'kode_bps_desa',
        'kode_pos',
        'kecamatan',
        'kode_kecamatan',
        'nama_camat',
        'nip_camat',
        'kabupaten',
        'kode_kabupaten',
        'provinsi',
        'kode_provinsi',
        'alamat_kantor',
        'kantor_desa',
        'email_desa',
        'telepon_desa',
        'ponsel_desa',
        'website_desa',
        'kepala_desa',
        'nip_kepala_desa',
        'nama_penanggungjawab_desa',
        'no_ppwa',
        'latitude',
        'longitude',
        'link_peta',
        'logo_desa',
        'gambar_kantor',
    ];
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IdentitasDesa;

class IdentitasDesaSeeder extends Seeder {
    public function run(): void {
        IdentitasDesa::create([
            'nama_desa'       => '',
            'kode_desa'       => '',
            'kode_pos'        => '',

            'kecamatan'       => '',
            'kabupaten'       => '',
            'provinsi'        => '',

            'alamat_kantor'   => '',
            'email_desa'      => '',
            'telepon_desa'    => '',
            'website_desa'    => '',

            'kepala_desa'     => '',
            'nip_kepala_desa' => '',

            'latitude'        => null,
            'longitude'       => null,
            'link_peta'       => '',
        ]);
    }
}

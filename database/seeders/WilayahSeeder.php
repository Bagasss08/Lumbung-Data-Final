<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Desa;
use App\Models\Wilayah;

class WilayahSeeder extends Seeder {
    public function run(): void {
        $desa = Desa::create([
            'kode_desa' => '0001',
            'nama_desa' => 'Desa Lumbung',
            'kecamatan' => 'Kecamatan Lumbung',
            'kabupaten' => 'Kabupaten Lumbung',
            'provinsi' => 'Jawa Barat',
            'klasifikasi_desa' => 'swadaya',
        ]);

        Wilayah::create([
            'desa_id' => $desa->id,
            'dusun' => 'Dusun 1',
            'rw' => '001',
            'rt' => '001',
            'ketua_rt' => 'Ketua RT 1',
            'ketua_rw' => 'Ketua RW 1',
            'jumlah_kk' => 10,
            'jumlah_penduduk' => 50,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SumberDana;

class SumberDanaSeeder extends Seeder {
    public function run() {
        $sumberDanaData = [
            [
                'nama_sumber' => 'Dana Desa',
                'keterangan' => 'Dana yang bersumber dari APBN yang diperuntukkan bagi desa'
            ],
            [
                'nama_sumber' => 'Alokasi Dana Desa (ADD)',
                'keterangan' => 'Dana perimbangan yang diterima kabupaten/kota dalam APBD setelah dikurangi DAK'
            ],
            [
                'nama_sumber' => 'Pendapatan Asli Desa',
                'keterangan' => 'Pendapatan yang berasal dari kewenangan desa berdasarkan hak asal usul dan kewenangan skala lokal desa'
            ],
            [
                'nama_sumber' => 'Bagi Hasil Pajak dan Retribusi',
                'keterangan' => 'Bagian desa dari pajak daerah dan retribusi daerah kabupaten/kota'
            ],
            [
                'nama_sumber' => 'Bantuan Keuangan Provinsi',
                'keterangan' => 'Bantuan keuangan yang bersumber dari APBD Provinsi'
            ],
            [
                'nama_sumber' => 'Bantuan Keuangan Kabupaten/Kota',
                'keterangan' => 'Bantuan keuangan yang bersumber dari APBD Kabupaten/Kota'
            ],
            [
                'nama_sumber' => 'Hibah dan Sumbangan',
                'keterangan' => 'Hibah dan sumbangan dari pihak ketiga yang tidak mengikat'
            ],
            [
                'nama_sumber' => 'Swadaya Masyarakat',
                'keterangan' => 'Partisipasi dan gotong royong masyarakat'
            ],
            [
                'nama_sumber' => 'Lain-lain Pendapatan yang Sah',
                'keterangan' => 'Pendapatan lain yang tidak bertentangan dengan peraturan perundang-undangan'
            ],
        ];

        foreach ($sumberDanaData as $sumber) {
            SumberDana::firstOrCreate(
                ['nama_sumber' => $sumber['nama_sumber']],
                $sumber
            );
        }

        $this->command->info('✅ Sumber Dana seeder berhasil dijalankan');
    }
}

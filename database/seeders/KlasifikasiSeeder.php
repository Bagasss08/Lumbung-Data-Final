<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KlasifikasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => '470.1', 'nama' => 'Domisili'],
            ['kode' => '470.2', 'nama' => 'SKTM'],
            ['kode' => '470.3', 'nama' => 'Kelahiran'],
            ['kode' => '470.4', 'nama' => 'Kematian'],
            ['kode' => '470.5', 'nama' => 'Belum Menikah'],
            ['kode' => '471.1', 'nama' => 'Pengantar KTP'],
            ['kode' => '471.2', 'nama' => 'Pengantar KK'],
            ['kode' => '472.1', 'nama' => 'Pindah'],
            ['kode' => '474.1', 'nama' => 'Nikah (N1)'],
            ['kode' => '474.2', 'nama' => 'Nikah (N2)'],
            ['kode' => '474.3', 'nama' => 'Nikah (N3)'],
            ['kode' => '474.4', 'nama' => 'Nikah (N4)'],
            ['kode' => '503.1', 'nama' => 'Usaha'],
            ['kode' => '593.1', 'nama' => 'Tanah'],
        ];

        foreach ($data as $item) {
            DB::table('klasifikasi_surats')->updateOrInsert(
                ['kode' => $item['kode']], // kunci unik
                [
                    'nama' => $item['nama'],
                    'nama_klasifikasi' => $item['nama'],
                    'keterangan' => '-',
                    'retensi_aktif' => 0,
                    'retensi_inaktif' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $this->command->info('✅ Klasifikasi surat berhasil di-seed tanpa duplicate!');
    }
}
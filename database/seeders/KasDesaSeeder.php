<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KasDesa;
use App\Models\TahunAnggaran;

class KasDesaSeeder extends Seeder {
    public function run() {
        // Pastikan ada tahun anggaran terlebih dahulu
        $tahun2024 = TahunAnggaran::firstOrCreate(['tahun' => 2024]);
        $tahun2025 = TahunAnggaran::firstOrCreate(['tahun' => 2025]);

        // Data Kas Desa Default
        $kasDesaData = [
            [
                'tahun_id' => $tahun2025->id,
                'nama' => 'Kas Desa Utama',
                'saldo_awal' => 50000000,
                'saldo_akhir' => 50000000,
            ],
            [
                'tahun_id' => $tahun2025->id,
                'nama' => 'Kas APBDes',
                'saldo_awal' => 100000000,
                'saldo_akhir' => 100000000,
            ],
            [
                'tahun_id' => $tahun2025->id,
                'nama' => 'Kas Operasional',
                'saldo_awal' => 25000000,
                'saldo_akhir' => 25000000,
            ],
            [
                'tahun_id' => $tahun2025->id,
                'nama' => 'Kas Bantuan Sosial',
                'saldo_awal' => 30000000,
                'saldo_akhir' => 30000000,
            ],
        ];

        foreach ($kasDesaData as $kas) {
            KasDesa::firstOrCreate(
                ['nama' => $kas['nama'], 'tahun_id' => $kas['tahun_id']],
                $kas
            );
        }

        $this->command->info('✅ Kas Desa seeder berhasil dijalankan');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAnggaran;

class TahunAnggaranSeeder extends Seeder {
    public function run() {
        // Data dengan berbagai kemungkinan status
        $tahunData = [
            ['tahun' => 2023],
            ['tahun' => 2024],
            ['tahun' => 2025],
            ['tahun' => 2026],
        ];

        foreach ($tahunData as $data) {
            TahunAnggaran::firstOrCreate(
                ['tahun' => $data['tahun']],
                $data
            );
        }

        $this->command->info('✅ Tahun Anggaran seeder berhasil dijalankan');
    }
}

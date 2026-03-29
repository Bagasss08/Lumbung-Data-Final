<?php

namespace Database\Seeders;

use App\Models\SdgsTujuan;
use App\Models\SdgsRekap;
use Illuminate\Database\Seeder;

class SdgsTujuanSeeder extends Seeder {
    /**
     * Seed 18 Tujuan SDGs Desa resmi (Kemendes PDTT) untuk tahun berjalan.
     *
     * Cara pakai:
     *   php artisan db:seed --class=SdgsTujuanSeeder
     */

    public function run(): void {
        $tahun = (int) ($this->command?->option('tahun') ?? date('Y'));

        if (SdgsTujuan::where('tahun', $tahun)->exists()) {
            $this->command?->warn("Data SDGs tahun {$tahun} sudah ada, seeder dilewati.");
            return;
        }

        $tujuan = SdgsTujuan::masterTujuan();

        foreach ($tujuan as $no => $nama) {
            SdgsTujuan::create([
                'tahun'       => $tahun,
                'no_tujuan'   => $no,
                'nama_tujuan' => $nama,
                'nilai'       => 0,
            ]);
        }

        // Buat rekap awal dengan skor 0
        SdgsRekap::updateOrCreate(
            ['tahun' => $tahun],
            ['skor_sdgs' => 0]
        );

        $this->command?->info("✔  18 tujuan SDGs Desa tahun {$tahun} berhasil di-seed.");
    }
}

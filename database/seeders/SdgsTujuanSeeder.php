<?php

namespace Database\Seeders;

use App\Models\SdgsTujuan;
use App\Models\SdgsRekap;
use Illuminate\Database\Seeder;

class SdgsTujuanSeeder extends Seeder {
    /**
     * Seed 18 Tujuan SDGs Desa resmi (Kemendes PDTT) untuk tahun tertentu.
     *
     * Cara menjalankan:
     * Linux/macOS/Git Bash: TAHUN=2026 php artisan db:seed --class=SdgsTujuanSeeder
     * Windows PowerShell: $env:TAHUN="2026"; php artisan db:seed --class=SdgsTujuanSeeder
     * Windows CMD: set TAHUN=2026 && php artisan db:seed --class=SdgsTujuanSeeder
     */

    public function run(): void {
        // Mengambil tahun dari Environment Variable 'TAHUN', jika tidak ada pakai tahun sekarang
        $envTahun = getenv('TAHUN');
        $tahun = $envTahun ? (int)$envTahun : (int)date('Y');

        // Proteksi agar data tidak double untuk tahun yang sama
        if (SdgsTujuan::where('tahun', $tahun)->exists()) {
            if ($this->command) {
                $this->command->warn("Data SDGs tahun {$tahun} sudah ada, seeder dilewati.");
            }
            return;
        }

        // Mengambil data master 18 tujuan dari Model
        $tujuan = SdgsTujuan::masterTujuan();

        foreach ($tujuan as $no => $nama) {
            SdgsTujuan::create([
                'tahun'       => $tahun,
                'no_tujuan'   => $no,
                'nama_tujuan' => $nama,
                'nilai'       => 0, // Skor default awal
            ]);
        }

        // Buat rekap awal dengan skor 0 untuk tahun tersebut
        SdgsRekap::updateOrCreate(
            ['tahun' => $tahun],
            ['skor_sdgs' => 0]
        );

        if ($this->command) {
            $this->command->info("✔ 18 tujuan SDGs Desa tahun {$tahun} berhasil di-seed.");
        }
    }
}

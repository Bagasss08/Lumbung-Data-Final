<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // Seeder Master Data Keuangan
        // URUTAN PENTING! Jangan diubah karena ada relasi

        $this->call([
            // 1. Tahun Anggaran (tidak ada dependency)
            TahunAnggaranSeeder::class,

            // 2. Bidang Anggaran (tidak ada dependency)
            BidangAnggaranSeeder::class,

            // 3. Kegiatan Anggaran (butuh Bidang Anggaran)
            KegiatanAnggaranSeeder::class,

            // 4. Sumber Dana (tidak ada dependency)
            SumberDanaSeeder::class,

            // 5. Kas Desa (butuh Tahun Anggaran)
            KasDesaSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('🎉 Semua seeder berhasil dijalankan!');
        $this->command->info('');
        $this->command->info('Data yang di-seed:');
        $this->command->info('✅ Tahun Anggaran: 4 tahun (2023-2026)');
        $this->command->info('✅ Bidang Anggaran: 8 bidang');
        $this->command->info('✅ Kegiatan Anggaran: 46 kegiatan');
        $this->command->info('✅ Sumber Dana: 9 sumber');
        $this->command->info('✅ Kas Desa: 4 kas');
    }
}

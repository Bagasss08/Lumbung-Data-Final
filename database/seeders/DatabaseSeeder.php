<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call([
            TahunAnggaranSeeder::class,
            BidangAnggaranSeeder::class,
            KegiatanAnggaranSeeder::class,
            SumberDanaSeeder::class,
            KasDesaSeeder::class,
            KehadiranJamKerjaSeeder::class,
            KlasifikasiSeeder::class,
            PersyaratanSuratSeeder::class,
            TemplateSuratSeeder::class,
            SuratPersyaratanSeeder::class,
            AkunRekeningSeeder::class,
            SuperAdminSeeder::class,
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

        $this->call([
            PpidJenisDokumenSeeder::class,
        ]);

        // ── Status Desa (IDM & SDGs) ──────────────────────────────────
        $this->call([
            IdmIndikatorSeeder::class,
            SdgsTujuanSeeder::class,
        ]);

        $this->command->info('✅ IDM Indikator: 60 indikator (IKS/IKE/IKL)');
        $this->command->info('✅ SDGs Tujuan: 18 tujuan');
    }
}

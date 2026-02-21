<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BidangAnggaran;

class BidangAnggaranSeeder extends Seeder {
    public function run() {
        $bidangData = [
            // PENDAPATAN
            ['nama_bidang' => 'Pendapatan Asli Desa'],
            ['nama_bidang' => 'Pendapatan Transfer'],
            ['nama_bidang' => 'Pendapatan Lain-lain'],

            // BELANJA
            ['nama_bidang' => 'Bidang Penyelenggaraan Pemerintahan Desa'],
            ['nama_bidang' => 'Bidang Pelaksanaan Pembangunan Desa'],
            ['nama_bidang' => 'Bidang Pembinaan Kemasyarakatan'],
            ['nama_bidang' => 'Bidang Pemberdayaan Masyarakat'],
            ['nama_bidang' => 'Bidang Penanggulangan Bencana, Darurat dan Mendesak'],
        ];

        foreach ($bidangData as $bidang) {
            BidangAnggaran::firstOrCreate(
                ['nama_bidang' => $bidang['nama_bidang']],
                $bidang
            );
        }

        $this->command->info('✅ Bidang Anggaran seeder berhasil dijalankan');
    }
}

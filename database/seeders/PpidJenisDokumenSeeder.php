<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PpidJenisDokumen;

class PpidJenisDokumenSeeder extends Seeder {
    public function run(): void {
        $data = [
            [
                'nama'             => 'Secara Berkala',
                'keterangan'       => 'Informasi yang rutin diterbitkan dan diperbaharui untuk publik',
                'icon'             => 'envelope',        // key dari $iconMap
                'warna_background' => '#1e40af',         // biru tua
                'status'           => 'aktif',
            ],
            [
                'nama'             => 'Serta Merta',
                'keterangan'       => 'Informasi yang wajib diumumkan segera karena penting bagi masyarakat',
                'icon'             => 'bolt',            // petir
                'warna_background' => '#16a34a',         // hijau
                'status'           => 'aktif',
            ],
            [
                'nama'             => 'Tersedia Setiap Saat',
                'keterangan'       => 'Informasi yang tersedia dan dapat diakses setiap saat',
                'icon'             => 'globe',           // globe
                'warna_background' => '#d97706',         // oranye
                'status'           => 'aktif',
            ],
            [
                'nama'             => 'Dikecualikan',
                'keterangan'       => 'Informasi yang tidak diumumkan karena dikecualikan oleh peraturan perundang-undangan',
                'icon'             => 'x-circle',        // tanda X lingkaran
                'warna_background' => '#dc2626',         // merah
                'status'           => 'aktif',
            ],
        ];

        foreach ($data as $item) {
            PpidJenisDokumen::updateOrCreate(
                ['nama' => $item['nama']],
                $item
            );
        }
    }
}

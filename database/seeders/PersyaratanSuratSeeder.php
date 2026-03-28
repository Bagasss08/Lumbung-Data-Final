<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersyaratanSurat;

class PersyaratanSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar persyaratan yang sudah dirapikan
        $persyaratan = [
            'Fotokopi Akta Kelahiran/Surat Kelahiran bagi keluarga yang mempunyai anak',
            'Fotokopi Ijasah Terakhir',
            'Fotokopi KK',
            'Fotokopi KTP',
            'Fotokopi Surat Nikah/Akta Nikah/Kutipan Akta Perkawinan',
            'SK. PNS/KARIP/SK. TNI – POLRI',
            'Surat imigrasi / STMD (Surat Tanda Melapor Diri)',
            'Surat Keterangan Cerai',
            'Surat Keterangan Kematian dari Kepala Desa/Kelurahan',
            'Surat Keterangan Kematian dari Rumah Sakit, Rumah Bersalin Puskesmas, atau visum Dokter',
        ];

        // Melakukan perulangan untuk menyimpan setiap data ke database
        foreach ($persyaratan as $item) {
            PersyaratanSurat::create([
                'nama' => $item
            ]);
        }
    }
}
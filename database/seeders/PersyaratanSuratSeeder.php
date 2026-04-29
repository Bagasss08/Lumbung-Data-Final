<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersyaratanSurat;

class PersyaratanSuratSeeder extends Seeder
{
    public function run(): void
    {
        $persyaratan = [
            'Fotokopi KTP Pemohon',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Formulir Permohonan (diisi pemohon)',
            'Fotokopi KTP Orang Tua',
            'Fotokopi KK Orang Tua',
            'Buku Nikah / Akta Nikah Orang Tua',
            'Surat Keterangan Lahir dari Bidan/RS',
            'Surat Keterangan Kematian dari RT/RS',
            'Fotokopi KTP Almarhum',
            'Fotokopi KK Almarhum',
            'Fotokopi KK Lama',
            'Fotokopi KTP Lama',
            'Data Alamat Tujuan Pindah',
            'Surat Pernyataan Belum Menikah',
            'Surat Pernyataan Tidak Mampu',
            'Data Orang Tua (untuk nikah)',
            'Persetujuan Kedua Mempelai',
            'Bukti Kepemilikan Tanah (Girik/Letter C)',
            'Surat Pernyataan Tidak Sengketa Tanah',
            'Foto Lokasi Usaha',
            'Data Jenis Usaha',
            'Fotokopi KTP Pelapor',
            'Fotokopi KK Pelapor',
        ];

        foreach ($persyaratan as $item) {
            PersyaratanSurat::firstOrCreate([
                'nama' => $item
            ]);
        }
    }
}
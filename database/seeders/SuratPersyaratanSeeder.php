<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuratPersyaratanSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua template (judul => id)
        $templates = DB::table('surat_templates')->pluck('id', 'judul');

        // Ambil semua persyaratan (nama => id)
        $persyaratan = DB::table('persyaratan_surats')->pluck('id', 'nama');

        $insert = function ($judulTemplate, $listSyarat) use ($templates, $persyaratan) {

            if (!isset($templates[$judulTemplate])) {
                throw new \Exception("Template tidak ditemukan: $judulTemplate");
            }

            $templateId = $templates[$judulTemplate];

            foreach ($listSyarat as $syarat) {
                if (!isset($persyaratan[$syarat])) {
                    // skip kalau tidak ada
                    continue;
                }

                DB::table('surat_persyaratan')->updateOrInsert(
                    [
                        'surat_template_id' => $templateId,
                        'persyaratan_surat_id' => $persyaratan[$syarat],
                    ],
                    [
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        };

        // =========================
        // 1. Domisili
        // =========================
        $insert('Surat Keterangan Domisili Desa', [
            'Fotokopi KTP Pemohon',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Formulir Permohonan (diisi pemohon)',
        ]);

        // =========================
        // 2. Usaha
        // =========================
        $insert('Surat Keterangan Usaha', [
            'Fotokopi KTP Pemohon',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Foto Lokasi Usaha',
            'Data Jenis Usaha',
        ]);

        // =========================
        // 3. SKTM
        // =========================
        $insert('Surat Keterangan Tidak Mampu', [
            'Fotokopi KTP Pemohon',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Surat Pernyataan Tidak Mampu',
        ]);

        // =========================
        // 4. Kelahiran
        // =========================
        $insert('Surat Keterangan Kelahiran', [
            'Surat Keterangan Lahir dari Bidan/RS',
            'Fotokopi Kartu Keluarga (KK)',
            'Fotokopi KTP Orang Tua',
            'Buku Nikah / Akta Nikah Orang Tua',
        ]);

        // =========================
        // 5. Kematian
        // =========================
        $insert('Surat Keterangan Kematian', [
            'Surat Keterangan Kematian dari RT/RS',
            'Fotokopi Kartu Keluarga (KK)',
            'Fotokopi KTP Almarhum',
            'Fotokopi KTP Pelapor',
        ]);

        // =========================
        // 6. Pengantar KTP
        // =========================
        $insert('Surat Pengantar Pembuatan KTP', [
            'Fotokopi Kartu Keluarga (KK)',
            'Fotokopi KTP Lama',
            'Surat Pengantar RT/RW',
        ]);

        // =========================
        // 7. Pengantar KK
        // =========================
        $insert('Surat Pengantar Pembuatan Kartu Keluarga', [
            'Fotokopi KK Lama',
            'Fotokopi KTP Pemohon',
            'Surat Pengantar RT/RW',
        ]);

        // =========================
        // 8. Pindah
        // =========================
        $insert('Surat Keterangan Pindah', [
            'Fotokopi Kartu Keluarga (KK)',
            'Fotokopi KTP Pemohon',
            'Surat Pengantar RT/RW',
            'Data Alamat Tujuan Pindah',
        ]);

        // =========================
        // 9. Belum Menikah
        // =========================
        $insert('Surat Keterangan Belum Menikah', [
            'Fotokopi KTP Pemohon',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Surat Pernyataan Belum Menikah',
        ]);

        // =========================
        // 10–13. N1–N4
        // =========================
        $insert('Surat Pengantar Pernikahan (N1)', [
            'Fotokopi KTP Pemohon',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
        ]);

        $insert('Surat Keterangan Asal-Usul (N2)', [
            'Data Orang Tua (untuk nikah)',
            'Fotokopi Kartu Keluarga (KK)',
        ]);

        $insert('Surat Persetujuan Mempelai (N3)', [
            'Persetujuan Kedua Mempelai',
        ]);

        $insert('Surat Keterangan Orang Tua (N4)', [
            'Data Orang Tua (untuk nikah)',
        ]);

        // =========================
        // 14. Tanah
        // =========================
        $insert('Surat Keterangan Tanah', [
            'Fotokopi KTP Pemohon',
            'Fotokopi Kartu Keluarga (KK)',
            'Bukti Kepemilikan Tanah (Girik/Letter C)',
            'Surat Pengantar RT/RW',
            'Surat Pernyataan Tidak Sengketa Tanah',
        ]);

        $this->command->info('✅ Relasi surat & persyaratan berhasil di-seed!');
    }
}
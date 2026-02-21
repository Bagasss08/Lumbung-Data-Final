<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KegiatanAnggaran;
use App\Models\BidangAnggaran;

class KegiatanAnggaranSeeder extends Seeder {
    public function run() {
        // Get bidang by name (karena tidak ada kode)
        $pendapatanAsli = BidangAnggaran::where('nama_bidang', 'Pendapatan Asli Desa')->first();
        $pendapatanTransfer = BidangAnggaran::where('nama_bidang', 'Pendapatan Transfer')->first();
        $pendapatanLain = BidangAnggaran::where('nama_bidang', 'Pendapatan Lain-lain')->first();
        $pemerintahan = BidangAnggaran::where('nama_bidang', 'Bidang Penyelenggaraan Pemerintahan Desa')->first();
        $pembangunan = BidangAnggaran::where('nama_bidang', 'Bidang Pelaksanaan Pembangunan Desa')->first();
        $kemasyarakatan = BidangAnggaran::where('nama_bidang', 'Bidang Pembinaan Kemasyarakatan')->first();
        $pemberdayaan = BidangAnggaran::where('nama_bidang', 'Bidang Pemberdayaan Masyarakat')->first();
        $darurat = BidangAnggaran::where('nama_bidang', 'Bidang Penanggulangan Bencana, Darurat dan Mendesak')->first();

        $kegiatanData = [
            // PENDAPATAN ASLI DESA
            ['bidang_id' => $pendapatanAsli->id, 'nama_kegiatan' => 'Hasil Usaha Desa'],
            ['bidang_id' => $pendapatanAsli->id, 'nama_kegiatan' => 'Hasil Aset Desa'],
            ['bidang_id' => $pendapatanAsli->id, 'nama_kegiatan' => 'Swadaya, Partisipasi dan Gotong Royong'],
            ['bidang_id' => $pendapatanAsli->id, 'nama_kegiatan' => 'Lain-lain Pendapatan Asli Desa'],

            // PENDAPATAN TRANSFER
            ['bidang_id' => $pendapatanTransfer->id, 'nama_kegiatan' => 'Dana Desa'],
            ['bidang_id' => $pendapatanTransfer->id, 'nama_kegiatan' => 'Bagi Hasil Pajak dan Retribusi'],
            ['bidang_id' => $pendapatanTransfer->id, 'nama_kegiatan' => 'Alokasi Dana Desa (ADD)'],
            ['bidang_id' => $pendapatanTransfer->id, 'nama_kegiatan' => 'Bantuan Keuangan Provinsi'],
            ['bidang_id' => $pendapatanTransfer->id, 'nama_kegiatan' => 'Bantuan Keuangan Kabupaten/Kota'],

            // PENDAPATAN LAIN-LAIN
            ['bidang_id' => $pendapatanLain->id, 'nama_kegiatan' => 'Hibah dan Sumbangan Pihak Ketiga'],
            ['bidang_id' => $pendapatanLain->id, 'nama_kegiatan' => 'Lain-lain Pendapatan Desa yang Sah'],

            // PENYELENGGARAAN PEMERINTAHAN DESA
            ['bidang_id' => $pemerintahan->id, 'nama_kegiatan' => 'Penyelenggaraan Belanja Siltap, Tunjangan dan Operasional Pemerintah Desa'],
            ['bidang_id' => $pemerintahan->id, 'nama_kegiatan' => 'Sarana dan Prasarana Pemerintahan Desa'],
            ['bidang_id' => $pemerintahan->id, 'nama_kegiatan' => 'Administrasi Kependudukan, Pencatatan Sipil, Statistik, dan Kearsipan'],
            ['bidang_id' => $pemerintahan->id, 'nama_kegiatan' => 'Tata Praja Pemerintahan, Perencanaan, Keuangan dan Pelaporan'],

            // PELAKSANAAN PEMBANGUNAN DESA
            ['bidang_id' => $pembangunan->id, 'nama_kegiatan' => 'Pendidikan'],
            ['bidang_id' => $pembangunan->id, 'nama_kegiatan' => 'Kesehatan'],
            ['bidang_id' => $pembangunan->id, 'nama_kegiatan' => 'Pekerjaan Umum dan Penataan Ruang'],
            ['bidang_id' => $pembangunan->id, 'nama_kegiatan' => 'Kawasan Permukiman'],
            ['bidang_id' => $pembangunan->id, 'nama_kegiatan' => 'Kehutanan dan Lingkungan Hidup'],
            ['bidang_id' => $pembangunan->id, 'nama_kegiatan' => 'Perhubungan, Komunikasi dan Informatika'],
            ['bidang_id' => $pembangunan->id, 'nama_kegiatan' => 'Energi dan Sumber Daya Mineral'],
            ['bidang_id' => $pembangunan->id, 'nama_kegiatan' => 'Pariwisata'],

            // PEMBINAAN KEMASYARAKATAN
            ['bidang_id' => $kemasyarakatan->id, 'nama_kegiatan' => 'Ketentraman, Ketertiban dan Perlindungan Masyarakat'],
            ['bidang_id' => $kemasyarakatan->id, 'nama_kegiatan' => 'Kebudayaan dan Keagamaan'],
            ['bidang_id' => $kemasyarakatan->id, 'nama_kegiatan' => 'Kepemudaan dan Olahraga'],
            ['bidang_id' => $kemasyarakatan->id, 'nama_kegiatan' => 'Kelembagaan Masyarakat'],

            // PEMBERDAYAAN MASYARAKAT
            ['bidang_id' => $pemberdayaan->id, 'nama_kegiatan' => 'Kelautan dan Perikanan'],
            ['bidang_id' => $pemberdayaan->id, 'nama_kegiatan' => 'Pertanian dan Peternakan'],
            ['bidang_id' => $pemberdayaan->id, 'nama_kegiatan' => 'Peningkatan Kapasitas Aparatur Desa'],
            ['bidang_id' => $pemberdayaan->id, 'nama_kegiatan' => 'Pemberdayaan Perempuan, Perlindungan Anak dan Keluarga'],
            ['bidang_id' => $pemberdayaan->id, 'nama_kegiatan' => 'Koperasi, Usaha Mikro Kecil dan Menengah'],
            ['bidang_id' => $pemberdayaan->id, 'nama_kegiatan' => 'Dukungan Penanaman Modal'],
            ['bidang_id' => $pemberdayaan->id, 'nama_kegiatan' => 'Perdagangan dan Perindustrian'],

            // PENANGGULANGAN BENCANA
            ['bidang_id' => $darurat->id, 'nama_kegiatan' => 'Penanggulangan Bencana'],
            ['bidang_id' => $darurat->id, 'nama_kegiatan' => 'Keadaan Darurat'],
            ['bidang_id' => $darurat->id, 'nama_kegiatan' => 'Keadaan Mendesak'],
        ];

        foreach ($kegiatanData as $kegiatan) {
            KegiatanAnggaran::firstOrCreate(
                ['nama_kegiatan' => $kegiatan['nama_kegiatan'], 'bidang_id' => $kegiatan['bidang_id']],
                $kegiatan
            );
        }

        $this->command->info('✅ Kegiatan Anggaran seeder berhasil dijalankan');
    }
}

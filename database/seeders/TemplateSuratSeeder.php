<?php

namespace Database\Seeders;

use App\Models\SuratTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemplateSuratSeeder extends Seeder
{
    public function run()
    {
        $jsonPath = database_path('data/templates.json');
        
        // 1. Pengecekan Eksistensi File
        if (!File::exists($jsonPath)) {
            $this->command->error("❌ File templates.json tidak ditemukan di: " . $jsonPath);
            return;
        }

        // 2. Baca isi file JSON
        $json = File::get($jsonPath);

        // 3. PEMBERSIHAN OTOMATIS: Hapus karakter BOM (Byte Order Mark) tersembunyi
        // Ini adalah penyebab utama json_decode() tiba-tiba menghasilkan nilai null
        $json = preg_replace('/[\xef\xbb\xbf]/', '', $json);

        // 4. Decode JSON menjadi Array
        $templates = json_decode($json, true);

        // 5. VALIDASI ERROR JSON: Kasih tau errornya apa kalau masih gagal
        if ($templates === null) {
            $this->command->error("❌ Format JSON tidak valid! Pesan error: " . json_last_error_msg());
            return;
        }

        // 6. VALIDASI ARRAY: Pastikan datanya bisa di-looping
        if (!is_array($templates)) {
            $this->command->error("❌ Format JSON terbaca, tapi isinya bukan Array `[ ... ]`. Cek kembali file JSON kamu.");
            return;
        }

        // 7. Siapkan folder penyimpanan
        if (!Storage::disk('public')->exists('templates')) {
            Storage::disk('public')->makeDirectory('templates');
        }

        $count = 0;

        // 8. Mulai Looping Data
        foreach ($templates as $data) {
            $wordContent = "
                <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
                <head>
                    <meta charset='utf-8'>
                    <title>{$data['judul']}</title>
                </head>
                <body>
                    {$data['konten_template']}
                </body>
                </html>
            ";

            $fileName = Str::slug($data['judul']) . '.doc';
            $filePath = 'templates/' . $fileName;

            // Simpan file word ke storage
            Storage::disk('public')->put($filePath, $wordContent);

            // 9. ANTI-DUPLIKAT: Gunakan updateOrCreate agar aman jika seeder dijalankan berkali-kali
            SuratTemplate::updateOrCreate(
                ['judul' => $data['judul']], // Cari berdasarkan judul
                [
                    'lampiran'             => $data['lampiran'] ?? null,
                    'status'               => $data['status'] ?? 'aktif',
                    'konten_template'      => $data['konten_template'],
                    'file_path'            => $filePath,
                    'klasifikasi_surat_id' => $data['klasifikasi_surat_id'] ?? null,
                ]
            );

            $count++;
        }

        $this->command->info("✅ Berhasil! $count Template Surat sudah masuk ke database dan folder storage/app/public/templates/");
    }
}
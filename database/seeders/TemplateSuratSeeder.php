<?php

namespace Database\Seeders;

use App\Models\SuratTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\TemplateSurat;

class TemplateSuratSeeder extends Seeder
{
    public function run()
    {
        $jsonPath = database_path('data/templates.json');
        
        if (!File::exists($jsonPath)) {
            $this->command->error("File templates.json tidak ditemukan di database/data/");
            return;
        }

        $json = File::get($jsonPath);
        $templates = json_decode($json, true);

        // 1. UBAH DI SINI: Ganti nama folder menjadi 'templates'
        if (!Storage::disk('public')->exists('templates')) {
            Storage::disk('public')->makeDirectory('templates');
        }

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
            
            // 2. UBAH DI SINI: Path disesuaikan jadi 'templates/'
            $filePath = 'templates/' . $fileName;

            // Ini otomatis akan masuk ke storage/app/public/templates/nama-file.doc
            Storage::disk('public')->put($filePath, $wordContent);

            SuratTemplate::create([
                'judul'                => $data['judul'],
                'lampiran'             => $data['lampiran'],
                'status'               => $data['status'],
                'konten_template'      => $data['konten_template'],
                'file_path'            => $filePath, // Di database akan tersimpan: templates/nama-file.doc
                'klasifikasi_surat_id' => $data['klasifikasi_surat_id'],
            ]);
        }

        $this->command->info('Berhasil! File Word sudah di-generate ke folder storage/app/public/templates/');
    }
}
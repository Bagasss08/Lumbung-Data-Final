<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        Artikel::create([
            'nama' => 'Artikel Pertama',
            'judul' => 'Artikel Pertama',
            'penulis' => 'Admin',
            'tanggal' => '2026-01-27',
            'deskripsi' => 'Ini adalah artikel pertama yang terhubung ke database.',
        ]);

        Artikel::create([
            'nama' => 'Artikel Kedua',
            'judul' => 'Artikel Kedua',
            'penulis' => 'Editor',
            'tanggal' => '2026-01-26',
            'deskripsi' => 'Ini adalah artikel kedua yang terhubung ke database.',
        ]);
    }
}

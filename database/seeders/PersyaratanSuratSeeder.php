<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersyaratanSuratSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('persyaratan_surats')->insert([
            ['nama' => 'KTP', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KK', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Surat Pengantar RT', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Surat Pengantar RW', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Pas Foto 3x4', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
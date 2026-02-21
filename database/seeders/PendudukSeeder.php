<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penduduk;

class PendudukSeeder extends Seeder {
    public function run(): void {
        Penduduk::create([
            'nik' => '3201010101010001',
            'nama' => 'Ahmad Surya',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'agama' => 'Islam',
            'pendidikan' => 'SMA',
            'pekerjaan' => 'bekerja',
            'status_kawin' => 'Kawin',
            'alamat' => 'Jl. Raya Desa No. 1',
        ]);

        Penduduk::create([
            'nik' => '3201010101010002',
            'nama' => 'Siti Aminah',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1992-05-15',
            'agama' => 'Islam',
            'pendidikan' => 'S1',
            'pekerjaan' => 'bekerja',
            'status_kawin' => 'Kawin',
            'alamat' => 'Jl. Raya Desa No. 2',
        ]);

        Penduduk::create([
            'nik' => '3201010101010003',
            'nama' => 'Budi Santoso',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '1985-03-20',
            'agama' => 'Kristen',
            'pendidikan' => 'SMP',
            'pekerjaan' => 'tidak bekerja',
            'status_kawin' => 'Belum Kawin',
            'alamat' => 'Jl. Raya Desa No. 3',
        ]);
    }
}

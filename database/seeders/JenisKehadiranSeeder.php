<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisKehadiranSeeder extends Seeder {
    public function run(): void {
        $jenisKehadiran = [
            [
                'kode_kehadiran' => 'H',
                'nama_kehadiran' => 'Hadir',
                'keterangan' => 'Pegawai hadir sesuai jadwal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kehadiran' => 'I',
                'nama_kehadiran' => 'Izin',
                'keterangan' => 'Pegawai izin dengan alasan tertentu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kehadiran' => 'S',
                'nama_kehadiran' => 'Sakit',
                'keterangan' => 'Pegawai sakit dan tidak dapat hadir',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kehadiran' => 'A',
                'nama_kehadiran' => 'Alpha',
                'keterangan' => 'Pegawai tidak hadir tanpa keterangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kehadiran' => 'C',
                'nama_kehadiran' => 'Cuti',
                'keterangan' => 'Pegawai sedang cuti',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kehadiran' => 'DL',
                'nama_kehadiran' => 'Dinas Luar',
                'keterangan' => 'Pegawai sedang bertugas di luar kantor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($jenisKehadiran as $data) {
            DB::table('jenis_kehadiran')->updateOrInsert(
                ['kode_kehadiran' => $data['kode_kehadiran']],
                $data
            );
        }
    }
}

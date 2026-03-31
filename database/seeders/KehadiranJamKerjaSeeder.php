<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KehadiranJamKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $shifts = [
            [
                'nama_shift' => 'Normal / Office Hour',
                'jam_masuk' => '08:00:00',
                'jam_keluar' => '17:00:00',
                'jam_istirahat_mulai' => '12:00:00',
                'jam_istirahat_selesai' => '13:00:00',
                'toleransi_menit' => 15,
                'is_aktif' => true,
                'keterangan' => 'Jam kerja standar perkantoran (Senin-Jumat)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_shift' => 'Shift Pagi',
                'jam_masuk' => '07:00:00',
                'jam_keluar' => '15:00:00',
                'jam_istirahat_mulai' => '11:30:00',
                'jam_istirahat_selesai' => '12:30:00',
                'toleransi_menit' => 15,
                'is_aktif' => true,
                'keterangan' => 'Shift operasional pagi',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_shift' => 'Shift Sore',
                'jam_masuk' => '15:00:00',
                'jam_keluar' => '23:00:00',
                'jam_istirahat_mulai' => '18:00:00',
                'jam_istirahat_selesai' => '19:00:00',
                'toleransi_menit' => 15,
                'is_aktif' => true,
                'keterangan' => 'Shift operasional sore ke malam',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_shift' => 'Shift Malam',
                'jam_masuk' => '23:00:00',
                'jam_keluar' => '07:00:00',
                'jam_istirahat_mulai' => '03:00:00',
                'jam_istirahat_selesai' => '04:00:00',
                'toleransi_menit' => 15,
                'is_aktif' => true,
                'keterangan' => 'Shift operasional malam hari',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_shift' => 'PNS / Pemerintahan',
                'jam_masuk' => '07:30:00',
                'jam_keluar' => '16:00:00',
                'jam_istirahat_mulai' => '12:00:00',
                'jam_istirahat_selesai' => '13:00:00',
                'toleransi_menit' => 15,
                'is_aktif' => true,
                'keterangan' => 'Jam kerja instansi pemerintahan atau pabrik tertentu',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('kehadiran_jam_kerja')->insert($shifts);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JenisSuratSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenis_surat')->insert([
            [
                'nama_jenis_surat' => 'Surat Keterangan Tidak Mampu',
                'keterangan' => 'Surat untuk keperluan bantuan sosial, sekolah, dan kesehatan.',
                'is_active' => 1,
                'aktif' => 'ya',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_jenis_surat' => 'Surat Keterangan Usaha',
                'keterangan' => 'Surat keterangan memiliki usaha untuk keperluan perbankan atau administrasi.',
                'is_active' => 1,
                'aktif' => 'ya',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_jenis_surat' => 'Surat Pengantar SKCK',
                'keterangan' => 'Surat pengantar untuk pembuatan SKCK di kepolisian.',
                'is_active' => 1,
                'aktif' => 'ya',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_jenis_surat' => 'Surat Keterangan Domisili',
                'keterangan' => 'Surat keterangan domisili warga desa.',
                'is_active' => 1,
                'aktif' => 'ya',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_jenis_surat' => 'Surat Keterangan Kelahiran',
                'keterangan' => 'Surat keterangan kelahiran untuk pengurusan akta kelahiran.',
                'is_active' => 1,
                'aktif' => 'ya',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_jenis_surat' => 'Surat Keterangan Kematian',
                'keterangan' => 'Surat keterangan kematian untuk pengurusan administrasi kependudukan.',
                'is_active' => 1,
                'aktif' => 'ya',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_jenis_surat' => 'Surat Izin Keramaian',
                'keterangan' => 'Surat izin untuk kegiatan atau acara di wilayah desa.',
                'is_active' => 1,
                'aktif' => 'ya',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_jenis_surat' => 'Surat Pengantar Nikah',
                'keterangan' => 'Surat pengantar untuk keperluan pencatatan pernikahan.',
                'is_active' => 1,
                'aktif' => 'ya',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_jenis_surat' => 'Surat Pengantar Jalan',
                'keterangan' => 'Surat pengantar untuk keperluan jalan atau perjalanan.',
                'is_active' => 1,
                'aktif' => 'ya',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
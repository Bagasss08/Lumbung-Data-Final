<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('jabatan_perangkat', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->comment('Nama jabatan, misal: Kepala Desa, Sekretaris Desa, dsb');
            $table->enum('golongan', ['pemerintah_desa', 'bpd'])->default('pemerintah_desa')
                ->comment('Pengelompokan jabatan');
            $table->unsignedTinyInteger('urutan')->default(0)->comment('Urutan tampil');
            $table->timestamps();
        });

        // Seed jabatan default sesuai OpenSID
        DB::table('jabatan_perangkat')->insert([
            // Pemerintah Desa
            ['nama' => 'Kepala Desa',               'golongan' => 'pemerintah_desa', 'urutan' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Sekretaris Desa',            'golongan' => 'pemerintah_desa', 'urutan' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kepala Seksi Pemerintahan',  'golongan' => 'pemerintah_desa', 'urutan' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kepala Seksi Kesejahteraan', 'golongan' => 'pemerintah_desa', 'urutan' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kepala Seksi Pelayanan',     'golongan' => 'pemerintah_desa', 'urutan' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kepala Urusan Tata Usaha',   'golongan' => 'pemerintah_desa', 'urutan' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kepala Urusan Keuangan',     'golongan' => 'pemerintah_desa', 'urutan' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kepala Urusan Perencanaan',  'golongan' => 'pemerintah_desa', 'urutan' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kepala Dusun',               'golongan' => 'pemerintah_desa', 'urutan' => 9,  'created_at' => now(), 'updated_at' => now()],
            // BPD
            ['nama' => 'Ketua BPD',                  'golongan' => 'bpd',             'urutan' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Wakil Ketua BPD',            'golongan' => 'bpd',             'urutan' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Sekretaris BPD',             'golongan' => 'bpd',             'urutan' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Anggota BPD',                'golongan' => 'bpd',             'urutan' => 13, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('jabatan_perangkat');
    }
};

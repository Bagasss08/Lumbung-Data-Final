<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Tabel referensi Bidang Pembangunan.
 * Sesuai OpenSID: ref_pembangunan_bidang
 *
 * Bidang mengacu pada Permendagri No.114/2014 tentang Pedoman
 * Pembangunan Desa (4 bidang utama + 1 bidang darurat).
 */
return new class extends Migration {
    public function up(): void {
        Schema::create('ref_pembangunan_bidang', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nama', 100);
        });

        // Seed data awal sesuai OpenSID
        DB::table('ref_pembangunan_bidang')->insert([
            ['id' => 1, 'nama' => 'Penyelenggaraan Pemerintahan Desa'],
            ['id' => 2, 'nama' => 'Pelaksanaan Pembangunan Desa'],
            ['id' => 3, 'nama' => 'Pembinaan Kemasyarakatan Desa'],
            ['id' => 4, 'nama' => 'Pemberdayaan Masyarakat Desa'],
            ['id' => 5, 'nama' => 'Penanggulangan Bencana, Keadaan Darurat dan Mendesak Desa'],
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('ref_pembangunan_bidang');
    }
};

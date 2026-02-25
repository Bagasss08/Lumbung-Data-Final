<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Tabel referensi Sumber Dana Pembangunan.
 * Sesuai OpenSID: ref_pembangunan_sumber_dana
 */
return new class extends Migration {
    public function up(): void {
        Schema::create('ref_pembangunan_sumber_dana', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nama', 100);
        });

        DB::table('ref_pembangunan_sumber_dana')->insert([
            ['id' => 1, 'nama' => 'APBDes'],
            ['id' => 2, 'nama' => 'ADD (Alokasi Dana Desa)'],
            ['id' => 3, 'nama' => 'DD (Dana Desa)'],
            ['id' => 4, 'nama' => 'PAD (Pendapatan Asli Desa)'],
            ['id' => 5, 'nama' => 'Bantuan Provinsi'],
            ['id' => 6, 'nama' => 'Bantuan Kabupaten/Kota'],
            ['id' => 7, 'nama' => 'Swadaya Masyarakat'],
            ['id' => 8, 'nama' => 'Lainnya'],
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('ref_pembangunan_sumber_dana');
    }
};

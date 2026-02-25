<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Tabel referensi Sasaran Pembangunan.
 * Sesuai OpenSID: ref_pembangunan_sasaran
 * Merujuk pada dokumen perencanaan desa (RPJMDes / RKPDes).
 */
return new class extends Migration {
    public function up(): void {
        Schema::create('ref_pembangunan_sasaran', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nama', 100);
        });

        DB::table('ref_pembangunan_sasaran')->insert([
            ['id' => 1, 'nama' => 'RPJMDes'],
            ['id' => 2, 'nama' => 'RKPDes'],
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('ref_pembangunan_sasaran');
    }
};

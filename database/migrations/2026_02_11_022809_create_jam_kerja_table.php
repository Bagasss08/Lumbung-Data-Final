<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jam_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('hari', 20);
            $table->time('jam_masuk');
            $table->time('jam_pulang');
            $table->integer('toleransi_terlambat')->default(0); // dalam menit
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('jam_kerja');
    }
};

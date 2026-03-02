<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kehadiran_jam_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('nama_shift', 100);             // Contoh: Shift Pagi, Shift Normal
            $table->time('jam_masuk');                     // 07:30:00
            $table->time('jam_keluar');                    // 16:00:00
            $table->time('jam_istirahat_mulai')->nullable(); // 12:00:00
            $table->time('jam_istirahat_selesai')->nullable(); // 13:00:00
            $table->unsignedTinyInteger('toleransi_menit')->default(15); // toleransi keterlambatan
            $table->boolean('is_aktif')->default(true);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kehadiran_jam_kerja');
    }
};

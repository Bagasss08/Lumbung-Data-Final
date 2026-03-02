<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kehadiran_hari_libur', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);              // Contoh: Hari Raya Idul Fitri
            $table->date('tanggal');                  // 2024-04-10
            $table->date('tanggal_selesai')->nullable(); // untuk libur yang lebih dari 1 hari
            $table->enum('jenis', ['nasional', 'lokal'])->default('nasional');
            $table->boolean('is_aktif')->default(true);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kehadiran_hari_libur');
    }
};

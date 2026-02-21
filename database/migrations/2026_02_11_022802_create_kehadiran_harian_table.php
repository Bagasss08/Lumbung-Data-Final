<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kehadiran_harian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pegawai')->constrained('pegawai')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('hari', 20);
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->foreignId('id_jenis_kehadiran')->constrained('jenis_kehadiran')->onDelete('cascade');
            $table->string('lokasi_absen', 255)->nullable();
            $table->enum('metode_absen', ['manual', 'fingerprint', 'qr'])->default('manual');
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kehadiran_harian');
    }
};

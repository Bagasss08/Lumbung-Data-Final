<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dinas_luar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pegawai')->constrained('pegawai')->onDelete('cascade');
            $table->string('nama_kegiatan', 255);
            $table->string('lokasi_kegiatan', 255);
            $table->date('tanggal_selesai');
            $table->text('instasi_tujuan')->nullable();
            $table->string('surat_tugas', 255)->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('dinas_luar');
    }
};

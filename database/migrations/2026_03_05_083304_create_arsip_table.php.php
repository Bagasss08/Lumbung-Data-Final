<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_dokumen')->nullable();
            $table->date('tanggal_dokumen')->nullable();
            $table->string('nama_dokumen')->nullable();
            $table->enum('jenis_dokumen', ['surat_masuk', 'surat_keluar', 'keputusan_kades', 'peraturan_desa', 'lainnya'])->nullable();
            $table->string('lokasi_arsip')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('arsip');
    }
};

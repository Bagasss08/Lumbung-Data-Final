<?php
// database/migrations/xxxx_create_mutasi_penduduk_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mutasi_penduduk', function (Blueprint $table) {
            $table->id();

            // Relasi ke penduduk (nullable, karena pindah masuk mungkin belum ada di DB)
            $table->foreignId('penduduk_id')->nullable()->constrained('penduduk')->nullOnDelete();

            // Data diri (disimpan manual agar tetap ada walau penduduk dihapus)
            $table->string('nik', 16);
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 20)->nullable();
            $table->string('no_kk', 16)->nullable();

            // Data mutasi
            $table->enum('jenis_mutasi', ['pindah_masuk', 'pindah_keluar']);
            $table->date('tanggal_mutasi');
            $table->string('asal')->nullable();    // desa/kota asal  (untuk pindah masuk)
            $table->string('tujuan')->nullable();  // desa/kota tujuan (untuk pindah keluar)
            $table->string('no_surat')->nullable();
            $table->text('alasan')->nullable();
            $table->text('keterangan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('mutasi_penduduk');
    }
};

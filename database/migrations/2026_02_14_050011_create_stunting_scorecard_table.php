<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Tabel stunting_scorecard
     * Rekap konvergensi layanan pencegahan stunting per triwulan
     * Sesuai OpenSID menu Stunting > Scorecard Konvergensi
     */
    public function up(): void {
        Schema::create('stunting_scorecard', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kia_id')->constrained('kia')->cascadeOnDelete();
            $table->integer('triwulan');    // 1, 2, 3, 4
            $table->integer('tahun');

            // 1. Layanan Ibu Hamil
            $table->enum('fe90', ['ya', 'tidak'])->default('tidak');             // TTD ≥ 90 tab
            $table->enum('ifa', ['ya', 'tidak'])->default('tidak');              // Suplemen IFA
            $table->enum('pmtbumil', ['ya', 'tidak'])->default('tidak');         // PMT Ibu Hamil
            $table->enum('pemeriksaan_kehamilan', ['ya', 'tidak'])->default('tidak'); // ANC K4
            $table->enum('akt_bumil', ['ya', 'tidak'])->default('tidak');        // Kelas Ibu Hamil

            // 2. Layanan Bayi/Anak
            $table->enum('imunisasi_dasar', ['ya', 'tidak'])->default('tidak');  // Imunisasi dasar lengkap
            $table->enum('pmtbalita', ['ya', 'tidak'])->default('tidak');        // PMT Balita
            $table->enum('vit_a', ['ya', 'tidak'])->default('tidak');            // Vitamin A
            $table->enum('stimulasi', ['ya', 'tidak'])->default('tidak');        // Stimulasi tumbuh kembang
            $table->enum('paud', ['ya', 'tidak'])->default('tidak');             // Akses PAUD

            // 3. Layanan Keluarga
            $table->enum('jkn', ['ya', 'tidak'])->default('tidak');              // JKN/BPJS
            $table->enum('air_bersih', ['ya', 'tidak'])->default('tidak');
            $table->enum('sanitasi', ['ya', 'tidak'])->default('tidak');         // Jamban layak
            $table->enum('perlindungan_sosial', ['ya', 'tidak'])->default('tidak'); // PKH/BLT dll

            $table->integer('skor_konvergensi')->default(0);  // Total skor (otomatis)
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['kia_id', 'triwulan', 'tahun']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('stunting_scorecard');
    }
};

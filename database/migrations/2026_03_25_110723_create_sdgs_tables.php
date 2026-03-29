<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Rekap total skor SDGs per tahun
        Schema::create('sdgs_rekap', function (Blueprint $table) {
            $table->id();
            $table->year('tahun')->unique();
            $table->decimal('skor_sdgs', 6, 2)->default(0)->comment('Rata-rata skor semua tujuan 0–100');
            $table->timestamps();
        });

        // Detail 18 tujuan SDGs Desa per tahun
        Schema::create('sdgs_tujuan', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->tinyInteger('no_tujuan')->comment('1–18');
            $table->string('nama_tujuan', 150);
            $table->decimal('nilai', 6, 2)->default(0)->comment('0–100');
            $table->timestamps();

            $table->unique(['tahun', 'no_tujuan']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('sdgs_tujuan');
        Schema::dropIfExists('sdgs_rekap');
    }
};

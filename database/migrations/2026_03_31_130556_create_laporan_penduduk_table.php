<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('laporan_penduduk', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->smallInteger('tahun');
            $table->tinyInteger('bulan');
            $table->string('file')->nullable();
            $table->timestamp('tgl_upload')->nullable();
            $table->timestamp('tgl_kirim')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('laporan_penduduk');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('analisis_master', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->comment('Nama kategori analisis, e.g. Analisis Kemiskinan');
            $table->string('kode', 20)->nullable()->unique()->comment('Kode unik analisis');
            $table->text('deskripsi')->nullable();
            $table->enum('subjek', ['PENDUDUK', 'KELUARGA', 'RUMAH_TANGGA', 'KELOMPOK'])
                ->default('PENDUDUK')
                ->comment('Subjek data yang dianalisis');
            $table->enum('status', ['AKTIF', 'TIDAK_AKTIF'])->default('AKTIF');
            $table->tinyInteger('lock')->default(0)->comment('0=tidak dikunci, 1=dikunci');
            $table->integer('periode')->nullable()->comment('Tahun periode analisis');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('analisis_master');
    }
};

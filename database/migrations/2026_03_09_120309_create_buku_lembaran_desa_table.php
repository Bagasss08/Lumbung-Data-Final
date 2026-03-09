<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_lembaran_desa', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_peraturan')->comment('Contoh: Peraturan Desa, Peraturan Kepala Desa');
            $table->string('nomor_ditetapkan')->comment('Nomor Peraturan');
            $table->date('tanggal_ditetapkan')->comment('Tanggal Ditetapkan');
            $table->text('tentang')->comment('Judul / Tentang Peraturan');
            $table->date('tanggal_diundangkan_lembaran')->nullable()->comment('Tanggal diundangkan di Lembaran Desa');
            $table->string('nomor_diundangkan_lembaran')->nullable()->comment('Nomor di Lembaran Desa');
            $table->date('tanggal_diundangkan_berita')->nullable()->comment('Tanggal diundangkan di Berita Desa');
            $table->string('nomor_diundangkan_berita')->nullable()->comment('Nomor di Berita Desa');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_lembaran_desa');
    }
};
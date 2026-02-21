<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sekretariat_informasi_publik', function (Blueprint $table) {
            $table->id();
            $table->string('judul_dokumen');
            $table->enum('tipe_dokumen', ['file', 'link', 'teks'])->default('file');
            $table->string('unggah_dokumen')->nullable(); // path file
            $table->integer('retensi_dokumen')->default(0); // nilai dalam hari/bulan
            $table->enum('satuan_retensi', ['hari', 'bulan', 'tahun'])->default('hari');
            $table->string('kategori_info_publik')->nullable(); // kategori informasi publik
            $table->text('keterangan')->nullable();
            $table->year('tahun')->nullable();
            $table->date('tanggal_terbit');
            $table->enum('status_terbit', ['ya', 'tidak'])->default('ya');
            $table->timestamps();

            $table->index('tipe_dokumen');
            $table->index('kategori_info_publik');
            $table->index('status_terbit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekretariat_informasi_publik');
    }
};

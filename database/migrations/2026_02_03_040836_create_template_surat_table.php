<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('template_surat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_surat_id'); // Relasi ke tabel jenis_surat
            $table->string('nama_template');
            $table->string('versi_template', 100);
            $table->string('file_template')->nullable();
            $table->date('tanggal_berlaku')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Opsional (disarankan): Membuat relasi Foreign Key agar data konsisten
            // Hapus tanda komentar (//) di bawah ini jika tabel 'jenis_surat' sudah di-migrate lebih dulu
            // $table->foreign('jenis_surat_id')->references('id')->on('jenis_surat')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_surat');
    }
};
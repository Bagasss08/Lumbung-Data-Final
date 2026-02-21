<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('konten', function (Blueprint $table) {
            $table->id();
            $table->foreignId('identitas_desa_id')->constrained('identitas_desa')->cascadeOnDelete();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('ringkasan')->nullable();
            $table->longText('isi_konten');
            $table->foreignId('media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->enum('jenis_konten', ['berita','pengumuman','layanan','regulasi','galeri']);
            $table->enum('status', ['draf','review','publish','arsip'])->default('draf');
            $table->timestamp('tanggal_publish')->nullable();
            $table->timestamp('tanggal_kadaluarsa')->nullable();
            $table->foreignId('penulis_id')->constrained('users');
            $table->foreignId('editor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('sumber')->nullable();
            $table->string('bahasa')->default('id');
            $table->integer('jumlah_view')->default(0);
            $table->enum('komentar_aktif', ['ya','tidak'])->default('ya');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konten');
    }
};

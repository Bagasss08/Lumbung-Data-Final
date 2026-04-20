<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wisatas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('kategori')->default('Wisata Alam');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('jam_buka')->nullable();
            $table->string('harga_tiket')->nullable()->default('Gratis');
            $table->text('fasilitas')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wisatas');
    }
};
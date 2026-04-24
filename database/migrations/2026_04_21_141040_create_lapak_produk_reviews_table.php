<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan nama tabel adalah 'ulasan' agar sesuai dengan file migrasi setelahnya
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();

            // Gunakan nama 'lapak_id' agar sinkron dengan migrasi tanggal 22 April
            $table->foreignId('lapak_id')
                  ->constrained('lapak_produk') // Sesuaikan dengan nama tabel produk kamu
                  ->cascadeOnDelete();

            // relasi ke user
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // rating 1-5
            $table->unsignedTinyInteger('rating');

            // komentar
            $table->text('komentar')->nullable();

            // foto (optional)
            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Pastikan nama tabel yang di-drop sama yaitu 'ulasan'
        Schema::dropIfExists('ulasan');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();

            // relasi ke produk
            $table->foreignId('lapak_produk_id')
                  ->constrained('lapak_produk')
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
        Schema::dropIfExists('lapak_produk_reviews');
    }
};

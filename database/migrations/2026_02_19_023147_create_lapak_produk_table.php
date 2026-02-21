<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lapak_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lapak_id')->constrained('lapak')->onDelete('cascade');
            $table->string('nama_produk', 150);
            $table->string('slug', 160)->unique();
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 15, 2)->default(0);
            $table->integer('stok')->default(0);
            $table->string('satuan', 30)->default('pcs');
            $table->string('foto', 255)->nullable();
            $table->enum('status', ['aktif', 'habis', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('lapak_produk');
    }
};

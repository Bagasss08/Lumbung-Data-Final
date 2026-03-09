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
        Schema::create('buku_keputusan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_keputusan');
            $table->date('tanggal_keputusan');
            $table->text('tentang');
            $table->text('uraian_singkat')->nullable();
            $table->string('nomor_dilaporkan')->nullable();
            $table->date('tanggal_dilaporkan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_keputusan');
    }
};
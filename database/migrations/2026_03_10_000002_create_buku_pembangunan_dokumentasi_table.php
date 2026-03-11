<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_pembangunan_dokumentasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pembangunan')->constrained('buku_pembangunan')->onDelete('cascade');
            $table->date('tanggal')->nullable();
            $table->integer('persentase')->nullable(); // 0-100
            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable(); // path foto
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_pembangunan_dokumentasi');
    }
};


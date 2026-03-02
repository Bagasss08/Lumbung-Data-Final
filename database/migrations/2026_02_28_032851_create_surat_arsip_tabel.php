<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip_surat', function (Blueprint $table) {
            $table->id();

            $table->string('nomor_surat')->unique();
            $table->string('jenis_surat');
            $table->string('nama_pemohon');
            $table->string('nik', 16)->index();
            $table->date('tanggal_surat')->index();

            $table->string('file_path');
            $table->enum('status', ['draft','selesai','ditolak'])->default('selesai');

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip_surat');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surat_permohonan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_id')->constrained('surat');
            $table->foreignId('penduduk_id')->constrained('penduduk');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat');
            $table->date('tanggal_permohonan');
            $table->text('keperluan')->nullable();
            $table->json('data_isian')->nullable();
            $table->enum('status', ['diajukan','diproses','ditolak','selesai'])->default('diajukan');
            $table->text('catatan_petugas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_permohonan');
    }
};

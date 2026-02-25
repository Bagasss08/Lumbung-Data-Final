<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cetak_surat', function (Blueprint $table) {
            $table->id();

            // Relasi ke template_surat
            $table->foreignId('template_id')
                  ->constrained('template_surat')
                  ->cascadeOnDelete();

            $table->string('nomor_surat')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->string('perihal')->nullable();
            $table->text('keterangan')->nullable();

            // Simpan JSON data warga
            $table->json('data_warga')->nullable();

            // File hasil upload / generate
            $table->string('file_surat')->nullable();
            $table->string('generated_file')->nullable();

            // Status surat (draft, dicetak, dibatalkan, dll)
            $table->string('status')->default('draft');

            // Relasi user pembuat
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cetak_surat');
    }
};
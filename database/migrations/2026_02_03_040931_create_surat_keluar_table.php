<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')
                  ->constrained('surat_permohonan')
                  ->cascadeOnDelete();
            $table->foreignId('template_id')
                  ->constrained('template_surat');
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_surat');
            $table->foreignId('penandatangan_id')
                  ->constrained('perangkat_desa');
            $table->string('file_surat'); // path PDF
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};

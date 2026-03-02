<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surat_templates', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('format_nomor')->nullable();
            $table->string('kode_klasifikasi')->nullable();
            $table->enum('status', ['aktif', 'noaktif'])->default('aktif');
            $table->longText('konten_template');
            $table->string('file_path')->nullable(); // path file DOCX
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_templates');
    }
};
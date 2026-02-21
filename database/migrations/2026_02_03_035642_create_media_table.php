<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('identitas_desa_id')->constrained('identitas_desa')->cascadeOnDelete();
            $table->enum('jenis_media', ['gambar','video','dokumen']);
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('file_path');
            $table->bigInteger('ukuran_file')->nullable();
            $table->string('tipe_file')->nullable();
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamp('tanggal_upload')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};

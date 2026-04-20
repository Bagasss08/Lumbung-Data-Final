<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dokumen_penduduk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penduduk_id');
            $table->string('nama_dokumen', 100);
            $table->string('jenis_dokumen', 100)->nullable();
            $table->string('file_path');
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('ukuran')->nullable()->comment('ukuran file dalam bytes');
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->timestamps();

            $table->foreign('penduduk_id')
                ->references('id')->on('penduduk')
                ->onDelete('cascade');

            $table->foreign('uploaded_by')
                ->references('id')->on('users')
                ->onDelete('set null');

            $table->index('penduduk_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('dokumen_penduduk');
    }
};

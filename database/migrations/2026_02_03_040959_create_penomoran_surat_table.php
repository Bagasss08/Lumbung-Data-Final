<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penomoran_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat');
            $table->year('tahun');
            $table->string('nomor_terakhir'); // contoh: 470/015/DS/2025
            $table->timestamps();

            $table->unique(['jenis_surat_id','tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penomoran_surat');
    }
};

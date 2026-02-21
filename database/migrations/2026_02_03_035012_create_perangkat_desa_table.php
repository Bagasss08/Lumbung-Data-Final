<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('perangkat_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('penduduk_id')
                  ->constrained('penduduk')
                  ->cascadeOnDelete();
            $table->enum('jabatan', ['kades','sekdes','kasi','kaur','kadus']);
            $table->string('no_sk');
            $table->date('tanggal_sk');
            $table->date('periode_mulai');
            $table->date('periode_selesai')->nullable();
            $table->enum('status', ['aktif','nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perangkat_desa');
    }
};

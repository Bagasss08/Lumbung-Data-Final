<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kehadiran_tahunan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pegawai')->constrained('pegawai')->onDelete('cascade');
            $table->year('tahun');
            $table->integer('total_hari_kerja')->default(0);
            $table->integer('total_hadir')->default(0);
            $table->integer('total_tidak_hadir')->default(0);
            $table->decimal('presentase_kehadiran', 5, 2)->default(0);
            $table->text('catatan_evaluasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kehadiran_tahunan');
    }
};

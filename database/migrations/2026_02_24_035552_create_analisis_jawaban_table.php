<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Opsi jawaban yang tersedia per indikator (untuk tipe OPTION/RADIO)
        Schema::create('analisis_jawaban', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_indikator');
            $table->string('jawaban', 200)->comment('Teks opsi jawaban');
            $table->decimal('nilai', 8, 2)->default(0)->comment('Nilai/skor untuk opsi ini');
            $table->integer('urutan')->default(1);
            $table->timestamps();

            $table->foreign('id_indikator')
                ->references('id')->on('analisis_indikator')
                ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('analisis_jawaban');
    }
};

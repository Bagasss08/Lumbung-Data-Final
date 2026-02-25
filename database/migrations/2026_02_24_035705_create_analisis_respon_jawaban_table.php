<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('analisis_respon_jawaban', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_responden');
            $table->unsignedBigInteger('id_indikator');
            $table->unsignedBigInteger('id_jawaban')->nullable()->comment('Jawaban pilihan (OPTION/RADIO)');
            $table->text('jawaban_teks')->nullable()->comment('Jawaban teks bebas (TEXT/TEXTAREA/DATE/NUMBER)');
            $table->decimal('nilai', 8, 2)->default(0)->comment('Nilai aktual dari jawaban ini');
            $table->timestamps();

            $table->foreign('id_responden')
                ->references('id')->on('analisis_responden')
                ->onDelete('cascade');

            $table->foreign('id_indikator')
                ->references('id')->on('analisis_indikator')
                ->onDelete('cascade');

            $table->foreign('id_jawaban')
                ->references('id')->on('analisis_jawaban')
                ->onDelete('set null');

            $table->unique(['id_responden', 'id_indikator'], 'uq_respon_indikator');
        });
    }

    public function down(): void {
        Schema::dropIfExists('analisis_respon_jawaban');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('analisis_indikator', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_master')->comment('FK ke analisis_master');
            $table->string('pertanyaan', 500)->comment('Teks pertanyaan/indikator');
            $table->enum('jenis', ['OPTION', 'RADIO', 'TEXT', 'TEXTAREA', 'DATE', 'NUMBER'])
                ->default('OPTION');
            $table->tinyInteger('aktif')->default(1);
            $table->integer('urutan')->default(1);
            $table->timestamps();

            $table->foreign('id_master')
                ->references('id')->on('analisis_master')
                ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('analisis_indikator');
    }
};

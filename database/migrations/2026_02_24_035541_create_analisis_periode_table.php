<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('analisis_periode', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_master');
            $table->string('nama', 100)->comment('Nama periode, e.g. Semester 1 2024');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->tinyInteger('aktif')->default(1);
            $table->timestamps();

            $table->foreign('id_master')
                ->references('id')->on('analisis_master')
                ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('analisis_periode');
    }
};

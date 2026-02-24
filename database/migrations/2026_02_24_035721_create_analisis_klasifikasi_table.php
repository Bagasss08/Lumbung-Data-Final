<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('analisis_klasifikasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_master');
            $table->string('nama', 100)->comment('Nama klasifikasi, e.g. Sangat Miskin, Miskin, Hampir Miskin');
            $table->decimal('skor_min', 8, 2)->default(0);
            $table->decimal('skor_max', 8, 2)->default(100);
            $table->string('warna', 20)->nullable()->comment('Warna hex untuk tampilan, e.g. #ef4444');
            $table->integer('urutan')->default(1);
            $table->timestamps();

            $table->foreign('id_master')
                ->references('id')->on('analisis_master')
                ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('analisis_klasifikasi');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('analisis_responden', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_master');
            $table->unsignedBigInteger('id_periode');
            // FK ke subjek bersifat nullable polimorfik sederhana:
            $table->unsignedBigInteger('id_penduduk')->nullable()->comment('FK ke tweb_penduduk jika subjek PENDUDUK');
            $table->unsignedBigInteger('id_keluarga')->nullable()->comment('FK ke tweb_keluarga jika subjek KELUARGA');
            $table->unsignedBigInteger('id_rtm')->nullable()->comment('FK ke tweb_rtm jika subjek RUMAH_TANGGA');
            $table->unsignedBigInteger('id_kelompok')->nullable()->comment('FK ke tweb_kelompok jika subjek KELOMPOK');
            $table->decimal('total_skor', 10, 2)->default(0)->comment('Total skor semua jawaban');
            $table->string('kategori_hasil', 100)->nullable()->comment('Hasil klasifikasi, e.g. MISKIN, SEJAHTERA');
            $table->timestamp('tgl_survei')->nullable();
            $table->timestamps();

            $table->foreign('id_master')
                ->references('id')->on('analisis_master')
                ->onDelete('cascade');

            $table->foreign('id_periode')
                ->references('id')->on('analisis_periode')
                ->onDelete('cascade');

            $table->index(['id_master', 'id_periode']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('analisis_responden');
    }
};

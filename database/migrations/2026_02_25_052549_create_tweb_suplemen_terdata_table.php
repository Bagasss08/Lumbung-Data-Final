<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tweb_suplemen_terdata', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_suplemen')->comment('FK ke tweb_suplemen');
            $table->string('id_pend', 20)->nullable()->comment('NIK penduduk (sasaran perorangan)');
            $table->string('no_kk', 16)->nullable()->comment('Nomor KK (sasaran keluarga)');
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_suplemen')->references('id')->on('tweb_suplemen')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('tweb_suplemen_terdata');
    }
};

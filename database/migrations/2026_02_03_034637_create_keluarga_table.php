<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk')->unique();
            $table->unsignedBigInteger('kepala_keluarga')->nullable();
            $table->text('alamat')->nullable();
            $table->foreignId('wilayah_id')->constrained('wilayah');
            $table->date('tgl_terdaftar');
            $table->enum('status', ['aktif','pindah'])->default('aktif');
            $table->enum('klasifikasi_ekonomi', ['miskin','rentan','mampu'])->nullable();
            $table->string('jenis_bantuan_aktif')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keluarga');
    }
};

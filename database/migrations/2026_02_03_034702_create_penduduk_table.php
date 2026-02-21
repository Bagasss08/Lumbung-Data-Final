<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->foreignId('keluarga_id')->nullable()
                  ->constrained('keluarga')->nullOnDelete();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L','P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('golongan_darah', 3)->nullable();
            $table->string('agama');
            $table->string('pendidikan')->nullable();
            $table->enum('pekerjaan', ['bekerja','tidak bekerja'])->default('tidak bekerja');
            $table->string('status_kawin');
            $table->enum('status_hidup', ['hidup','meninggal'])->default('hidup');
            $table->string('kewarganegaraan')->default('WNI');
            $table->string('no_telp')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->foreignId('wilayah_id')->constrained('wilayah');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};

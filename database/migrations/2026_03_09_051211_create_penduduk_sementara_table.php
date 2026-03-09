<?php
// database/migrations/xxxx_create_penduduk_sementara_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('penduduk_sementara', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->nullable();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 20)->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('kewarganegaraan', 50)->nullable()->default('WNI');
            $table->string('asal_daerah')->nullable();       // dari mana
            $table->string('tujuan_kedatangan')->nullable(); // keperluan
            $table->date('tanggal_datang');
            $table->date('tanggal_pergi')->nullable();       // null = masih di sini
            $table->string('no_surat_ket')->nullable();      // no. surat keterangan
            $table->string('tempat_menginap')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('penduduk_sementara');
    }
};

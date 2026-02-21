<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('nip', 18)->nullable();
            $table->string('nama_lengkap', 100);
            $table->string('jabatan', 100)->nullable();
            $table->string('unit_kerja', 100)->nullable();
            $table->enum('status_kepegawaian', ['PNS', 'honorer', 'perangkat desa'])->default('perangkat desa');
            $table->text('alamat')->nullable();
            $table->string('nomor_telepon', 15)->nullable();
            $table->enum('status_aktif', ['aktif', 'tidak aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pegawai');
    }
};

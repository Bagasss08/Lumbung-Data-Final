<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('program_peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('program')->onDelete('cascade');
            $table->foreignId('penduduk_id')->nullable()->constrained('penduduk')->onDelete('set null');
            $table->string('peserta');                       // NIK atau No KK
            $table->string('kartu_nama')->nullable();        // nama di kartu
            $table->string('kartu_nik')->nullable();         // NIK di kartu
            $table->string('kartu_no_id')->nullable();       // nomor id kartu
            $table->string('kartu_tempat_lahir')->nullable();
            $table->date('kartu_tanggal_lahir')->nullable();
            $table->text('kartu_alamat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('program_peserta');
    }
};

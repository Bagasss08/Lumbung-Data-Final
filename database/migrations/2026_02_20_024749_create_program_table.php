<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
    
return new class extends Migration {
    public function up(): void {
        Schema::create('program', function (Blueprint $table) {
            $table->id();
            $table->string('nama');                          // nama program bantuan
            $table->string('sumber_dana')->nullable();      // sumber dana (APBN, APBD, dll)
            $table->year('tahun')->nullable();              // tahun program
            $table->text('keterangan')->nullable();         // keterangan/deskripsi
            $table->decimal('nominal', 15, 2)->nullable();  // nominal bantuan
            $table->text('syarat')->nullable();             // syarat/kriteria penerima
            $table->tinyInteger('sasaran')->default(1);     // 1=Penduduk, 2=Keluarga
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->tinyInteger('status')->default(1);      // 1=Aktif, 0=Tidak Aktif
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('program');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('lembaga_anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lembaga_id')->constrained('lembaga_desas')->cascadeOnDelete();
            $table->foreignId('penduduk_id')->constrained('penduduk')->cascadeOnDelete();
            $table->string('no_anggota')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('nomor_sk_jabatan')->nullable();
            $table->string('nomor_sk_pengangkatan')->nullable();
            $table->date('tanggal_sk_pengangkatan')->nullable();
            $table->string('nomor_sk_pemberhentian')->nullable();
            $table->date('tanggal_sk_pemberhentian')->nullable();
            $table->string('masa_jabatan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembaga_anggota');
    }
};

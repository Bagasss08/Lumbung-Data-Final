<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_pembangunan', function (Blueprint $table) {
            $table->id();
            $table->integer('config_id')->nullable();
            $table->string('nama'); // nama kegiatan pembangunan
            $table->integer('id_lokasi')->nullable(); // FK ke tabel wilayah/dusun
            $table->year('tahun_anggaran'); // tahun anggaran
            $table->string('bidang')->nullable(); // bidang kegiatan
            $table->text('sasaran')->nullable(); // sasaran
            $table->string('volume')->nullable(); // volume
            $table->string('satuan')->nullable(); // satuan
            $table->string('pelaksana')->nullable(); // pelaksana
            $table->string('sumber_dana')->nullable(); // sumber dana
            $table->decimal('anggaran_pemerintah', 15, 2)->default(0); // anggaran pemerintah
            $table->decimal('anggaran_provinsi', 15, 2)->default(0); // anggaran provinsi
            $table->decimal('anggaran_kabkota', 15, 2)->default(0); // anggaran kab/kota
            $table->decimal('anggaran_swakelola', 15, 2)->default(0); // anggaran swakelola
            $table->text('keterangan')->nullable(); // keterangan
            $table->tinyInteger('aktif')->default(1); // 1=aktif, 0=nonaktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_pembangunan');
    }
};


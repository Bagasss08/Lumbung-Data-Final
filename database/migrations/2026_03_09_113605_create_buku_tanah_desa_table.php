<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_tanah_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemilik')->comment('Nama Pemilik / Badan Hukum');
            $table->double('luas_tanah')->comment('Luas dalam m2');
            $table->string('status_hak_tanah')->comment('SHM, HGB, Girik, Leter C, dll');
            $table->string('penggunaan_tanah')->comment('Perumahan, Pertanian, Ladang, dll');
            $table->text('letak_tanah')->comment('Blok / Alamat lengkap');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_tanah_desa');
    }
};
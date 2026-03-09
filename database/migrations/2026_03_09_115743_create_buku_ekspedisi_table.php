<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_ekspedisi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengiriman')->comment('Tarikh Surat Dihantar');
            $table->date('tanggal_surat')->comment('Tarikh Surat Ditulis');
            $table->string('nomor_surat');
            $table->text('isi_singkat')->comment('Isi Ringkas Surat');
            $table->string('tujuan')->comment('Ditujukan Kepada');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_ekspedisi');
    }
};
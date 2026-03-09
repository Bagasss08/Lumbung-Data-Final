<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_agenda_surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengiriman')->comment('Tanggal Surat Dikirim / Dikeluarkan');
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('tujuan')->comment('Ditujukan Kepada');
            $table->text('isi_singkat')->comment('Isi Singkat / Perihal');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_agenda_surat_keluar');
    }
};
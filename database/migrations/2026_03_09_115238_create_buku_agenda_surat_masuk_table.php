<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_agenda_surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_penerimaan')->comment('Tanggal Surat Diterima');
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('pengirim')->comment('Surat dari Instansi/Orang');
            $table->text('isi_singkat')->comment('Isi Singkat / Perihal');
            $table->string('disposisi')->nullable()->comment('Disposisi kepada siapa');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_agenda_surat_masuk');
    }
};
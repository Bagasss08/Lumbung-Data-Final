<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_tanah_kas_desa', function (Blueprint $table) {
            $table->id();
            $table->string('asal_tanah_kas_desa')->comment('Asal Tanah Kas Desa');
            $table->string('nomor_sertifikat')->nullable()->comment('Nomor Sertifikat / Buku C / Persil');
            $table->double('luas')->comment('Luas dalam Meter Persegi');
            $table->string('kelas')->nullable()->comment('Kelas Tanah');
            $table->string('asal_perolehan')->comment('Asli Milik Desa, Bantuan Pemerintah, dll');
            $table->date('tanggal_perolehan');
            $table->string('jenis_tanah')->comment('Sawah, Tegal, Kebun, dll');
            $table->enum('status_patok', ['Ada', 'Tidak Ada'])->default('Tidak Ada');
            $table->enum('status_papan_nama', ['Ada', 'Tidak Ada'])->default('Tidak Ada');
            $table->text('lokasi');
            $table->string('peruntukan')->nullable();
            $table->string('mutasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_tanah_kas_desa');
    }
};
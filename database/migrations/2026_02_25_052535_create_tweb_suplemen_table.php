<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tweb_suplemen', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->comment('Nama data suplemen');
            $table->enum('sasaran', ['1', '2'])->default('1')
                ->comment('1 = Perorangan (penduduk), 2 = Keluarga (KK)');
            $table->text('keterangan')->nullable()->comment('Deskripsi/keterangan');
            $table->string('logo', 255)->nullable()->comment('Path file gambar/logo');
            $table->date('tgl_mulai')->nullable()->comment('Tanggal mulai berlaku');
            $table->date('tgl_selesai')->nullable()->comment('Tanggal selesai berlaku');
            $table->tinyInteger('aktif')->default(1)->comment('1=aktif, 0=nonaktif');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tweb_suplemen');
    }
};

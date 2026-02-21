<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('posyandu', function (Blueprint $table) {
            $table->id();
            $table->string('nama_posyandu', 100);
            $table->string('dusun', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('hari_kegiatan', 20)->nullable();  // senin, selasa, dst
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('penanggung_jawab', 100)->nullable();  // bidan/petugas
            $table->integer('jumlah_kader')->default(0);
            $table->enum('status_posyandu', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('posyandu');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rumah_tangga', function (Blueprint $table) {
            $table->id();
            $table->string('no_rumah_tangga', 20)->unique();
            $table->foreignId('kepala_rumah_tangga')->nullable()->constrained('penduduk')->onDelete('set null');
            $table->text('alamat')->nullable();
            $table->foreignId('wilayah_id')->nullable()->constrained('wilayah')->onDelete('set null');
            $table->integer('jumlah_anggota')->default(0);
            $table->enum('klasifikasi_ekonomi', ['miskin', 'rentan', 'mampu'])->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->date('tgl_terdaftar')->nullable();
            $table->string('jenis_bantuan_aktif', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah_tangga');
    }
};

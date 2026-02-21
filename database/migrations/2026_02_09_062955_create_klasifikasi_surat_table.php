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
        Schema::create('klasifikasi_surats', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique();
            $table->string('nama_klasifikasi');
            $table->string('kategori');
            $table->string('retensi_aktif'); // e.g., "5 tahun"
            $table->string('retensi_inaktif'); // e.g., "10 tahun"
            $table->boolean('status')->default(true); // true = aktif, false = tidak aktif
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klasifikasi_surats');
    }
};

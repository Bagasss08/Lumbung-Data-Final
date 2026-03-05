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
        Schema::create('peraturan_desa', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('jenis_peraturan'); // Contoh: Perdes, Perkades, dll
            $table->string('nomor_ditetapkan');
            $table->date('tanggal_ditetapkan');
            $table->text('uraian_singkat')->nullable();
            $table->boolean('is_aktif')->default(true); // Untuk kolom 'Aktif'
            $table->date('dimuat_pada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peraturan_desa');
    }
};
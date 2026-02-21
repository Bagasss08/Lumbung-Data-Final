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
        Schema::create('rumah_tangga_penduduk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->constrained('penduduk')->onDelete('cascade');
            $table->foreignId('rumah_tangga_id')->constrained('rumah_tangga')->onDelete('cascade');
            $table->enum('hubungan_rumah_tangga', [
                'kepala_rumah_tangga',
                'istri',
                'suami',
                'anak',
                'orang_tua',
                'saudara',
                'pembantu',
                'lainnya'
            ])->default('lainnya');
            $table->unique(['penduduk_id', 'rumah_tangga_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah_tangga_penduduk');
    }
};

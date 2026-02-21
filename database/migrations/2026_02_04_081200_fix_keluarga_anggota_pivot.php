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
        Schema::table('keluarga_anggota', function (Blueprint $table) {
            $table->foreignId('penduduk_id')->constrained('penduduk')->onDelete('cascade');
            $table->foreignId('keluarga_id')->constrained('keluarga')->onDelete('cascade');
            $table->enum('hubungan_keluarga', [
                'kepala_keluarga',
                'istri',
                'suami',
                'anak',
                'orang_tua',
                'saudara',
                'famili_lain'
            ])->default('famili_lain');
            $table->unique(['penduduk_id', 'keluarga_id']); // Prevent duplicate memberships
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluarga_anggota', function (Blueprint $table) {
            $table->dropForeign(['penduduk_id']);
            $table->dropForeign(['keluarga_id']);
            $table->dropColumn(['penduduk_id', 'keluarga_id', 'hubungan_keluarga']);
        });
    }
};

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
        Schema::table('keluarga', function (Blueprint $table) {
            // Remove kepala_keluarga field as penduduk should not have status kepala keluarga
            $table->dropForeign(['kepala_keluarga']);
            $table->dropColumn('kepala_keluarga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluarga', function (Blueprint $table) {
            // Restore kepala_keluarga field
            $table->unsignedBigInteger('kepala_keluarga')->nullable();
            $table->foreign('kepala_keluarga')
                  ->references('id')
                  ->on('penduduk')
                  ->nullOnDelete();
        });
    }
};

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
            // Remove kepala_keluarga foreign key
            if (Schema::hasColumn('keluarga', 'kepala_keluarga')) {
                $table->dropForeign(['kepala_keluarga']);
                $table->dropColumn('kepala_keluarga');
            }

            // Remove status field (keluarga tidak memiliki status hidup/mati)
            if (Schema::hasColumn('keluarga', 'status')) {
                $table->dropColumn('status');
            }

            // Add soft delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluarga', function (Blueprint $table) {
            // Restore kepala_keluarga
            $table->unsignedBigInteger('kepala_keluarga')->nullable();
            $table->foreign('kepala_keluarga')->references('id')->on('penduduk');

            // Restore status
            $table->enum('status', ['aktif','pindah'])->default('aktif');

            // Remove soft delete
            $table->dropSoftDeletes();
        });
    }
};

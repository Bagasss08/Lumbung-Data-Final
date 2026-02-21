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
        Schema::table('rumah_tangga', function (Blueprint $table) {
            // Remove kepala_rumah_tangga foreign key
            if (Schema::hasColumn('rumah_tangga', 'kepala_rumah_tangga')) {
                $table->dropForeign(['kepala_rumah_tangga']);
                $table->dropColumn('kepala_rumah_tangga');
            }

            // Remove status field (rumah tangga tidak memiliki status hidup/mati)
            if (Schema::hasColumn('rumah_tangga', 'status')) {
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
        Schema::table('rumah_tangga', function (Blueprint $table) {
            // Restore kepala_rumah_tangga
            $table->unsignedBigInteger('kepala_rumah_tangga')->nullable();
            $table->foreign('kepala_rumah_tangga')->references('id')->on('penduduk');

            // Restore status
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');

            // Remove soft delete
            $table->dropSoftDeletes();
        });
    }
};

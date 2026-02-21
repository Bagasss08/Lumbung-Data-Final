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
        Schema::table('penduduk', function (Blueprint $table) {
            // Remove direct foreign keys to keluarga and rumah_tangga
            $table->dropForeign(['keluarga_id']);
            $table->dropColumn('keluarga_id');

            // Check if rumah_tangga_id exists and remove it
            if (Schema::hasColumn('penduduk', 'rumah_tangga_id')) {
                $table->dropForeign(['rumah_tangga_id']);
                $table->dropColumn('rumah_tangga_id');
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
        Schema::table('penduduk', function (Blueprint $table) {
            // Restore keluarga_id
            $table->foreignId('keluarga_id')->nullable()
                  ->constrained('keluarga')->nullOnDelete();

            // Remove soft delete
            $table->dropSoftDeletes();
        });
    }
};

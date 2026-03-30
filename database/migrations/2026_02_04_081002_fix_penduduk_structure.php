<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('penduduk', function (Blueprint $table) {
            if (Schema::hasColumn('penduduk', 'keluarga_id')) {
                $table->dropForeign(['keluarga_id']);
                $table->dropColumn('keluarga_id');
            }

            if (Schema::hasColumn('penduduk', 'rumah_tangga_id')) {
                $table->dropForeign(['rumah_tangga_id']);
                $table->dropColumn('rumah_tangga_id');
            }

            if (!Schema::hasColumn('penduduk', 'deleted_at')) {
                $table->softDeletes();
            }
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

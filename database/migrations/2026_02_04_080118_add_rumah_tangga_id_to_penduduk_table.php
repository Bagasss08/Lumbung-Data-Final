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
            $table->foreignId('rumah_tangga_id')->nullable()->after('keluarga_id')
                  ->constrained('rumah_tangga')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropForeign(['rumah_tangga_id']);
            $table->dropColumn('rumah_tangga_id');
        });
    }
};

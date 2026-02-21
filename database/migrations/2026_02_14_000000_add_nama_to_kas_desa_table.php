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
        Schema::table('kas_desa', function (Blueprint $table) {
            $table->string('nama')->nullable()->after('tahun_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kas_desa', function (Blueprint $table) {
            $table->dropColumn('nama');
        });
    }
};

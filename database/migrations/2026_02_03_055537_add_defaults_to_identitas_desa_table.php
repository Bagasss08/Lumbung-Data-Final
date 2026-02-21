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
        Schema::table('identitas_desa', function (Blueprint $table) {
            $table->string('nama_desa')->default('')->change();
            $table->string('kode_desa')->default('')->change();
            $table->string('kecamatan')->default('')->change();
            $table->string('kabupaten')->default('')->change();
            $table->string('provinsi')->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identitas_desa', function (Blueprint $table) {
            $table->string('nama_desa')->nullable(false)->change();
            $table->string('kode_desa')->nullable(false)->change();
            $table->string('kecamatan')->nullable(false)->change();
            $table->string('kabupaten')->nullable(false)->change();
            $table->string('provinsi')->nullable(false)->change();
        });
    }
};

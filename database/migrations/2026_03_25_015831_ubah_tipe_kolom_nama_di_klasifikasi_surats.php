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
        Schema::table('klasifikasi_surats', function (Blueprint $table) {
            // Mengubah tipe kolom dari string (VARCHAR 255) menjadi TEXT
            // TEXT bisa menampung hingga 65.000+ karakter
            $table->text('nama')->change();
            $table->text('nama_klasifikasi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('klasifikasi_surats', function (Blueprint $table) {
            // Kembalikan ke string jika sewaktu-waktu di-rollback
            $table->string('nama', 255)->change();
            $table->string('nama_klasifikasi', 255)->change();
        });
    }
};
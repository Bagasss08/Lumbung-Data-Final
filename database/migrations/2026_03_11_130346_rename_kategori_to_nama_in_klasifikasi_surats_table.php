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
            // Mengubah nama kolom dari 'kategori' menjadi 'nama'
            $table->renameColumn('kategori', 'nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('klasifikasi_surats', function (Blueprint $table) {
            // Mengembalikan nama kolom dari 'nama' menjadi 'kategori' jika di-rollback
            $table->renameColumn('nama', 'kategori');
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Tambah kolom penduduk_id (Nullable, karena admin bukan warga)
            $table->foreignId('penduduk_id')->nullable()->after('id')->constrained('penduduk')->onDelete('cascade');
        });

        // 2. Ubah kolom role agar mendukung 'warga'. 
        // Karena di MySQL Enum agak strict, kita alter pakai raw statement
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'operator', 'warga') NOT NULL DEFAULT 'warga'");
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['penduduk_id']);
            $table->dropColumn('penduduk_id');
        });
        
        // Kembalikan enum (opsional, hati-hati jika ada data 'warga')
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'operator') NOT NULL DEFAULT 'operator'");
    }
};

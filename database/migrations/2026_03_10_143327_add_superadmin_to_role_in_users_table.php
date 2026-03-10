<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mengubah kolom ENUM dengan menambahkan 'superadmin'
        // Menggunakan raw statement agar lebih aman dan tidak butuh package doctrine/dbal
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'admin', 'operator', 'warga') NOT NULL DEFAULT 'warga'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan kolom ENUM ke kondisi semula jika di-rollback (tanpa superadmin)
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'operator', 'warga') NOT NULL DEFAULT 'warga'");
    }
};
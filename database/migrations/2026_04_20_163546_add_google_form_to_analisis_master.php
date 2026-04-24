<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::table('analisis_master', function (Blueprint $table) {
            // Kolom Google Form
            $table->string('google_form_id')->nullable()->after('periode');
            $table->timestamp('last_sync_at')->nullable()->after('google_form_id');
        });

        // Perluas enum subjek (MySQL)
        // Sesuaikan jika pakai PostgreSQL (gunakan alter column type text + check constraint)
        DB::statement("
            ALTER TABLE analisis_master
            MODIFY COLUMN subjek ENUM(
                'PENDUDUK',
                'KELUARGA',
                'RUMAH_TANGGA',
                'KELOMPOK',
                'DESA',
                'DUSUN',
                'RW',
                'RT'
            ) NOT NULL
        ");
    }

    public function down(): void {
        // Kembalikan enum ke nilai semula
        DB::statement("
            ALTER TABLE analisis_master
            MODIFY COLUMN subjek ENUM(
                'PENDUDUK',
                'KELUARGA',
                'RUMAH_TANGGA',
                'KELOMPOK'
            ) NOT NULL
        ");

        Schema::table('analisis_master', function (Blueprint $table) {
            $table->dropColumn(['google_form_id', 'last_sync_at']);
        });
    }
};

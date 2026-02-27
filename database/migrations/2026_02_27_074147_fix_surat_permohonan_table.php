<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Jadikan surat_id boleh kosong (NULL) agar tidak error saat insert
        DB::statement("ALTER TABLE surat_permohonan MODIFY COLUMN surat_id bigint(20) UNSIGNED NULL");

        // 2. Tambahkan kolom dokumen_pendukung untuk menyimpan path file yang diupload
        if (!Schema::hasColumn('surat_permohonan', 'dokumen_pendukung')) {
            Schema::table('surat_permohonan', function (Blueprint $table) {
                $table->string('dokumen_pendukung', 255)->nullable()->after('keperluan');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('surat_permohonan', 'dokumen_pendukung')) {
            Schema::table('surat_permohonan', function (Blueprint $table) {
                $table->dropColumn('dokumen_pendukung');
            });
        }
        
        // Kembalikan ke NOT NULL (Opsional)
        DB::statement("ALTER TABLE surat_permohonan MODIFY COLUMN surat_id bigint(20) UNSIGNED NOT NULL");
    }
};
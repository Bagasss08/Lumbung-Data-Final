<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Ubah enum status sesuai kebutuhan sistem baru
        DB::statement("ALTER TABLE surat_permohonan MODIFY COLUMN status ENUM('belum lengkap', 'sedang diperiksa', 'menunggu tandatangan', 'siap diambil', 'sudah diambil', 'dibatalkan') NOT NULL DEFAULT 'sedang diperiksa'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE surat_permohonan MODIFY COLUMN status ENUM('diajukan','diproses','ditolak','selesai') NOT NULL DEFAULT 'diajukan'");
    }
};

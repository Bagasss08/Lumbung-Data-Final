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
    public function up(): void {
        DB::statement("ALTER TABLE kehadiran_pegawai 
        MODIFY COLUMN metode_masuk ENUM('manual', 'self_checkin', 'fingerprint') NULL");
        DB::statement("ALTER TABLE kehadiran_pegawai 
        MODIFY COLUMN metode_keluar ENUM('manual', 'self_checkout', 'fingerprint') NULL");
    }

    public function down(): void {
        DB::statement("ALTER TABLE kehadiran_pegawai 
        MODIFY COLUMN metode_masuk ENUM('manual', 'self_checkin') NULL");
        DB::statement("ALTER TABLE kehadiran_pegawai 
        MODIFY COLUMN metode_keluar ENUM('manual', 'self_checkout') NULL");
    }
};

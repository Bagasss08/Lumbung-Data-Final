<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('kehadiran_bulanan', function (Blueprint $table) {
            // Ganti kolom bulan dari string ke integer
            $table->integer('bulan')->change();

            // Tambah kolom yang kurang (opsional, kalau mau lengkap)
            if (!Schema::hasColumn('kehadiran_bulanan', 'jumlah_sakit')) {
                $table->integer('jumlah_sakit')->default(0)->after('jumlah_izin');
            }
            if (!Schema::hasColumn('kehadiran_bulanan', 'jumlah_cuti')) {
                $table->integer('jumlah_cuti')->default(0)->after('jumlah_sakit');
            }
        });
    }

    public function down(): void {
        Schema::table('kehadiran_bulanan', function (Blueprint $table) {
            $table->string('bulan', 20)->change();
            $table->dropColumn(['jumlah_sakit', 'jumlah_cuti']);
        });
    }
};

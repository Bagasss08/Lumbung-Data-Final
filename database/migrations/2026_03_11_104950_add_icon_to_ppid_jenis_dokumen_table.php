<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('ppid_jenis_dokumen', function (Blueprint $table) {
            $table->string('icon', 100)->nullable()->after('keterangan');
            $table->string('warna_background', 20)->default('#000000')->after('icon');
            $table->string('status', 20)->default('aktif')->after('warna_background');
        });
    }

    public function down(): void {
        Schema::table('ppid_jenis_dokumen', function (Blueprint $table) {
            $table->dropColumn(['icon', 'warna_background', 'status']);
        });
    }
};

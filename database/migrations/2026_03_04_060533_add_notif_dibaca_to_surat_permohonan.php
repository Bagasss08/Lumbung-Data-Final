<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('surat_permohonan', function (Blueprint $table) {
            if (!Schema::hasColumn('surat_permohonan', 'notif_dibaca')) {
                $table->boolean('notif_dibaca')->default(true)->after('status');
            }
        });
    }

    public function down(): void {
        Schema::table('surat_permohonan', function (Blueprint $table) {
            $table->dropColumn('notif_dibaca');
        });
    }
};

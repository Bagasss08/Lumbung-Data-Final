<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // Ganti semua 'identitas_desas' menjadi 'identitas_desa'

    public function up(): void {
        Schema::table('identitas_desa', function (Blueprint $table) {
            $table->string('facebook')->nullable()->after('website_desa');
            $table->string('instagram')->nullable()->after('facebook');
            $table->string('youtube')->nullable()->after('instagram');
        });
    }

    public function down(): void {
        Schema::table('identitas_desa', function (Blueprint $table) {
            $table->dropColumn(['facebook', 'instagram', 'youtube']);
        });
    }
};

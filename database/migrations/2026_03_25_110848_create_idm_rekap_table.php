<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('idm_rekap', function (Blueprint $table) {
            $table->id();
            $table->year('tahun')->unique();

            $table->decimal('skor_idm', 6, 4)->default(0);
            $table->string('status_idm', 30)->nullable();
            $table->decimal('skor_idm_minimal', 6, 4)->default(0);
            $table->string('target_status', 30)->nullable();

            $table->decimal('skor_iks', 6, 4)->default(0);
            $table->decimal('skor_ike', 6, 4)->default(0);
            $table->decimal('skor_ikl', 6, 4)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('idm_rekap');
    }
};

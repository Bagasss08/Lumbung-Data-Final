<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agenda_config', function (Blueprint $table) {
            $table->id();
            $table->foreignId('identitas_desa_id')->constrained('identitas_desa')->cascadeOnDelete();
            $table->string('nama_pengaturan');
            $table->text('nilai_pengaturan')->nullable();
            $table->string('tipe_data');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_config');
    }
};

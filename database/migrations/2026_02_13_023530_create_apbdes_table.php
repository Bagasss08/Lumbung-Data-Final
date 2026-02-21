<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('apbdes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tahun_id')
                ->constrained('tahun_anggaran')
                ->cascadeOnDelete();

            $table->foreignId('kegiatan_id')
                ->constrained('kegiatan_anggaran')
                ->cascadeOnDelete();

            $table->foreignId('sumber_dana_id')
                ->constrained('sumber_dana')
                ->cascadeOnDelete();

            $table->bigInteger('anggaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apbdes');
    }
};

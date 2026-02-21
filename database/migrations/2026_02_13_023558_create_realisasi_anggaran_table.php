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
        Schema::create('realisasi_anggaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('apbdes_id')
                ->constrained('apbdes')
                ->cascadeOnDelete();

            $table->date('tanggal');
            $table->bigInteger('jumlah');
            $table->text('keterangan')->nullable();
            $table->string('bukti')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisasi_anggaran');
    }
};

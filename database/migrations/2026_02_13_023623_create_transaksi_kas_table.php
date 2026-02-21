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
        Schema::create('transaksi_kas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kas_id')
                ->constrained('kas_desa')
                ->cascadeOnDelete();

            $table->foreignId('realisasi_id')
                ->nullable()
                ->constrained('realisasi_anggaran')
                ->nullOnDelete();

            $table->date('tanggal');
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->bigInteger('jumlah');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_kas');
    }
};

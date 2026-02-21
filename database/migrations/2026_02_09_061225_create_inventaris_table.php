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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->text('deskripsi')->nullable();
            $table->string('kategori');
            $table->integer('jumlah');
            $table->enum('kondisi', ['baik', 'rusak', 'perlu_perbaikan']);
            $table->string('lokasi');
            $table->decimal('harga_perolehan', 15, 2)->nullable();
            $table->date('tanggal_perolehan')->nullable();
            $table->string('sumber_perolehan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};

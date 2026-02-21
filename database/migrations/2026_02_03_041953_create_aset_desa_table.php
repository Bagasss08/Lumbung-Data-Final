<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('aset_desa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('identitas_desa_id')->constrained('identitas_desa');
            $table->string('nama_aset');
            $table->enum('jenis_aset', ['tanah','bangunan','kendaraan']);
            $table->decimal('luas', 10, 2)->nullable();
            $table->decimal('nilai', 15, 2)->nullable();
            $table->year('tahun_perolehan')->nullable();
            $table->string('sumber')->nullable();
            $table->string('kondisi')->nullable();
            $table->string('lokasi')->nullable();
            $table->enum('status', ['aktif','rusak','dihapus'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aset_desa');
    }
};

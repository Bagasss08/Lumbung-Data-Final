<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Gunakan Schema::create untuk MEMBUAT tabel dari awal
        Schema::create('jenis_surat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis_surat');
            $table->text('keterangan')->nullable();
            
            // Langsung gunakan is_active (boolean), tidak perlu pakai enum 'aktif' lagi
            $table->boolean('is_active')->default(true); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_surat');
    }
};
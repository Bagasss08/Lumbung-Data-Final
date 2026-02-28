<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('c_desa', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_pemilik', ['warga_desa', 'warga_luar'])->default('warga_desa');
            // Relasi ke tabel penduduk jika warga asli desa
            $table->foreignId('penduduk_id')->nullable()->constrained('penduduk')->nullOnDelete();
            
            // Kolom manual jika warga luar desa
            $table->string('nik_luar', 20)->nullable();
            $table->string('nama_luar', 100)->nullable();
            $table->text('alamat_luar')->nullable();
            
            $table->string('nomor_cdesa', 50)->unique();
            $table->string('nama_di_cdesa', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('c_desa');
    }
};
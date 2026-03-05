<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rencana_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_proyek'); // NAMA PROYEK / KEGIATAN
            $table->string('lokasi'); // LOKASI
            
            // SUMBER DANA (Dipecah sesuai kolom yang diminta)
            $table->decimal('dana_pemerintah', 15, 2)->default(0);
            $table->decimal('dana_provinsi', 15, 2)->default(0);
            $table->decimal('dana_kab_kota', 15, 2)->default(0);
            $table->decimal('dana_swadaya', 15, 2)->default(0);
            
            // JUMLAH (Bisa dihitung otomatis atau diinput)
            $table->decimal('jumlah_total', 15, 2)->default(0); 
            
            $table->string('pelaksana'); // PELAKSANA
            $table->text('manfaat'); // MANFAAT
            $table->text('keterangan')->nullable(); // KET
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rencana_desa');
    }
};
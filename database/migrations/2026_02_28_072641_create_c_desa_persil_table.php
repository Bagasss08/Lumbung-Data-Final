<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('c_desa_persil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('c_desa_id')->constrained('c_desa')->cascadeOnDelete();
            $table->string('nomor_persil', 50);
            $table->string('kelas_tanah', 20); // cth: D-III, S-I
            $table->text('lokasi')->nullable();
            $table->decimal('luas', 10, 2); // Luas dalam M2
            $table->integer('jumlah_mutasi')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('c_desa_persil');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('lembaga_desas');
        Schema::create('lembaga_desas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('lembaga_kategoris')->onDelete('restrict');
            $table->string('nama');
            $table->string('kode')->unique();
            $table->string('no_sk')->nullable();
            $table->string('ketua')->nullable();
            $table->integer('jumlah_anggota')->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('logo')->nullable();
            $table->tinyInteger('aktif')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lembaga_desas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::dropIfExists('lembaga_dokumen');

        Schema::create('lembaga_dokumen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lembaga_id');
            $table->string('judul');
            $table->year('tahun')->nullable();
            $table->boolean('aktif')->default(true);
            $table->text('keterangan')->nullable();
            $table->string('file')->nullable();
            $table->string('status')->default('Aktif');
            $table->timestamps();

            $table->foreign('lembaga_id')
                ->references('id')
                ->on('lembaga_desas')
                ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('lembaga_dokumen');
    }
};

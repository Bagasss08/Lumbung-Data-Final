<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penerima_bantuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bantuan_id')
                  ->constrained('bantuan')
                  ->cascadeOnDelete();
            $table->foreignId('penduduk_id')
                  ->constrained('penduduk')
                  ->cascadeOnDelete();
            $table->enum('status', ['ditetapkan','disalurkan','dibatalkan'])
                  ->default('ditetapkan');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerima_bantuan');
    }
};

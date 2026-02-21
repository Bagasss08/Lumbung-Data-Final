<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('konten_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konten_id')->constrained('konten')->cascadeOnDelete();
            $table->enum('aksi', ['buat','edit','publish','arsip']);
            $table->foreignId('users_id')->constrained('users');
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konten_log');
    }
};

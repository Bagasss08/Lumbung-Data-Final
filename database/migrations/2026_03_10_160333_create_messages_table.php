<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            
            // Pengirim pesan
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            
            // Penerima pesan (Bisa dikosongkan jika memilih "Kirim ke Semua Admin")
            $table->foreignId('receiver_id')->nullable()->constrained('users')->onDelete('cascade');
            
            $table->string('judul');
            $table->text('pesan');
            $table->boolean('is_read')->default(false);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
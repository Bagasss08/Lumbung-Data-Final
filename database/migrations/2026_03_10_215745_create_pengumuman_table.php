<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumumans', function (Blueprint $table) {
            $table->id();
            
            // Siapa Superadmin yang membuat pengumuman
            $table->foreignId('dibuat_oleh')->constrained('users')->onDelete('cascade');
            
            $table->string('judul');
            $table->text('isi');
            
            // Target: 'semua', 'admin', 'operator', atau 'warga'
            $table->string('target_role'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumumans');
    }
};
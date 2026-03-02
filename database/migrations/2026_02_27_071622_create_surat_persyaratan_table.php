<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surat_persyaratan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_template_id')
                ->constrained('surat_templates')
                ->cascadeOnDelete();

            $table->foreignId('persyaratan_surat_id')
                ->constrained('persyaratan_surats')
                ->cascadeOnDelete();

            $table->timestamps();

            // Biar tidak dobel relasi yang sama
            $table->unique(['surat_template_id', 'persyaratan_surat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_persyaratan');
    }
};
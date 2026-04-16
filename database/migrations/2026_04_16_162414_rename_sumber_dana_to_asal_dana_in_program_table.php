<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('program', function (Blueprint $table) {
            $table->renameColumn('sumber_dana', 'asal_dana');
        });
    }

    public function down(): void {
        Schema::table('program', function (Blueprint $table) {
            $table->renameColumn('asal_dana', 'sumber_dana');
        });
    }
};

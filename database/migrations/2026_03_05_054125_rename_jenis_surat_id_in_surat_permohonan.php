<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('surat_permohonan', function (Blueprint $table) {
        $table->renameColumn('jenis_surat_id', 'surat_template_id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_permohonan', function (Blueprint $table) {
            //
        });
    }
};

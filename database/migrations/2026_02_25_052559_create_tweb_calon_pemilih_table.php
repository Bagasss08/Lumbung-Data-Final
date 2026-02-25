// database/migrations/xxxx_create_tweb_calon_pemilih_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tweb_calon_pemilih', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique()->comment('NIK penduduk');
            $table->string('nama', 100);
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->tinyInteger('jenis_kelamin')->nullable()->comment('1=Laki-laki, 2=Perempuan');
            $table->string('alamat', 255)->nullable();
            $table->string('rt', 4)->nullable();
            $table->string('rw', 4)->nullable();
            $table->string('dusun', 50)->nullable();
            $table->string('status_perkawinan', 50)->nullable();
            $table->string('no_kk', 16)->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->tinyInteger('aktif')->default(1)->comment('1=aktif, 0=nonaktif');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tweb_calon_pemilih');
    }
};

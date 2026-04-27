<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('layanan_mandiri_pengaturan', function (Blueprint $table) {
            $table->id();
            $table->enum('aktif', ['Ya', 'Tidak'])->default('Ya')
                ->comment('Apakah Layanan Mandiri aktif');
            $table->enum('tampilkan_pendaftaran', ['Ya', 'Tidak'])->default('Tidak')
                ->comment('Tampilkan form pendaftaran mandiri di halaman login');
            $table->enum('tampilkan_ektp', ['Ya', 'Tidak'])->default('Tidak')
                ->comment('Tampilkan tombol Login dengan E-KTP');
            $table->string('latar_login', 255)->nullable()
                ->comment('Nama file gambar latar halaman login mandiri');
            $table->timestamps();
        });

        // Seed baris default (hanya 1 baris)
        DB::table('layanan_mandiri_pengaturan')->insert([
            'aktif'                 => 'Ya',
            'tampilkan_pendaftaran' => 'Tidak',
            'tampilkan_ektp'        => 'Tidak',
            'latar_login'           => null,
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('layanan_mandiri_pengaturan');
    }
};

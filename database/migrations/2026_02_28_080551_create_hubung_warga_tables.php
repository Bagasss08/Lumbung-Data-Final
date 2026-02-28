<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tabel Kontak Eksternal (Orang Dinas, Relasi, dll yang bukan warga)
        Schema::create('kontak_eksternal', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('instansi', 150)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // 2. Tabel Grup Kontak (Misal: Grup RT 01, Grup PKK)
        Schema::create('kontak_grup', function (Blueprint $table) {
            $table->id();
            $table->string('nama_grup', 100);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 3. Tabel Pesan Utama (Inbox/Outbox)
        Schema::create('pesan', function (Blueprint $table) {
            $table->id();
            // Pengirim (Bisa Admin, bisa Warga). Merujuk ke tabel users
            $table->foreignId('pengirim_id')->constrained('users')->cascadeOnDelete();
            
            // Penerima (Jika null, berarti pesan broadcast/grup)
            $table->foreignId('penerima_id')->nullable()->constrained('users')->cascadeOnDelete();
            
            // Relasi ke grup (jika pesan dikirim ke grup)
            $table->foreignId('grup_id')->nullable()->constrained('kontak_grup')->nullOnDelete();
            
            // Untuk Threading (Balasan dari pesan sebelumnya)
            $table->foreignId('parent_id')->nullable()->constrained('pesan')->cascadeOnDelete();

            $table->string('subjek', 255)->nullable();
            $table->longText('isi_pesan');
            $table->string('lampiran')->nullable();
            
            // Status Baca di Dashboard Web
            $table->boolean('sudah_dibaca')->default(false);
            $table->timestamp('waktu_dibaca')->nullable();

            // Kesiapan untuk integrasi WhatsApp/Email nanti
            $table->enum('metode_pengiriman', ['web', 'whatsapp', 'email'])->default('web');
            $table->enum('status_pengiriman', ['tertunda', 'terkirim', 'gagal'])->default('terkirim');
            
            $table->boolean('is_arsip_pengirim')->default(false);
            $table->boolean('is_arsip_penerima')->default(false);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesan');
        Schema::dropIfExists('kontak_grup');
        Schema::dropIfExists('kontak_eksternal');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Tambah wilayah_id ke posyandu
        Schema::table('posyandu', function (Blueprint $table) {
            $table->foreignId('wilayah_id')
                ->nullable()
                ->after('rw')
                ->constrained('wilayah')
                ->nullOnDelete();
        });

        // Tambah penduduk_id_ibu, penduduk_id_anak, wilayah_id, user_id ke kia
        Schema::table('kia', function (Blueprint $table) {
            $table->foreignId('penduduk_id_ibu')
                ->nullable()
                ->after('posyandu_id')
                ->constrained('penduduk')
                ->nullOnDelete();

            $table->foreignId('penduduk_id_anak')
                ->nullable()
                ->after('penduduk_id_ibu')
                ->constrained('penduduk')
                ->nullOnDelete();

            $table->foreignId('wilayah_id')
                ->nullable()
                ->after('rw')
                ->constrained('wilayah')
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->after('wilayah_id')
                ->constrained('users')
                ->nullOnDelete();
        });

        // Tambah penduduk_id, wilayah_id, user_id ke vaksin
        Schema::table('vaksin', function (Blueprint $table) {
            $table->foreignId('penduduk_id')
                ->nullable()
                ->after('nik')
                ->constrained('penduduk')
                ->nullOnDelete();

            $table->foreignId('wilayah_id')
                ->nullable()
                ->after('rw')
                ->constrained('wilayah')
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->after('wilayah_id')
                ->constrained('users')
                ->nullOnDelete();
        });

        // Tambah user_id ke pemantauan_bumil
        Schema::table('pemantauan_bumil', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('petugas')
                ->constrained('users')
                ->nullOnDelete();
        });

        // Tambah user_id ke pemantauan_anak
        Schema::table('pemantauan_anak', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('petugas')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::table('pemantauan_anak', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('pemantauan_bumil', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('vaksin', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['wilayah_id']);
            $table->dropForeign(['penduduk_id']);
            $table->dropColumn(['user_id', 'wilayah_id', 'penduduk_id']);
        });

        Schema::table('kia', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['wilayah_id']);
            $table->dropForeign(['penduduk_id_anak']);
            $table->dropForeign(['penduduk_id_ibu']);
            $table->dropColumn(['user_id', 'wilayah_id', 'penduduk_id_anak', 'penduduk_id_ibu']);
        });

        Schema::table('posyandu', function (Blueprint $table) {
            $table->dropForeign(['wilayah_id']);
            $table->dropColumn('wilayah_id');
        });
    }
};

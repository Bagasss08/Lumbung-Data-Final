<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengecek apakah superadmin sudah ada agar tidak duplikat saat dijalankan ulang
        $cekAdmin = User::where('role', 'superadmin')->first();

        if (!$cekAdmin) {
            User::create([
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@admin.com',
                'password' => Hash::make('rahasia123'), // Ganti dengan password yang kamu inginkan
                'role' => 'superadmin',
                // 'penduduk_id' => null, // Biarkan kosong atau sesuaikan jika wajib diisi
            ]);
            
            $this->command->info('Akun Superadmin berhasil dibuat!');
        } else {
            $this->command->info('Akun Superadmin sudah ada di database.');
        }
    }
}
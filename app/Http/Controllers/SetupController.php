<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class SetupController extends Controller
{
    public function showSetup()
    {
        return view('setup');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->name, // or generate unique username
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        // Run specific migration for identitas_desa if it doesn't exist
        if (!\Illuminate\Support\Facades\Schema::hasTable('identitas_desa')) {
            try {
                Artisan::call('migrate', ['--path' => 'database/migrations/2026_02_03_052445_create_identitas_desa_table.php', '--force' => true]);
            } catch (\Exception $e) {
                // Ignore migration errors
            }
        }

        // Run seeders
        try {
            $seederExitCode = Artisan::call('db:seed', ['--force' => true]);
            if ($seederExitCode !== 0) {
                // Seeders failed, but continue anyway
            }
        } catch (\Exception $e) {
            // Ignore seeder errors
        }

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }
}

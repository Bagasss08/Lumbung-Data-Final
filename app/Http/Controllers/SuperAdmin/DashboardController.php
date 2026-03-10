<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Total Pengguna & Penambahan bulan ini
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
                                 ->whereYear('created_at', now()->year)
                                 ->count();

        // 2. Hitung Admin & Operator
        $totalAdmins = User::whereIn('role', ['superadmin', 'admin', 'operator'])->count();

        // 3. Pesan/Log Hari Ini (Kita gunakan pesan masuk sebagai contoh log harian)
        $messagesToday = Message::whereDate('created_at', today())->count();

        // 4. Aktivitas Terkini (Kombinasi User baru & Pesan baru)
        $recentUsers = User::latest()->take(2)->get()->map(function($item) {
            return [
                'bg' => '#eff6ff', // blue-50
                'dot' => '#3b82f6', // blue-500
                'msg' => 'User baru terdaftar',
                'sub' => $item->name . ' (' . strtoupper($item->role) . ') · ' . $item->created_at->diffForHumans()
            ];
        });

        $recentMessages = Message::latest()->take(2)->get()->map(function($item) {
            return [
                'bg' => '#eef2ff', // indigo-50
                'dot' => '#6366f1', // indigo-500
                'msg' => 'Pesan internal baru',
                'sub' => $item->judul . ' · ' . $item->created_at->diffForHumans()
            ];
        });

        // Gabungkan aktivitas dan ambil 4 terbaru
        $activities = $recentUsers->concat($recentMessages)->take(4);

        return view('superadmin.dashboard', compact(
            'totalUsers', 
            'newUsersThisMonth', 
            'totalAdmins', 
            'messagesToday', 
            'activities'
        ));
    }
}
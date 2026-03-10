<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class KontakController extends Controller
{
    public function index()
    {
        // Ambil pesan yang ditujukan khusus untuk Superadmin ini, 
        // ATAU pesan broadcast (receiver_id null)
        $messages = Message::with('sender')
            ->where('receiver_id', Auth::id())
            ->orWhereNull('receiver_id')
            ->latest() // Urutkan dari yang terbaru
            ->get();

        return view('superadmin.kontak.index', compact('messages'));
    }
}
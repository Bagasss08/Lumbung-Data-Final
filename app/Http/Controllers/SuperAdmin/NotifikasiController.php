<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller {
    public function create() {
        // Hanya ambil user dengan role admin, operator, atau superadmin (kecuali diri sendiri)
        $admins = Users::whereIn('role', ['admin', 'operator', 'superadmin'])
            ->where('id', '!=', Auth::id())
            ->get();

        return view('superadmin.notifikasi.create', compact('admins'));
    }

    public function store(Request $request) {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pesan' => 'required|string',
            // receiver_id boleh kosong jika pilih "Semua Admin"
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id, // Berisi ID user atau null
            'judul' => $request->judul,
            'pesan' => $request->pesan,
        ]);

        return redirect()->route('superadmin.notifikasi.create')
            ->with('success', 'Pesan berhasil dikirim ke Admin!');
    }
}

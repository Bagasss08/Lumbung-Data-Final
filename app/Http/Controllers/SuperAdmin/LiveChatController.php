<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LiveChatController extends Controller
{
    // Menampilkan halaman utama Live Chat
    public function index()
    {
        $superadminId = Auth::id();

        // Ambil data admin & hitung jumlah pesan yang belum dibaca dari masing-masing admin
        $admins = User::whereIn('role', ['admin', 'operator'])
                      ->where('id', '!=', $superadminId)
                      ->get()
                      ->map(function($admin) use ($superadminId) {
                          $admin->unread = Message::where('sender_id', $admin->id)
                                                  ->where('receiver_id', $superadminId)
                                                  ->where('is_read', false)
                                                  ->count();
                          return $admin;
                      });

        return view('superadmin.livechat.index', compact('admins'));
    }

    // Mengambil riwayat pesan antara Superadmin dan Admin tertentu (via AJAX)
    public function fetchMessages($userId)
    {
        $superadminId = Auth::id();

        // Cari riwayat chat
        $messages = Message::where(function($q) use ($superadminId, $userId) {
            $q->where('sender_id', $superadminId)->where('receiver_id', $userId);
        })->orWhere(function($q) use ($superadminId, $userId) {
            $q->where('sender_id', $userId)->where('receiver_id', $superadminId);
        })->orderBy('created_at', 'asc')->get()->map(function($msg) use ($superadminId) {
            return [
                'id' => $msg->id,
                'pesan' => $msg->pesan,
                'is_sender' => $msg->sender_id === $superadminId,
                'time' => $msg->created_at->format('H:i')
            ];
        });

        // Ubah status pesan yang diterima superadmin menjadi sudah dibaca
        Message::where('sender_id', $userId)
               ->where('receiver_id', $superadminId)
               ->where('is_read', false)
               ->update(['is_read' => true]);

        return response()->json(['messages' => $messages]);
    }

    // Mengirim pesan ke Admin tertentu (via AJAX)
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'pesan' => 'required|string'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'judul' => 'Pesan dari Superadmin',
            'pesan' => $request->pesan,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'pesan' => $message->pesan,
                'is_sender' => true, // Selalu true karena ini pesan yang baru saja kita kirim
                'time' => $message->created_at->format('H:i')
            ]
        ]);
    }
}
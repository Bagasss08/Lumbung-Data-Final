<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function fetchMessages()
    {
        $adminId = Auth::id();
        $superadmin = User::where('role', 'superadmin')->first();

        if (!$superadmin) {
            return response()->json(['messages' => []]);
        }

        // Ambil riwayat chat antara Admin ini dan Superadmin
        $messages = Message::where(function($q) use ($adminId, $superadmin) {
            $q->where('sender_id', $adminId)->where('receiver_id', $superadmin->id);
        })->orWhere(function($q) use ($adminId, $superadmin) {
            $q->where('sender_id', $superadmin->id)->where('receiver_id', $adminId);
        })->orderBy('created_at', 'asc')->get()->map(function($msg) use ($adminId) {
            return [
                'id' => $msg->id,
                'pesan' => $msg->pesan,
                'is_sender' => $msg->sender_id === $adminId, // true = pesan dari Admin (kanan), false = dari SA (kiri)
                'time' => $msg->created_at->format('H:i')
            ];
        });

        return response()->json(['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['pesan' => 'required|string']);

        $superadmin = User::where('role', 'superadmin')->first();

        if (!$superadmin) {
            return response()->json(['error' => 'Superadmin tidak ditemukan'], 404);
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $superadmin->id,
            'judul' => 'Pesan Bantuan Bubble Chat', // Diisi otomatis karena tabel membutuhkan judul
            'pesan' => $request->pesan,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'pesan' => $message->pesan,
                'is_sender' => true,
                'time' => $message->created_at->format('H:i')
            ]
        ]);
    }

    public function fetchPengumuman()
    {
        try {
            // Tarik data pengumuman yang targetnya untuk admin/semua
            $pengumumans = \App\Models\Pengumuman::whereIn('target_role', ['semua', 'admin', 'operator', 'Semua', 'Admin', 'Operator'])
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get()
                            ->map(function($p) {
                                return [
                                    'id' => $p->id,
                                    'judul' => $p->judul,
                                    'isi' => $p->isi,
                                    'waktu' => $p->created_at ? $p->created_at->diffForHumans() : 'Baru saja'
                                ];
                            });

            return response()->json(['items' => $pengumumans]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
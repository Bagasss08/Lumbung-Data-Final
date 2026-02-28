<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $pesan = Pesan::with('pengirim')
            ->where('penerima_id', $userId)
            ->where('is_arsip_penerima', false)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('warga.pesan.index', compact('pesan'));
    }

    public function show($id)
    {
        $pesan = Pesan::with(['pengirim', 'penerima'])->findOrFail($id);

        if ($pesan->penerima_id !== Auth::id() && $pesan->pengirim_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pesan ini.');
        }

        if ($pesan->penerima_id === Auth::id() && !$pesan->sudah_dibaca) {
            $pesan->update([
                'sudah_dibaca' => true,
                'waktu_dibaca' => now()
            ]);
        }

        return view('warga.pesan.show', compact('pesan'));
    }

    public function create(Request $request)
    {
        $replyTo = $request->get('reply_to');
        $subject = $request->get('subject');

        return view('warga.pesan.create', compact('replyTo', 'subject'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subjek' => 'required|string|max:255',
            'isi_pesan' => 'required|string',
        ]);

        $penerima_id = $request->reply_to;

        // Jika ini bukan balasan (menulis pesan baru), cari ID Admin
        if (!$penerima_id) {
            // Cari user yang memiliki hak akses admin
            $admin = User::whereIn('role', ['admin', 'administrator', 'Admin', 'Administrator'])->first();
            
            // Fallback: Jika role admin tidak terdeteksi, ambil user ID 1 (biasanya akun pembuat sistem/admin)
            if (!$admin) {
                $admin = User::first(); 
            }

            if (!$admin) {
                return redirect()->back()->with('error', 'Gagal mengirim pesan: Tidak ada Admin yang ditemukan di sistem.');
            }

            $penerima_id = $admin->id;
        }

        Pesan::create([
            'pengirim_id' => Auth::id(),
            'penerima_id' => $penerima_id,
            'subjek' => $request->subjek,
            'isi_pesan' => $request->isi_pesan,
            'status_pengiriman' => 'terkirim'
        ]);

        // Jika berhasil, akan dikembalikan ke halaman index warga dengan membawa notif success
        return redirect()->route('warga.pesan.index')->with('success', 'Pesan berhasil dikirim ke Admin Desa.');
    }
}
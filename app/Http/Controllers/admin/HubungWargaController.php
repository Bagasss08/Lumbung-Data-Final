<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HubungWargaController extends Controller
{
    // Kotak Masuk: Ambil semua pesan di mana PENGIRIMNYA adalah Warga
    public function inbox()
    {
        $pesan = Pesan::with('pengirim')
            ->whereHas('pengirim', function($query) {
                $query->where('role', 'warga');
            })
            ->where('is_arsip_penerima', false)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.hubung-warga.inbox', compact('pesan'));
    }

    // Pesan Terkirim: Ambil semua pesan di mana PENERIMANYA adalah Warga
    public function sent()
    {
        $pesan = Pesan::with('penerima')
            ->whereHas('penerima', function($query) {
                $query->where('role', 'warga');
            })
            ->where('is_arsip_pengirim', false)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.hubung-warga.sent', compact('pesan'));
    }

    public function create(Request $request)
    {
        $warga = User::where('role', 'warga')->with('penduduk')->get();
        $replyTo = $request->get('reply_to');
        $subject = $request->get('subject');

        return view('admin.hubung-warga.create', compact('warga', 'replyTo', 'subject'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penerima_id' => 'required|exists:users,id',
            'subjek' => 'required|string|max:255',
            'isi_pesan' => 'required',
        ]);

        Pesan::create([
            'pengirim_id' => Auth::id(),
            'penerima_id' => $request->penerima_id,
            'subjek' => $request->subjek,
            'isi_pesan' => $request->isi_pesan,
            'status_pengiriman' => 'terkirim'
        ]);

        return redirect()->route('admin.hubung-warga.sent')->with('success', 'Pesan berhasil dikirim ke warga!');
    }

    public function show($id)
    {
        $pesan = Pesan::with(['pengirim', 'penerima'])->findOrFail($id);

        // Jika admin membuka pesan baru dari warga, tandai sudah dibaca
        if (!$pesan->sudah_dibaca && $pesan->pengirim && $pesan->pengirim->role == 'warga') {
            $pesan->update([
                'sudah_dibaca' => true,
                'waktu_dibaca' => now()
            ]);
        }

        return view('admin.hubung-warga.show', compact('pesan'));
    }
}
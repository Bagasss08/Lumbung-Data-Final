<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    // Menampilkan daftar pengumuman yang sudah dikirim
    public function index()
    {
        $pengumumans = Pengumuman::with('pembuat')->latest()->paginate(10);
        return view('superadmin.pengumuman.index', compact('pengumumans'));
    }

    // Form untuk membuat pengumuman baru
    public function create()
    {
        return view('superadmin.pengumuman.create');
    }

    // Proses menyimpan pengumuman ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'target_role' => 'required|in:semua,admin,operator,warga'
        ]);

        Pengumuman::create([
            'dibuat_oleh' => Auth::id(),
            'judul' => $request->judul,
            'isi' => $request->isi,
            'target_role' => $request->target_role,
        ]);

        return redirect()->route('superadmin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil disebarkan ke audiens target!');
    }

    // Menghapus pengumuman
    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('superadmin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditarik/dihapus.');
    }
}
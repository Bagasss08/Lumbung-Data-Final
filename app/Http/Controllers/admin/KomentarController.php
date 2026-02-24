<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KomentarArtikel;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    // Menampilkan semua komentar (diurutkan dari yang pending)
    public function index()
    {
        $komentars = KomentarArtikel::with('artikel')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')") // Pending muncul paling atas
            ->latest()
            ->paginate(15);

        return view('admin.komentar.index', compact('komentars'));
    }

    // Menyetujui komentar
    public function approve($id)
    {
        $komentar = KomentarArtikel::findOrFail($id);
        $komentar->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Komentar berhasil disetujui dan akan tampil di website.');
    }

    // Menolak komentar (misal: mengandung unsur buruk)
    public function reject($id)
    {
        $komentar = KomentarArtikel::findOrFail($id);
        $komentar->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Komentar ditolak dan disembunyikan dari website.');
    }

    // Menghapus komentar secara permanen
    public function destroy($id)
    {
        $komentar = KomentarArtikel::findOrFail($id);
        $komentar->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus permanen.');
    }
}
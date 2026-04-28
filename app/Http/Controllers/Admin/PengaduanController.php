<?php
// app/Http/Controllers/Admin/PengaduanController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller {
    public function index(Request $request) {
        $query = Pengaduan::with(['penduduk', 'petugas'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('subjek', 'like', "%$search%");
            });
        }

        $pengaduans = $query->paginate(10)->withQueryString();
        $statusList  = Pengaduan::$statusLabel;

        return view('admin.pengaduan.index', compact('pengaduans', 'statusList'));
    }

    public function show(Pengaduan $pengaduan) {
        $pengaduan->load(['penduduk', 'petugas']);
        $statusList = Pengaduan::$statusLabel;

        return view('admin.pengaduan.show', compact('pengaduan', 'statusList'));
    }

    public function tanggapi(Request $request, Pengaduan $pengaduan) {
        $request->validate([
            'tanggapan' => 'required|string|min:5',
            'status'    => 'required|in:1,2,3,4',
        ]);

        $pengaduan->update([
            'tanggapan'  => $request->tanggapan,
            'status'     => $request->status,
            'petugas_id' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.pengaduan.show', $pengaduan)
            ->with('success', 'Tanggapan berhasil disimpan.');
    }

    public function destroy(Pengaduan $pengaduan) {
        if ($pengaduan->lampiran) {
            Storage::disk('public')->delete($pengaduan->lampiran);
        }

        $pengaduan->delete();

        return redirect()
            ->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }
}

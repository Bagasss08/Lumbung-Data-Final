<?php

namespace App\Http\Controllers\Admin\LayananSurat;

use App\Http\Controllers\Controller;
use App\Models\ArsipSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    /**
     * Halaman daftar arsip
     */
    public function index()
    {
        $arsip = ArsipSurat::latest()->paginate(10);

        return view('arsip.index', compact('arsip'));
    }

    /**
     * Detail arsip
     */
    public function show($id)
    {
        $arsip = ArsipSurat::findOrFail($id);

        return view('arsip.show', compact('arsip'));
    }

    /**
     * Download file arsip
     */
    public function download($id)
    {
        $arsip = ArsipSurat::findOrFail($id);

        if (!Storage::exists($arsip->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::download($arsip->file_path);
    }

    /**
     * Soft delete arsip
     */
    public function destroy($id)
    {
        $arsip = ArsipSurat::findOrFail($id);
        $arsip->delete();

        return redirect()->route('arsip.index')
            ->with('success', 'Arsip berhasil dihapus.');
    }
}
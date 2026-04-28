<?php

namespace App\Http\Controllers\Admin\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BukuAgendaSuratKeluar;

class AgendaSuratKeluarController extends Controller
{
    public function index()
    {
        $suratKeluar = BukuAgendaSuratKeluar::latest()->paginate(10);
        return view('admin.buku-administrasi.umum.agenda-surat-keluar.index', compact('suratKeluar'));
    }

    public function create()
    {
        return view('admin.buku-administrasi.umum.agenda-surat-keluar.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_pengiriman' => 'required|date',
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'isi_singkat' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        BukuAgendaSuratKeluar::create($validated);

        return redirect()->route('admin.buku-administrasi.umum.agenda-surat-keluar.index')
                         ->with('success', 'Data Surat Keluar berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $suratKeluar = BukuAgendaSuratKeluar::findOrFail($id);
        return view('admin.buku-administrasi.umum.agenda-surat-keluar.edit', compact('suratKeluar'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'tanggal_pengiriman' => 'required|date',
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'isi_singkat' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $suratKeluar = BukuAgendaSuratKeluar::findOrFail($id);
        $suratKeluar->update($validated);

        return redirect()->route('admin.buku-administrasi.umum.agenda-surat-keluar.index')
                         ->with('success', 'Data Surat Keluar berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $suratKeluar = BukuAgendaSuratKeluar::findOrFail($id);
        $suratKeluar->delete();

        return redirect()->route('admin.buku-administrasi.umum.agenda-surat-keluar.index')
                         ->with('success', 'Data Surat Keluar berhasil dihapus.');
    }
}
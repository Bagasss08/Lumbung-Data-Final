<?php

namespace App\Http\Controllers\Admin\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BukuAgendaSuratMasuk;

class AgendaSuratMasukController extends Controller
{
    public function index()
    {
        $suratMasuk = BukuAgendaSuratMasuk::latest()->paginate(10);
        return view('admin.buku-administrasi.umum.agenda-surat-masuk.index', compact('suratMasuk'));
    }

    public function create()
    {
        return view('admin.buku-administrasi.umum.agenda-surat-masuk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_penerimaan' => 'required|date',
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'isi_singkat' => 'required|string',
            'disposisi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        BukuAgendaSuratMasuk::create($validated);

        return redirect()->route('admin.buku-administrasi.umum.agenda-surat-masuk.index')
                         ->with('success', 'Data Surat Masuk berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $suratMasuk = BukuAgendaSuratMasuk::findOrFail($id);
        return view('admin.buku-administrasi.umum.agenda-surat-masuk.edit', compact('suratMasuk'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'tanggal_penerimaan' => 'required|date',
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'isi_singkat' => 'required|string',
            'disposisi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $suratMasuk = BukuAgendaSuratMasuk::findOrFail($id);
        $suratMasuk->update($validated);

        return redirect()->route('admin.buku-administrasi.umum.agenda-surat-masuk.index')
                         ->with('success', 'Data Surat Masuk berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $suratMasuk = BukuAgendaSuratMasuk::findOrFail($id);
        $suratMasuk->delete();

        return redirect()->route('admin.buku-administrasi.umum.agenda-surat-masuk.index')
                         ->with('success', 'Data Surat Masuk berhasil dihapus.');
    }
}
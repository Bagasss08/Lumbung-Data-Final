<?php

namespace App\Http\Controllers\Admin\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BukuEkspedisi;

class EkspedisiController extends Controller
{
    public function index()
    {
        $ekspedisi = BukuEkspedisi::latest()->paginate(10);
        return view('admin.buku-administrasi.umum.ekspedisi.index', compact('ekspedisi'));
    }

    public function create()
    {
        return view('admin.buku-administrasi.umum.ekspedisi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_pengiriman' => 'required|date',
            'tanggal_surat' => 'required|date',
            'nomor_surat' => 'required|string|max:255',
            'isi_singkat' => 'required|string',
            'tujuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        BukuEkspedisi::create($validated);

        return redirect()->route('admin.buku-administrasi.umum.ekspedisi.index')
                         ->with('success', 'Data pengiriman surat berjaya ditambah ke Buku Ekspedisi.');
    }

    public function edit(string $id)
    {
        $ekspedisi = BukuEkspedisi::findOrFail($id);
        return view('admin.buku-administrasi.umum.ekspedisi.edit', compact('ekspedisi'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'tanggal_pengiriman' => 'required|date',
            'tanggal_surat' => 'required|date',
            'nomor_surat' => 'required|string|max:255',
            'isi_singkat' => 'required|string',
            'tujuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $ekspedisi = BukuEkspedisi::findOrFail($id);
        $ekspedisi->update($validated);

        return redirect()->route('admin.buku-administrasi.umum.ekspedisi.index')
                         ->with('success', 'Data Buku Ekspedisi berjaya dikemas kini.');
    }

    public function destroy(string $id)
    {
        $ekspedisi = BukuEkspedisi::findOrFail($id);
        $ekspedisi->delete();

        return redirect()->route('admin.buku-administrasi.umum.ekspedisi.index')
                         ->with('success', 'Data Buku Ekspedisi berjaya dipadam.');
    }
}
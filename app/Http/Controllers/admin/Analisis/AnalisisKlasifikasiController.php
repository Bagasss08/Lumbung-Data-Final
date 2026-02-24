<?php

namespace App\Http\Controllers\Admin\Analisis;

use App\Http\Controllers\Controller;
use App\Models\AnalisisMaster;
use App\Models\AnalisisKlasifikasi;
use Illuminate\Http\Request;

class AnalisisKlasifikasiController extends Controller
{
    public function store(Request $request, AnalisisMaster $analisi)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:100',
            'skor_min' => 'required|numeric',
            'skor_max' => 'required|numeric|gte:skor_min',
            'warna'    => 'nullable|string|max:20',
            'urutan'   => 'nullable|integer',
        ]);

        $validated['id_master'] = $analisi->id;
        $validated['urutan']    = $validated['urutan'] ?? ($analisi->klasifikasi()->max('urutan') + 1);

        AnalisisKlasifikasi::create($validated);

        return back()->with('success', 'Klasifikasi berhasil ditambahkan!');
    }

    public function update(Request $request, AnalisisMaster $analisi, AnalisisKlasifikasi $klasifikasi)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:100',
            'skor_min' => 'required|numeric',
            'skor_max' => 'required|numeric|gte:skor_min',
            'warna'    => 'nullable|string|max:20',
            'urutan'   => 'nullable|integer',
        ]);

        $klasifikasi->update($validated);

        return back()->with('success', 'Klasifikasi berhasil diperbarui!');
    }

    public function destroy(AnalisisMaster $analisi, AnalisisKlasifikasi $klasifikasi)
    {
        $klasifikasi->delete();
        return back()->with('success', 'Klasifikasi berhasil dihapus!');
    }
}

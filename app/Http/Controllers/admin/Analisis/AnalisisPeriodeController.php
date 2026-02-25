<?php

namespace App\Http\Controllers\Admin\Analisis;

use App\Http\Controllers\Controller;
use App\Models\AnalisisMaster;
use App\Models\AnalisisPeriode;
use Illuminate\Http\Request;

class AnalisisPeriodeController extends Controller
{
    public function store(Request $request, AnalisisMaster $analisi)
    {
        $validated = $request->validate([
            'nama'            => 'required|string|max:100',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'aktif'           => 'boolean',
        ]);

        $validated['id_master'] = $analisi->id;
        $validated['aktif']    = $request->boolean('aktif', true);

        AnalisisPeriode::create($validated);

        return back()->with('success', 'Periode berhasil ditambahkan!');
    }

    public function update(Request $request, AnalisisMaster $analisi, AnalisisPeriode $periode)
    {
        $validated = $request->validate([
            'nama'            => 'required|string|max:100',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'aktif'           => 'boolean',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);
        $periode->update($validated);

        return back()->with('success', 'Periode berhasil diperbarui!');
    }

    public function destroy(AnalisisMaster $analisi, AnalisisPeriode $periode)
    {
        if ($periode->responden()->exists()) {
            return back()->with('error', 'Periode tidak dapat dihapus karena sudah memiliki data responden.');
        }
        $periode->delete();
        return back()->with('success', 'Periode berhasil dihapus!');
    }
}

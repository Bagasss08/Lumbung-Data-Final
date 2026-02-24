<?php

namespace App\Http\Controllers\Admin\Analisis;

use App\Http\Controllers\Controller;
use App\Models\AnalisisMaster;
use App\Models\AnalisisIndikator;
use App\Models\AnalisisJawaban;
use Illuminate\Http\Request;

class AnalisisIndikatorController extends Controller {
    public function store(Request $request, AnalisisMaster $analisi) {
        if ($analisi->lock) {
            return back()->with('error', 'Analisis dikunci, tidak bisa menambah indikator.');
        }

        $validated = $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'jenis'      => 'required|in:OPTION,RADIO,TEXT,TEXTAREA,DATE,NUMBER',
            'aktif'      => 'boolean',
            'urutan'     => 'nullable|integer|min:1',
        ]);

        $validated['aktif']   = $request->boolean('aktif', true);
        $validated['urutan']  = $validated['urutan'] ?? ($analisi->indikator()->max('urutan') + 1);
        $validated['id_master'] = $analisi->id;

        AnalisisIndikator::create($validated);

        return back()->with('success', 'Indikator berhasil ditambahkan!');
    }

    public function update(Request $request, AnalisisMaster $analisi, AnalisisIndikator $indikator) {
        $validated = $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'jenis'      => 'required|in:OPTION,RADIO,TEXT,TEXTAREA,DATE,NUMBER',
            'aktif'      => 'boolean',
            'urutan'     => 'nullable|integer|min:1',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);
        $indikator->update($validated);

        return back()->with('success', 'Indikator berhasil diperbarui!');
    }

    public function destroy(AnalisisMaster $analisi, AnalisisIndikator $indikator) {
        if ($analisi->lock) {
            return back()->with('error', 'Analisis dikunci.');
        }
        $indikator->delete();
        return back()->with('success', 'Indikator berhasil dihapus!');
    }

    // ── Jawaban (opsi) ───────────────────────────────────────────────────────

    public function storeJawaban(Request $request, AnalisisMaster $analisi, AnalisisIndikator $indikator) {
        $validated = $request->validate([
            'jawaban' => 'required|string|max:200',
            'nilai'   => 'required|numeric',
            'urutan'  => 'nullable|integer',
        ]);

        $validated['id_indikator'] = $indikator->id;
        $validated['urutan'] = $validated['urutan'] ?? ($indikator->jawaban()->max('urutan') + 1);

        AnalisisJawaban::create($validated);

        return back()->with('success', 'Opsi jawaban berhasil ditambahkan!');
    }

    public function destroyJawaban(AnalisisMaster $analisi, AnalisisIndikator $indikator, AnalisisJawaban $jawaban) {
        $jawaban->delete();
        return back()->with('success', 'Opsi jawaban berhasil dihapus!');
    }

    public function reorder(Request $request, AnalisisMaster $analisi) {
        $request->validate(['urutan' => 'required|array']);
        foreach ($request->urutan as $id => $urutan) {
            AnalisisIndikator::where('id', $id)->where('id_master', $analisi->id)->update(['urutan' => $urutan]);
        }
        return response()->json(['success' => true]);
    }
}

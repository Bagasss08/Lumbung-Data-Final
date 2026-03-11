<?php

namespace App\Http\Controllers\Admin\Ppid;

use App\Http\Controllers\Controller;
use App\Models\PpidJenisDokumen;
use Illuminate\Http\Request;

class PpidJenisController extends Controller {
    public function index() {
        $jenis = PpidJenisDokumen::withCount('dokumen')->latest()->paginate(15);
        return view('admin.ppid.jenis.index', compact('jenis'));
    }

    public function create() {
        return view('admin.ppid.jenis.form');
    }

    public function store(Request $request) {
        $request->validate([
            'nama'       => 'required|string|max:255|unique:ppid_jenis_dokumen,nama',
            'keterangan' => 'nullable|string',
        ]);

        PpidJenisDokumen::create($request->all());

        return redirect()->route('admin.ppid.jenis.index')
            ->with('success', 'Jenis dokumen berhasil ditambahkan!');
    }

    public function edit(PpidJenisDokumen $jeni) {
        return view('admin.ppid.jenis.form', ['jenis' => $jeni]);
    }

    public function update(Request $request, PpidJenisDokumen $jeni) {
        $request->validate([
            'nama'       => 'required|string|max:255|unique:ppid_jenis_dokumen,nama,' . $jeni->id,
            'keterangan' => 'nullable|string',
        ]);

        $jeni->update($request->all());

        return redirect()->route('admin.ppid.jenis.index')
            ->with('success', 'Jenis dokumen berhasil diperbarui!');
    }

    public function destroy(PpidJenisDokumen $jeni) {
        if ($jeni->dokumen()->count() > 0) {
            return redirect()->route('admin.ppid.jenis.index')
                ->with('error', 'Jenis dokumen tidak dapat dihapus karena masih digunakan!');
        }

        $jeni->delete();

        return redirect()->route('admin.ppid.jenis.index')
            ->with('success', 'Jenis dokumen berhasil dihapus!');
    }
}

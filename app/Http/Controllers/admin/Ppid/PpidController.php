<?php

namespace App\Http\Controllers\Admin\Ppid;

use App\Http\Controllers\Controller;
use App\Models\PpidDokumen;
use App\Models\PpidJenisDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PpidController extends Controller {
    public function index(Request $request) {
        $query = PpidDokumen::with('jenisDokumen');

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        if ($request->filled('jenis_dokumen')) {
            $query->where('ppid_jenis_dokumen_id', $request->jenis_dokumen);
        }

        $dokumen     = $query->latest()->paginate(10)->withQueryString();
        $jenisList   = PpidJenisDokumen::orderBy('nama')->get();
        $tahunList   = PpidDokumen::selectRaw('DISTINCT tahun')
            ->whereNotNull('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('admin.ppid.index', compact('dokumen', 'jenisList', 'tahunList'));
    }

    public function create() {
        $jenisList = PpidJenisDokumen::orderBy('nama')->get();
        return view('admin.ppid.form', compact('jenisList'));
    }

    public function store(Request $request) {
        $request->validate([
            'judul_dokumen'        => 'required|string|max:255',
            'ppid_jenis_dokumen_id' => 'nullable|exists:ppid_jenis_dokumen,id',
            'tahun'                => 'nullable|integer|min:2000|max:2099',
            'bulan'                => 'nullable|integer|min:1|max:12',
            'waktu_retensi'        => 'nullable|string|max:100',
            'tanggal_terbit'       => 'nullable|date',
            'keterangan'           => 'nullable|string',
            'file_path'            => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:10240',
            'status'               => 'required|in:aktif,tidak_aktif',
        ]);

        $data = $request->except('file_path');

        if ($request->hasFile('file_path')) {
            $data['file_path'] = $request->file('file_path')
                ->store('ppid/dokumen', 'public');
        }

        PpidDokumen::create($data);

        return redirect()->route('admin.ppid.index')
            ->with('success', 'Dokumen PPID berhasil ditambahkan!');
    }

    public function show(PpidDokumen $ppid) {
        $ppid->load('jenisDokumen');
        return view('admin.ppid.show', compact('ppid'));
    }

    public function edit(PpidDokumen $ppid) {
        $jenisList = PpidJenisDokumen::orderBy('nama')->get();
        return view('admin.ppid.form', compact('ppid', 'jenisList'));
    }

    public function update(Request $request, PpidDokumen $ppid) {
        $request->validate([
            'judul_dokumen'        => 'required|string|max:255',
            'ppid_jenis_dokumen_id' => 'nullable|exists:ppid_jenis_dokumen,id',
            'tahun'                => 'nullable|integer|min:2000|max:2099',
            'bulan'                => 'nullable|integer|min:1|max:12',
            'waktu_retensi'        => 'nullable|string|max:100',
            'tanggal_terbit'       => 'nullable|date',
            'keterangan'           => 'nullable|string',
            'file_path'            => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:10240',
            'status'               => 'required|in:aktif,tidak_aktif',
        ]);

        $data = $request->except('file_path');

        if ($request->hasFile('file_path')) {
            // Hapus file lama
            if ($ppid->file_path) {
                Storage::disk('public')->delete($ppid->file_path);
            }
            $data['file_path'] = $request->file('file_path')
                ->store('ppid/dokumen', 'public');
        }

        $ppid->update($data);

        return redirect()->route('admin.ppid.index')
            ->with('success', 'Dokumen PPID berhasil diperbarui!');
    }

    public function destroy(PpidDokumen $ppid) {
        if ($ppid->file_path) {
            Storage::disk('public')->delete($ppid->file_path);
        }
        $ppid->delete();

        return redirect()->route('admin.ppid.index')
            ->with('success', 'Dokumen PPID berhasil dihapus!');
    }
}

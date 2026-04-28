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
            $query->where(function ($q) use ($request) {
                $q->where('tahun', $request->tahun)
                    ->orWhere(function ($q2) use ($request) {
                        $q2->whereNull('tahun')
                            ->whereYear('tanggal_terbit', $request->tahun);
                    });
            });
        }

        if ($request->filled('bulan')) {
            $query->where(function ($q) use ($request) {
                $q->where('bulan', $request->bulan)
                    ->orWhere(function ($q2) use ($request) {
                        $q2->whereNull('bulan')
                            ->whereMonth('tanggal_terbit', $request->bulan);
                    });
            });
        }

        if ($request->filled('jenis_dokumen')) {
            $query->where('ppid_jenis_dokumen_id', $request->jenis_dokumen);
        }

        // Filter pencarian (search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_dokumen', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('jenisDokumen', fn($q2) => $q2->where('nama', 'like', "%{$search}%"));
            });
        }

        // Jumlah entri per halaman
        $perPage   = in_array((int) $request->get('per_page'), [10, 25, 50, 100])
            ? (int) $request->get('per_page')
            : 10;

        $dokumen   = $query->latest()->paginate($perPage)->withQueryString();
        $jenisList = PpidJenisDokumen::orderBy('nama')->get();
        $tahunList = range(date('Y'), 2020);

        return view('admin.ppid.index', compact('dokumen', 'jenisList', 'tahunList', 'perPage'));
    }

    public function create() {
        $jenisList = PpidJenisDokumen::orderBy('nama')->get();
        return view('admin.ppid.form', compact('jenisList'));
    }

    public function store(Request $request) {
        $request->validate([
            'judul_dokumen'         => 'required|string|max:255',
            'ppid_jenis_dokumen_id' => 'nullable|exists:ppid_jenis_dokumen,id',
            'retensi_nilai'         => 'nullable|integer|min:0',
            'retensi_satuan'        => 'nullable|string|max:20',
            'tipe_dokumen'          => 'nullable|in:file,link',
            'tanggal_terbit'        => 'nullable|date',
            'keterangan'            => 'nullable|string',
            'file_path'             => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'status'                => 'required|in:aktif,tidak_aktif',
        ]);

        $data = $request->except('file_path');

        // Auto-isi tahun & bulan dari tanggal_terbit
        if ($request->filled('tanggal_terbit')) {
            $data['tahun'] = date('Y', strtotime($request->tanggal_terbit));
            $data['bulan'] = (int) date('n', strtotime($request->tanggal_terbit));
        }

        // Gabungkan retensi untuk kolom waktu_retensi (backward compat)
        if ($request->filled('retensi_nilai') && $request->filled('retensi_satuan')) {
            $data['waktu_retensi'] = $request->retensi_nilai . ' ' . $request->retensi_satuan;
        }

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
            'judul_dokumen'         => 'required|string|max:255',
            'ppid_jenis_dokumen_id' => 'nullable|exists:ppid_jenis_dokumen,id',
            'retensi_nilai'         => 'nullable|integer|min:0',
            'retensi_satuan'        => 'nullable|string|max:20',
            'tipe_dokumen'          => 'nullable|in:file,link',
            'tanggal_terbit'        => 'nullable|date',
            'keterangan'            => 'nullable|string',
            'file_path'             => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'status'                => 'required|in:aktif,tidak_aktif',
        ]);

        $data = $request->except('file_path');

        // Auto-isi tahun & bulan dari tanggal_terbit
        if ($request->filled('tanggal_terbit')) {
            $data['tahun'] = date('Y', strtotime($request->tanggal_terbit));
            $data['bulan'] = (int) date('n', strtotime($request->tanggal_terbit));
        }

        // Gabungkan retensi untuk kolom waktu_retensi (backward compat)
        if ($request->filled('retensi_nilai') && $request->filled('retensi_satuan')) {
            $data['waktu_retensi'] = $request->retensi_nilai . ' ' . $request->retensi_satuan;
        }

        if ($request->hasFile('file_path')) {
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

    public function bulkDestroy(Request $request) {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:ppid_dokumen,id',
        ]);

        $dokumen = PpidDokumen::whereIn('id', $request->ids)->get();

        foreach ($dokumen as $item) {
            if ($item->file_path) {
                Storage::disk('public')->delete($item->file_path);
            }
            $item->delete();
        }

        return redirect()->route('admin.ppid.index')
            ->with('success', count($request->ids) . ' dokumen berhasil dihapus!');
    }

    public function updateLokasi(Request $request, $id) {
        $request->validate([
            'lokasi_arsip' => 'nullable|string|max:255',
            'kategori'     => 'required|string',
        ]);

        // Untuk dokumen_desa, update di ppid_dokumen
        if ($request->kategori === 'dokumen_desa') {
            PpidDokumen::findOrFail($id)->update([
                'lokasi_arsip' => $request->lokasi_arsip,
            ]);
        } else {
            // Untuk kategori lain, update di tabel arsip
            Arsip::findOrFail($id)->update([
                'lokasi_arsip' => $request->lokasi_arsip,
            ]);
        }

        return back()->with('success', 'Lokasi arsip berhasil diperbarui.');
    }
}

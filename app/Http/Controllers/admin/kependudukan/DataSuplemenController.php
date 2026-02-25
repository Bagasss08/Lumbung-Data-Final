<?php

namespace App\Http\Controllers\Admin\Kependudukan;

use App\Http\Controllers\Controller;
use App\Models\DataSuplemen;
use App\Models\SuplemenTerdata;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataSuplemenController extends Controller {
    // ─── Master Suplemen ────────────────────────────────────────────

    public function index(Request $request) {
        $query = DataSuplemen::withCount('terdata');

        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('sasaran')) {
            $query->where('sasaran', $request->sasaran);
        }
        if ($request->filled('aktif')) {
            $query->where('aktif', $request->aktif);
        }

        $suplemen = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.suplemen.index', compact('suplemen'));
    }

    public function create() {
        return view('admin.suplemen.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama'        => 'required|string|max:100',
            'sasaran'     => 'required|in:1,2',
            'keterangan'  => 'nullable|string',
            'logo'        => 'nullable|image|max:2048',
            'tgl_mulai'   => 'nullable|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_mulai',
        ]);

        // Checkbox aktif → 1 atau 0
        $validated['aktif'] = $request->has('aktif') ? 1 : 0;

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('suplemen', 'public');
        }

        DataSuplemen::create($validated);

        return redirect()->route('admin.suplemen.index')
            ->with('success', 'Data suplemen berhasil ditambahkan.');
    }

    public function show(DataSuplemen $suplemen) {
        $terdata = $suplemen->terdata()->with('penduduk', 'keluarga')->paginate(20);
        return view('admin.suplemen.show', compact('suplemen', 'terdata'));
    }

    public function edit(DataSuplemen $suplemen) {
        return view('admin.suplemen.edit', compact('suplemen'));
    }

    public function update(Request $request, DataSuplemen $suplemen) {
        $validated = $request->validate([
            'nama'        => 'required|string|max:100',
            'sasaran'     => 'required|in:1,2',
            'keterangan'  => 'nullable|string',
            'logo'        => 'nullable|image|max:2048',
            'tgl_mulai'   => 'nullable|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_mulai',
        ]);

        $validated['aktif'] = $request->has('aktif') ? 1 : 0;

        if ($request->hasFile('logo')) {
            if ($suplemen->logo) {
                Storage::disk('public')->delete($suplemen->logo);
            }
            $validated['logo'] = $request->file('logo')->store('suplemen', 'public');
        }

        $suplemen->update($validated);

        return redirect()->route('admin.suplemen.index')
            ->with('success', 'Data suplemen berhasil diperbarui.');
    }

    public function destroy(DataSuplemen $suplemen) {
        if ($suplemen->logo) {
            Storage::disk('public')->delete($suplemen->logo);
        }
        $suplemen->delete();

        return redirect()->route('admin.suplemen.index')
            ->with('success', 'Data suplemen berhasil dihapus.');
    }

    // ─── Anggota Terdata ────────────────────────────────────────────

    public function terdataIndex(DataSuplemen $suplemen) {
        $terdata = $suplemen->terdata()
            ->with(['penduduk', 'keluarga'])
            ->paginate(20);

        return view('admin.suplemen.terdata.index', compact('suplemen', 'terdata'));
    }

    public function terdataCreate(DataSuplemen $suplemen) {
        if ($suplemen->sasaran == '1') {
            // Perorangan: ambil NIK yang belum terdata di suplemen ini
            $sudahTerdata = $suplemen->terdata()->pluck('id_pend');

            $penduduk = Penduduk::whereNotIn('nik', $sudahTerdata)
                ->where('status_hidup', 'hidup')
                ->select('nik', 'nama')  // ← hapus no_kk
                ->orderBy('nama')
                ->get();
        } else {
            // Keluarga: ambil No. KK yang belum terdata
            $sudahTerdata = $suplemen->terdata()->pluck('no_kk');
            $penduduk     = collect(); // tidak dipakai untuk sasaran keluarga
        }

        return view('admin.suplemen.terdata.create', compact('suplemen', 'penduduk'));
    }

    public function terdataStore(Request $request, DataSuplemen $suplemen) {
        if ($suplemen->sasaran == '1') {
            $request->validate([
                'id_pend'    => 'required|string|max:16|exists:penduduk,nik',
                'keterangan' => 'nullable|string|max:255',
            ]);

            // Cegah duplikat
            $sudahAda = SuplemenTerdata::where('id_suplemen', $suplemen->id)
                ->where('id_pend', $request->id_pend)
                ->exists();

            if ($sudahAda) {
                return back()->with('error', 'Penduduk ini sudah terdaftar di suplemen ini.');
            }

            SuplemenTerdata::create([
                'id_suplemen' => $suplemen->id,
                'id_pend'     => $request->id_pend,
                'keterangan'  => $request->keterangan,
            ]);
        } else {
            $request->validate([
                'no_kk'      => 'required|string|max:16',
                'keterangan' => 'nullable|string|max:255',
            ]);

            // Cegah duplikat No. KK
            $sudahAda = SuplemenTerdata::where('id_suplemen', $suplemen->id)
                ->where('no_kk', $request->no_kk)
                ->exists();

            if ($sudahAda) {
                return back()->with('error', 'No. KK ini sudah terdaftar di suplemen ini.');
            }

            SuplemenTerdata::create([
                'id_suplemen' => $suplemen->id,
                'no_kk'       => $request->no_kk,
                'keterangan'  => $request->keterangan,
            ]);
        }

        return redirect()->route('admin.suplemen.terdata.index', $suplemen)
            ->with('success', 'Anggota terdata berhasil ditambahkan.');
    }

    public function terdataDestroy(DataSuplemen $suplemen, SuplemenTerdata $terdata) {
        $terdata->delete();

        return redirect()->route('admin.suplemen.terdata.index', $suplemen)
            ->with('success', 'Anggota terdata berhasil dihapus.');
    }
}

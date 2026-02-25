<?php

namespace App\Http\Controllers\Admin\Kependudukan;

use App\Http\Controllers\Controller;
use App\Models\CalonPemilih;
use Illuminate\Http\Request;

class CalonPemilihController extends Controller {
    public function index(Request $request) {
        $query = CalonPemilih::query();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->q . '%')
                    ->orWhere('nik', 'like', '%' . $request->q . '%');
            });
        }
        if ($request->filled('dusun')) {
            $query->where('dusun', $request->dusun);
        }
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        if ($request->filled('aktif')) {
            $query->where('aktif', $request->aktif);
        }

        $calonPemilih = $query->orderBy('nama')->paginate(20)->withQueryString();

        $dusunList = CalonPemilih::select('dusun')->distinct()->whereNotNull('dusun')->pluck('dusun');
        $totalLaki    = CalonPemilih::where('aktif', 1)->where('jenis_kelamin', 1)->count();
        $totalPerempuan = CalonPemilih::where('aktif', 1)->where('jenis_kelamin', 2)->count();

        return view('admin.calon-pemilih.index', compact(
            'calonPemilih',
            'dusunList',
            'totalLaki',
            'totalPerempuan'
        ));
    }

    public function create() {
        return view('admin.calon-pemilih.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nik'               => 'required|string|max:16|unique:tweb_calon_pemilih,nik',
            'nama'              => 'required|string|max:100',
            'tempat_lahir'      => 'nullable|string|max:50',
            'tanggal_lahir'     => 'nullable|date',
            'jenis_kelamin'     => 'nullable|in:1,2',
            'alamat'            => 'nullable|string|max:255',
            'rt'                => 'nullable|string|max:4',
            'rw'                => 'nullable|string|max:4',
            'dusun'             => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|string|max:50',
            'no_kk'             => 'nullable|string|max:16',
            'keterangan'        => 'nullable|string|max:255',
            'aktif'             => 'boolean',
        ]);

        CalonPemilih::create($validated);

        return redirect()->route('admin.calon-pemilih.index')
            ->with('success', 'Calon pemilih berhasil ditambahkan.');
    }

    public function show(CalonPemilih $calonPemilih) {
        return view('admin.calon-pemilih.show', compact('calonPemilih'));
    }

    public function edit(CalonPemilih $calonPemilih) {
        return view('admin.calon-pemilih.edit', compact('calonPemilih'));
    }

    public function update(Request $request, CalonPemilih $calonPemilih) {
        $validated = $request->validate([
            'nik'               => 'required|string|max:16|unique:tweb_calon_pemilih,nik,' . $calonPemilih->id,
            'nama'              => 'required|string|max:100',
            'tempat_lahir'      => 'nullable|string|max:50',
            'tanggal_lahir'     => 'nullable|date',
            'jenis_kelamin'     => 'nullable|in:1,2',
            'alamat'            => 'nullable|string|max:255',
            'rt'                => 'nullable|string|max:4',
            'rw'                => 'nullable|string|max:4',
            'dusun'             => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|string|max:50',
            'no_kk'             => 'nullable|string|max:16',
            'keterangan'        => 'nullable|string|max:255',
            'aktif'             => 'boolean',
        ]);

        $calonPemilih->update($validated);

        return redirect()->route('admin.calon-pemilih.index')
            ->with('success', 'Data calon pemilih berhasil diperbarui.');
    }

    public function destroy(CalonPemilih $calonPemilih) {
        $calonPemilih->delete();

        return redirect()->route('admin.calon-pemilih.index')
            ->with('success', 'Calon pemilih berhasil dihapus.');
    }

    public function toggleAktif(CalonPemilih $calonPemilih) {
        $calonPemilih->update(['aktif' => !$calonPemilih->aktif]);

        return back()->with('success', 'Status berhasil diubah.');
    }
}

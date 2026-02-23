<?php

namespace App\Http\Controllers\Admin\Kependudukan;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use App\Models\KelompokAnggota;
use App\Models\KelompokMaster;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelompokController extends Controller {
    // =========================================================
    // KELOMPOK MASTER (Jenis Kelompok)
    // =========================================================

    public function masterIndex() {
        $data = KelompokMaster::withCount('kelompok')->orderBy('nama')->get();
        return view('admin.kelompok.master.index', compact('data'));
    }

    public function masterStore(Request $request) {
        $request->validate([
            'nama'      => 'required|string|max:100|unique:kelompok_master,nama',
            'singkatan' => 'nullable|string|max:20',
            'jenis'     => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        KelompokMaster::create($request->only('nama', 'singkatan', 'jenis', 'keterangan'));

        return redirect()->route('admin.kelompok.master.index')
            ->with('success', 'Jenis kelompok berhasil ditambahkan.');
    }

    public function masterUpdate(Request $request, KelompokMaster $master) {
        $request->validate([
            'nama'      => 'required|string|max:100|unique:kelompok_master,nama,' . $master->id,
            'singkatan' => 'nullable|string|max:20',
            'jenis'     => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $master->update($request->only('nama', 'singkatan', 'jenis', 'keterangan'));

        return redirect()->route('admin.kelompok.master.index')
            ->with('success', 'Jenis kelompok berhasil diperbarui.');
    }

    public function masterDestroy(KelompokMaster $master) {
        if ($master->kelompok()->count() > 0) {
            return redirect()->route('admin.kelompok.master.index')
                ->with('error', 'Tidak dapat menghapus jenis kelompok yang masih memiliki data kelompok.');
        }
        $master->delete();
        return redirect()->route('admin.kelompok.master.index')
            ->with('success', 'Jenis kelompok berhasil dihapus.');
    }

    // =========================================================
    // KELOMPOK
    // =========================================================

    public function index(Request $request) {
        $query = Kelompok::with('master')
            ->withCount('anggotaAktif');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('singkatan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('master')) {
            $query->where('id_kelompok_master', $request->master);
        }

        if ($request->filled('aktif')) {
            $query->where('aktif', $request->aktif);
        }

        $kelompok = $query->orderBy('nama')->paginate(15)->withQueryString();
        $masterList = KelompokMaster::orderBy('nama')->get();

        return view('admin.kelompok.index', compact('kelompok', 'masterList'));
    }

    public function create() {
        $masterList = KelompokMaster::orderBy('nama')->get();
        return view('admin.kelompok.create', compact('masterList'));
    }

    public function store(Request $request) {
        $request->validate([
            'id_kelompok_master' => 'required|exists:kelompok_master,id',
            'nama'               => 'required|string|max:100',
            'singkatan'          => 'nullable|string|max:20',
            'tgl_terbentuk'      => 'nullable|date',
            'sk_desa'            => 'nullable|string|max:100',
            'tgl_sk_desa'        => 'nullable|date',
            'sk_kabupaten'       => 'nullable|string|max:100',
            'tgl_sk_kabupaten'   => 'nullable|date',
            'nik_ketua'          => 'nullable|string|max:16',
            'nama_ketua'         => 'nullable|string|max:100',
            'telepon'            => 'nullable|string|max:20',
            'alamat'             => 'nullable|string',
            'aktif'              => 'required|in:1,0',
            'keterangan'         => 'nullable|string',
        ]);

        Kelompok::create($request->all());

        return redirect()->route('admin.kelompok.index')
            ->with('success', 'Kelompok berhasil ditambahkan.');
    }

    public function show(Kelompok $kelompok) {
        $kelompok->load(['master', 'anggota.penduduk']);
        return view('admin.kelompok.show', compact('kelompok'));
    }

    public function edit(Kelompok $kelompok) {
        $masterList = KelompokMaster::orderBy('nama')->get();
        return view('admin.kelompok.edit', compact('kelompok', 'masterList'));
    }

    public function update(Request $request, Kelompok $kelompok) {
        $request->validate([
            'id_kelompok_master' => 'required|exists:kelompok_master,id',
            'nama'               => 'required|string|max:100',
            'singkatan'          => 'nullable|string|max:20',
            'tgl_terbentuk'      => 'nullable|date',
            'sk_desa'            => 'nullable|string|max:100',
            'tgl_sk_desa'        => 'nullable|date',
            'sk_kabupaten'       => 'nullable|string|max:100',
            'tgl_sk_kabupaten'   => 'nullable|date',
            'nik_ketua'          => 'nullable|string|max:16',
            'nama_ketua'         => 'nullable|string|max:100',
            'telepon'            => 'nullable|string|max:20',
            'alamat'             => 'nullable|string',
            'aktif'              => 'required|in:1,0',
            'keterangan'         => 'nullable|string',
        ]);

        $kelompok->update($request->all());

        return redirect()->route('admin.kelompok.show', $kelompok)
            ->with('success', 'Kelompok berhasil diperbarui.');
    }

    public function destroy(Kelompok $kelompok) {
        $kelompok->delete();
        return redirect()->route('admin.kelompok.index')
            ->with('success', 'Kelompok berhasil dihapus.');
    }

    // =========================================================
    // ANGGOTA KELOMPOK
    // =========================================================

    public function anggotaIndex(Kelompok $kelompok) {
        $kelompok->load(['master', 'anggota.penduduk']);
        return view('admin.kelompok.anggota.index', compact('kelompok'));
    }

    public function anggotaCreate(Kelompok $kelompok) {
        // Ambil NIK yang sudah menjadi anggota aktif agar tidak dobel
        $nikSudahAnggota = $kelompok->anggotaAktif()->pluck('nik')->toArray();

        // Penduduk hidup yang belum jadi anggota aktif di kelompok ini
        $pendudukList = Penduduk::whereNotIn('nik', $nikSudahAnggota)
            ->where('status_hidup', '!=', 'meninggal')  // filter penduduk aktif
            ->orderBy('nama')
            ->get(['nik', 'nama', 'jenis_kelamin', 'alamat']);

        return view('admin.kelompok.anggota.create', compact('kelompok', 'pendudukList'));
    }

    public function anggotaStore(Request $request, Kelompok $kelompok) {
        $request->validate([
            'nik'       => 'required|string|max:16',
            'jabatan'   => 'nullable|string|max:50',
            'tgl_masuk' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        // Cek apakah sudah menjadi anggota aktif
        $existing = KelompokAnggota::where('id_kelompok', $kelompok->id)
            ->where('nik', $request->nik)
            ->where('aktif', '1')
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Penduduk ini sudah menjadi anggota aktif kelompok.')
                ->withInput();
        }

        KelompokAnggota::create([
            'id_kelompok' => $kelompok->id,
            'nik'         => $request->nik,
            'jabatan'     => $request->jabatan,
            'tgl_masuk'   => $request->tgl_masuk,
            'aktif'       => '1',
            'keterangan'  => $request->keterangan,
        ]);

        return redirect()->route('admin.kelompok.anggota.index', $kelompok)
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function anggotaDestroy(Kelompok $kelompok, KelompokAnggota $anggota) {
        $anggota->update(['aktif' => '0', 'tgl_keluar' => now()]);
        return redirect()->route('admin.kelompok.anggota.index', $kelompok)
            ->with('success', 'Anggota berhasil dikeluarkan dari kelompok.');
    }

    public function anggotaDestroySoft(Kelompok $kelompok, KelompokAnggota $anggota) {
        $anggota->delete();
        return redirect()->route('admin.kelompok.anggota.index', $kelompok)
            ->with('success', 'Data anggota berhasil dihapus.');
    }

    // =========================================================
    // SEARCH PENDUDUK (AJAX)
    // =========================================================

    public function searchPenduduk(Request $request) {
        $term = $request->get('q', '');
        $results = Penduduk::where(function ($q) use ($term) {
            $q->where('nik', 'like', "%$term%")
                ->orWhere('nama', 'like', "%$term%");
        })
            ->where('status_hidup', '!=', 'meninggal')
            ->orderBy('nama')
            ->limit(20)
            ->get(['nik', 'nama', 'alamat'])
            ->map(fn($p) => [
                'id'      => $p->nik,
                'text'    => "{$p->nik} — {$p->nama}",
                'alamat'  => $p->alamat ?? '',
            ]);

        return response()->json(['results' => $results]);
    }
}

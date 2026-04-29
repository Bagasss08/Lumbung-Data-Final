<?php

namespace App\Http\Controllers\Admin\BukuAdministrasi;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class KtpKkController extends Controller {
    /* ------------------------------------------------------------------ */
    /*  Landing Page                                                        */
    /* ------------------------------------------------------------------ */
    public function index() {
        $totalKtp = Penduduk::count();
        $totalKk  = Keluarga::count();

        return view('admin.buku-administrasi.penduduk.ktp-kk.index', compact(
            'totalKtp',
            'totalKk'
        ));
    }

    /* ================================================================== */
    /*  KTP  — pakai tabel `penduduk`                                      */
    /* ================================================================== */

    public function indexKtp(Request $request) {
        $query = Penduduk::with('wilayah');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('nik', 'like', "%$q%")
                    ->orWhere('nama', 'like', "%$q%");
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('status_hidup')) {
            $query->where('status_hidup', $request->status_hidup);
        }

        $ktpList = $query->latest()->paginate(15)->withQueryString();

        return view('admin.buku-administrasi.penduduk.ktp-kk.ktp.index', compact('ktpList'));
    }

    public function createKtp() {
        return view('admin.buku-administrasi.penduduk.ktp-kk.ktp.create');
    }

    public function storeKtp(Request $request) {
        $validated = $request->validate([
            'nik'              => 'required|string|size:16|unique:penduduk,nik',
            'nama'             => 'required|string|max:255',
            'jenis_kelamin'    => 'required|in:L,P',
            'tempat_lahir'     => 'required|string|max:100',
            'tanggal_lahir'    => 'required|date',
            'golongan_darah'   => 'nullable|in:A,B,AB,O,-',
            'agama'            => 'required|string|max:50',
            'pendidikan'       => 'nullable|string|max:100',
            'pekerjaan'        => 'nullable|string|max:100',
            'status_kawin'     => 'required|string|max:50',
            'status_hidup'     => 'required|string|max:20',
            'kewarganegaraan'  => 'required|string|max:10',
            'no_telp'          => 'nullable|string|max:20',
            'email'            => 'nullable|email|max:100',
            'alamat'           => 'required|string',
            'wilayah_id'       => 'nullable|exists:wilayah,id',
        ]);

        Penduduk::create($validated);

        return redirect()->route('admin.buku-administrasi.penduduk.ktp-kk.ktp.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function showKtp(Penduduk $ktp) {
        $ktp->load('wilayah', 'keluarga.rumahTangga');
        return view('admin.buku-administrasi.penduduk.ktp-kk.ktp.show', compact('ktp'));
    }

    public function editKtp(Penduduk $ktp) {
        return view('admin.buku-administrasi.penduduk.ktp-kk.ktp.edit', compact('ktp'));
    }

    public function updateKtp(Request $request, Penduduk $ktp) {
        $validated = $request->validate([
            'nik'              => 'required|string|size:16|unique:penduduk,nik,' . $ktp->id,
            'nama'             => 'required|string|max:255',
            'jenis_kelamin'    => 'required|in:L,P',
            'tempat_lahir'     => 'required|string|max:100',
            'tanggal_lahir'    => 'required|date',
            'golongan_darah'   => 'nullable|in:A,B,AB,O,-',
            'agama'            => 'required|string|max:50',
            'pendidikan'       => 'nullable|string|max:100',
            'pekerjaan'        => 'nullable|string|max:100',
            'status_kawin'     => 'required|string|max:50',
            'status_hidup'     => 'required|string|max:20',
            'kewarganegaraan'  => 'required|string|max:10',
            'no_telp'          => 'nullable|string|max:20',
            'email'            => 'nullable|email|max:100',
            'alamat'           => 'required|string',
            'wilayah_id'       => 'nullable|exists:wilayah,id',
        ]);

        $ktp->update($validated);

        return redirect()->route('admin.buku-administrasi.penduduk.ktp-kk.ktp.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroyKtp(Penduduk $ktp) {
        $ktp->delete();

        return redirect()->route('admin.buku-administrasi.penduduk.ktp-kk.ktp.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }

    /* ================================================================== */
    /*  KK — pakai tabel `keluarga` + pivot `keluarga_anggota`            */
    /* ================================================================== */

    public function indexKk(Request $request) {
        $query = Keluarga::with('wilayah')->withCount('anggota');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where('no_kk', 'like', "%$q%");
        }

        $kkList = $query->latest()->paginate(15)->withQueryString();

        return view('admin.buku-administrasi.penduduk.ktp-kk.kk.index', compact('kkList'));
    }

    public function createKk() {
        $pendudukList = Penduduk::orderBy('nama')->get(['id', 'nik', 'nama']);
        return view('admin.buku-administrasi.penduduk.ktp-kk.kk.create', compact('pendudukList'));
    }

    public function storeKk(Request $request) {
        $validated = $request->validate([
            'no_kk'               => 'required|string|max:16|unique:keluarga,no_kk',
            'alamat'              => 'required|string',
            'wilayah_id'          => 'nullable|exists:wilayah,id',
            'tgl_terdaftar'       => 'required|date',
            'klasifikasi_ekonomi' => 'nullable|string|max:50',
            'jenis_bantuan_aktif' => 'nullable|string|max:100',
            // Anggota
            'anggota'                         => 'required|array|min:1',
            'anggota.*.penduduk_id'           => 'required|exists:penduduk,id',
            'anggota.*.hubungan_keluarga'     => 'required|string|max:50',
        ]);

        // Pastikan ada tepat 1 kepala keluarga
        $kepalaCount = collect($validated['anggota'])
            ->where('hubungan_keluarga', 'kepala_keluarga')->count();

        if ($kepalaCount !== 1) {
            return back()->withInput()
                ->withErrors(['anggota' => 'Harus ada tepat satu Kepala Keluarga.']);
        }

        $kk = Keluarga::create([
            'no_kk'               => $validated['no_kk'],
            'alamat'              => $validated['alamat'],
            'wilayah_id'          => $validated['wilayah_id'] ?? null,
            'tgl_terdaftar'       => $validated['tgl_terdaftar'],
            'klasifikasi_ekonomi' => $validated['klasifikasi_ekonomi'] ?? null,
            'jenis_bantuan_aktif' => $validated['jenis_bantuan_aktif'] ?? null,
        ]);

        // Sync pivot many-to-many
        $syncData = [];
        foreach ($validated['anggota'] as $a) {
            $syncData[$a['penduduk_id']] = ['hubungan_keluarga' => $a['hubungan_keluarga']];
        }
        $kk->anggota()->sync($syncData);

        return redirect()->route('admin.buku-administrasi.penduduk.ktp-kk.kk.index')
            ->with('success', 'Data KK berhasil ditambahkan.');
    }

    public function showKk(Keluarga $kk) {
        $kk->load('anggota', 'wilayah');
        return view('admin.buku-administrasi.penduduk.ktp-kk.kk.show', compact('kk'));
    }

    public function editKk(Keluarga $kk) {
        $kk->load('anggota');
        $pendudukList = Penduduk::orderBy('nama')->get(['id', 'nik', 'nama']);
        return view('admin.buku-administrasi.penduduk.ktp-kk.kk.edit', compact('kk', 'pendudukList'));
    }

    public function updateKk(Request $request, Keluarga $kk) {
        $validated = $request->validate([
            'no_kk'               => 'required|string|max:16|unique:keluarga,no_kk,' . $kk->id,
            'alamat'              => 'required|string',
            'wilayah_id'          => 'nullable|exists:wilayah,id',
            'tgl_terdaftar'       => 'required|date',
            'klasifikasi_ekonomi' => 'nullable|string|max:50',
            'jenis_bantuan_aktif' => 'nullable|string|max:100',
            'anggota'                     => 'required|array|min:1',
            'anggota.*.penduduk_id'       => 'required|exists:penduduk,id',
            'anggota.*.hubungan_keluarga' => 'required|string|max:50',
        ]);

        $kepalaCount = collect($validated['anggota'])
            ->where('hubungan_keluarga', 'kepala_keluarga')->count();

        if ($kepalaCount !== 1) {
            return back()->withInput()
                ->withErrors(['anggota' => 'Harus ada tepat satu Kepala Keluarga.']);
        }

        $kk->update([
            'no_kk'               => $validated['no_kk'],
            'alamat'              => $validated['alamat'],
            'wilayah_id'          => $validated['wilayah_id'] ?? null,
            'tgl_terdaftar'       => $validated['tgl_terdaftar'],
            'klasifikasi_ekonomi' => $validated['klasifikasi_ekonomi'] ?? null,
            'jenis_bantuan_aktif' => $validated['jenis_bantuan_aktif'] ?? null,
        ]);

        $syncData = [];
        foreach ($validated['anggota'] as $a) {
            $syncData[$a['penduduk_id']] = ['hubungan_keluarga' => $a['hubungan_keluarga']];
        }
        $kk->anggota()->sync($syncData);

        return redirect()->route('admin.buku-administrasi.penduduk.ktp-kk.kk.index')
            ->with('success', 'Data KK berhasil diperbarui.');
    }

    public function destroyKk(Keluarga $kk) {
        // Detach semua anggota dulu dari pivot
        $kk->anggota()->detach();
        $kk->delete();

        return redirect()->route('admin.buku-administrasi.penduduk.ktp-kk.kk.index')
            ->with('success', 'Data KK berhasil dihapus.');
    }
}

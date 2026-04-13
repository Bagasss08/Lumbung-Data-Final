<?php

namespace App\Http\Controllers\Admin\Kependudukan;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\RumahTangga;
use App\Models\Wilayah;
use App\Models\Ref\RefAgama;
use App\Models\Ref\RefPendidikan;
use App\Models\Ref\RefPekerjaan;
use App\Models\Ref\RefStatusKawin;
use App\Models\Ref\RefWarganegara;
use App\Models\Ref\RefGolonganDarah;
use App\Models\Ref\RefShdk;
use App\Models\Ref\RefCacat;
use App\Models\Ref\RefSakitMenahun;
use App\Models\Ref\RefCaraKb;
use App\Models\Ref\RefAsuransi;
use App\Models\Ref\RefBahasa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;

class KeluargaController extends Controller {
    // =========================================================================
    // INDEX
    // =========================================================================

    public function index(Request $request) {
        $query = Keluarga::withCount('anggota')
            ->with(['kepalaKeluarga:id,nama,nik,jenis_kelamin,foto,tag_id_card', 'wilayah']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', "%{$search}%")
                    ->orWhereHas('kepalaKeluarga', fn($q2) => $q2->where('nama', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%"));
            });
        }

        // Filter wilayah
        if ($request->filled('wilayah_id')) {
            $query->where('wilayah_id', $request->wilayah_id);
        } elseif ($request->filled('dusun')) {
            $query->whereHas('wilayah', fn($q) => $q->where('dusun', $request->dusun));
        }

        // Filter jenis kelamin kepala KK
        if ($request->filled('jenis_kelamin')) {
            $query->whereHas('kepalaKeluarga', fn($q) => $q->where('jenis_kelamin', $request->jenis_kelamin));
        }

        // Filter status KK — sesuai OpenSID: aktif | nonaktif (hilang/pindah/mati) | kosong
        if ($request->filled('status_kk')) {
            match ($request->status_kk) {
                // KK Aktif: kepala masih hidup
                'aktif'    => $query->whereHas('kepalaKeluarga', fn($q) => $q->where('status_dasar', Penduduk::STATUS_DASAR_HIDUP)),
                // KK Hilang/Pindah/Mati: kepala sudah tidak aktif
                'nonaktif' => $query->whereHas('kepalaKeluarga', fn($q) => $q->whereIn('status_dasar', [
                    Penduduk::STATUS_DASAR_MATI,
                    Penduduk::STATUS_DASAR_PINDAH,
                    Penduduk::STATUS_DASAR_HILANG,
                    Penduduk::STATUS_DASAR_PERGI,
                ])),
                // KK Kosong: tidak punya anggota sama sekali
                'kosong'   => $query->doesntHave('anggota'),
                default    => null,
            };
        }

        $perPage  = (int) $request->get('per_page', 10);
        $keluarga = $query->orderBy('no_kk')->paginate($perPage)->appends($request->query());

        // Stats
        $stats = [
            'total'    => Keluarga::count(),
            'aktif'    => Keluarga::aktif()->count(),
            'nonaktif' => Keluarga::tidakAktif()->count(),
        ];

        // Dropdown
        $wilayahList = Wilayah::orderBy('dusun')->orderBy('rw')->orderBy('rt')->get();
        $dusunList   = $wilayahList->pluck('dusun')->filter()->unique()->values();

        $pendudukLepas = Penduduk::wargaAktif()
            ->whereNull('keluarga_id')
            ->select('id', 'nik', 'nama', 'jenis_kelamin', 'wilayah_id')
            ->orderBy('nama')
            ->get();

        return view('admin.keluarga', compact(
            'keluarga',
            'stats',
            'wilayahList',
            'dusunList',
            'pendudukLepas',
        ));
    }

    // =========================================================================
    // CREATE — Pilih cara tambah KK baru
    // =========================================================================

    /**
     * Form tambah KK baru — penduduk masuk (input data baru).
     */
    public function createMasuk() {
        $wilayah         = Wilayah::orderBy('dusun')->orderBy('rw')->orderBy('rt')->get();
        $refAgama        = RefAgama::orderBy('nama')->get();
        $refPendidikan   = RefPendidikan::orderBy('id')->get();
        $refPekerjaan    = RefPekerjaan::orderBy('nama')->get();
        $refStatusKawin  = RefStatusKawin::orderBy('id')->get();
        $refWarganegara  = RefWarganegara::orderBy('nama')->get();
        $refGolDarah     = RefGolonganDarah::orderBy('nama')->get();
        $refShdk         = RefShdk::orderBy('id')->get();
        $refCacat        = RefCacat::orderBy('nama')->get();
        $refSakitMenahun = RefSakitMenahun::orderBy('nama')->get();
        $refCaraKb       = RefCaraKb::orderBy('nama')->get();
        $refAsuransi     = RefAsuransi::orderBy('nama')->get();
        $refBahasa       = RefBahasa::orderBy('nama')->get();

        return view('admin.keluarga-create-masuk', compact(
            'wilayah', 'refAgama', 'refPendidikan', 'refPekerjaan',
            'refStatusKawin', 'refWarganegara', 'refGolDarah', 'refShdk',
            'refCacat', 'refSakitMenahun', 'refCaraKb', 'refAsuransi', 'refBahasa',
        ));
    }

    /**
     * Form tambah KK baru — dari penduduk yang sudah ada (penduduk lepas).
     * Penduduk lepas = status hidup + belum punya KK (keluarga_id null).
     */
    public function createDariPenduduk() {
        $pendudukLepas = Penduduk::wargaAktif()
            ->whereNull('keluarga_id')
            ->select('id', 'nik', 'nama', 'jenis_kelamin')
            ->orderBy('nama')
            ->get();

        $wilayah = Wilayah::orderBy('dusun')->orderBy('rw')->orderBy('rt')->get();

        return view('admin.keluarga-create-dari-penduduk', compact('pendudukLepas', 'wilayah'));
    }

    // =========================================================================
    // STORE
    // =========================================================================

    /**
     * Simpan KK baru — penduduk masuk (data baru sekaligus).
     */
    public function storeMasuk(Request $request) {
        $request->validate([
            'no_kk'         => 'required|string|max:16|unique:keluarga,no_kk',
            'alamat'        => 'nullable|string',
            'wilayah_id'    => 'required|exists:wilayah,id',
            'tgl_terdaftar' => 'required|date',
            // Data kepala keluarga baru
            'nik'           => 'required|string|size:16|unique:penduduk,nik',
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama_id'      => 'required|integer',
        ]);

        DB::transaction(function () use ($request) {
            // Buat KK dulu, kepala_keluarga_id diisi setelah penduduk dibuat
            $keluarga = Keluarga::create([
                'no_kk'         => $request->no_kk,
                'alamat'        => $request->alamat,
                'wilayah_id'    => $request->wilayah_id,
                'tgl_terdaftar' => $request->tgl_terdaftar,
                'status'        => Keluarga::STATUS_AKTIF,
            ]);

            // Buat data penduduk kepala KK baru
            $kepala = Penduduk::create([
                'nik'           => $request->nik,
                'nama'          => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama_id'      => $request->agama_id,
                'keluarga_id'   => $keluarga->id,
                'kk_level'      => Penduduk::SHDK_KEPALA_KELUARGA,
                'wilayah_id'    => $request->wilayah_id,
                'status_dasar'  => Penduduk::STATUS_DASAR_HIDUP,
                'status'        => Penduduk::STATUS_TETAP,
                'jenis_tambah'  => Penduduk::JENIS_TAMBAH_MASUK,
                'tgl_terdaftar' => $request->tgl_terdaftar,
            ]);

            // Update FK kepala di KK
            $keluarga->update([
                'kepala_keluarga_id' => $kepala->id,
                'nik_kepala'         => $kepala->nik,
            ]);
        });

        return redirect()->route('admin.keluarga')
            ->with('success', 'KK baru berhasil ditambahkan.');
    }

    /**
     * Simpan KK baru — dari penduduk yang sudah ada.
     */
    public function storeDariPenduduk(Request $request) {
        $request->validate([
            'no_kk'              => 'required|string|max:16|unique:keluarga,no_kk',
            'kepala_keluarga_id' => 'required|exists:penduduk,id',
            'tgl_terdaftar'      => 'nullable|date',
        ]);

        // Validasi: pastikan penduduk benar-benar lepas dan masih hidup
        $kepala = Penduduk::where('id', $request->kepala_keluarga_id)
            ->where('status_dasar', Penduduk::STATUS_DASAR_HIDUP)
            ->whereNull('keluarga_id')
            ->first();

        if (! $kepala) {
            return back()->withErrors(['kepala_keluarga_id' => 'Penduduk tidak valid atau sudah terdaftar di KK lain.'])->withInput();
        }

        // wilayah_id diambil dari wilayah penduduk yang dipilih, bukan dari form
        $wilayahId = $kepala->wilayah_id;

        DB::transaction(function () use ($request, $kepala, $wilayahId) {
            $keluarga = Keluarga::create([
                'no_kk'              => $request->no_kk,
                'wilayah_id'         => $wilayahId,
                'tgl_terdaftar'      => $request->tgl_terdaftar ?? now()->toDateString(),
                'status'             => Keluarga::STATUS_AKTIF,
                'kepala_keluarga_id' => $kepala->id,
                'nik_kepala'         => $kepala->nik,
            ]);

            $kepala->update([
                'keluarga_id' => $keluarga->id,
                'kk_level'    => Penduduk::SHDK_KEPALA_KELUARGA,
            ]);
        });

        return redirect()->route('admin.keluarga')
            ->with('success', 'KK baru berhasil ditambahkan.');
    }

    // =========================================================================
    // SHOW — Detail & daftar anggota
    // =========================================================================

    public function show(Keluarga $keluarga) {
        $keluarga->load([
            'wilayah',
            'kepalaKeluarga',
            'anggota' => fn($q) => $q->orderByRaw("FIELD(kk_level, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10)"),
            'anggota.agama',
            'anggota.pekerjaan',
            'anggota.statusKawin',
            'rumahTangga',
        ]);

        // Penduduk lepas untuk tambah anggota dari penduduk sudah ada
        $pendudukLepas = Penduduk::wargaAktif()
            ->whereNull('keluarga_id')
            ->select('id', 'nik', 'nama', 'jenis_kelamin')
            ->orderBy('nama')
            ->get();

        return view('admin.keluarga-show', compact('keluarga', 'pendudukLepas'));
    }

    // =========================================================================
    // EDIT & UPDATE — Data KK + Kepala Keluarga
    // =========================================================================

    public function edit(Keluarga $keluarga) {
        $keluarga->load('kepalaKeluarga', 'anggota:id,nik,nama,kk_level');

        $wilayah         = Wilayah::orderBy('dusun')->orderBy('rw')->orderBy('rt')->get();
        $refAgama        = RefAgama::orderBy('nama')->get();
        $refPendidikan   = RefPendidikan::orderBy('id')->get();
        $refPekerjaan    = RefPekerjaan::orderBy('nama')->get();
        $refStatusKawin  = RefStatusKawin::orderBy('id')->get();
        $refWarganegara  = RefWarganegara::orderBy('nama')->get();
        $refGolDarah     = RefGolonganDarah::orderBy('nama')->get();
        $refShdk         = RefShdk::orderBy('id')->get();
        $refCacat        = RefCacat::orderBy('nama')->get();
        $refSakitMenahun = RefSakitMenahun::orderBy('nama')->get();
        $refCaraKb       = RefCaraKb::orderBy('nama')->get();
        $refAsuransi     = RefAsuransi::orderBy('nama')->get();
        $refBahasa       = RefBahasa::orderBy('nama')->get();

        return view('admin.keluarga-edit', compact(
            'keluarga',
            'wilayah',
            'refAgama',
            'refPendidikan',
            'refPekerjaan',
            'refStatusKawin',
            'refWarganegara',
            'refGolDarah',
            'refShdk',
            'refCacat',
            'refSakitMenahun',
            'refCaraKb',
            'refAsuransi',
            'refBahasa',
        ));
    }

    public function update(Request $request, Keluarga $keluarga) {
        $request->validate([
            // Data KK
            'no_kk'               => 'required|string|max:16|unique:keluarga,no_kk,' . $keluarga->id,
            'alamat'              => 'nullable|string',
            'wilayah_id'          => 'required|exists:wilayah,id',
            'tgl_terdaftar'       => 'required|date',
            'tgl_cetak_kk'        => 'nullable|date',
            'klasifikasi_ekonomi' => 'nullable|in:miskin,rentan,mampu',
            'jenis_bantuan_aktif' => 'nullable|string|max:255',
            // Data Kepala Keluarga (Penduduk)
            'nik'                 => 'required|string|size:16|unique:penduduk,nik,' . ($keluarga->kepala_keluarga_id ?? 'NULL'),
            'nama'                => 'required|string|max:255',
            'jenis_kelamin'       => 'required|in:L,P',
            'tempat_lahir'        => 'required|string|max:255',
            'tanggal_lahir'       => 'required|date',
            'agama_id'            => 'required|integer|exists:ref_agama,id',
            'nama_ibu'            => 'required|string|max:255',
            'warganegara_id'      => 'required|integer|exists:ref_warganegara,id',
            'status_kawin_id'     => 'required|integer|exists:ref_status_kawin,id',
            'email'               => 'nullable|email|max:255',
            // Opsional
            'kk_level'            => 'nullable|integer|min:1|max:10',
            'status'              => 'nullable|in:1,2,3',
            'ktp_el'              => 'nullable|in:0,1',
            'status_rekam'        => 'nullable|in:1,2,3,4',
            'foto'                => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request, $keluarga) {
            // ── 1. Update data KK ────────────────────────────────────────────
            $keluarga->update([
                'no_kk'               => $request->no_kk,
                'alamat'              => $request->alamat,
                'wilayah_id'          => $request->wilayah_id,
                'tgl_terdaftar'       => $request->tgl_terdaftar,
                'tgl_cetak_kk'        => $request->tgl_cetak_kk,
                'klasifikasi_ekonomi' => $request->klasifikasi_ekonomi,
                'jenis_bantuan_aktif' => $request->jenis_bantuan_aktif,
            ]);

            // ── 2. Update data Penduduk kepala ────────────────────────────────
            $kepala = $keluarga->kepalaKeluarga;
            if ($kepala) {
                // Handle upload foto
                $fotoPath = $kepala->foto;
                if ($request->hasFile('foto')) {
                    if ($fotoPath) {
                        \Storage::disk('public')->delete($fotoPath);
                    }
                    $fotoPath = $request->file('foto')->store('penduduk/foto', 'public');
                }

                $kepala->update([
                    'nik'                 => $request->nik,
                    'nama'                => $request->nama,
                    'jenis_kelamin'       => $request->jenis_kelamin,
                    'tempat_lahir'        => $request->tempat_lahir,
                    'tanggal_lahir'       => $request->tanggal_lahir,
                    'waktu_lahir'         => $request->waktu_lahir,
                    'agama_id'            => $request->agama_id,
                    'warganegara_id'      => $request->warganegara_id,
                    'status_kawin_id'     => $request->status_kawin_id,
                    'nama_ibu'            => $request->nama_ibu,
                    'nama_ayah'           => $request->nama_ayah,
                    'nik_ibu'             => $request->nik_ibu,
                    'nik_ayah'            => $request->nik_ayah,
                    'kk_level'            => $request->kk_level ?? $kepala->kk_level,
                    'status'              => $request->status ?? $kepala->status,
                    'ktp_el'              => $request->ktp_el,
                    'status_rekam'        => $request->status_rekam,
                    'tag_id_card'         => $request->tag_id_card,
                    'no_kk_sebelumnya'    => $request->no_kk_sebelumnya,
                    'akta_lahir'          => $request->akta_lahir,
                    'tempat_dilahirkan'   => $request->tempat_dilahirkan,
                    'jenis_kelahiran'     => $request->jenis_kelahiran,
                    'kelahiran_anak_ke'   => $request->kelahiran_anak_ke,
                    'penolong_kelahiran'  => $request->penolong_kelahiran,
                    'berat_lahir'         => $request->berat_lahir,
                    'panjang_lahir'       => $request->panjang_lahir,
                    'pendidikan_kk_id'    => $request->pendidikan_kk_id,
                    'pendidikan_sedang_id' => $request->pendidikan_sedang_id,
                    'pekerjaan_id'        => $request->pekerjaan_id,
                    'pekerja_migran'      => $request->pekerja_migran ?? 0,
                    'dokumen_pasport'     => $request->dokumen_pasport,
                    'tanggal_akhir_paspor' => $request->tanggal_akhir_paspor,
                    'akta_perkawinan'     => $request->akta_perkawinan,
                    'tanggal_perkawinan'  => $request->tanggal_perkawinan,
                    'akta_perceraian'     => $request->akta_perceraian,
                    'tanggal_perceraian'  => $request->tanggal_perceraian,
                    'golongan_darah_id'   => $request->golongan_darah_id,
                    'cacat_id'            => $request->cacat_id,
                    'sakit_menahun_id'    => $request->sakit_menahun_id,
                    'cara_kb_id'          => $request->cara_kb_id,
                    'asuransi_id'         => $request->asuransi_id,
                    'no_asuransi'         => $request->no_asuransi,
                    'bahasa_id'           => $request->bahasa_id,
                    'keterangan'          => $request->keterangan,
                    'alamat_sebelumnya'   => $request->alamat_sebelumnya,
                    'no_telp'             => $request->no_telp,
                    'email'               => $request->email,
                    'wilayah_id'          => $request->wilayah_id,
                    'foto'                => $fotoPath,
                ]);

                // Sync nik_kepala di KK jika NIK berubah
                if ($keluarga->nik_kepala !== $request->nik) {
                    $keluarga->update(['nik_kepala' => $request->nik]);
                }
            }
        });

        return redirect()->route('admin.keluarga-show', $keluarga)
            ->with('success', 'Data KK dan kepala keluarga berhasil diperbarui.');
    }

    // =========================================================================
    // TAMBAH ANGGOTA
    // =========================================================================

    /**
     * Tambah anggota baru lahir.
     */
    public function storeAnggotaLahir(Request $request, Keluarga $keluarga) {
        $request->validate([
            'nik'            => 'required|string|size:16|unique:penduduk,nik',
            'nama'           => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'tempat_lahir'   => 'required|string|max:255',
            'tanggal_lahir'  => 'required|date',
            'agama_id'       => 'required|integer',
            'kk_level'       => 'required|integer|min:1|max:10',
            'nama_ayah'      => 'nullable|string|max:255',
            'nama_ibu'       => 'nullable|string|max:255',
        ]);

        Penduduk::create([
            ...$request->only([
                'nik',
                'nama',
                'jenis_kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'agama_id',
                'kk_level',
                'nama_ayah',
                'nama_ibu',
            ]),
            'keluarga_id'   => $keluarga->id,
            'wilayah_id'    => $keluarga->wilayah_id,
            'status_dasar'  => Penduduk::STATUS_DASAR_HIDUP,
            'status'        => Penduduk::STATUS_TETAP,
            'jenis_tambah'  => Penduduk::JENIS_TAMBAH_LAHIR,
            'tgl_peristiwa' => $request->tanggal_lahir,
            'tgl_terdaftar' => now()->toDateString(),
        ]);

        return redirect()->route('admin.keluarga-show', $keluarga)
            ->with('success', 'Anggota keluarga (lahir) berhasil ditambahkan.');
    }

    /**
     * Tambah anggota masuk (pindah datang).
     */
    public function storeAnggotaMasuk(Request $request, Keluarga $keluarga) {
        $request->validate([
            'nik'            => 'required|string|size:16|unique:penduduk,nik',
            'nama'           => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'tempat_lahir'   => 'required|string|max:255',
            'tanggal_lahir'  => 'required|date',
            'agama_id'       => 'required|integer',
            'kk_level'       => 'required|integer|min:1|max:10',
            'tgl_terdaftar'  => 'required|date',
        ]);

        Penduduk::create([
            ...$request->only([
                'nik',
                'nama',
                'jenis_kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'agama_id',
                'kk_level',
                'tgl_terdaftar',
            ]),
            'keluarga_id'   => $keluarga->id,
            'wilayah_id'    => $keluarga->wilayah_id,
            'status_dasar'  => Penduduk::STATUS_DASAR_HIDUP,
            'status'        => Penduduk::STATUS_TETAP,
            'jenis_tambah'  => Penduduk::JENIS_TAMBAH_MASUK,
            'tgl_peristiwa' => $request->tgl_terdaftar,
        ]);

        return redirect()->route('admin.keluarga-show', $keluarga)
            ->with('success', 'Anggota keluarga (masuk) berhasil ditambahkan.');
    }

    /**
     * Tambah anggota dari penduduk yang sudah ada (penduduk lepas).
     */
    public function storeAnggotaDariPenduduk(Request $request, Keluarga $keluarga) {
        $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'kk_level'    => 'required|integer|min:1|max:10',
        ]);

        // Pastikan penduduk benar-benar lepas
        $penduduk = Penduduk::where('id', $request->penduduk_id)
            ->where('status_dasar', Penduduk::STATUS_DASAR_HIDUP)
            ->whereNull('keluarga_id')
            ->first();

        if (! $penduduk) {
            return back()->withErrors(['penduduk_id' => 'Penduduk tidak valid atau sudah terdaftar di KK lain.']);
        }

        $penduduk->update([
            'keluarga_id' => $keluarga->id,
            'wilayah_id'  => $keluarga->wilayah_id,
            'kk_level'    => $request->kk_level,
        ]);

        return redirect()->route('admin.keluarga-show', $keluarga)
            ->with('success', 'Anggota berhasil ditambahkan dari data penduduk yang sudah ada.');
    }

    // =========================================================================
    // PECAH KK — Keluarkan anggota jadi penduduk lepas
    // =========================================================================

    public function pecahKk(Keluarga $keluarga, Penduduk $penduduk) {
        // Cegah pecah kepala keluarga yang masih punya anggota
        if ($penduduk->kk_level === Penduduk::SHDK_KEPALA_KELUARGA) {
            $jumlahAnggota = $keluarga->anggota()->where('id', '!=', $penduduk->id)->count();
            if ($jumlahAnggota > 0) {
                return back()->with('error', 'Kepala keluarga tidak bisa dipecah selama masih ada anggota lain. Pecah anggota lain terlebih dahulu.');
            }
        }

        $penduduk->update([
            'keluarga_id' => null,
            'kk_level'    => null,
        ]);

        // Jika kepala yang dipecah, kosongkan FK kepala di KK
        if ($keluarga->kepala_keluarga_id === $penduduk->id) {
            $keluarga->update([
                'kepala_keluarga_id' => null,
                'nik_kepala'         => null,
            ]);
        }

        return redirect()->route('admin.keluarga-show', $keluarga)
            ->with('success', "{$penduduk->nama} berhasil dikeluarkan dari KK ini (penduduk lepas).");
    }

    // =========================================================================
    // BUAT KK BARU dari anggota
    // =========================================================================

    /**
     * Form buat KK baru — anggota tertentu jadi kepala KK baru.
     */
    public function formBuatKkBaru(Keluarga $keluargaAsal, Penduduk $penduduk) {
        // Pastikan penduduk ini memang anggota KK asal
        if ($penduduk->keluarga_id !== $keluargaAsal->id) {
            return back()->with('error', 'Penduduk bukan anggota KK ini.');
        }

        $wilayah = Wilayah::orderBy('dusun')->orderBy('rw')->orderBy('rt')->get();

        return view('admin.keluarga-buat-kk-baru', compact('keluargaAsal', 'penduduk', 'wilayah'));
    }

    /**
     * Proses buat KK baru — penduduk keluar dari KK lama, jadi kepala KK baru.
     */
    public function storeBuatKkBaru(Request $request, Keluarga $keluargaAsal, Penduduk $penduduk) {
        $request->validate([
            'no_kk'         => 'required|string|max:16|unique:keluarga,no_kk',
            'alamat'        => 'nullable|string',
            'wilayah_id'    => 'required|exists:wilayah,id',
            'tgl_terdaftar' => 'required|date',
            'kk_level_baru' => 'required|integer|min:1|max:10', // SHDK di KK baru (harusnya 1)
        ]);

        if ($penduduk->keluarga_id !== $keluargaAsal->id) {
            return back()->with('error', 'Penduduk bukan anggota KK ini.');
        }

        DB::transaction(function () use ($request, $keluargaAsal, $penduduk) {
            // Buat KK baru
            $kkBaru = Keluarga::create([
                'no_kk'              => $request->no_kk,
                'alamat'             => $request->alamat ?? $keluargaAsal->alamat,
                'wilayah_id'         => $request->wilayah_id,
                'tgl_terdaftar'      => $request->tgl_terdaftar,
                'status'             => Keluarga::STATUS_AKTIF,
                'kepala_keluarga_id' => $penduduk->id,
                'nik_kepala'         => $penduduk->nik,
            ]);

            // Pindahkan penduduk ke KK baru sebagai kepala
            $penduduk->update([
                'keluarga_id' => $kkBaru->id,
                'kk_level'    => Penduduk::SHDK_KEPALA_KELUARGA,
                'wilayah_id'  => $request->wilayah_id,
            ]);

            // Jika dia adalah kepala KK asal, kosongkan FK di KK asal
            if ($keluargaAsal->kepala_keluarga_id === $penduduk->id) {
                $keluargaAsal->update([
                    'kepala_keluarga_id' => null,
                    'nik_kepala'         => null,
                ]);
            }
        });

        return redirect()->route('admin.keluarga')
            ->with('success', "KK baru berhasil dibuat. {$penduduk->nama} sekarang jadi kepala keluarga di KK baru.");
    }

    // =========================================================================
    // GENERATE NO KK SEMENTARA
    // =========================================================================

    /**
     * Generate No KK Sementara via AJAX.
     * Format: '0' + kode_desa (10 digit) + urutan (5 digit) = 16 digit
     */
    public function generateNoKkSementara() {
        $kodeDesa = config('app.kode_desa', '0000000000');
        $kodeDesa = str_pad(substr($kodeDesa, 0, 10), 10, '0', STR_PAD_LEFT);
        $prefix   = '0' . $kodeDesa; // 11 karakter

        $lastKk = Keluarga::withTrashed()
            ->where('no_kk', 'like', $prefix . '%')
            ->orderByRaw('CAST(no_kk AS UNSIGNED) DESC')
            ->value('no_kk');

        $urutan = $lastKk ? ((int) substr($lastKk, 11, 5)) + 1 : 1;

        if ($urutan > 99999) {
            return response()->json(['error' => 'Batas No KK Sementara sudah tercapai.'], 422);
        }

        $noKkSementara = $prefix . str_pad($urutan, 5, '0', STR_PAD_LEFT);

        return response()->json(['no_kk' => $noKkSementara]);
    }
    /**
     * Generate NIK Sementara via AJAX.
     */
    public function generateNikSementara()
    {
        try {
            $nik = Penduduk::generateNikSementara();
            return response()->json(['nik' => $nik]);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    // =========================================================================
    // PINDAH WILAYAH KOLEKTIF
    // =========================================================================

    public function pindahWilayahKolektif(Request $request) {
        $request->validate([
            'ids.*'      => 'integer|exists:keluarga,id',
            'ids'        => 'required|array|min:1',
            'wilayah_id' => 'required|exists:wilayah,id',
        ]);

        DB::transaction(function () use ($request) {
            $keluargaList = Keluarga::whereIn('id', $request->ids)->get();

            foreach ($keluargaList as $kk) {
                $kk->update(['wilayah_id' => $request->wilayah_id]);

                // Pindahkan wilayah semua anggota sekaligus
                $kk->anggota()->update(['wilayah_id' => $request->wilayah_id]);
            }
        });

        return back()->with('success', count($request->ids) . ' KK berhasil dipindah wilayah.');
    }

    // =========================================================================
    // TAMBAH RUMAH TANGGA KOLEKTIF
    // =========================================================================

    public function tambahRumahTanggaKolektif(Request $request) {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:keluarga,id',
        ]);

        DB::transaction(function () use ($request) {
            // Ambil KK pertama yang dipilih untuk dapat wilayah_id & alamat
            $kkPertama = Keluarga::with('wilayah')->find($request->ids[0]);

            // Generate no_rumah_tangga otomatis — format: RT + kode wilayah + timestamp
            // Pastikan unik dengan loop sederhana
            do {
                $noRumahTangga = 'RT' . now()->format('YmdHis') . rand(100, 999);
            } while (RumahTangga::where('no_rumah_tangga', $noRumahTangga)->exists());

            $rumahTangga = RumahTangga::create([
                'no_rumah_tangga' => $noRumahTangga,
                'alamat'          => $kkPertama?->alamat,
                'wilayah_id'      => $kkPertama?->wilayah_id,
                'tgl_terdaftar'   => now()->toDateString(),
            ]);

            // Hubungkan semua KK yang dipilih ke rumah tangga baru
            Keluarga::whereIn('id', $request->ids)
                ->update(['rumah_tangga_id' => $rumahTangga->id]);
        });

        $jumlah = count($request->ids);

        return back()->with('success', "{$jumlah} KK berhasil ditambahkan ke rumah tangga kolektif baru.");
    }
    
    // =========================================================================
    // DESTROY
    // =========================================================================

    public function destroy(Keluarga $keluarga) {
        $jumlahAnggota = $keluarga->anggota()->count();
        if ($jumlahAnggota > 0) {
            return back()->with('error', "KK {$keluarga->no_kk} tidak bisa dihapus karena masih memiliki {$jumlahAnggota} anggota. Pecah anggota terlebih dahulu.");
        }

        $keluarga->delete();

        return redirect()->route('admin.keluarga')
            ->with('success', 'Keluarga berhasil dihapus.');
    }

    public function bulkDestroy(Request $request) {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:keluarga,id',
        ]);

        $keluargaList = Keluarga::whereIn('id', $request->ids)->withCount('anggota')->get();

        $adaAnggota = $keluargaList->where('anggota_count', '>', 0);
        if ($adaAnggota->count() > 0) {
            $noKkList = $adaAnggota->pluck('no_kk')->implode(', ');
            return back()->with('error', "KK berikut tidak bisa dihapus karena masih punya anggota: {$noKkList}");
        }

        $count = $keluargaList->count();
        foreach ($keluargaList as $k) {
            $k->delete();
        }

        return back()->with('success', "Berhasil menghapus {$count} keluarga.");
    }

    // =========================================================================
    // EXPORT EXCEL
    // =========================================================================

    public function exportExcel(Request $request) {
        $data = $this->buildExportQuery($request)->get();

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet()->setTitle('Data Keluarga');

        $headers = ['No', 'No. KK', 'Kepala Keluarga', 'NIK Kepala', 'Jml Anggota', 'Alamat', 'RT', 'RW', 'Dusun', 'Tgl Terdaftar', 'Tgl Cetak KK', 'Status'];
        $col     = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col++ . '1', $h);
        }

        $lastCol = chr(ord('A') + count($headers) - 1);
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(25);
        $sheet->freezePane('A2');

        foreach ($data as $i => $row) {
            $r      = $i + 2;
            $c      = 'A';
            $kepala = $row->kepalaKeluarga;

            $sheet->setCellValue($c++ . $r, $i + 1);
            $sheet->setCellValue($c++ . $r, $row->no_kk ?? '-');
            $sheet->setCellValue($c++ . $r, $kepala?->nama ?? '-');
            $sheet->setCellValue($c++ . $r, $kepala?->nik ?? '-');
            $sheet->setCellValue($c++ . $r, $row->getTotalAnggota());
            $sheet->setCellValue($c++ . $r, $row->alamat ?? '-');
            $sheet->setCellValue($c++ . $r, $row->wilayah?->rt ?? '-');
            $sheet->setCellValue($c++ . $r, $row->wilayah?->rw ?? '-');
            $sheet->setCellValue($c++ . $r, $row->wilayah?->dusun ?? '-');
            $sheet->setCellValue($c++ . $r, $row->tgl_terdaftar?->format('d/m/Y') ?? '-');
            $sheet->setCellValue($c++ . $r, $row->tgl_cetak_kk?->format('d/m/Y') ?? '-');
            $sheet->setCellValue($c++ . $r, $row->status ? 'Aktif' : 'Tidak Aktif');

            if ($i % 2 === 1) {
                $sheet->getStyle("A{$r}:{$lastCol}{$r}")
                    ->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F9FAFB');
            }
        }

        foreach (range('A', $lastCol) as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        $writer = new XlsxWriter($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'data_keluarga_' . now()->format('Ymd_His') . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // =========================================================================
    // EXPORT PDF
    // =========================================================================

    public function exportPdf(Request $request) {
        $keluarga = $this->buildExportQuery($request)->get();
        $stats    = ['total' => $keluarga->count()];

        $pdf = Pdf::loadView('admin.keluarga-export-pdf', compact('keluarga', 'stats'))
            ->setPaper('a4', 'landscape')
            ->setOptions(['dpi' => 110, 'defaultFont' => 'sans-serif']);

        return $pdf->download('data_keluarga_' . now()->format('Ymd_His') . '.pdf');
    }

    // =========================================================================
    // HELPER PRIVATE
    // =========================================================================

    private function buildExportQuery(Request $request) {
        return Keluarga::with(['kepalaKeluarga:id,nama,nik', 'wilayah'])
            ->when(
                $request->filled('search'),
                fn($q) => $q->where(
                    fn($q2) => $q2
                        ->where('no_kk', 'like', "%{$request->search}%")
                        ->orWhereHas('kepalaKeluarga', fn($q3) => $q3->where('nama', 'like', "%{$request->search}%"))
                )
            )
            ->when($request->filled('wilayah_id'), fn($q) => $q->where('wilayah_id', $request->wilayah_id))
            ->when($request->filled('klasifikasi_ekonomi'), fn($q) => $q->where('klasifikasi_ekonomi', $request->klasifikasi_ekonomi))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->orderBy('no_kk');
    }
}


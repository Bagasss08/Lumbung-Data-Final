<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// InfoDesa
use App\Http\Controllers\Admin\InfoDesa\IdentitasDesaController;
use App\Http\Controllers\Admin\InfoDesa\WilayahController;
use App\Http\Controllers\Admin\InfoDesa\PemerintahDesaController;

// Kependudukan
use App\Http\Controllers\Admin\kependudukan\PendudukController;
use App\Http\Controllers\Admin\kependudukan\KeluargaController;
use App\Http\Controllers\Admin\kependudukan\RumahTanggaController;
use App\Http\Controllers\Admin\Kependudukan\KelompokController;

// Kehadiran
use App\Http\Controllers\Admin\kehadiran\JenisKehadiranController;
use App\Http\Controllers\Admin\kehadiran\PegawaiController;
use App\Http\Controllers\Admin\kehadiran\JamKerjaController;
use App\Http\Controllers\Admin\kehadiran\KehadiranHarianController;
use App\Http\Controllers\Admin\kehadiran\KeteranganController;
use App\Http\Controllers\Admin\kehadiran\DinasLuarController;
use App\Http\Controllers\Admin\kehadiran\RekapitulasiController;

// Sekretariat
use App\Http\Controllers\Admin\sekretariat\SekretariatController;

// Keuangan
use App\Http\Controllers\Admin\keuangan\KeuanganController;

// Layanan Surat
use App\Http\Controllers\Admin\layanansurat\LayananSuratController;
use App\Http\Controllers\Admin\layanansurat\CetakController;
use App\Http\Controllers\Admin\layanansurat\CetakSuratController;
use App\Http\Controllers\SuratController;

// Bantuan
use App\Http\Controllers\Admin\Bantuan\BantuanController;
use App\Http\Controllers\Admin\Bantuan\BantuanPesertaController;

// Analisis
use App\Http\Controllers\Admin\Analisis\AnalisisMasterController;
use App\Http\Controllers\Admin\Analisis\AnalisisIndikatorController;
use App\Http\Controllers\Admin\Analisis\AnalisisRespondenController;
use App\Http\Controllers\Admin\Analisis\AnalisisPeriodeController;
use App\Http\Controllers\Admin\Analisis\AnalisisKlasifikasiController;

// Lapak
use App\Http\Controllers\Admin\LapakController;
use App\Http\Controllers\Admin\LapakProdukController;

// Pembangunan
use App\Http\Controllers\Admin\Pembangunan\PembangunanController;

// Lainnya
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\RumahTanggaAnggotaController;
use App\Http\Controllers\Admin\KehadiranBulananController;
use App\Http\Controllers\Admin\KehadiranTahunanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\Auth\AktivasiWargaController;

// Alias untuk LayananSurat (Warga vs Admin)
use App\Http\Controllers\Admin\layanansurat\LayananSuratController as AdminSuratController;
use App\Http\Controllers\Warga\LayananSuratController as WargaSuratController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontendController::class, 'home'])->name('home');

Route::get('/berita', [FrontendController::class, 'berita'])->name('berita');

Route::get('/program', function () {
    return view('frontend.program');
})->name('program');

Route::get('/profil', [FrontendController::class, 'profil'])->name('profil');
Route::get('/data-desa', [FrontendController::class, 'dataDesa'])->name('data-desa');

// Artikel (gunakan satu definisi saja, hindari duplikat)
Route::get('/artikel', [FrontendController::class, 'berita'])->name('artikel');
Route::get('/artikel/{id}', [FrontendController::class, 'artikelShow'])->name('artikel.show');
Route::post('/artikel/{id}/komentar', [FrontendController::class, 'storeKomentar'])->name('artikel.komentar.store');

Route::get('/wilayah', [FrontendController::class, 'wilayah'])->name('wilayah');
Route::get('/wilayah/{id}', [FrontendController::class, 'wilayahShow'])->name('wilayah.show');

Route::get('/profil/kepala-desa', [FrontendController::class, 'profilKepalaDesa'])->name('profil-kepala-desa');

Route::get('/kontak', [FrontendController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [FrontendController::class, 'storeKontak'])->name('kontak.store');

Route::get('/pemerintahan', [FrontendController::class, 'pemerintahan'])->name('pemerintahan');

Route::get('/kebijakan-privasi', function () {
    return view('frontend.pages.kebijakan-privasi.index', [
        'lastUpdated' => Carbon::parse('2025-01-01')->isoFormat('D MMMM YYYY'),
    ]);
})->name('kebijakan-privasi');

Route::get('/syarat-ketentuan', function () {
    return view('frontend.pages.syarat-ketentuan.index', [
        'lastUpdated' => Carbon::parse('2025-01-01')->isoFormat('D MMMM YYYY'),
    ]);
})->name('syarat-ketentuan');

Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');

Route::get('/lapak', [FrontendController::class, 'lapak'])->name('lapak');
Route::get('/lapak/{slug}', [FrontendController::class, 'lapakShow'])->name('lapak.show');

Route::get('/peta-situs', function () {
    return view('frontend.pages.peta-situs.index');
})->name('peta-situs');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/setup', [SetupController::class, 'showSetup'])->name('setup')->middleware('check.setup');
Route::post('/setup', [SetupController::class, 'register'])->name('setup.register');

Route::middleware('guest')->group(function () {
    Route::get('/layanan-mandiri/aktivasi', [AktivasiWargaController::class, 'showCheckForm'])->name('aktivasi.index');
    Route::post('/layanan-mandiri/cek', [AktivasiWargaController::class, 'check'])->name('aktivasi.check');
    Route::post('/layanan-mandiri/daftar', [AktivasiWargaController::class, 'register'])->name('aktivasi.store');
});

/*
|--------------------------------------------------------------------------
| WARGA ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('warga')->name('warga.')->middleware(['auth', 'role:warga'])->group(function () {

    Route::get('/dashboard', function () {
        return view('warga.dashboard');
    })->name('dashboard');

    Route::get('/profil', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user) {
            $user->load('penduduk');
        }
        return view('warga.profil', compact('user'));
    })->name('profil');

    Route::get('/surat', [WargaSuratController::class, 'index'])->name('surat.index');
    Route::get('/surat/create', [WargaSuratController::class, 'create'])->name('surat.create');
    Route::post('/surat', [WargaSuratController::class, 'store'])->name('surat.store');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES — IDENTITAS DESA (tidak butuh check identitas)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/identitas-desa', [IdentitasDesaController::class, 'index'])->name('identitas-desa.index');
    Route::get('/identitas-desa/edit', [IdentitasDesaController::class, 'edit'])->name('identitas-desa.edit');
    Route::put('/identitas-desa', [IdentitasDesaController::class, 'update'])->name('identitas-desa.update');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES — UTAMA (butuh identitas desa)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'check.identitas.desa'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | STATISTIK
    |--------------------------------------------------------------------------
    */
    Route::get('/statistik/kependudukan', [\App\Http\Controllers\Admin\statistik\StatistikController::class, 'kependudukan'])
        ->name('statistik.kependudukan');

    Route::get('/statistik/laporan-bulanan', function (\Illuminate\Http\Request $request) {
        $month = $request->query('month');
        $year  = $request->query('year');

        $now = Carbon::now();
        if ($month && $year) {
            try {
                $start = Carbon::createFromDate((int) $year, (int) $month, 1)->startOfDay();
            } catch (\Exception $e) {
                $start = $now->copy()->startOfMonth();
            }
        } else {
            $start = $now->copy()->startOfMonth();
        }
        $end   = $start->copy()->endOfMonth()->endOfDay();
        $year  = $start->year;
        $month = $start->month;

        $total_penduduk = \App\Models\Penduduk::where('status_hidup', 'hidup')->count();

        $lahir = \App\Models\Penduduk::whereYear('tanggal_lahir', $year)
            ->whereMonth('tanggal_lahir', $month)
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $created = \App\Models\Penduduk::whereBetween('created_at', [$start, $end])->count();
        $datang  = max(0, $created - $lahir);

        $meninggal = \App\Models\Penduduk::where('status_hidup', 'meninggal')
            ->whereBetween('updated_at', [$start, $end])
            ->count();

        $pindah = 0;

        $mutasi = [
            'lahir'     => $lahir,
            'meninggal' => $meninggal,
            'datang'    => $datang,
            'pindah'    => $pindah,
        ];

        $makePercent = function ($count) use ($total_penduduk) {
            $pct  = $total_penduduk > 0 ? round(($count / $total_penduduk) * 100, 2) : 0;
            $sign = $pct >= 0 ? '+' : '';
            return $sign . $pct . '%';
        };

        $laporan = [
            ['kategori' => 'Kelahiran', 'jumlah' => $lahir,     'persen' => $makePercent($lahir)],
            ['kategori' => 'Kematian',  'jumlah' => $meninggal, 'persen' => $makePercent($meninggal)],
            ['kategori' => 'Pendatang', 'jumlah' => $datang,    'persen' => $makePercent($datang)],
            ['kategori' => 'Pindah',    'jumlah' => $pindah,    'persen' => $makePercent($pindah)],
        ];

        $data = [
            'bulan'          => $start->translatedFormat('F Y'),
            'total_penduduk' => $total_penduduk,
            'mutasi'         => $mutasi,
            'laporan'        => $laporan,
        ];

        return view('admin.statistik.laporan-bulanan', compact('data'));
    })->name('statistik.laporan-bulanan');

    Route::get('/statistik/kelompok-rentan', [\App\Http\Controllers\Admin\statistik\StatistikController::class, 'kelompokRentan'])
        ->name('statistik.kelompok-rentan');

    Route::get('/statistik/penduduk', function () {
        $penduduk = \App\Models\Penduduk::with(['keluargas'])
            ->where('status_hidup', 'hidup')
            ->orderBy('nama')
            ->paginate(50);

        $total_penduduk  = \App\Models\Penduduk::where('status_hidup', 'hidup')->count();
        $laki_laki       = \App\Models\Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'L')->count();
        $perempuan       = \App\Models\Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'P')->count();
        $kepala_keluarga = \App\Models\Keluarga::count();

        $data = [
            'penduduk'        => $penduduk,
            'total_penduduk'  => $total_penduduk,
            'laki_laki'       => $laki_laki,
            'perempuan'       => $perempuan,
            'kepala_keluarga' => $kepala_keluarga,
        ];

        return view('admin.statistik.penduduk', compact('data'));
    })->name('statistik.penduduk');

    /*
    |--------------------------------------------------------------------------
    | KEPENDUDUKAN — PENDUDUK
    |--------------------------------------------------------------------------
    */
    Route::get('/penduduk', [PendudukController::class, 'index'])->name('penduduk');
    Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
    Route::post('/penduduk', [PendudukController::class, 'store'])->name('penduduk.store');
    Route::post('/penduduk/import', [PendudukController::class, 'import'])->name('penduduk.import');
    Route::get('/penduduk/{penduduk}', [PendudukController::class, 'show'])->name('penduduk.show');
    Route::get('/penduduk/{penduduk}/edit', [PendudukController::class, 'edit'])->name('penduduk.edit');
    Route::put('/penduduk/{penduduk}', [PendudukController::class, 'update'])->name('penduduk.update');
    Route::get('/penduduk/{penduduk}/delete', [PendudukController::class, 'confirmDestroy'])->name('penduduk.confirm-destroy');
    Route::delete('/penduduk/{penduduk}', [PendudukController::class, 'destroy'])->name('penduduk.destroy');

    /*
    |--------------------------------------------------------------------------
    | KEPENDUDUKAN — KELUARGA
    |--------------------------------------------------------------------------
    */
    Route::get('/keluarga', [KeluargaController::class, 'index'])->name('keluarga');
    Route::get('/keluarga/create', [KeluargaController::class, 'create'])->name('keluarga.create');
    Route::post('/keluarga', [KeluargaController::class, 'store'])->name('keluarga.store');
    Route::get('/keluarga/{keluarga}', [KeluargaController::class, 'show'])->name('keluarga.show');
    Route::get('/keluarga/{keluarga}/edit', [KeluargaController::class, 'edit'])->name('keluarga.edit');
    Route::put('/keluarga/{keluarga}', [KeluargaController::class, 'update'])->name('keluarga.update');
    Route::get('/keluarga/{keluarga}/delete', [KeluargaController::class, 'confirmDestroy'])->name('keluarga.confirm-destroy');
    Route::delete('/keluarga/{keluarga}', [KeluargaController::class, 'destroy'])->name('keluarga.destroy');

    /*
    |--------------------------------------------------------------------------
    | KEPENDUDUKAN — RUMAH TANGGA
    |--------------------------------------------------------------------------
    */
    Route::resource('rumah-tangga', RumahTanggaController::class)->names([
        'index'   => 'rumah-tangga.index',
        'create'  => 'rumah-tangga.create',
        'store'   => 'rumah-tangga.store',
        'show'    => 'rumah-tangga.show',
        'edit'    => 'rumah-tangga.edit',
        'update'  => 'rumah-tangga.update',
        'destroy' => 'rumah-tangga.destroy',
    ]);
    Route::get('/rumah-tangga/{rumahTangga}/delete', [RumahTanggaController::class, 'confirmDestroy'])
        ->name('rumah-tangga.confirm-destroy');

    // Rumah Tangga Anggota
    Route::prefix('rumah-tangga/{rumahTangga}/anggota')->name('rumah-tangga-anggota.')->group(function () {
        Route::get('/', [RumahTanggaAnggotaController::class, 'index'])->name('index');
        Route::get('/create', [RumahTanggaAnggotaController::class, 'create'])->name('create');
        Route::post('/', [RumahTanggaAnggotaController::class, 'store'])->name('store');
        Route::get('/{anggota}/edit', [RumahTanggaAnggotaController::class, 'edit'])->name('edit');
        Route::put('/{anggota}', [RumahTanggaAnggotaController::class, 'update'])->name('update');
        Route::delete('/{anggota}', [RumahTanggaAnggotaController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | KEPENDUDUKAN — KELOMPOK
    |--------------------------------------------------------------------------
    */
    Route::prefix('kelompok/master')->name('kelompok.master.')->group(function () {
        Route::get('/', [KelompokController::class, 'masterIndex'])->name('index');
        Route::post('/', [KelompokController::class, 'masterStore'])->name('store');
        Route::put('/{master}', [KelompokController::class, 'masterUpdate'])->name('update');
        Route::delete('/{master}', [KelompokController::class, 'masterDestroy'])->name('destroy');
    });

    Route::prefix('kelompok')->name('kelompok.')->group(function () {
        Route::get('/search-penduduk', [KelompokController::class, 'searchPenduduk'])->name('search-penduduk');
        Route::get('/', [KelompokController::class, 'index'])->name('index');
        Route::get('/create', [KelompokController::class, 'create'])->name('create');
        Route::post('/', [KelompokController::class, 'store'])->name('store');
        Route::get('/{kelompok}', [KelompokController::class, 'show'])->name('show');
        Route::get('/{kelompok}/edit', [KelompokController::class, 'edit'])->name('edit');
        Route::put('/{kelompok}', [KelompokController::class, 'update'])->name('update');
        Route::delete('/{kelompok}', [KelompokController::class, 'destroy'])->name('destroy');

        Route::prefix('/{kelompok}/anggota')->name('anggota.')->group(function () {
            Route::get('/', [KelompokController::class, 'anggotaIndex'])->name('index');
            Route::get('/tambah', [KelompokController::class, 'anggotaCreate'])->name('create');
            Route::post('/', [KelompokController::class, 'anggotaStore'])->name('store');
            Route::patch('/{anggota}/nonaktif', [KelompokController::class, 'anggotaDestroy'])->name('nonaktif');
            Route::delete('/{anggota}', [KelompokController::class, 'anggotaDestroySoft'])->name('destroy');
        });
    });

    Route::get('/data-suplemen', function () {
        return view('admin.data-suplemen');
    })->name('data-suplemen');

    Route::get('/calon-pemilih', function () {
        return view('admin.calon-pemilih');
    })->name('calon-pemilih');

    /*
    |--------------------------------------------------------------------------
    | LAYANAN SURAT
    |--------------------------------------------------------------------------
    */
    Route::get('/surat/get-variables/{id}', [SuratController::class, 'getVariables']);
    Route::post('/surat/generate', [SuratController::class, 'generateSurat'])->name('surat.generate');

    Route::prefix('layanan-surat')->name('layanan-surat.')->group(function () {

        // Pengaturan Template
        Route::get('/pengaturan', [LayananSuratController::class, 'pengaturan'])->name('pengaturan');
        Route::post('/template', [LayananSuratController::class, 'storeTemplate'])->name('template.store');
        Route::put('/template/{id}', [LayananSuratController::class, 'updateTemplate'])->name('template.update');
        Route::delete('/template/{id}', [LayananSuratController::class, 'destroyTemplate'])->name('template.destroy');

        // Cetak Surat
        Route::resource('cetak', CetakController::class);
        Route::get('cetak/{id}/print', [CetakController::class, 'cetak'])->name('cetak.print');
    });

    // Cetak Surat (CetakSuratController)
    Route::prefix('layanan-surat/cetak-surat')->name('layanan-surat.cetak-surat.')->group(function () {
        Route::get('/', [CetakSuratController::class, 'index'])->name('index');
        Route::post('/', [CetakSuratController::class, 'store'])->name('store');
        Route::get('/{id}', [CetakSuratController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CetakSuratController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CetakSuratController::class, 'update'])->name('update');
        Route::delete('/{id}', [CetakSuratController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/print', [CetakSuratController::class, 'print'])->name('print');
        Route::get('/penduduk/{nik}', [CetakSuratController::class, 'getPendudukData'])->name('getPenduduk');
    });

    /*
    |--------------------------------------------------------------------------
    | SEKRETARIAT
    |--------------------------------------------------------------------------
    */
    Route::prefix('sekretariat')->name('sekretariat.')->group(function () {

        // Informasi Publik
        Route::get('/informasi-publik', [SekretariatController::class, 'index'])->name('informasi-publik.index');
        Route::get('/informasi-publik/create', [SekretariatController::class, 'create'])->name('informasi-publik.create');
        Route::post('/informasi-publik', [SekretariatController::class, 'store'])->name('informasi-publik.store');
        Route::get('/informasi-publik/{id}/edit', [SekretariatController::class, 'edit'])->name('informasi-publik.edit');
        Route::put('/informasi-publik/{id}', [SekretariatController::class, 'update'])->name('informasi-publik.update');
        Route::delete('/informasi-publik/{id}', [SekretariatController::class, 'destroy'])->name('informasi-publik.destroy');
        Route::get('/informasi-publik/{id}/download', [SekretariatController::class, 'download'])->name('informasi-publik.download');

        // Inventaris
        Route::get('/inventaris', [SekretariatController::class, 'inventaris'])->name('inventaris');
        Route::get('/inventaris/create', [SekretariatController::class, 'inventarisCreate'])->name('inventaris.create');
        Route::post('/inventaris', [SekretariatController::class, 'inventarisStore'])->name('inventaris.store');
        Route::get('/inventaris/{id}/edit', [SekretariatController::class, 'inventarisEdit'])->name('inventaris.edit');
        Route::put('/inventaris/{id}', [SekretariatController::class, 'inventarisUpdate'])->name('inventaris.update');
        Route::delete('/inventaris/{id}', [SekretariatController::class, 'inventarisDestroy'])->name('inventaris.destroy');

        // Klasifikasi Surat
        Route::get('/klasifikasi-surat', [SekretariatController::class, 'klasifikasiSurat'])->name('klasifikasi-surat');
        Route::get('/klasifikasi-surat/create', [SekretariatController::class, 'klasifikasiSuratCreate'])->name('klasifikasi-surat.create');
        Route::post('/klasifikasi-surat', [SekretariatController::class, 'klasifikasiSuratStore'])->name('klasifikasi-surat.store');
        Route::get('/klasifikasi-surat/{id}', [SekretariatController::class, 'klasifikasiSuratShow'])->name('klasifikasi-surat.show');
        Route::get('/klasifikasi-surat/{id}/edit', [SekretariatController::class, 'klasifikasiSuratEdit'])->name('klasifikasi-surat.edit');
        Route::put('/klasifikasi-surat/{id}', [SekretariatController::class, 'klasifikasiSuratUpdate'])->name('klasifikasi-surat.update');
        Route::delete('/klasifikasi-surat/{id}', [SekretariatController::class, 'klasifikasiSuratDestroy'])->name('klasifikasi-surat.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | KEHADIRAN
    |--------------------------------------------------------------------------
    */
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('jenis-kehadiran', JenisKehadiranController::class)->except(['show']);
    Route::resource('jam-kerja', JamKerjaController::class);
    Route::resource('kehadiran-harian', KehadiranHarianController::class);
    Route::resource('keterangan', KeteranganController::class);
    Route::resource('dinas-luar', DinasLuarController::class);

    Route::prefix('kehadiran')->name('kehadiran.')->group(function () {
        Route::get('/rekapitulasi', [RekapitulasiController::class, 'index'])->name('rekapitulasi.index');
        Route::get('/rekapitulasi/export-excel', [RekapitulasiController::class, 'exportExcel'])->name('rekapitulasi.export.excel');
        Route::get('/rekapitulasi/export-pdf', [RekapitulasiController::class, 'exportPdf'])->name('rekapitulasi.export.pdf');
    });

    /*
    |--------------------------------------------------------------------------
    | KEUANGAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('keuangan')->name('keuangan.')->group(function () {
        Route::get('/laporan', [KeuanganController::class, 'laporan'])->name('laporan');
        Route::get('/input-data', [KeuanganController::class, 'inputData'])->name('input-data');
        Route::post('/input-data', [KeuanganController::class, 'store'])->name('store');
        Route::delete('/{id}', [KeuanganController::class, 'destroy'])->name('destroy');
        Route::get('/laporan-apbdes', [KeuanganController::class, 'laporanApbdes'])->name('laporan-apbdes');

        // Kas Desa
        Route::get('/kas-desa', [KeuanganController::class, 'kasDesa'])->name('kas-desa');
        Route::get('/kas-desa/create', [KeuanganController::class, 'kasDesaCreate'])->name('kas-desa.create');
        Route::post('/kas-desa', [KeuanganController::class, 'kasDesaStore'])->name('kas-desa.store');
        Route::get('/kas-desa/{id}/edit', [KeuanganController::class, 'kasDesaEdit'])->name('kas-desa.edit');
        Route::put('/kas-desa/{id}', [KeuanganController::class, 'kasDesaUpdate'])->name('kas-desa.update');
        Route::delete('/kas-desa/{id}', [KeuanganController::class, 'kasDesaDestroy'])->name('kas-desa.destroy');

        // APBDes
        Route::get('/apbdes', [KeuanganController::class, 'apbdes'])->name('apbdes');
        Route::get('/apbdes/create', [KeuanganController::class, 'apbdesCreate'])->name('apbdes.create');
        Route::post('/apbdes', [KeuanganController::class, 'apbdesStore'])->name('apbdes.store');
        Route::get('/apbdes/{id}/edit', [KeuanganController::class, 'apbdesEdit'])->name('apbdes.edit');
        Route::put('/apbdes/{id}', [KeuanganController::class, 'apbdesUpdate'])->name('apbdes.update');
        Route::delete('/apbdes/{id}', [KeuanganController::class, 'apbdesDestroy'])->name('apbdes.destroy');
        Route::post('/apbdes/{apbdesId}/realisasi', [KeuanganController::class, 'realisasiStore'])->name('apbdes.realisasi.store');
    });

    Route::get('/laporan', function () {
        return view('admin.laporan');
    })->name('laporan');

    /*
    |--------------------------------------------------------------------------
    | ARTIKEL & KOMENTAR
    |--------------------------------------------------------------------------
    */
    Route::resource('artikel', ArtikelController::class);

    Route::get('/komentar', [App\Http\Controllers\Admin\KomentarController::class, 'index'])->name('komentar.index');
    Route::patch('/komentar/{id}/approve', [App\Http\Controllers\Admin\KomentarController::class, 'approve'])->name('komentar.approve');
    Route::patch('/komentar/{id}/reject', [App\Http\Controllers\Admin\KomentarController::class, 'reject'])->name('komentar.reject');
    Route::delete('/komentar/{id}', [App\Http\Controllers\Admin\KomentarController::class, 'destroy'])->name('komentar.destroy');

    /*
    |--------------------------------------------------------------------------
    | ANALISIS
    |--------------------------------------------------------------------------
    */
    Route::resource('analisis', AnalisisMasterController::class)
        ->parameters(['analisis' => 'analisi']);

    Route::post('analisis/{analisi}/toggle-status', [AnalisisMasterController::class, 'toggleStatus'])
        ->name('analisis.toggle-status');

    Route::post('analisis/{analisi}/toggle-lock', [AnalisisMasterController::class, 'toggleLock'])
        ->name('analisis.toggle-lock');

    Route::prefix('analisis/{analisi}/indikator')->name('analisis.indikator.')->group(function () {
        Route::post('/', [AnalisisIndikatorController::class, 'store'])->name('store');
        Route::put('/{indikator}', [AnalisisIndikatorController::class, 'update'])->name('update');
        Route::delete('/{indikator}', [AnalisisIndikatorController::class, 'destroy'])->name('destroy');
        Route::post('/reorder', [AnalisisIndikatorController::class, 'reorder'])->name('reorder');
        Route::post('/{indikator}/jawaban', [AnalisisIndikatorController::class, 'storeJawaban'])->name('jawaban.store');
        Route::delete('/{indikator}/jawaban/{jawaban}', [AnalisisIndikatorController::class, 'destroyJawaban'])->name('jawaban.destroy');
    });

    Route::prefix('analisis/{analisi}/periode')->name('analisis.periode.')->group(function () {
        Route::post('/', [AnalisisPeriodeController::class, 'store'])->name('store');
        Route::put('/{periode}', [AnalisisPeriodeController::class, 'update'])->name('update');
        Route::delete('/{periode}', [AnalisisPeriodeController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('analisis/{analisi}/klasifikasi')->name('analisis.klasifikasi.')->group(function () {
        Route::post('/', [AnalisisKlasifikasiController::class, 'store'])->name('store');
        Route::put('/{klasifikasi}', [AnalisisKlasifikasiController::class, 'update'])->name('update');
        Route::delete('/{klasifikasi}', [AnalisisKlasifikasiController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('analisis/{analisi}/responden')->name('analisis.responden.')->group(function () {
        Route::get('/', [AnalisisRespondenController::class, 'index'])->name('index');
        Route::get('/create', [AnalisisRespondenController::class, 'create'])->name('create');
        Route::post('/', [AnalisisRespondenController::class, 'store'])->name('store');
        Route::get('/{responden}', [AnalisisRespondenController::class, 'show'])->name('show');
        Route::delete('/{responden}', [AnalisisRespondenController::class, 'destroy'])->name('destroy');
        Route::get('/export/csv', [AnalisisRespondenController::class, 'export'])->name('export');
        Route::get('/export/rekap', [AnalisisRespondenController::class, 'exportRekap'])->name('export.rekap');
    });

    /*
    |--------------------------------------------------------------------------
    | BANTUAN
    |--------------------------------------------------------------------------
    */
    Route::get('/bantuan/cari-penduduk', function (\Illuminate\Http\Request $request) {
        $nik      = $request->query('nik');
        $penduduk = \App\Models\Penduduk::where('nik', $nik)
            ->where('status_hidup', 'hidup')
            ->first();

        if ($penduduk) {
            return response()->json([
                'found'    => true,
                'penduduk' => [
                    'id'            => $penduduk->id,
                    'nama'          => $penduduk->nama,
                    'nik'           => $penduduk->nik,
                    'jenis_kelamin' => $penduduk->jenis_kelamin,
                    'tanggal_lahir' => optional($penduduk->tanggal_lahir)->format('d/m/Y'),
                    'alamat'        => $penduduk->alamat,
                ],
            ]);
        }

        return response()->json(['found' => false]);
    })->name('bantuan.cari-penduduk');

    Route::resource('bantuan', BantuanController::class);

    Route::prefix('bantuan/{bantuan}/peserta')->name('bantuan.peserta.')->group(function () {
        Route::get('/create', [BantuanPesertaController::class, 'create'])->name('create');
        Route::post('/', [BantuanPesertaController::class, 'store'])->name('store');
        Route::delete('/{peserta}', [BantuanPesertaController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | KESEHATAN
    |--------------------------------------------------------------------------
    */
    require __DIR__ . '/kesehatan.php';

    /*
    |--------------------------------------------------------------------------
    | PEMBANGUNAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('pembangunan')->name('pembangunan.')->group(function () {

        Route::resource('/', PembangunanController::class)
            ->parameters(['' => 'pembangunan'])
            ->names([
                'index'   => 'index',
                'create'  => 'create',
                'store'   => 'store',
                'show'    => 'show',
                'edit'    => 'edit',
                'update'  => 'update',
                'destroy' => 'destroy',
            ]);

        Route::post('{pembangunan}/dokumentasi', [PembangunanController::class, 'storeDokumentasi'])
            ->name('dokumentasi.store');

        Route::delete('{pembangunan}/dokumentasi/{dokumentasi}', [PembangunanController::class, 'destroyDokumentasi'])
            ->name('dokumentasi.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | LAPAK
    |--------------------------------------------------------------------------
    */
    Route::prefix('lapak')->name('lapak.')->group(function () {
        Route::get('/', [LapakController::class, 'index'])->name('index');
        Route::get('/tambah', [LapakController::class, 'create'])->name('create');
        Route::post('/', [LapakController::class, 'store'])->name('store');
        Route::get('/{lapak}', [LapakController::class, 'show'])->name('show');
        Route::get('/{lapak}/edit', [LapakController::class, 'edit'])->name('edit');
        Route::put('/{lapak}', [LapakController::class, 'update'])->name('update');
        Route::delete('/{lapak}', [LapakController::class, 'destroy'])->name('destroy');
        Route::patch('/{lapak}/toggle-status', [LapakController::class, 'toggleStatus'])->name('toggle-status');

        Route::prefix('/{lapak}/produk')->name('produk.')->group(function () {
            Route::get('/', [LapakProdukController::class, 'index'])->name('index');
            Route::get('/tambah', [LapakProdukController::class, 'create'])->name('create');
            Route::post('/', [LapakProdukController::class, 'store'])->name('store');
            Route::get('/{produk}/edit', [LapakProdukController::class, 'edit'])->name('edit');
            Route::put('/{produk}', [LapakProdukController::class, 'update'])->name('update');
            Route::delete('/{produk}', [LapakProdukController::class, 'destroy'])->name('destroy');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | INFO DESA — WILAYAH ADMINISTRATIF
    |--------------------------------------------------------------------------
    */
    Route::resource('info-desa/wilayah-administratif', WilayahController::class)->names([
        'index'   => 'info-desa.wilayah-administratif',
        'create'  => 'info-desa.wilayah-administratif.create',
        'store'   => 'info-desa.wilayah-administratif.store',
        'show'    => 'info-desa.wilayah-administratif.show',
        'edit'    => 'info-desa.wilayah-administratif.edit',
        'update'  => 'info-desa.wilayah-administratif.update',
        'destroy' => 'info-desa.wilayah-administratif.destroy',
    ]);
    Route::get('/info-desa/wilayah-administratif/{wilayah}/delete', [WilayahController::class, 'confirmDestroy'])
        ->name('info-desa.wilayah-administratif.confirm-destroy');

    /*
    |--------------------------------------------------------------------------
    | PEMERINTAH DESA
    |--------------------------------------------------------------------------
    */
    Route::prefix('pemerintah-desa')->name('pemerintah-desa.')->group(function () {
        Route::get('/', [PemerintahDesaController::class, 'index'])->name('index');
        Route::get('/create', [PemerintahDesaController::class, 'create'])->name('create');
        Route::post('/', [PemerintahDesaController::class, 'store'])->name('store');
        Route::get('/{pemerintahDesa}', [PemerintahDesaController::class, 'show'])->name('show');
        Route::get('/{pemerintahDesa}/edit', [PemerintahDesaController::class, 'edit'])->name('edit');
        Route::put('/{pemerintahDesa}', [PemerintahDesaController::class, 'update'])->name('update');
        Route::delete('/{pemerintahDesa}', [PemerintahDesaController::class, 'destroy'])->name('destroy');
        Route::patch('/{pemerintahDesa}/toggle-status', [PemerintahDesaController::class, 'toggleStatus'])->name('toggle-status');
    });

    /*
    |--------------------------------------------------------------------------
    | PENGGUNA (SISTEM)
    |--------------------------------------------------------------------------
    */
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/create', [PenggunaController::class, 'create'])->name('pengguna.create');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna/{user}', [PenggunaController::class, 'show'])->name('pengguna.show');
    Route::get('/pengguna/{user}/edit', [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::put('/pengguna/{user}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{user}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    /*
    |--------------------------------------------------------------------------
    | PENGADUAN
    |--------------------------------------------------------------------------
    */
    Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::post('pengaduan/{pengaduan}/tanggapi', [PengaduanController::class, 'tanggapi'])->name('pengaduan.tanggapi');
    Route::delete('pengaduan/{pengaduan}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
});
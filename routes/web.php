<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\Admin\InfoDesaController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\RumahTanggaAnggotaController;
use App\Http\Controllers\Admin\SekretariatController;
use App\Http\Controllers\Admin\KehadiranBulananController;
use App\Http\Controllers\Admin\KehadiranTahunanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\Auth\AktivasiWargaController;
use App\Http\Controllers\Warga\DashboardWargaController;
use App\Http\Controllers\Admin\LayananSuratController as AdminSuratController;
use App\Http\Controllers\Warga\LayananSuratController as WargaSuratController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

// HOME
Route::get('/', [App\Http\Controllers\FrontendController::class, 'home'])->name('home');

// BERITA DESA
Route::get('/berita', [App\Http\Controllers\FrontendController::class, 'berita'])->name('berita');
Route::get('/artikel/{id}', [App\Http\Controllers\FrontendController::class, 'artikelShow'])->name('artikel.show');

// PROGRAM KERJA
Route::get('/program', function () {
    return view('frontend.program');
})->name('program');

// PROFIL DESA
Route::get('/profil', [App\Http\Controllers\FrontendController::class, 'profil'])->name('profil');

// DATA DESA
Route::get('/data-desa', [FrontendController::class, 'dataDesa'])->name('data-desa');

// ARTIKEL
Route::get('/artikel', [FrontendController::class, 'berita'])->name('artikel');
Route::get('/artikel/{id}', [FrontendController::class, 'artikelShow'])->name('artikel.show');

// TAMBAHKAN ROUTE INI:
Route::post('/artikel/{id}/komentar', [FrontendController::class, 'storeKomentar'])->name('artikel.komentar.store');


// WILAYAH ADMINISTRATIF
Route::get('/wilayah', [App\Http\Controllers\FrontendController::class, 'wilayah'])->name('wilayah');
Route::get('/wilayah/{id}', [FrontendController::class, 'wilayahShow'])->name('wilayah.show');

// PROFIL KEPALA DESA
Route::get('/profil/kepala-desa', [FrontendController::class, 'profilKepalaDesa'])->name('profil-kepala-desa');

// KONTAK
Route::get('/kontak', [FrontendController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [FrontendController::class, 'storeKontak'])->name('kontak.store');

Route::get('/pemerintahan', [FrontendController::class, 'pemerintahan'])->name('pemerintahan');

Route::get('/kebijakan-privasi', function () {
    return view('frontend.pages.kebijakan-privasi.index', [
        'lastUpdated' => \Carbon\Carbon::parse('2025-01-01')->isoFormat('D MMMM YYYY')
    ]);
})->name('kebijakan-privasi');

Route::get('/syarat-ketentuan', function () {
    return view('frontend.pages.syarat-ketentuan.index', [
        'lastUpdated' => \Carbon\Carbon::parse('2025-01-01')->isoFormat('D MMMM YYYY')
    ]);
})->name('syarat-ketentuan');

// FAQ
Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');

// LAPAK
Route::get('/lapak', [FrontendController::class, 'lapak'])->name('lapak');
Route::get('/lapak/{slug}', [FrontendController::class, 'lapakShow'])->name('lapak.show');

Route::get('/peta-situs', function () {
    return view('frontend.pages.peta-situs.index');
})->name('peta-situs');

// LOGIN
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// SETUP
Route::get('/setup', [SetupController::class, 'showSetup'])->name('setup')->middleware('check.setup');
Route::post('/setup', [SetupController::class, 'register'])->name('setup.register');

// --- AUTH WARGA (AKTIVASI) ---
Route::middleware('guest')->group(function () {
    Route::get('/layanan-mandiri/aktivasi', [AktivasiWargaController::class, 'showCheckForm'])->name('aktivasi.index');
    Route::post('/layanan-mandiri/cek', [AktivasiWargaController::class, 'check'])->name('aktivasi.check');
    Route::post('/layanan-mandiri/daftar', [AktivasiWargaController::class, 'register'])->name('aktivasi.store');
});

// --- AREA WARGA (SUDAH LOGIN) ---
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
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

// Identitas Desa - accessible without identitas desa check
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | IDENTITAS DESA
    |--------------------------------------------------------------------------
    */
    Route::get('/identitas-desa', [App\Http\Controllers\Admin\InfoDesa\IdentitasDesaController::class, 'index'])->name('identitas-desa.index');
    Route::get('/identitas-desa/edit', [App\Http\Controllers\Admin\InfoDesa\IdentitasDesaController::class, 'edit'])->name('identitas-desa.edit');
    Route::put('/identitas-desa', [App\Http\Controllers\Admin\InfoDesa\IdentitasDesaController::class, 'update'])->name('identitas-desa.update');
});

// Other admin routes - require identitas desa to be filled
Route::prefix('admin')->name('admin.')->middleware(['auth', 'check.identitas.desa'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | STATISTIK DESA
    |--------------------------------------------------------------------------
    */
    Route::get('/statistik/kependudukan', [\App\Http\Controllers\Admin\statistik\StatistikController::class, 'kependudukan'])->name('statistik.kependudukan');

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
    | MASTER DATA
    |--------------------------------------------------------------------------
    */
    Route::get('/penduduk', [App\Http\Controllers\Admin\kependudukan\PendudukController::class, 'index'])->name('penduduk');
    Route::get('/penduduk/create', [App\Http\Controllers\Admin\kependudukan\PendudukController::class, 'create'])->name('penduduk.create');
    Route::post('/penduduk', [App\Http\Controllers\Admin\kependudukan\PendudukController::class, 'store'])->name('penduduk.store');
    Route::get('/penduduk/{penduduk}', [App\Http\Controllers\Admin\kependudukan\PendudukController::class, 'show'])->name('penduduk.show');
    Route::post('/penduduk/import', [App\Http\Controllers\Admin\kependudukan\PendudukController::class, 'import'])->name('penduduk.import');
    Route::get('/penduduk/{penduduk}/edit', [App\Http\Controllers\Admin\kependudukan\PendudukController::class, 'edit'])->name('penduduk.edit');
    Route::put('/penduduk/{penduduk}', [App\Http\Controllers\Admin\kependudukan\PendudukController::class, 'update'])->name('penduduk.update');
    Route::get('/penduduk/{penduduk}/delete', [App\Http\Controllers\Admin\kependudukan\PendudukController::class, 'confirmDestroy'])->name('penduduk.confirm-destroy');
    Route::delete('/penduduk/{penduduk}', [App\Http\Controllers\Admin\kependudukan\PendudukController::class, 'destroy'])->name('penduduk.destroy');

    Route::get('/keluarga', [App\Http\Controllers\admin\kependudukan\KeluargaController::class, 'index'])->name('keluarga');
    Route::get('/keluarga/create', [App\Http\Controllers\admin\kependudukan\KeluargaController::class, 'create'])->name('keluarga.create');
    Route::post('/keluarga', [App\Http\Controllers\admin\kependudukan\KeluargaController::class, 'store'])->name('keluarga.store');
    Route::get('/keluarga/{keluarga}', [App\Http\Controllers\admin\kependudukan\KeluargaController::class, 'show'])->name('keluarga.show');
    Route::get('/keluarga/{keluarga}/edit', [App\Http\Controllers\admin\kependudukan\KeluargaController::class, 'edit'])->name('keluarga.edit');
    Route::put('/keluarga/{keluarga}', [App\Http\Controllers\admin\kependudukan\KeluargaController::class, 'update'])->name('keluarga.update');
    Route::get('/keluarga/{keluarga}/delete', [App\Http\Controllers\admin\kependudukan\KeluargaController::class, 'confirmDestroy'])->name('keluarga.confirm-destroy');
    Route::delete('/keluarga/{keluarga}', [App\Http\Controllers\admin\kependudukan\KeluargaController::class, 'destroy'])->name('keluarga.destroy');

    Route::resource('rumah-tangga', App\Http\Controllers\Admin\kependudukan\RumahTanggaController::class)->names([
        'index'   => 'rumah-tangga.index',
        'create'  => 'rumah-tangga.create',
        'store'   => 'rumah-tangga.store',
        'show'    => 'rumah-tangga.show',
        'edit'    => 'rumah-tangga.edit',
        'update'  => 'rumah-tangga.update',
        'destroy' => 'rumah-tangga.destroy',
    ]);
    Route::get('/rumah-tangga/{rumahTangga}/delete', [App\Http\Controllers\Admin\kependudukan\RumahTanggaController::class, 'confirmDestroy'])->name('rumah-tangga.confirm-destroy');

    // Rumah Tangga Anggota
    Route::prefix('rumah-tangga/{rumahTangga}/anggota')->name('rumah-tangga-anggota.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\RumahTanggaAnggotaController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\RumahTanggaAnggotaController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\RumahTanggaAnggotaController::class, 'store'])->name('store');
        Route::get('/{anggota}/edit', [App\Http\Controllers\Admin\RumahTanggaAnggotaController::class, 'edit'])->name('edit');
        Route::put('/{anggota}', [App\Http\Controllers\Admin\RumahTanggaAnggotaController::class, 'update'])->name('update');
        Route::delete('/{anggota}', [App\Http\Controllers\Admin\RumahTanggaAnggotaController::class, 'destroy'])->name('destroy');
    });

    // Kelompok Master
    Route::prefix('kelompok/master')->name('kelompok.master.')->group(function () {
        Route::get('/', [KelompokController::class, 'masterIndex'])->name('index');
        Route::post('/', [KelompokController::class, 'masterStore'])->name('store');
        Route::put('/{master}', [KelompokController::class, 'masterUpdate'])->name('update');
        Route::delete('/{master}', [KelompokController::class, 'masterDestroy'])->name('destroy');
    });

    // Kelompok & Anggota
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
    Route::get('/surat', function () {
        return view('admin.surat');
    })->name('surat');

    Route::get('/layanan-surat/pengaturan', [App\Http\Controllers\Admin\LayananSuratController::class, 'pengaturan'])->name('layanan-surat.pengaturan');
    Route::get('/layanan-surat/cetak', [App\Http\Controllers\Admin\LayananSuratController::class, 'cetak'])->name('layanan-surat.cetak');
    Route::get('/layanan-surat/permohonan', [App\Http\Controllers\Admin\LayananSuratController::class, 'permohonan'])->name('layanan-surat.permohonan');
    Route::get('/layanan-surat/arsip', [App\Http\Controllers\Admin\LayananSuratController::class, 'arsip'])->name('layanan-surat.arsip');
    Route::get('/layanan-surat/daftar-persyaratan', [App\Http\Controllers\Admin\LayananSuratController::class, 'daftarPersyaratan'])->name('layanan-surat.daftar-persyaratan');
    Route::post('/layanan-surat/template', [App\Http\Controllers\Admin\LayananSuratController::class, 'storeTemplate'])->name('layanan-surat.storeTemplate');

    /*
    |--------------------------------------------------------------------------
    | SEKRETARIAT
    |--------------------------------------------------------------------------
    */
    Route::get('/sekretariat/informasi-publik', [SekretariatController::class, 'index'])->name('sekretariat.informasi-publik.index');
    Route::get('/sekretariat/informasi-publik/create', [SekretariatController::class, 'create'])->name('sekretariat.informasi-publik.create');
    Route::post('/sekretariat/informasi-publik', [SekretariatController::class, 'store'])->name('sekretariat.informasi-publik.store');
    Route::get('/sekretariat/informasi-publik/{id}/edit', [SekretariatController::class, 'edit'])->name('sekretariat.informasi-publik.edit');
    Route::put('/sekretariat/informasi-publik/{id}', [SekretariatController::class, 'update'])->name('sekretariat.informasi-publik.update');
    Route::delete('/sekretariat/informasi-publik/{id}', [SekretariatController::class, 'destroy'])->name('sekretariat.informasi-publik.destroy');
    Route::get('/sekretariat/informasi-publik/{id}/download', [SekretariatController::class, 'download'])->name('sekretariat.informasi-publik.download');
    Route::get('/sekretariat/inventaris', [SekretariatController::class, 'inventaris'])->name('sekretariat.inventaris');
    Route::get('/sekretariat/inventaris/create', [SekretariatController::class, 'inventarisCreate'])->name('sekretariat.inventaris.create');
    Route::post('/sekretariat/inventaris', [SekretariatController::class, 'inventarisStore'])->name('sekretariat.inventaris.store');
    Route::get('/sekretariat/inventaris/{id}/edit', [SekretariatController::class, 'inventarisEdit'])->name('sekretariat.inventaris.edit');
    Route::put('/sekretariat/inventaris/{id}', [SekretariatController::class, 'inventarisUpdate'])->name('sekretariat.inventaris.update');
    Route::delete('/sekretariat/inventaris/{id}', [SekretariatController::class, 'inventarisDestroy'])->name('sekretariat.inventaris.destroy');
    Route::get('/sekretariat/klasifikasi-surat', [SekretariatController::class, 'klasifikasiSurat'])->name('sekretariat.klasifikasi-surat');
    Route::get('/sekretariat/klasifikasi-surat/create', [SekretariatController::class, 'klasifikasiSuratCreate'])->name('sekretariat.klasifikasi-surat.create');
    Route::post('/sekretariat/klasifikasi-surat', [SekretariatController::class, 'klasifikasiSuratStore'])->name('sekretariat.klasifikasi-surat.store');
    Route::get('/sekretariat/klasifikasi-surat/{id}', [SekretariatController::class, 'klasifikasiSuratShow'])->name('sekretariat.klasifikasi-surat.show');
    Route::get('/sekretariat/klasifikasi-surat/{id}/edit', [SekretariatController::class, 'klasifikasiSuratEdit'])->name('sekretariat.klasifikasi-surat.edit');
    Route::put('/sekretariat/klasifikasi-surat/{id}', [SekretariatController::class, 'klasifikasiSuratUpdate'])->name('sekretariat.klasifikasi-surat.update');
    Route::delete('/sekretariat/klasifikasi-surat/{id}', [SekretariatController::class, 'klasifikasiSuratDestroy'])->name('sekretariat.klasifikasi-surat.destroy');

    /*
    |--------------------------------------------------------------------------
    | ANALISIS
    |--------------------------------------------------------------------------
    */

    // Analisis Master (CRUD)
    Route::resource('analisis', AnalisisMasterController::class)
        ->parameters(['analisis' => 'analisi']);

    Route::post('analisis/{analisi}/toggle-status', [AnalisisMasterController::class, 'toggleStatus'])
        ->name('analisis.toggle-status');

    Route::post('analisis/{analisi}/toggle-lock', [AnalisisMasterController::class, 'toggleLock'])
        ->name('analisis.toggle-lock');

    // Indikator (nested under analisis)
    Route::prefix('analisis/{analisi}/indikator')->name('analisis.indikator.')->group(function () {
        Route::post('/', [AnalisisIndikatorController::class, 'store'])->name('store');
        Route::put('/{indikator}', [AnalisisIndikatorController::class, 'update'])->name('update');
        Route::delete('/{indikator}', [AnalisisIndikatorController::class, 'destroy'])->name('destroy');
        Route::post('/reorder', [AnalisisIndikatorController::class, 'reorder'])->name('reorder');

        Route::post('/{indikator}/jawaban', [AnalisisIndikatorController::class, 'storeJawaban'])->name('jawaban.store');
        Route::delete('/{indikator}/jawaban/{jawaban}', [AnalisisIndikatorController::class, 'destroyJawaban'])->name('jawaban.destroy');
    });

    // Periode (nested under analisis)
    Route::prefix('analisis/{analisi}/periode')->name('analisis.periode.')->group(function () {
        Route::post('/', [AnalisisPeriodeController::class, 'store'])->name('store');
        Route::put('/{periode}', [AnalisisPeriodeController::class, 'update'])->name('update');
        Route::delete('/{periode}', [AnalisisPeriodeController::class, 'destroy'])->name('destroy');
    });

    // Klasifikasi (nested under analisis)
    Route::prefix('analisis/{analisi}/klasifikasi')->name('analisis.klasifikasi.')->group(function () {
        Route::post('/', [AnalisisKlasifikasiController::class, 'store'])->name('store');
        Route::put('/{klasifikasi}', [AnalisisKlasifikasiController::class, 'update'])->name('update');
        Route::delete('/{klasifikasi}', [AnalisisKlasifikasiController::class, 'destroy'])->name('destroy');
    });

    // Responden (nested under analisis)
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
        Route::get('create', [BantuanPesertaController::class, 'create'])->name('create');
        Route::post('/', [BantuanPesertaController::class, 'store'])->name('store');
        Route::delete('{peserta}', [BantuanPesertaController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | KESEHATAN
    |--------------------------------------------------------------------------
    */
    require __DIR__ . '/kesehatan.php';

    /*
    |--------------------------------------------------------------------------
    | KEHADIRAN
    |--------------------------------------------------------------------------
    */
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('jenis-kehadiran', JenisKehadiranController::class)->except(['show']);
    Route::resource('kehadiran-harian', KehadiranHarianController::class);
    Route::resource('jam-kerja', JamKerjaController::class);
    Route::resource('keterangan', KeteranganController::class);
    Route::resource('dinas-luar', DinasLuarController::class);

    Route::prefix('kehadiran')->name('kehadiran.')->group(function () {
        Route::get('/rekapitulasi', [RekapitulasiController::class, 'index'])->name('rekapitulasi.index');
        Route::get('/rekapitulasi/export-excel', [RekapitulasiController::class, 'exportExcel'])->name('rekapitulasi.export.excel');
        Route::get('/rekapitulasi/export-pdf', [RekapitulasiController::class, 'exportPdf'])->name('rekapitulasi.export.pdf');
    });

    /*
    |--------------------------------------------------------------------------
    | KEUANGAN & LAPORAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('keuangan')->group(function () {
        Route::get('/laporan', [KeuanganController::class, 'laporan'])->name('keuangan.laporan');
        Route::get('/input-data', [KeuanganController::class, 'inputData'])->name('keuangan.input-data');
        Route::post('/input-data', [KeuanganController::class, 'store'])->name('keuangan.store');
        Route::delete('/{id}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');
        Route::get('/laporan-apbdes', [KeuanganController::class, 'laporanApbdes'])->name('keuangan.laporan-apbdes');

        Route::get('/kas-desa', [KeuanganController::class, 'kasDesa'])->name('keuangan.kas-desa');
        Route::get('/kas-desa/create', [KeuanganController::class, 'kasDesaCreate'])->name('keuangan.kas-desa.create');
        Route::post('/kas-desa', [KeuanganController::class, 'kasDesaStore'])->name('keuangan.kas-desa.store');
        Route::get('/kas-desa/{id}/edit', [KeuanganController::class, 'kasDesaEdit'])->name('keuangan.kas-desa.edit');
        Route::put('/kas-desa/{id}', [KeuanganController::class, 'kasDesaUpdate'])->name('keuangan.kas-desa.update');
        Route::delete('/kas-desa/{id}', [KeuanganController::class, 'kasDesaDestroy'])->name('keuangan.kas-desa.destroy');

        Route::get('/apbdes', [KeuanganController::class, 'apbdes'])->name('keuangan.apbdes');
        Route::get('/apbdes/create', [KeuanganController::class, 'apbdesCreate'])->name('keuangan.apbdes.create');
        Route::post('/apbdes', [KeuanganController::class, 'apbdesStore'])->name('keuangan.apbdes.store');
        Route::get('/apbdes/{id}/edit', [KeuanganController::class, 'apbdesEdit'])->name('keuangan.apbdes.edit');
        Route::put('/apbdes/{id}', [KeuanganController::class, 'apbdesUpdate'])->name('keuangan.apbdes.update');
        Route::delete('/apbdes/{id}', [KeuanganController::class, 'apbdesDestroy'])->name('keuangan.apbdes.destroy');
        Route::post('/apbdes/{apbdesId}/realisasi', [KeuanganController::class, 'realisasiStore'])->name('keuangan.apbdes.realisasi.store');
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

    // INI RUTE KOMENTAR YANG SUDAH DIPERBAIKI (ADA DI DALAM BLOK ADMIN)
    Route::get('/komentar', [App\Http\Controllers\Admin\KomentarController::class, 'index'])->name('komentar.index');
    Route::patch('/komentar/{id}/approve', [App\Http\Controllers\Admin\KomentarController::class, 'approve'])->name('komentar.approve');
    Route::patch('/komentar/{id}/reject', [App\Http\Controllers\Admin\KomentarController::class, 'reject'])->name('komentar.reject');
    Route::delete('/komentar/{id}', [App\Http\Controllers\Admin\KomentarController::class, 'destroy'])->name('komentar.destroy');

    /*
    |--------------------------------------------------------------------------
    | SISTEM
    |--------------------------------------------------------------------------
    */
    Route::get('/pengguna', [App\Http\Controllers\Admin\PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/create', [App\Http\Controllers\Admin\PenggunaController::class, 'create'])->name('pengguna.create');
    Route::post('/pengguna', [App\Http\Controllers\Admin\PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna/{user}', [App\Http\Controllers\Admin\PenggunaController::class, 'show'])->name('pengguna.show');
    Route::get('/pengguna/{user}/edit', [App\Http\Controllers\Admin\PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::put('/pengguna/{user}', [App\Http\Controllers\Admin\PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{user}', [App\Http\Controllers\Admin\PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    /*
    |--------------------------------------------------------------------------
    | INFO DESA
    |--------------------------------------------------------------------------
    */
    Route::resource('info-desa/wilayah-administratif', App\Http\Controllers\Admin\InfoDesa\WilayahController::class)->names([
        'index'   => 'info-desa.wilayah-administratif',
        'create'  => 'info-desa.wilayah-administratif.create',
        'store'   => 'info-desa.wilayah-administratif.store',
        'show'    => 'info-desa.wilayah-administratif.show',
        'edit'    => 'info-desa.wilayah-administratif.edit',
        'update'  => 'info-desa.wilayah-administratif.update',
        'destroy' => 'info-desa.wilayah-administratif.destroy',
    ]);
    Route::get('/info-desa/wilayah-administratif/{wilayah}/delete', [App\Http\Controllers\Admin\InfoDesa\WilayahController::class, 'confirmDestroy'])->name('info-desa.wilayah-administratif.confirm-destroy');

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
    | PEMBANGUNAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('pembangunan')->name('pembangunan.')->group(function () {

        // ── CRUD utama Pembangunan ───────────────────────────────
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

        // ── Dokumentasi (nested di dalam kegiatan) ───────────────
        // Sesuai OpenSID: pembangunan_ref_dokumentasi
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
    | PENGADUAN
    |--------------------------------------------------------------------------
    */
    Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::post('pengaduan/{pengaduan}/tanggapi', [PengaduanController::class, 'tanggapi'])->name('pengaduan.tanggapi');
    Route::delete('pengaduan/{pengaduan}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
});
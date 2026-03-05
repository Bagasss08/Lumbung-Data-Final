<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// InfoDesa
use App\Http\Controllers\Admin\InfoDesa\IdentitasDesaController;
use App\Http\Controllers\Admin\InfoDesa\WilayahController;
use App\Http\Controllers\Admin\InfoDesa\PemerintahDesaController;
use App\Http\Controllers\Admin\InfoDesa\StatusDesaController;
use App\Http\Controllers\Admin\InfoDesa\LayananPelangganController;
use App\Http\Controllers\Admin\InfoDesa\KerjasamaController;

// Kependudukan
use App\Http\Controllers\Admin\kependudukan\PendudukController;
use App\Http\Controllers\Admin\kependudukan\KeluargaController;
use App\Http\Controllers\Admin\kependudukan\RumahTanggaController;
use App\Http\Controllers\Admin\kependudukan\KelompokController;
use App\Http\Controllers\Admin\kependudukan\DataSuplemenController;
use App\Http\Controllers\Admin\kependudukan\CalonPemilihController;

// Kehadiran
use App\Http\Controllers\Admin\Kehadiran\JamKerjaController;
use App\Http\Controllers\Admin\Kehadiran\HariLiburController;
use App\Http\Controllers\Admin\Kehadiran\RekapitulasiController;
use App\Http\Controllers\Admin\Kehadiran\PengaduanKehadiranController;
use App\Http\Controllers\Admin\Kehadiran\InputKehadiranController;

use App\Http\Controllers\Admin\PeraturanDesaController;
use App\Http\Controllers\Admin\BukuUmumController;

// Import Controller buku penduduk
use App\Http\Controllers\Admin\BukuPendudukController; // <--- Jangan lupa baris ini di paling atas

// Import Controller buku pembangunan
use App\Http\Controllers\Admin\BukuPembangunanController;
use App\Http\Controllers\Admin\RencanaPembangunanController;

// Sekretariat
use App\Http\Controllers\Admin\sekretariat\SekretariatController;

// Keuangan
use App\Http\Controllers\Admin\keuangan\KeuanganController;

// Layanan Surat
use App\Http\Controllers\Admin\layanansurat\LayananSuratController;
use App\Http\Controllers\Admin\layanansurat\CetakController;
use App\Http\Controllers\Admin\layanansurat\CetakSuratController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\Admin\layanansurat\ArsipController;
use App\Http\Controllers\Admin\layanansurat\SuratTemplateController;
use App\Http\Controllers\Admin\layanansurat\LetterController;
        use App\Http\Controllers\Admin\PersyaratanController;
        


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

// profil
use App\Http\Controllers\Admin\ProfilController;

// Lainnya
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InfoDesaController;
use App\Http\Controllers\Admin\LembagaController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\RumahTanggaAnggotaController;
use App\Http\Controllers\Admin\KehadiranBulananController;
use App\Http\Controllers\Admin\KehadiranTahunanController;
use App\Http\Controllers\Admin\Pertanahan\CDesaController;
use App\Http\Controllers\Admin\HubungWargaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\Auth\AktivasiWargaController;

// Alias untuk LayananSurat (Warga vs Admin)
use App\Http\Controllers\Admin\layanansurat\LayananSuratController as AdminSuratController;
use App\Http\Controllers\Warga\LayananSuratController as WargaSuratController;
use App\Http\Controllers\Warga\PesanController;

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
// PROFIL DESA
Route::get('/identitas-desa', [App\Http\Controllers\FrontendController::class, 'profil'])->name('identitas-desa');

// DATA DESA
Route::get('/demografi', [FrontendController::class, 'dataDesa'])->name('data-desa');

// APBD
Route::get('/apbd', [App\Http\Controllers\FrontendController::class, 'apbd'])->name('apbd');

// Artikel (gunakan satu definisi saja, hindari duplikat)
Route::get('/artikel', [FrontendController::class, 'berita'])->name('artikel');
Route::get('/artikel/{id}', [FrontendController::class, 'artikelShow'])->name('artikel.show');
Route::post('/artikel/{id}/komentar', [FrontendController::class, 'storeKomentar'])->name('artikel.komentar.store');

Route::get('/wilayah', [FrontendController::class, 'wilayah'])->name('wilayah');

// WILAYAH ADMINISTRATIF
Route::get('/wilayah/{id}', [FrontendController::class, 'wilayahShow'])->name('wilayah.show');

Route::get('/profil/kepala-desa', [FrontendController::class, 'profilKepalaDesa'])->name('profil-kepala-desa');

// BPD
Route::get('/bpd', [FrontendController::class, 'bpd'])->name('bpd');

// KEMASYARAKATAN
Route::get('/kemasyarakatan', [App\Http\Controllers\FrontendController::class, 'kemasyarakatan'])->name('kemasyarakatan');

// KONTAK
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
    Route::get('/layanan-mandiri/cek', [AktivasiWargaController::class, 'showCheckForm']);
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

    // Rute Pesan Warga
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan.index');
    Route::get('/pesan/tulis', [PesanController::class, 'create'])->name('pesan.create');
    Route::post('/pesan', [PesanController::class, 'store'])->name('pesan.store');
    Route::get('/pesan/{id}', [PesanController::class, 'show'])->name('pesan.show');
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
| NOTIFIKASI BADGES — endpoint polling topbar
|--------------------------------------------------------------------------
*/
    Route::get('/notifikasi/badges', function () {
        return response()->json([
            'pending_komentar'   => \App\Models\KomentarArtikel::where('status', 'pending')->count(),
            'unread_pesan'       => \App\Models\Pesan::where('penerima_id', Auth::id())
                ->where('sudah_dibaca', false)->count(),
            'pending_permohonan' => \App\Models\SuratPermohonan::whereIn('status', [
                'belum lengkap',
                'sedang diperiksa',
                'menunggu tandatangan',
            ])->count(),
        ]);
    })->name('notifikasi.badges');

    /*
|--------------------------------------------------------------------------
| PROFIL ADMIN
|--------------------------------------------------------------------------
*/
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
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
    | LEMBAGA DESA (MASTER KELOMPOK)
    |--------------------------------------------------------------------------
    */
    Route::resource('lembaga', LembagaController::class);

    /*
    |--------------------------------------------------------------------------
    | MASTER DATA
    |--------------------------------------------------------------------------
    */
    Route::get('/penduduk', [PendudukController::class, 'index'])->name('penduduk');
    Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
    Route::post('/penduduk', [PendudukController::class, 'store'])->name('penduduk.store');
    Route::post('/penduduk/import', [PendudukController::class, 'import'])->name('penduduk.import');
    Route::get('/penduduk/template',     [PendudukController::class, 'downloadTemplate'])->name('penduduk.template');
    Route::get('/penduduk/export/excel', [PendudukController::class, 'exportExcel'])->name('penduduk.export.excel');
    Route::get('/penduduk/export/pdf',   [PendudukController::class, 'exportPdf'])->name('penduduk.export.pdf');
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
    Route::get('/keluarga/export/excel', [KeluargaController::class, 'exportExcel'])->name('keluarga.export.excel');
    Route::get('/keluarga/export/pdf', [KeluargaController::class, 'exportPdf'])->name('keluarga.export.pdf');
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
            Route::get('/template', [KelompokController::class, 'downloadTemplate'])->name('template');
            Route::post('/import', [KelompokController::class, 'import'])->name('import');
            Route::get('/export/excel', [KelompokController::class, 'exportExcel'])->name('export.excel');
            Route::get('/export/pdf', [KelompokController::class, 'exportPdf'])->name('export.pdf');
            Route::patch('/{anggota}/nonaktif', [KelompokController::class, 'anggotaDestroy'])->name('nonaktif');
            Route::delete('/{anggota}', [KelompokController::class, 'anggotaDestroySoft'])->name('destroy');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | KEPENDUDUKAN — SUPLEMEN
    |--------------------------------------------------------------------------
    */
    Route::get('/suplemen', [DataSuplemenController::class, 'index'])->name('suplemen.index');
    Route::get('/suplemen/create', [DataSuplemenController::class, 'create'])->name('suplemen.create');
    Route::post('/suplemen', [DataSuplemenController::class, 'store'])->name('suplemen.store');
    Route::get('/suplemen/{suplemen}', [DataSuplemenController::class, 'show'])->name('suplemen.show');
    Route::get('/suplemen/{suplemen}/edit', [DataSuplemenController::class, 'edit'])->name('suplemen.edit');
    Route::put('/suplemen/{suplemen}', [DataSuplemenController::class, 'update'])->name('suplemen.update');
    Route::delete('/suplemen/{suplemen}', [DataSuplemenController::class, 'destroy'])->name('suplemen.destroy');

    // Suplemen - Terdata (Import/Export)
    Route::get('/suplemen/{suplemen}/terdata/template',     [DataSuplemenController::class, 'downloadTemplate'])->name('suplemen.terdata.template');
    Route::post('/suplemen/{suplemen}/terdata/import',      [DataSuplemenController::class, 'import'])->name('suplemen.terdata.import');
    Route::get('/suplemen/{suplemen}/terdata/export/excel', [DataSuplemenController::class, 'exportExcel'])->name('suplemen.terdata.export.excel');
    Route::get('/suplemen/{suplemen}/terdata/export/pdf',   [DataSuplemenController::class, 'exportPdf'])->name('suplemen.terdata.export.pdf');

    // Suplemen - Terdata (Anggota)
    Route::get('/suplemen/{suplemen}/terdata', [DataSuplemenController::class, 'terdataIndex'])->name('suplemen.terdata.index');
    Route::get('/suplemen/{suplemen}/terdata/create', [DataSuplemenController::class, 'terdataCreate'])->name('suplemen.terdata.create');
    Route::post('/suplemen/{suplemen}/terdata', [DataSuplemenController::class, 'terdataStore'])->name('suplemen.terdata.store');
    Route::delete('/suplemen/{suplemen}/terdata/{terdata}', [DataSuplemenController::class, 'terdataDestroy'])->name('suplemen.terdata.destroy');

    /*
    |--------------------------------------------------------------------------
    | KEPENDUDUKAN — CALON PEMILIH
    |--------------------------------------------------------------------------
    */
    Route::get('/calon-pemilih/template', [CalonPemilihController::class, 'downloadTemplate'])->name('calon-pemilih.template');
    Route::post('/calon-pemilih/import', [CalonPemilihController::class, 'import'])->name('calon-pemilih.import');
    Route::get('/calon-pemilih/export/excel', [CalonPemilihController::class, 'exportExcel'])->name('calon-pemilih.export.excel');
    Route::get('/calon-pemilih/export/pdf', [CalonPemilihController::class, 'exportPdf'])->name('calon-pemilih.export.pdf');
    Route::get('/calon-pemilih', [CalonPemilihController::class, 'index'])->name('calon-pemilih.index');
    Route::get('/calon-pemilih/create', [CalonPemilihController::class, 'create'])->name('calon-pemilih.create');
    Route::post('/calon-pemilih', [CalonPemilihController::class, 'store'])->name('calon-pemilih.store');
    Route::get('/calon-pemilih/{calonPemilih}', [CalonPemilihController::class, 'show'])->name('calon-pemilih.show');
    Route::get('/calon-pemilih/{calonPemilih}/edit', [CalonPemilihController::class, 'edit'])->name('calon-pemilih.edit');
    Route::put('/calon-pemilih/{calonPemilih}', [CalonPemilihController::class, 'update'])->name('calon-pemilih.update');
    Route::delete('/calon-pemilih/{calonPemilih}', [CalonPemilihController::class, 'destroy'])->name('calon-pemilih.destroy');
    Route::patch('/calon-pemilih/{calonPemilih}/toggle-aktif', [CalonPemilihController::class, 'toggleAktif'])->name('calon-pemilih.toggle-aktif');

    /*
    |--------------------------------------------------------------------------
    | LAYANAN SURAT
    |--------------------------------------------------------------------------
    */
   Route::prefix('layanan-surat')->name('layanan-surat.')->group(function () {

    /*
    |-----------------------------------------
    | 1. Persyaratan
    |-----------------------------------------
    */
    Route::prefix('persyaratan')->name('persyaratan.')->controller(PersyaratanController::class)->group(function () {

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');

    });


    /*
    |-----------------------------------------
    | 2. Template Surat
    |-----------------------------------------
    */
    // Bungkus dalam prefix 'admin' agar URL menjadi: domain.com/admin/template
        Route::prefix('pengaturan')->name('template-surat.')->group(function () {
            Route::get('/', [SuratTemplateController::class, 'index'])->name('index');
            Route::get('/create', [SuratTemplateController::class, 'create'])->name('create');
            Route::post('/store', [SuratTemplateController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [SuratTemplateController::class, 'edit'])->name('edit');
            Route::put('/{id}', [SuratTemplateController::class, 'update'])->name('update');
            Route::delete('/{id}', [SuratTemplateController::class, 'destroy'])->name('destroy');
});


    /*
    |-----------------------------------------
    | 3. Cetak Surat
    |-----------------------------------------
    */
    // Pastikan grup ini berada di tempat yang semestinya di web.php
Route::prefix('cetak')->name('cetak.')->controller(LetterController::class)->group(function () {
    
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    
    // Alur Preview & Edit (Method yang dicari Blade kamu)
    Route::post('/preview', 'preview')->name('preview');

    // Alur Final Simpan & Cetak
    Route::post('/generate-final', 'generateFinal')->name('generateFinal');

    // Ajax & Search
    Route::get('/live-search-nik', 'liveSearchNik')->name('liveSearchNik');
    Route::get('/get-data/{nik}', 'getDataByNik')->name('getDataByNik');
    Route::get('/penduduk/{nik}', 'getPendudukData')->name('getPenduduk');

    Route::get('/{id}', 'show')->name('show');
    Route::get('/{id}/print', 'cetak')->name('print');
    Route::post('/store', 'store')->name('store');
});


    /*
    |-----------------------------------------
    | 4. Permohonan Surat
    |-----------------------------------------
    */
    Route::get('/permohonan', [AdminSuratController::class, 'permohonan'])->name('permohonan.index');
    Route::get('/permohonan/{id}', [AdminSuratController::class, 'showPermohonan'])->name('permohonan.show');
    Route::put('/permohonan/{id}/status', [AdminSuratController::class, 'updateStatusPermohonan'])->name('permohonan.update-status');
    
    // HAPUS route prosesCetak yang lama agar tidak nyampah
    // Route::get('/layanan-surat/cetak/proses/{permohonan_id}', ...
    
    // INI YANG BENAR: Cukup panggil URL dan Namanya tanpa awalan admin/layanan-surat
    Route::get('/letters/create', [\App\Http\Controllers\Admin\layanansurat\LayananSuratController::class, 'createLetter'])
        ->name('letters.create');
            
    /*
    |-----------------------------------------
    | 5. Arsip Surat
    |-----------------------------------------
    */
        Route::get('/arsip', [AdminSuratController::class, 'arsip'])->name('arsip');
        Route::delete('/arsip/{id}', [AdminSuratController::class, 'destroyArsip'])->name('arsip.destroy');

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
    | BUKU ADMINISTRASI
    |--------------------------------------------------------------------------
    */
    Route::prefix('buku-administrasi')->name('buku-administrasi.')->group(function () {
        
        // ==========================================
        // 1. ADMIN UMUM
        // ==========================================
        Route::prefix('umum')->name('umum.')->group(function () {
            
            // URL: /admin/buku-administrasi/umum
            // Memanggil BukuUmumController
            Route::get('/', [BukuUmumController::class, 'index'])->name('index'); 

            // URL: /admin/buku-administrasi/umum/peraturan-desa
            Route::get('/peraturan-desa', [PeraturanDesaController::class, 'index'])->name('peraturan-desa.index');
            
            // CRUD Peraturan Desa (Bisa dibuka komentarnya nanti)
             Route::get('/peraturan-desa/create', [PeraturanDesaController::class, 'create'])->name('peraturan-desa.create');
             Route::post('/peraturan-desa', [PeraturanDesaController::class, 'store'])->name('peraturan-desa.store');
             Route::get('/peraturan-desa/{id}/edit', [PeraturanDesaController::class, 'edit'])->name('peraturan-desa.edit');
            // Route::put('/peraturan-desa/{id}', [PeraturanDesaController::class, 'update'])->name('peraturan-desa.update');
            // Route::delete('/peraturan-desa/{id}', [PeraturanDesaController::class, 'destroy'])->name('peraturan-desa.destroy');

            // Nanti kamu bisa tambahkan buku lain di kategori UMUM di sini:
            // Route::get('/keputusan-kades', [KeputusanKadesController::class, 'index'])->name('keputusan-kades.index');
            // Route::get('/pemerintah-desa', [PemerintahDesaController::class, 'index'])->name('pemerintah-desa.index');
        });

// ==========================================
// 2. ADMIN PENDUDUK
// ==========================================
// Asumsi: Kode ini berada di dalam group prefix 'admin'
Route::prefix('penduduk')->name('penduduk.')->group(function () {
    
    // Menggunakan Controller, bukan function() langsung
    Route::get('/', [BukuPendudukController::class, 'index'])->name('index');

});

// ==========================================
// 3. ADMIN PEMBANGUNAN
// ==========================================
// Prefix: URL akan diawali '/pembangunan'
// Name: Nama route akan diawali 'pembangunan.'
Route::prefix('pembangunan')->name('pembangunan.')->group(function () {
    
    // ---------------------------------------------------------
    // Dashboard Pembangunan
    // URL: /pembangunan
    // Route Name: pembangunan.index
    // ---------------------------------------------------------
    Route::get('/', [BukuPembangunanController::class, 'index'])->name('index');

    // =========================================================
    // CRUD RENCANA PEMBANGUNAN
    // =========================================================
    
    // 1. Tampilkan Tabel (Index)
    // URL: /pembangunan/rencana
    // Route Name: pembangunan.rencana.index
    Route::get('/rencana', [RencanaPembangunanController::class, 'index'])
        ->name('rencana.index');

    // 2. Form Tambah Data (Create)
    // URL: /pembangunan/rencana/create
    // Route Name: pembangunan.rencana.create
    Route::get('/rencana/create', [RencanaPembangunanController::class, 'create'])
        ->name('rencana.create');

    // 3. Proses Simpan Data (Store)
    // URL: /pembangunan/rencana (POST)
    // Route Name: pembangunan.rencana.store
    Route::post('/rencana', [RencanaPembangunanController::class, 'store'])
        ->name('rencana.store');

    // 4. Form Edit (Edit)
    // URL: /pembangunan/rencana/{id}/edit
    // Route Name: pembangunan.rencana.edit
    Route::get('/rencana/{id}/edit', [RencanaPembangunanController::class, 'edit'])
        ->name('rencana.edit');

    // 5. Proses Update (Update)
    // URL: /pembangunan/rencana/{id} (PUT)
    // Route Name: pembangunan.rencana.update
    Route::put('/rencana/{id}', [RencanaPembangunanController::class, 'update'])
        ->name('rencana.update');

    // 6. Proses Hapus (Destroy)
    // URL: /pembangunan/rencana/{id} (DELETE)
    // Route Name: pembangunan.rencana.destroy
    Route::delete('/rencana/{id}', [RencanaPembangunanController::class, 'destroy'])
        ->name('rencana.destroy');

});

        // ==========================================
        // 4. ARSIP
        // ==========================================
        Route::prefix('arsip')->name('arsip.')->group(function () {
            Route::get('/', function () {
                return view('admin.buku.arsip.arsip'); // File: resources/views/admin/buku/arsip/arsip.blade.php
            })->name('index');
        });

    });

    /*
    |--------------------------------------------------------------------------
    | KEHADIRAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('kehadiran')->name('kehadiran.')->group(function () {

        // JAM KERJA
        Route::prefix('jam-kerja')->name('jam-kerja.')->group(function () {
            Route::get('/',                    [JamKerjaController::class, 'index'])->name('index');
            Route::post('/',                   [JamKerjaController::class, 'store'])->name('store');
            Route::put('/{jamKerja}',          [JamKerjaController::class, 'update'])->name('update');
            Route::delete('/{jamKerja}',       [JamKerjaController::class, 'destroy'])->name('destroy');
            Route::patch('/{jamKerja}/toggle', [JamKerjaController::class, 'toggleStatus'])->name('toggle');
        });

        // HARI LIBUR
        Route::prefix('hari-libur')->name('hari-libur.')->group(function () {
            Route::get('/',                 [HariLiburController::class, 'index'])->name('index');
            Route::post('/',                [HariLiburController::class, 'store'])->name('store');
            Route::put('/{hariLibur}',      [HariLiburController::class, 'update'])->name('update');
            Route::delete('/{hariLibur}',   [HariLiburController::class, 'destroy'])->name('destroy');
            Route::post('/import-nasional', [HariLiburController::class, 'importNasional'])->name('import-nasional');
            Route::get('/preview-nasional', [HariLiburController::class, 'previewNasional'])->name('preview-nasional');
            Route::post('/clear-cache',     [HariLiburController::class, 'clearCache'])->name('clear-cache');
        });

        // REKAPITULASI
        Route::prefix('rekapitulasi')->name('rekapitulasi.')->group(function () {
            Route::get('/',             [RekapitulasiController::class, 'index'])->name('index');
            Route::get('/export-pdf',   [RekapitulasiController::class, 'exportPdf'])->name('export-pdf');
            Route::get('/export-excel', [RekapitulasiController::class, 'exportExcel'])->name('export-excel');
        });

        // PENGADUAN KEHADIRAN
        Route::prefix('pengaduan-kehadiran')->name('pengaduan-kehadiran.')->group(function () {
            Route::get('/',                                  [PengaduanKehadiranController::class, 'index'])->name('index');
            Route::get('/{pengaduanKehadiran}',              [PengaduanKehadiranController::class, 'show'])->name('show');
            Route::post('/{pengaduanKehadiran}/approve',     [PengaduanKehadiranController::class, 'approve'])->name('approve');
            Route::post('/{pengaduanKehadiran}/reject',      [PengaduanKehadiranController::class, 'reject'])->name('reject');
            Route::delete('/{pengaduanKehadiran}',           [PengaduanKehadiranController::class, 'destroy'])->name('destroy');
        });

        // INPUT KEHADIRAN
        Route::prefix('input')->name('input.')->group(function () {
            Route::get('/',                     [InputKehadiranController::class, 'index'])->name('index');
            Route::post('/simpan-manual',       [InputKehadiranController::class, 'simpanManual'])->name('simpan-manual');
            Route::post('/preview-fingerprint', [InputKehadiranController::class, 'previewFingerprint'])->name('preview-fingerprint');
            Route::post('/simpan-fingerprint',  [InputKehadiranController::class, 'simpanFingerprint'])->name('simpan-fingerprint');
            Route::post('/hapus',               [InputKehadiranController::class, 'hapusKehadiran'])->name('hapus');
        });
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
        Route::get('/template', [BantuanPesertaController::class, 'downloadTemplate'])->name('template');
        Route::post('/import', [BantuanPesertaController::class, 'import'])->name('import');
        Route::get('/export/excel', [BantuanPesertaController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [BantuanPesertaController::class, 'exportPdf'])->name('export.pdf');
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
    | INFO DESA — STATUS DESA
    |--------------------------------------------------------------------------
    */
    Route::get('status-desa/export/excel', [StatusDesaController::class, 'exportExcel'])->name('status-desa.export.excel');
    Route::get('status-desa/export/pdf',   [StatusDesaController::class, 'exportPdf'])->name('status-desa.export.pdf');
    Route::resource('status-desa', StatusDesaController::class)->names('status-desa');

    /*
    |--------------------------------------------------------------------------
    | INFO DESA — LAYANAN PELANGGAN
    |--------------------------------------------------------------------------
    */
    Route::get('layanan-pelanggan/export/excel', [LayananPelangganController::class, 'exportExcel'])->name('layanan-pelanggan.export.excel');
    Route::get('layanan-pelanggan/export/pdf',   [LayananPelangganController::class, 'exportPdf'])->name('layanan-pelanggan.export.pdf');
    Route::resource('layanan-pelanggan', LayananPelangganController::class)->names('layanan-pelanggan');

    /*
    |--------------------------------------------------------------------------
    | INFO DESA — KERJASAMA
    |--------------------------------------------------------------------------
    */
    Route::get('kerjasama/export/excel', [KerjasamaController::class, 'exportExcel'])->name('kerjasama.export.excel');
    Route::get('kerjasama/export/pdf',   [KerjasamaController::class, 'exportPdf'])->name('kerjasama.export.pdf');
    Route::resource('kerjasama', KerjasamaController::class)->names('kerjasama');

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

    /*
    |--------------------------------------------------------------------------
    | PERTANAHAN - C-DESA
    |--------------------------------------------------------------------------
    */
    Route::prefix('pertanahan')->name('pertanahan.')->group(function () {
        Route::resource('c-desa', CDesaController::class)->names('c-desa');
        Route::post('c-desa/{id}/persil', [CDesaController::class, 'storePersil'])->name('c-desa.persil.store');
    });

    /*
    |--------------------------------------------------------------------------
    | HUBUNG WARGA
    |--------------------------------------------------------------------------
    */
    Route::prefix('hubung-warga')->name('hubung-warga.')->group(function () {
        Route::get('/inbox', [HubungWargaController::class, 'inbox'])->name('inbox');
        Route::get('/tulis', [HubungWargaController::class, 'create'])->name('create');
        Route::post('/kirim', [HubungWargaController::class, 'store'])->name('store');
        Route::get('/terkirim', [HubungWargaController::class, 'sent'])->name('sent');
        Route::get('/baca/{id}', [HubungWargaController::class, 'show'])->name('show');
    });
});
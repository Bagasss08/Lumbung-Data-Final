<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Admin\ChatController;

// InfoDesa
use App\Http\Controllers\Admin\InfoDesa\IdentitasDesaController;
use App\Http\Controllers\Admin\InfoDesa\WilayahController;
use App\Http\Controllers\Admin\InfoDesa\StatusDesaController;
use App\Http\Controllers\Admin\InfoDesa\LayananPelangganController;
use App\Http\Controllers\Admin\InfoDesa\KerjasamaController;
use App\Http\Controllers\InfoDesa\LembagaKategoriController;
use App\Http\Controllers\InfoDesa\LembagaDesaController;

// Kependudukan
use App\Http\Controllers\Admin\Kependudukan\PendudukController;
use App\Http\Controllers\Admin\Kependudukan\KeluargaController;
use App\Http\Controllers\Admin\Kependudukan\RumahTanggaController;
use App\Http\Controllers\Admin\Kependudukan\RumahTanggaAnggotaController;
use App\Http\Controllers\Admin\Kependudukan\KelompokController;
use App\Http\Controllers\Admin\Kependudukan\KelompokAnggotaController; // 👇 TAMBAHKAN BARIS INI
use App\Http\Controllers\Admin\Kependudukan\DataSuplemenController;
use App\Http\Controllers\Admin\Kependudukan\CalonPemilihController;

// Kehadiran
use App\Http\Controllers\Admin\Kehadiran\JamKerjaController;
use App\Http\Controllers\Admin\Kehadiran\HariLiburController;
use App\Http\Controllers\Admin\Kehadiran\RekapitulasiController;
use App\Http\Controllers\Admin\Kehadiran\PengaduanKehadiranController;
use App\Http\Controllers\Admin\Kehadiran\InputKehadiranController;

// Buku Umum / Administrasi Desa
use App\Http\Controllers\Admin\PeraturanDesaController;
use App\Http\Controllers\Admin\BukuUmumController;
use App\Http\Controllers\Admin\Buku\KeputusanController;
use App\Http\Controllers\Admin\Buku\PemerintahController;
use App\Http\Controllers\Admin\Buku\TanahKasDesaController;
use App\Http\Controllers\Admin\Buku\TanahDesaController;
use App\Http\Controllers\Admin\Buku\AgendaSuratKeluarController;
use App\Http\Controllers\Admin\Buku\AgendaSuratMasukController;
use App\Http\Controllers\Admin\Buku\EkspedisiController;
use App\Http\Controllers\Admin\Buku\LembaranDesaController;

// Buku Penduduk
use App\Http\Controllers\Admin\BukuPendudukController;
use App\Http\Controllers\Admin\BukuAdministrasi\BukuIndukPendudukController;
use App\Http\Controllers\Admin\BukuAdministrasi\BukuMutasiPendudukController;
use App\Http\Controllers\Admin\BukuAdministrasi\BukuRekapitulasiPendudukController;
use App\Http\Controllers\Admin\BukuAdministrasi\BukuPendudukSementaraController;
use App\Http\Controllers\Admin\BukuAdministrasi\KtpKkController;

// Buku Pembangunan
use App\Http\Controllers\Admin\BukuPembangunanController;
use App\Http\Controllers\Admin\RencanaPembangunanController;
use App\Http\Controllers\Admin\BukuAdministrasi\BukuRencanaKerjaPembangunanController;
use App\Http\Controllers\Admin\BukuAdministrasi\BukuActivitiesPembangunanController;
use App\Http\Controllers\Admin\BukuAdministrasi\BukuInventarisPembangunanController;
use App\Http\Controllers\Admin\BukuAdministrasi\BukuKaderPemberdayaanController;

// Buku Administrasi Arsip Desa
use App\Http\Controllers\Admin\BukuAdministrasi\ArsipDesa\ArsipDesaController;

// Sekretariat
use App\Http\Controllers\Admin\Sekretariat\SekretariatController;

// Keuangan
use App\Http\Controllers\Admin\Keuangan\KeuanganController;
use App\Http\Controllers\Admin\Keuangan\InputController;

// Layanan Surat
use App\Http\Controllers\SuratController;
use App\Http\Controllers\Admin\layanansurat\CetakController;
use App\Http\Controllers\Admin\layanansurat\CetakSuratController;
use App\Http\Controllers\Admin\layanansurat\ArsipController;
use App\Http\Controllers\Admin\layanansurat\SuratTemplateController;
use App\Http\Controllers\Admin\layanansurat\LetterController;
use App\Http\Controllers\Admin\layanansurat\PersyaratanController;

// Alias untuk Layanan Surat (Warga vs Admin)
use App\Http\Controllers\Admin\layanansurat\LayananSuratController as AdminSuratController;
use App\Http\Controllers\Warga\LayananSuratController as WargaSuratController;
use App\Http\Controllers\Warga\PesanController;

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

// Profil
use App\Http\Controllers\Admin\ProfilController;

// Layanan Mandiri
use App\Http\Controllers\Admin\LayananMandiri\PendaftarController;
use App\Http\Controllers\Admin\LayananMandiri\PengaturanController;

// PPID
use App\Http\Controllers\Admin\Ppid\PpidController;
use App\Http\Controllers\Admin\Ppid\PpidJenisController;
use App\Http\Controllers\Admin\Ppid\PermohonanInformasiController;

// Lainnya
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InfoDesaController;
use App\Http\Controllers\Admin\LembagaController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\KehadiranBulananController;
use App\Http\Controllers\Admin\KehadiranTahunanController;
use App\Http\Controllers\Admin\Pertanahan\CDesaController;
use App\Http\Controllers\Admin\HubungWargaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\Auth\AktivasiWargaController;
use App\Http\Controllers\Auth\LayananMandiriController;
use App\Http\Controllers\Admin\statistik\LaporanPendudukController;
use App\Http\Controllers\Warga\AktivitasController;
use App\Http\Controllers\Admin\WisataController;

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

Route::get('/wisata', [FrontendController::class, 'wisata'])->name('wisata');
Route::get('/wisata/{id}', [FrontendController::class, 'wisataShow'])->name('wisata.show');
Route::post('/wisata/{id}/ulasan', [FrontendController::class, 'storeUlasanWisata'])->name('wisata.ulasan.store');

Route::get('/profil', [FrontendController::class, 'profil'])->name('profil');
Route::get('/data-desa', [FrontendController::class, 'dataDesa'])->name('data-desa');
Route::get('/identitas-desa', [FrontendController::class, 'profil'])->name('identitas-desa');
Route::get('/demografi', [FrontendController::class, 'dataDesa'])->name('demografi');
Route::get('/apbd', [FrontendController::class, 'apbd'])->name('apbd');

Route::get('/artikel', [FrontendController::class, 'berita'])->name('artikel');
Route::get('/artikel/{id}', [FrontendController::class, 'artikelShow'])->name('artikel.show');
Route::post('/artikel/{id}/komentar', [FrontendController::class, 'storeKomentar'])->name('artikel.komentar.store');

Route::get('/wilayah', [FrontendController::class, 'wilayah'])->name('wilayah');
Route::get('/wilayah/{id}', [FrontendController::class, 'wilayahShow'])->name('wilayah.show');

Route::get('/profil/kepala-desa', [FrontendController::class, 'profilKepalaDesa'])->name('profil-kepala-desa');
Route::get('/bpd', [FrontendController::class, 'bpd'])->name('bpd');
Route::get('/kemasyarakatan', [FrontendController::class, 'kemasyarakatan'])->name('kemasyarakatan');

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
Route::post('/lapak/{id}/ulasan', [FrontendController::class, 'storeUlasan'])
    ->name('ulasan.store');

Route::get('/pembangunan/{pembangunan}', [FrontendController::class, 'pembangunanShow'])->name('pembangunan.show');

Route::get('/peta-situs', function () {
    return view('frontend.pages.peta-situs.index');
})->name('peta-situs');

/*
|--------------------------------------------------------------------------
| AUTH & GUEST ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);

// Route Form Lupa Password (yang sebelumnya)
Route::get('/lupa-password', [AuthController::class, 'showLupaPassword'])->name('password.request'); // Ganti name jadi password.request (standar Laravel)
Route::post('/lupa-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/fix-email', function () {
    return [
        'mailer' => config('mail.default'),
        'host' => config('mail.mailers.smtp.host'),
        'username' => config('mail.mailers.smtp.username'),
        'password' => config('mail.mailers.smtp.password') ? 'ADA' : 'KOSONG',
    ];
});
// --- TAMBAHKAN ROUTE INI ---
// Route Form Reset Password (saat link diklik)
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
// Route Proses Simpan Password Baru
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('/setup', [SetupController::class, 'showSetup'])->name('setup')->middleware('check.setup');
Route::post('/setup', [SetupController::class, 'register'])->name('setup.register');

// GET layanan mandiri dikeluarkan dari middleware guest
Route::get('/layanan-mandiri', [LayananMandiriController::class, 'showLoginForm'])
    ->name('layanan-mandiri');

Route::post('/layanan-mandiri/masuk', [LayananMandiriController::class, 'login'])
    ->name('layanan-mandiri.login');

Route::get('/layanan-mandiri/masuk-ektp', [LayananMandiriController::class, 'showMasukEktp'])
    ->name('layanan-mandiri.masuk-ektp');

Route::post('/layanan-mandiri/masuk-ektp', [LayananMandiriController::class, 'prosesMasukEktp'])
    ->name('layanan-mandiri.masuk-ektp.proses');

Route::middleware('guest')->group(function () {
    Route::get('/layanan-mandiri/aktivasi', [AktivasiWargaController::class, 'showCheckForm'])->name('aktivasi.index');
    Route::post('/layanan-mandiri/cek', [AktivasiWargaController::class, 'check'])->name('aktivasi.check');
    Route::post('/layanan-mandiri/daftar', [AktivasiWargaController::class, 'register'])->name('aktivasi.store');
    Route::get('/layanan-mandiri/cek', [AktivasiWargaController::class, 'showCheckForm']);
});

// Logout di luar guest (boleh akses saat sudah login)
Route::post('/layanan-mandiri/keluar', [LayananMandiriController::class, 'logout'])
    ->name('layanan-mandiri.logout');

/*
|--------------------------------------------------------------------------
| WARGA ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('warga')->name('warga.')->middleware(['auth', 'role:warga'])->group(function () {

    // ── NOTIFIKASI WARGA — endpoint polling ──────────────────────────────
    Route::get('/notifikasi/badges', function () {
        $user = Auth::user();
        $unreadPesan = \App\Models\Pesan::where('penerima_id', $user->id)->where('sudah_dibaca', false)->count();

        $updateSurat = 0;
        if ($user->penduduk_id) {
            $totalSurat = \App\Models\SuratPermohonan::where('penduduk_id', $user->penduduk_id)
                ->whereNotIn('status', ['menunggu', 'diajukan'])
                ->count();

            $readSurat = DB::table('notifikasi_dibaca')
                ->where('user_id', $user->id)
                ->where('notif_type', 'surat')
                ->whereIn('notif_id', \App\Models\SuratPermohonan::where('penduduk_id', $user->penduduk_id)
                    ->whereNotIn('status', ['menunggu', 'diajukan'])
                    ->pluck('id'))
                ->count();

            $updateSurat = $totalSurat - $readSurat;
        }

        return response()->json([
            'unread_pesan' => $unreadPesan,
            'update_surat' => $updateSurat,
            'total'        => $unreadPesan + $updateSurat,
        ]);
    })->name('notifikasi.badges');

    Route::post('/notifikasi/surat-dibaca', function () {
        $user = Auth::user();
        if ($user->penduduk_id) {
            $suratIds = \App\Models\SuratPermohonan::where('penduduk_id', $user->penduduk_id)
                ->whereNotIn('status', ['menunggu', 'diajukan'])
                ->where('notif_dibaca', false)
                ->pluck('id');

            foreach ($suratIds as $id) {
                DB::table('notifikasi_dibaca')->updateOrInsert(
                    [
                        'user_id'    => $user->id,
                        'notif_type' => 'surat',
                        'notif_id'   => $id,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            \App\Models\SuratPermohonan::where('penduduk_id', $user->penduduk_id)
                ->whereNotIn('status', ['menunggu', 'diajukan'])
                ->where('notif_dibaca', false)
                ->update(['notif_dibaca' => true]);
        }
        return response()->json(['ok' => true]);
    })->name('notifikasi.surat-dibaca');

    Route::get('/notifikasi/list', function () {
        try {
            $user = Auth::user();
            $items = [];

            $readPesan = DB::table('notifikasi_dibaca')
                ->where('user_id', $user->id)
                ->where('notif_type', 'pesan')
                ->pluck('notif_id')
                ->toArray();

            $dismissedPesan = DB::table('notifikasi_dismissed')
                ->where('user_id', $user->id)
                ->where('notif_type', 'pesan')
                ->pluck('notif_id')
                ->toArray();

            $pesan = \App\Models\Pesan::where('penerima_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($pesan as $p) {
                if (in_array($p->id, $dismissedPesan)) continue;
                $items[] = [
                    'id'        => 'pesan-' . $p->id,
                    'type'      => 'pesan',
                    'title'     => 'Pesan Masuk',
                    'message'   => \Illuminate\Support\Str::limit($p->isi ?? 'Pesan baru', 60),
                    'url'       => '#',
                    'is_read'   => (bool)$p->sudah_dibaca,
                    'time'      => $p->created_at->diffForHumans(),
                    'timestamp' => $p->created_at->timestamp,
                ];
            }

            if ($user->penduduk_id) {
                $readSurat = DB::table('notifikasi_dibaca')
                    ->where('user_id', $user->id)
                    ->where('notif_type', 'surat')
                    ->pluck('notif_id')
                    ->toArray();

                $dismissedSurat = DB::table('notifikasi_dismissed')
                    ->where('user_id', $user->id)
                    ->where('notif_type', 'surat')
                    ->pluck('notif_id')
                    ->toArray();

                $surat = \App\Models\SuratPermohonan::where('penduduk_id', $user->penduduk_id)
                    ->whereNotIn('status', ['menunggu', 'diajukan'])
                    ->orderBy('updated_at', 'desc')
                    ->get();

                foreach ($surat as $s) {
                    if (in_array($s->id, $dismissedSurat)) continue;

                    $items[] = [
                        'id'        => 'surat-' . $s->id,
                        'type'      => 'surat',
                        'title'     => 'Surat Permohonan',
                        'message'   => 'Status: ' . $s->status,
                        'url'       => '#',
                        'is_read'   => in_array($s->id, $readSurat),
                        'time'      => $s->updated_at->diffForHumans(),
                        'timestamp' => $s->updated_at->timestamp,
                    ];
                }
            }

            usort($items, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);
            return response()->json(['items' => $items]);
        } catch (\Exception $e) {
            \Log::error('Notifikasi list error: ' . $e->getMessage());
            return response()->json(['items' => []], 200);
        }
    })->name('notifikasi.list');

    Route::post('/notifikasi/tandai-semua', function () {
        $user = Auth::user();

        \App\Models\Pesan::where('penerima_id', $user->id)
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);

        if ($user->penduduk_id) {
            $suratIds = \App\Models\SuratPermohonan::where('penduduk_id', $user->penduduk_id)
                ->whereNotIn('status', ['menunggu', 'diajukan'])
                ->pluck('id');

            foreach ($suratIds as $id) {
                DB::table('notifikasi_dibaca')->updateOrInsert(
                    ['user_id' => $user->id, 'notif_type' => 'surat', 'notif_id' => $id],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }

        return response()->json(['ok' => true]);
    })->name('notifikasi.tandai-semua');

    Route::delete('/notifikasi/hapus-banyak', function (\Illuminate\Http\Request $request) {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['ok' => false], 422);
        }

        $user = Auth::user();
        foreach ($ids as $id) {
            $parts = explode('-', $id, 2);
            $type  = $parts[0] ?? '';
            $rawId = $parts[1] ?? null;

            if (!$rawId || !is_numeric($rawId)) continue;
            $rawId = (int)$rawId;

            if ($type === 'pesan') {
                \App\Models\Pesan::where('id', $rawId)
                    ->where('penerima_id', $user->id)
                    ->delete();
            } elseif ($type === 'surat') {
                DB::table('notifikasi_dismissed')->updateOrInsert(
                    ['user_id' => $user->id, 'notif_type' => 'surat', 'notif_id' => $rawId],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }

        return response()->json(['ok' => true]);
    })->name('notifikasi.hapus-banyak');

    Route::post('/notifikasi/baca-satu', function (\Illuminate\Http\Request $request) {
        $parts  = explode('-', $request->input('id'), 2);
        $prefix = $parts[0] ?? '';
        $rawId  = $parts[1] ?? null;

        if ($prefix === 'pesan' && $rawId) {
            \App\Models\Pesan::where('id', (int)$rawId)
                ->where('penerima_id', Auth::id())
                ->update(['sudah_dibaca' => true]);
        } elseif ($prefix === 'surat' && $rawId) {
            DB::table('notifikasi_dibaca')->updateOrInsert(
                [
                    'user_id'    => Auth::id(),
                    'notif_type' => 'surat',
                    'notif_id'   => (int) $rawId,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        return response()->json(['ok' => true]);
    })->name('notifikasi.baca-satu');

    Route::get('/notifikasi', function () {
        return view('warga.notifikasi.index');
    })->name('notifikasi.index');

    Route::delete('/notifikasi/hapus-satu', function (\Illuminate\Http\Request $request) {
        $id   = $request->input('id');
        $tipe = $request->input('tipe');

        if (!$id || !$tipe) {
            return response()->json(['status' => 'error'], 422);
        }

        $user   = Auth::user();
        $parts  = explode('-', $id, 2);
        $prefix = $parts[0] ?? '';
        $rawId  = $parts[1] ?? null;

        if (!$rawId || !is_numeric($rawId)) {
            return response()->json(['status' => 'error', 'message' => 'ID tidak valid'], 422);
        }

        if ($prefix === 'pesan') {
            \App\Models\Pesan::where('id', (int) $rawId)
                ->where('penerima_id', $user->id)
                ->delete();
        } elseif ($prefix === 'surat') {
            DB::table('notifikasi_dismissed')->updateOrInsert(
                [
                    'user_id'    => $user->id,
                    'notif_type' => 'surat',
                    'notif_id'   => (int) $rawId,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        return response()->json(['status' => 'ok']);
    })->name('notifikasi.hapus-satu');

    Route::get('/dashboard', function () {
        return view('warga.dashboard');
    })->name('dashboard');

    // ✅ DIPERBAIKI — hapus /warga/ prefix, name, dan middleware yang dobel
    Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas');

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

    Route::get('/pengumuman/fetch', [\App\Http\Controllers\Admin\ChatController::class, 'fetchPengumuman'])->name('chat.pengumuman.fetch');
    Route::post('/pengumuman/send', [\App\Http\Controllers\Admin\ChatController::class, 'sendPengumuman'])->name('chat.pengumuman.send');
    Route::get('/chat/messages', [ChatController::class, 'fetchMessages'])->name('chat.fetch');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD & REDIRECTS
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pembangunan', function () {
        return redirect()->route('admin.pembangunan-utama.index');
    })->name('pembangunan');

    /*
    |--------------------------------------------------------------------------
    | PROFIL ADMIN
    |--------------------------------------------------------------------------
    */
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
    Route::post('/profil/send-otp', [ProfilController::class, 'sendOtp'])->name('profil.send-otp');
    Route::post('/profil/verify-otp', [ProfilController::class, 'verifyOtp'])->name('profil.verify-otp');

    /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI
    |--------------------------------------------------------------------------
    */
    Route::get('/notifikasi/list', function () {
        $userId = Auth::id();

        $readKomentar   = DB::table('notifikasi_dibaca')
            ->where('user_id', $userId)->where('notif_type', 'komentar')
            ->pluck('notif_id')->toArray();

        $readPermohonan = DB::table('notifikasi_dibaca')
            ->where('user_id', $userId)->where('notif_type', 'permohonan')
            ->pluck('notif_id')->toArray();

        // ★ Filter dismissed
        $dismissedKomentar   = DB::table('notifikasi_dismissed')
            ->where('user_id', $userId)->where('notif_type', 'komentar')
            ->pluck('notif_id')->toArray();

        $dismissedPermohonan = DB::table('notifikasi_dismissed')
            ->where('user_id', $userId)->where('notif_type', 'permohonan')
            ->pluck('notif_id')->toArray();

        $items = [];

        if (class_exists(\App\Models\KomentarArtikel::class)) {
            $query = \App\Models\KomentarArtikel::where('status', 'pending')
                ->orderByDesc('created_at')->limit(5);
            if (!empty($dismissedKomentar)) {
                $query->whereNotIn('id', $dismissedKomentar);
            }
            $komentarList = $query->get();
            foreach ($komentarList as $k) {
                $items[] = [
                    'id'      => 'komentar-' . $k->id,
                    'type'    => 'komentar',
                    'title'   => 'Komentar Menunggu',
                    'message' => \Illuminate\Support\Str::limit($k->isi ?? 'Komentar baru menunggu persetujuan', 60),
                    'url'     => route('admin.komentar.index'),
                    'is_read' => in_array($k->id, $readKomentar), // ← dari DB
                    'time'    => $k->created_at->diffForHumans(),
                ];
            }
        }

        if (class_exists(\App\Models\Pesan::class)) {
            $dismissedPesan = DB::table('notifikasi_dismissed')
                ->where('user_id', $userId)->where('notif_type', 'pesan')
                ->pluck('notif_id')->toArray();

            $pesanQuery = \App\Models\Pesan::where('penerima_id', $userId)
                ->orderByDesc('created_at')->limit(5);
            if (!empty($dismissedPesan)) {
                $pesanQuery->whereNotIn('id', $dismissedPesan);
            }
            foreach ($pesanQuery->get() as $p) {
                $items[] = [
                    'id'      => 'pesan-' . $p->id,
                    'type'    => 'pesan',
                    'title'   => 'Pesan Masuk',
                    'message' => \Illuminate\Support\Str::limit($p->isi ?? $p->subjek ?? 'Pesan baru', 60),
                    'url'     => route('admin.hubung-warga.inbox'),
                    'is_read' => (bool) $p->sudah_dibaca, // ← dari kolom DB
                    'time'    => $p->created_at->diffForHumans(),
                ];
            }
        }

        if (class_exists(\App\Models\SuratPermohonan::class)) {
            $query = \App\Models\SuratPermohonan::whereIn('status', [
                'sedang diperiksa',
                'menunggu',
                'menunggu tandatangan',
                'belum lengkap'
            ])->orderByDesc('created_at')->limit(5);
            if (!empty($dismissedPermohonan)) {
                $query->whereNotIn('id', $dismissedPermohonan);
            }
            foreach ($query->get() as $s) {
                $items[] = [
                    'id'      => 'permohonan-' . $s->id,
                    'type'    => 'permohonan',
                    'title'   => 'Permohonan Surat',
                    'message' => 'Permohonan ' . ($s->jenisSurat->nama_surat ?? 'surat') . ' menunggu persetujuan',
                    'url'     => '/admin/layanan-surat/permohonan/' . $s->id,
                    'is_read' => in_array($s->id, $readPermohonan), // ← dari DB
                    'time'    => $s->created_at->diffForHumans(),
                ];
            }
        }

        usort($items, fn($a, $b) => strcmp($b['time'], $a['time']));
        $totalUnread = count(array_filter($items, fn($i) => !$i['is_read']));

        return response()->json([
            'items'        => array_slice($items, 0, 10),
            'total_unread' => $totalUnread,
        ]);
    })->name('notifikasi.list');

    Route::get('/notifikasi/semua', function () {
        $userId = Auth::id();

        // ID yang sudah dibaca
        $readKomentar   = DB::table('notifikasi_dibaca')
            ->where('user_id', $userId)->where('notif_type', 'komentar')
            ->pluck('notif_id')->toArray();

        $readPermohonan = DB::table('notifikasi_dibaca')
            ->where('user_id', $userId)->where('notif_type', 'permohonan')
            ->pluck('notif_id')->toArray();

        // ★ ID yang sudah di-dismiss (hapus dari halaman notifikasi)
        $dismissedKomentar   = DB::table('notifikasi_dismissed')
            ->where('user_id', $userId)->where('notif_type', 'komentar')
            ->pluck('notif_id')->toArray();

        $dismissedPermohonan = DB::table('notifikasi_dismissed')
            ->where('user_id', $userId)->where('notif_type', 'permohonan')
            ->pluck('notif_id')->toArray();

        $dismissedPesan = DB::table('notifikasi_dismissed')
            ->where('user_id', $userId)->where('notif_type', 'pesan')
            ->pluck('notif_id')->toArray();

        $items = [];

        // Komentar pending — kecuali yang sudah di-dismiss
        if (class_exists(\App\Models\KomentarArtikel::class)) {
            $query = \App\Models\KomentarArtikel::where('status', 'pending')
                ->orderByDesc('created_at');

            if (!empty($dismissedKomentar)) {
                $query->whereNotIn('id', $dismissedKomentar);
            }

            foreach ($query->get() as $k) {
                $items[] = [
                    'id'      => 'komentar-' . $k->id,
                    'type'    => 'komentar',
                    'title'   => 'Komentar Menunggu',
                    'message' => \Illuminate\Support\Str::limit($k->isi ?? 'Komentar baru menunggu persetujuan', 60),
                    'url'     => route('admin.komentar.index'),
                    'is_read' => in_array($k->id, $readKomentar),
                    'time'    => $k->created_at->diffForHumans(),
                ];
            }
        }

        // Pesan — kecuali yang sudah di-dismiss (yang sudah dihapus pesan-nya sudah benar-benar dihapus)
        if (class_exists(\App\Models\Pesan::class)) {
            $query = \App\Models\Pesan::where('penerima_id', $userId)
                ->orderByDesc('created_at');

            if (!empty($dismissedPesan)) {
                $query->whereNotIn('id', $dismissedPesan);
            }

            foreach ($query->get() as $p) {
                $items[] = [
                    'id'      => 'pesan-' . $p->id,
                    'type'    => 'pesan',
                    'title'   => 'Pesan Masuk',
                    'message' => \Illuminate\Support\Str::limit($p->isi ?? $p->subjek ?? 'Pesan baru', 60),
                    'url'     => route('admin.hubung-warga.inbox'),
                    'is_read' => (bool) $p->sudah_dibaca,
                    'time'    => $p->created_at->diffForHumans(),
                ];
            }
        }

        // Permohonan surat — kecuali yang sudah di-dismiss
        if (class_exists(\App\Models\SuratPermohonan::class)) {
            $query = \App\Models\SuratPermohonan::whereIn('status', [
                'sedang diperiksa',
                'menunggu',
                'menunggu tandatangan',
                'belum lengkap'
            ])->orderByDesc('created_at');

            if (!empty($dismissedPermohonan)) {
                $query->whereNotIn('id', $dismissedPermohonan);
            }

            foreach ($query->get() as $s) {
                $items[] = [
                    'id'      => 'permohonan-' . $s->id,
                    'type'    => 'permohonan',
                    'title'   => 'Permohonan Surat',
                    'message' => 'Permohonan ' . ($s->jenisSurat->nama_surat ?? 'surat') . ' menunggu persetujuan',
                    'url'     => '/admin/layanan-surat/permohonan/' . $s->id,
                    'is_read' => in_array($s->id, $readPermohonan),
                    'time'    => $s->created_at->diffForHumans(),
                ];
            }
        }

        usort($items, fn($a, $b) => strcmp($b['time'], $a['time']));

        return response()->json(['items' => $items]);
    })->name('notifikasi.semua');

    Route::post('/notifikasi/tandai-semua', function () {
        $userId = Auth::id();

        // Tandai semua pesan sebagai dibaca
        if (class_exists(\App\Models\Pesan::class)) {
            \App\Models\Pesan::where('penerima_id', $userId)
                ->where('sudah_dibaca', false)
                ->update(['sudah_dibaca' => true]);
        }

        // Tandai semua komentar pending sebagai dibaca
        if (class_exists(\App\Models\KomentarArtikel::class)) {
            $komentarIds = \App\Models\KomentarArtikel::where('status', 'pending')->pluck('id');
            foreach ($komentarIds as $kid) {
                DB::table('notifikasi_dibaca')->updateOrInsert(
                    ['user_id' => $userId, 'notif_type' => 'komentar', 'notif_id' => $kid],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }

        // Tandai semua permohonan pending sebagai dibaca
        if (class_exists(\App\Models\SuratPermohonan::class)) {
            $permohonanIds = \App\Models\SuratPermohonan::whereIn('status', [
                'sedang diperiksa',
                'menunggu',
                'menunggu tandatangan',
                'belum lengkap'
            ])->pluck('id');

            foreach ($permohonanIds as $pid) {
                DB::table('notifikasi_dibaca')->updateOrInsert(
                    ['user_id' => $userId, 'notif_type' => 'permohonan', 'notif_id' => $pid],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }

        return response()->json(['ok' => true]);
    })->name('notifikasi.tandai-semua');

    // ✅ YANG BENAR — simpan ke DB
    Route::post('/notifikasi/baca-satu', function (\Illuminate\Http\Request $request) {
        $parts  = explode('-', $request->input('id'), 2);
        $prefix = $parts[0] ?? '';
        $rawId  = $parts[1] ?? null;

        if ($prefix === 'pesan' && $rawId) {
            \App\Models\Pesan::where('id', (int)$rawId)
                ->where('penerima_id', Auth::id())
                ->update(['sudah_dibaca' => true]);
        } elseif (in_array($prefix, ['komentar', 'permohonan']) && $rawId) {
            DB::table('notifikasi_dibaca')->updateOrInsert(
                ['user_id' => Auth::id(), 'notif_type' => $prefix, 'notif_id' => (int)$rawId],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        return response()->json(['ok' => true]);
    })->name('notifikasi.baca-satu');
    Route::delete('/notifikasi/hapus-satu', function (\Illuminate\Http\Request $request) {
        $id   = $request->input('id');
        $tipe = $request->input('type'); // frontend kirim type juga

        $parts  = explode('-', $id, 2);
        $prefix = $parts[0] ?? '';
        $rawId  = $parts[1] ?? null;

        if (!$rawId || !is_numeric($rawId)) {
            return response()->json(['status' => 'error', 'message' => 'ID tidak valid'], 422);
        }

        $userId = Auth::id();

        if (in_array($prefix, ['pesan', 'komentar', 'permohonan'])) {
            // Komentar & Permohonan: tidak bisa dihapus dari sumbernya,
            // simpan ke notifikasi_dismissed supaya tidak muncul lagi
            DB::table('notifikasi_dismissed')->updateOrInsert(
                [
                    'user_id'    => $userId,
                    'notif_type' => $prefix,
                    'notif_id'   => (int) $rawId,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Tandai juga sebagai dibaca sekalian
            DB::table('notifikasi_dibaca')->updateOrInsert(
                [
                    'user_id'    => $userId,
                    'notif_type' => $prefix,
                    'notif_id'   => (int) $rawId,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        return response()->json(['status' => 'ok']);
    })->name('notifikasi.hapus-satu');

    Route::get('/notifikasi', function () {
        return view('admin.notifikasi.index');
    })->name('notifikasi.index');

    Route::get('/notifikasi/badges', function () {
        $userId = Auth::id();

        $readKomentar = DB::table('notifikasi_dibaca')
            ->where('user_id', $userId)->where('notif_type', 'komentar')
            ->pluck('notif_id')->toArray();

        $readPermohonan = DB::table('notifikasi_dibaca')
            ->where('user_id', $userId)->where('notif_type', 'permohonan')
            ->pluck('notif_id')->toArray();

        $pendingKomentar = class_exists(\App\Models\KomentarArtikel::class)
            ? \App\Models\KomentarArtikel::where('status', 'pending')
            ->whereNotIn('id', $readKomentar)
            ->count()
            : 0;

        $dismissedPesanBadge = DB::table('notifikasi_dismissed')
            ->where('user_id', $userId)->where('notif_type', 'pesan')
            ->pluck('notif_id')->toArray();

        $unreadPesan = class_exists(\App\Models\Pesan::class)
            ? \App\Models\Pesan::where('penerima_id', $userId)
            ->where('sudah_dibaca', false)
            ->when(!empty($dismissedPesanBadge), fn($q) => $q->whereNotIn('id', $dismissedPesanBadge))
            ->count()
            : 0;

        $pendingPermohonan = class_exists(\App\Models\SuratPermohonan::class)
            ? \App\Models\SuratPermohonan::whereIn('status', [
                'sedang diperiksa',
                'menunggu',
                'menunggu tandatangan',
                'belum lengkap'
            ])->whereNotIn('id', $readPermohonan)->count()
            : 0;

        return response()->json([
            'pending_komentar'   => $pendingKomentar,
            'unread_pesan'       => $unreadPesan,
            'pending_permohonan' => $pendingPermohonan,
        ]);
    })->name('notifikasi.badges');

    /*
    |--------------------------------------------------------------------------
    | STATISTIK
    |--------------------------------------------------------------------------
    */
    Route::get('/statistik/kependudukan', [\App\Http\Controllers\Admin\statistik\StatistikController::class, 'kependudukan'])->name('statistik.kependudukan');
    Route::get('/statistik/kelompok-rentan', [\App\Http\Controllers\Admin\statistik\StatistikController::class, 'kelompokRentan'])->name('statistik.kelompok-rentan');
    Route::get('/statistik/laporan-bulanan', [App\Http\Controllers\Admin\statistik\StatistikController::class, 'laporanBulanan'])->name('statistik.laporan-bulanan');

    Route::get('/statistik/penduduk',               [LaporanPendudukController::class, 'index'])->name('statistik.penduduk');
    Route::post('/statistik/penduduk',               [LaporanPendudukController::class, 'store'])->name('statistik.penduduk.store');
    Route::put('/statistik/penduduk/{id}',          [LaporanPendudukController::class, 'update'])->name('statistik.penduduk.update');
    Route::delete('/statistik/penduduk/{id}',        [LaporanPendudukController::class, 'destroy'])->name('statistik.penduduk.destroy');
    Route::delete('/statistik/penduduk-bulk-destroy', [LaporanPendudukController::class, 'bulkDestroy'])->name('statistik.penduduk.bulk-destroy');

    /*
    |--------------------------------------------------------------------------
    | INFO DESA - LEMBAGA
    |--------------------------------------------------------------------------
    */
    Route::resource('lembaga', LembagaController::class);

    Route::prefix('info-desa')->group(function () {
        Route::resource('lembaga-kategori', LembagaKategoriController::class);
        Route::delete('lembaga-kategori/bulk-destroy', [LembagaKategoriController::class, 'destroy'])->name('lembaga-kategori.bulk-destroy');

        Route::get('lembaga-desa/cetak', [LembagaDesaController::class, 'cetak'])->name('lembaga-desa.cetak');
        Route::get('lembaga-desa/unduh', [LembagaDesaController::class, 'unduh'])->name('lembaga-desa.unduh');

        Route::resource('lembaga-desa', LembagaDesaController::class);
        Route::delete('lembaga-desa/bulk-destroy', [LembagaDesaController::class, 'destroy'])->name('lembaga-desa.bulk-destroy');

        Route::prefix('lembaga-desa/{lembaga}/dokumen')->name('lembaga-desa.dokumen.')->group(function () {
            Route::get('/',                 [\App\Http\Controllers\InfoDesa\lembagaDokumenController::class, 'index'])->name('index');
            Route::get('/create',            [\App\Http\Controllers\InfoDesa\lembagaDokumenController::class, 'create'])->name('create');
            Route::post('/',                 [\App\Http\Controllers\InfoDesa\lembagaDokumenController::class, 'store'])->name('store');
            Route::get('/{dokumen}/edit',    [\App\Http\Controllers\InfoDesa\lembagaDokumenController::class, 'edit'])->name('edit');
            Route::put('/{dokumen}',         [\App\Http\Controllers\InfoDesa\lembagaDokumenController::class, 'update'])->name('update');
            Route::delete('/{dokumen}',      [\App\Http\Controllers\InfoDesa\lembagaDokumenController::class, 'destroy'])->name('destroy');
            Route::delete('/',               [\App\Http\Controllers\InfoDesa\lembagaDokumenController::class, 'bulkDestroy'])->name('bulk-destroy');
            Route::get('/{dokumen}/download', [\App\Http\Controllers\InfoDesa\lembagaDokumenController::class, 'download'])->name('download');
        });

        Route::prefix('lembaga-desa/{lembaga}/anggota')->name('lembaga-desa.anggota.')->group(function () {
            Route::get('/', [\App\Http\Controllers\InfoDesa\LembagaAnggotaController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\InfoDesa\LembagaAnggotaController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\InfoDesa\LembagaAnggotaController::class, 'store'])->name('store');
            Route::get('/{anggota}/edit', [\App\Http\Controllers\InfoDesa\LembagaAnggotaController::class, 'edit'])->name('edit');
            Route::put('/{anggota}', [\App\Http\Controllers\InfoDesa\LembagaAnggotaController::class, 'update'])->name('update');
            Route::delete('/{anggota}', [\App\Http\Controllers\InfoDesa\LembagaAnggotaController::class, 'destroy'])->name('destroy');
            Route::delete('/', [\App\Http\Controllers\InfoDesa\LembagaAnggotaController::class, 'bulkDestroy'])->name('bulk-destroy');
            Route::get('/cetak', [\App\Http\Controllers\InfoDesa\LembagaAnggotaController::class, 'cetak'])->name('cetak');
            Route::get('/unduh', [\App\Http\Controllers\InfoDesa\LembagaAnggotaController::class, 'unduh'])->name('unduh');

            if (file_exists(__DIR__ . '/web-lembaga-anggota.php')) {
                require __DIR__ . '/web-lembaga-anggota.php';
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | KEPENDUDUKAN — PENDUDUK
    |--------------------------------------------------------------------------
    */
    Route::get('/penduduk', [PendudukController::class, 'index'])->name('penduduk');
    Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
    Route::post('/penduduk', [PendudukController::class, 'store'])->name('penduduk.store');
    Route::post('/penduduk/import', [PendudukController::class, 'import'])->name('penduduk.import');
    Route::post('/penduduk/import-bip', [PendudukController::class, 'importBip'])->name('penduduk.import-bip');
    Route::get('/penduduk/template', [PendudukController::class, 'downloadTemplate'])->name('penduduk.template');
    Route::get('/penduduk/export/excel', [PendudukController::class, 'exportExcel'])->name('penduduk.export.excel');
    Route::get('/penduduk/export/huruf', [PendudukController::class, 'exportExcel'])->name('penduduk.export.huruf');
    Route::get('/penduduk/export/pdf', [PendudukController::class, 'exportPdf'])->name('penduduk.export.pdf');

    Route::delete('/penduduk/bulk-destroy', [PendudukController::class, 'bulkDestroy'])->name('penduduk.bulk-destroy');
    Route::get('/penduduk/cetak-data', [PendudukController::class, 'cetakData'])->name('penduduk.cetak-data');

    Route::get('/penduduk/{penduduk}', [PendudukController::class, 'show'])->name('penduduk.show');
    Route::get('/penduduk/{penduduk}/cetak-biodata', [PendudukController::class, 'cetakBiodata'])
        ->name('penduduk.cetak-biodata');
    Route::get('/penduduk/{penduduk}/edit', [PendudukController::class, 'edit'])->name('penduduk.edit');
    Route::put('/penduduk/{penduduk}', [PendudukController::class, 'update'])->name('penduduk.update');
    Route::get('/penduduk/{penduduk}/delete', [PendudukController::class, 'confirmDestroy'])->name('penduduk.confirm-destroy');
    Route::delete('/penduduk/{penduduk}', [PendudukController::class, 'destroy'])->name('penduduk.destroy');
    Route::patch('/penduduk/{penduduk}/ubah-status-dasar', [PendudukController::class, 'ubahStatusDasar'])->name('penduduk.ubah-status-dasar');

    Route::get('/penduduk/{penduduk}/lokasi',                    [PendudukController::class, 'lokasi'])->name('penduduk.lokasi');
    Route::post('/penduduk/{penduduk}/lokasi',                   [PendudukController::class, 'lokasiStore'])->name('penduduk.lokasi.store');
    Route::get('/penduduk/{penduduk}/dokumen',                   [PendudukController::class, 'dokumen'])->name('penduduk.dokumen');
    Route::post('/penduduk/{penduduk}/dokumen',                  [PendudukController::class, 'dokumenStore'])->name('penduduk.dokumen.store');
    Route::patch('/penduduk/{penduduk}/dokumen/{dokumenId}',     [PendudukController::class, 'dokumenUpdate'])->name('penduduk.dokumen.update');
    Route::delete('/penduduk/{penduduk}/dokumen/{dokumenId}',    [PendudukController::class, 'dokumenDestroy'])->name('penduduk.dokumen.destroy');
    Route::delete('/penduduk/{penduduk}/dokumen',                [PendudukController::class, 'dokumenBulkDestroy'])->name('penduduk.dokumen.bulk-destroy');

    /*
|--------------------------------------------------------------------------
| KEPENDUDUKAN — KELUARGA
|--------------------------------------------------------------------------
*/
    Route::get('/keluarga',               [KeluargaController::class, 'index'])->name('keluarga');
    Route::get('/keluarga/export/excel',  [KeluargaController::class, 'exportExcel'])->name('keluarga.export.excel');
    Route::get('/keluarga/export/pdf',    [KeluargaController::class, 'exportPdf'])->name('keluarga.export.pdf');

    Route::get('/keluarga/create/masuk',          [KeluargaController::class, 'createMasuk'])->name('keluarga.create.masuk');
    Route::post('/keluarga/create/masuk',         [KeluargaController::class, 'storeMasuk'])->name('keluarga.store.masuk');
    Route::get('/keluarga/create/dari-penduduk',  [KeluargaController::class, 'createDariPenduduk'])->name('keluarga.create.dari-penduduk');
    Route::post('/keluarga/create/dari-penduduk', [KeluargaController::class, 'storeDariPenduduk'])->name('keluarga.store.dari-penduduk');

    Route::delete('/keluarga/bulk-destroy',               [KeluargaController::class, 'bulkDestroy'])->name('keluarga.bulk-destroy');
    Route::post('/keluarga/pindah-wilayah-kolektif',      [KeluargaController::class, 'pindahWilayahKolektif'])->name('keluarga.pindah-wilayah-kolektif');
    Route::post('/keluarga/tambah-rumah-tangga-kolektif', [KeluargaController::class, 'tambahRumahTanggaKolektif'])->name('keluarga.tambah-rumah-tangga-kolektif');

    Route::get('/keluarga/{keluarga}',           [KeluargaController::class, 'show'])->name('keluarga.show');
    Route::get('/keluarga/{keluarga}/edit',      [KeluargaController::class, 'edit'])->name('keluarga.edit');
    Route::put('/keluarga/{keluarga}',           [KeluargaController::class, 'update'])->name('keluarga.update');
    Route::delete('/keluarga/{keluarga}',        [KeluargaController::class, 'destroy'])->name('keluarga.destroy');

    // ── Cetak Kartu Keluarga (PDF) ─────────────────────────────────────────────
    Route::get('/keluarga/{keluarga}/cetak-kk',  [KeluargaController::class, 'cetakKk'])->name('keluarga.cetak-kk');
    Route::get('/keluarga/{keluarga}/lihat-kk',  [KeluargaController::class, 'lihatKk'])->name('keluarga.lihat-kk'); // tambah ini

    // ── Tambah Anggota ─────────────────────────────────────────────────────────
    Route::get('/keluarga/{keluarga}/anggota/create', [KeluargaController::class, 'createAnggota'])->name('keluarga.anggota.create');
    Route::post('/keluarga/{keluarga}/anggota',       [KeluargaController::class, 'storeAnggota'])->name('keluarga.anggota.store');

    Route::post('/keluarga/{keluarga}/anggota/lahir',          [KeluargaController::class, 'storeAnggotaLahir'])->name('keluarga.anggota.store-lahir');
    Route::post('/keluarga/{keluarga}/anggota/masuk',          [KeluargaController::class, 'storeAnggotaMasuk'])->name('keluarga.anggota.store-masuk');
    Route::post('/keluarga/{keluarga}/anggota/dari-penduduk',  [KeluargaController::class, 'storeAnggotaDariPenduduk'])->name('keluarga.anggota.store-dari-penduduk');

    // ── Manajemen Anggota ──────────────────────────────────────────────────────
    // Keluarkan anggota (non-kepala) dari KK → jadi penduduk lepas
    Route::delete(
        '/keluarga/{keluarga}/anggota/{penduduk}/pecah',
        [KeluargaController::class, 'pecahKk']
    )->name('keluarga.anggota.pecah');

    // Pecah KK oleh Kepala Keluarga → KK dibubarkan, semua anggota jadi lepas
    Route::delete(
        '/keluarga/{keluarga}/anggota/{penduduk}/pecah-kk',
        [KeluargaController::class, 'pecahKkKepala']
    )->name('keluarga.pecah-kk');

    // Ubah Hubungan (SHDK) anggota dalam KK
    Route::patch(
        '/keluarga/{keluarga}/anggota/{penduduk}/ubah-hubungan',
        [KeluargaController::class, 'ubahHubungan']
    )->name('keluarga.anggota.ubah-hubungan');

    // ── Buat KK Baru (Pecah) ───────────────────────────────────────────────────
    Route::get(
        '/keluarga/{keluarga}/anggota/{penduduk}/buat-kk-baru',
        [KeluargaController::class, 'formBuatKkBaru']
    )->name('keluarga.buat-kk-baru.form');
    Route::post(
        '/keluarga/{keluarga}/anggota/{penduduk}/buat-kk-baru',
        [KeluargaController::class, 'storeBuatKkBaru']
    )->name('keluarga.buat-kk-baru.store');

    /*
    |--------------------------------------------------------------------------
    | KEPENDUDUKAN — RUMAH TANGGA
    |--------------------------------------------------------------------------
    */
    Route::get('/rumah-tangga/cetak',           [RumahTanggaController::class, 'cetak'])->name('rumah-tangga.cetak');
    Route::get('/rumah-tangga/unduh',           [RumahTanggaController::class, 'unduh'])->name('rumah-tangga.unduh');
    Route::get('/rumah-tangga/export-pdf',      [RumahTanggaController::class, 'exportPdf'])->name('rumah-tangga.export-pdf');
    Route::get('/rumah-tangga/template-impor',  [RumahTanggaController::class, 'templateImpor'])->name('rumah-tangga.template-impor');
    Route::post('/rumah-tangga/impor',          [RumahTanggaController::class, 'impor'])->name('rumah-tangga.impor');
    Route::delete('/rumah-tangga/bulk-destroy', [RumahTanggaController::class, 'bulkDestroy'])->name('rumah-tangga.bulk-destroy');
    Route::get('/rumah-tangga/cari-penduduk',   [RumahTanggaController::class, 'cariPenduduk'])->name('rumah-tangga.cari-penduduk');

    Route::resource('rumah-tangga', RumahTanggaController::class)->names([
        'index'   => 'rumah-tangga.index',
        'create'  => 'rumah-tangga.create',
        'store'   => 'rumah-tangga.store',
        'show'    => 'rumah-tangga.show',
        'edit'    => 'rumah-tangga.edit',
        'update'  => 'rumah-tangga.update',
        'destroy' => 'rumah-tangga.destroy',
    ]);

    Route::get('/rumah-tangga/{rumahTangga}/delete',   [RumahTanggaController::class, 'confirmDestroy'])->name('rumah-tangga.confirm-destroy');
    Route::post('/rumah-tangga/{rumahTangga}/tambah-kk', [RumahTanggaController::class, 'tambahKk'])->name('rumah-tangga.tambah-kk');
    Route::delete('/rumah-tangga/{rumahTangga}/lepas-kk/{keluarga}', [RumahTanggaController::class, 'lepasKk'])->name('rumah-tangga.lepas-kk');
    Route::get('/rumah-tangga/{rumahTangga}/lokasi',   [RumahTanggaController::class, 'lokasi'])->name('rumah-tangga.lokasi');
    Route::post('/rumah-tangga/{rumahTangga}/lokasi',  [RumahTanggaController::class, 'lokasiStore'])->name('rumah-tangga.lokasi.store');

    // ── TAMBAHAN BARU (anggota RT dari halaman show) ──────────────────────────────
    Route::delete('/rumah-tangga/{rumahTangga}/anggota/bulk-destroy',          [RumahTanggaAnggotaController::class, 'bulkDestroy'])->name('rumah-tangga.anggota.bulk-destroy');
    Route::patch('/rumah-tangga/{rumahTangga}/anggota/{penduduk}/hubungan',    [RumahTanggaAnggotaController::class, 'updateHubungan'])->name('rumah-tangga.anggota.update-hubungan');
    Route::delete('/rumah-tangga/{rumahTangga}/anggota/{penduduk}',            [RumahTanggaAnggotaController::class, 'destroy'])->name('rumah-tangga.anggota.destroy');


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

        // ✅ HANYA SATU prefix, tidak nested
        Route::prefix('{kelompok}/anggota')->name('anggota.')->group(function () {
            Route::get('/', [KelompokAnggotaController::class, 'index'])->name('index');
            Route::get('/create', [KelompokAnggotaController::class, 'create'])->name('create');
            Route::post('/', [KelompokAnggotaController::class, 'store'])->name('store');
            Route::delete('/{anggota}', [KelompokAnggotaController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('rumah-tangga/{rumahTangga}/anggota')->name('rumah-tangga-anggota.')->group(function () {
            Route::get('/',              [RumahTanggaAnggotaController::class, 'index'])->name('index');
            Route::get('/create',        [RumahTanggaAnggotaController::class, 'create'])->name('create');
            Route::post('/',             [RumahTanggaAnggotaController::class, 'store'])->name('store');
            Route::get('/{anggota}/edit', [RumahTanggaAnggotaController::class, 'edit'])->name('edit');
            Route::put('/{anggota}',     [RumahTanggaAnggotaController::class, 'update'])->name('update');
            Route::delete('/{anggota}',  [RumahTanggaAnggotaController::class, 'destroy'])->name('destroy');
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

    Route::get('/suplemen/{suplemen}/terdata/template', [DataSuplemenController::class, 'downloadTemplate'])->name('suplemen.terdata.template');
    Route::post('/suplemen/{suplemen}/terdata/import', [DataSuplemenController::class, 'import'])->name('suplemen.terdata.import');
    Route::get('/suplemen/{suplemen}/terdata/export/excel', [DataSuplemenController::class, 'exportExcel'])->name('suplemen.terdata.export.excel');
    Route::get('/suplemen/{suplemen}/terdata/export/pdf', [DataSuplemenController::class, 'exportPdf'])->name('suplemen.terdata.export.pdf');
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
        Route::resource('daftar-persyaratan', PersyaratanController::class)
            ->parameters(['daftar-persyaratan' => 'persyaratan'])
            ->names('persyaratan')
            ->except(['show']);

        Route::prefix('pengaturan')->name('template-surat.')->group(function () {
            Route::get('/global', [SuratTemplateController::class, 'pengaturan'])->name('pengaturan');
            Route::post('/global', [SuratTemplateController::class, 'simpanPengaturan'])->name('simpan-pengaturan');
            Route::get('/', [SuratTemplateController::class, 'index'])->name('index');
            Route::get('/create', [SuratTemplateController::class, 'create'])->name('create');
            Route::post('/store', [SuratTemplateController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [SuratTemplateController::class, 'edit'])->name('edit');
            Route::put('/{id}', [SuratTemplateController::class, 'update'])->name('update');
            Route::delete('/{id}', [SuratTemplateController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('cetak')->name('cetak.')->controller(LetterController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::post('/template', 'generateFromTemplate')->name('template');
            Route::post('/preview', 'preview')->name('preview');
            Route::post('/generate-final', 'generateFinal')->name('generateFinal');
            Route::get('/live-search-nik', 'liveSearchNik')->name('liveSearchNik');
            Route::get('/get-data/{nik}', 'getDataByNik')->name('getDataByNik');
            Route::get('/penduduk/{nik}', 'getPendudukData')->name('getPenduduk');
            Route::get('/{id}', 'show')->name('show');
            Route::get('/{id}/print', 'cetak')->name('print');
        });

        Route::get('/permohonan', [AdminSuratController::class, 'permohonan'])->name('permohonan.index');
        Route::get('/permohonan/{id}', [AdminSuratController::class, 'showPermohonan'])->name('permohonan.show');
        Route::put('/permohonan/{id}/status', [AdminSuratController::class, 'updateStatusPermohonan'])->name('permohonan.update-status');

        Route::get('/letters/create', [AdminSuratController::class, 'createLetter'])->name('letters.create');

        Route::get('/arsip', [AdminSuratController::class, 'arsip'])->name('arsip');
        Route::delete('/arsip/{id}', [AdminSuratController::class, 'destroyArsip'])->name('arsip.destroy');

        Route::prefix('cetak-surat')->name('cetak-surat.')->group(function () {
            Route::get('/', [LetterController::class, 'index'])->name('index');
            Route::post('/', [LetterController::class, 'store'])->name('store');
            Route::get('/{id}', [LetterController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [LetterController::class, 'edit'])->name('edit');
            Route::put('/{id}', [LetterController::class, 'update'])->name('update');
            Route::delete('/{id}', [LetterController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/print', [LetterController::class, 'cetak'])->name('print');
            Route::get('/penduduk/{nik}', [LetterController::class, 'getPendudukData'])->name('getPenduduk');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | SEKRETARIAT
    |--------------------------------------------------------------------------
    */
    Route::prefix('sekretariat')->name('sekretariat.')->group(function () {
        Route::get('/informasi-publik', [SekretariatController::class, 'index'])->name('informasi-publik.index');
        Route::get('/informasi-publik/create', [SekretariatController::class, 'create'])->name('informasi-publik.create');
        Route::post('/informasi-publik', [SekretariatController::class, 'store'])->name('informasi-publik.store');
        Route::get('/informasi-publik/{id}/edit', [SekretariatController::class, 'edit'])->name('informasi-publik.edit');
        Route::put('/informasi-publik/{id}', [SekretariatController::class, 'update'])->name('informasi-publik.update');
        Route::delete('/informasi-publik/{id}', [SekretariatController::class, 'destroy'])->name('informasi-publik.destroy');
        Route::get('/informasi-publik/{id}/download', [SekretariatController::class, 'download'])->name('informasi-publik.download');

        Route::get('/inventaris', [SekretariatController::class, 'inventaris'])->name('inventaris');
        Route::get('/inventaris/create', [SekretariatController::class, 'inventarisCreate'])->name('inventaris.create');
        Route::post('/inventaris', [SekretariatController::class, 'inventarisStore'])->name('inventaris.store');
        Route::get('/inventaris/{id}/edit', [SekretariatController::class, 'inventarisEdit'])->name('inventaris.edit');
        Route::put('/inventaris/{id}', [SekretariatController::class, 'inventarisUpdate'])->name('inventaris.update');
        Route::delete('/inventaris/{id}', [SekretariatController::class, 'inventarisDestroy'])->name('inventaris.destroy');

        Route::delete('/klasifikasi-surat/bulk-destroy', [SekretariatController::class, 'klasifikasiSuratBulkDestroy'])->name('klasifikasi-surat.bulk-destroy');
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
            Route::get('/', [BukuUmumController::class, 'index'])->name('index');

            Route::get('/peraturan-desa', [PeraturanDesaController::class, 'index'])->name('peraturan-desa.index');
            Route::get('/peraturan-desa/create', [PeraturanDesaController::class, 'create'])->name('peraturan-desa.create');
            Route::post('/peraturan-desa', [PeraturanDesaController::class, 'store'])->name('peraturan-desa.store');
            Route::get('/peraturan-desa/{id}/edit', [PeraturanDesaController::class, 'edit'])->name('peraturan-desa.edit');
            Route::get('/peraturan-desa/{id}', [PeraturanDesaController::class, 'show'])->name('peraturan-desa.show');
            Route::put('/peraturan-desa/{id}', [PeraturanDesaController::class, 'update'])->name('peraturan-desa.update');
            Route::delete('/peraturan-desa/{id}', [PeraturanDesaController::class, 'destroy'])->name('peraturan-desa.destroy');

            Route::resource('inventaris-kekayaan-desa', \App\Http\Controllers\Admin\BukuInventarisKekayaanDesaController::class)
                ->parameters(['inventaris-kekayaan-desa' => 'inventarisKekayaanDesa']);

            Route::get('/keputusan', [KeputusanController::class, 'index'])->name('keputusan.index');
            Route::get('/keputusan/create', [KeputusanController::class, 'create'])->name('keputusan.create');
            Route::post('/keputusan', [KeputusanController::class, 'store'])->name('keputusan.store');
            Route::get('/keputusan/{id}', [KeputusanController::class, 'show'])->name('keputusan.show');
            Route::get('/keputusan/{id}/edit', [KeputusanController::class, 'edit'])->name('keputusan.edit');
            Route::put('/keputusan/{id}', [KeputusanController::class, 'update'])->name('keputusan.update');
            Route::delete('/keputusan/{id}', [KeputusanController::class, 'destroy'])->name('keputusan.destroy');

            // Buku Pemerintah Desa
            Route::delete('/pemerintah/bulk-destroy', [PemerintahController::class, 'bulkDestroy'])->name('pemerintah.bulk-destroy');
            Route::get('/pemerintah', [PemerintahController::class, 'index'])->name('pemerintah.index');
            Route::get('/pemerintah/create', [PemerintahController::class, 'create'])->name('pemerintah.create');
            Route::post('/pemerintah', [PemerintahController::class, 'store'])->name('pemerintah.store');
            Route::get('/pemerintah/{id}', [PemerintahController::class, 'show'])->name('pemerintah.show');
            Route::get('/pemerintah/{id}/edit', [PemerintahController::class, 'edit'])->name('pemerintah.edit');
            Route::put('/pemerintah/{id}', [PemerintahController::class, 'update'])->name('pemerintah.update');
            Route::delete('/pemerintah/{id}', [PemerintahController::class, 'destroy'])->name('pemerintah.destroy');

            Route::get('/tanah-kas-desa', [TanahKasDesaController::class, 'index'])->name('tanah-kas-desa.index');
            Route::get('/tanah-kas-desa/create', [TanahKasDesaController::class, 'create'])->name('tanah-kas-desa.create');
            Route::post('/tanah-kas-desa', [TanahKasDesaController::class, 'store'])->name('tanah-kas-desa.store');
            Route::get('/tanah-kas-desa/{id}', [TanahKasDesaController::class, 'show'])->name('tanah-kas-desa.show');
            Route::get('/tanah-kas-desa/{id}/edit', [TanahKasDesaController::class, 'edit'])->name('tanah-kas-desa.edit');
            Route::put('/tanah-kas-desa/{id}', [TanahKasDesaController::class, 'update'])->name('tanah-kas-desa.update');
            Route::delete('/tanah-kas-desa/{id}', [TanahKasDesaController::class, 'destroy'])->name('tanah-kas-desa.destroy');

            Route::get('/tanah-desa', [TanahDesaController::class, 'index'])->name('tanah-desa.index');
            Route::get('/tanah-desa/create', [TanahDesaController::class, 'create'])->name('tanah-desa.create');
            Route::post('/tanah-desa', [TanahDesaController::class, 'store'])->name('tanah-desa.store');
            Route::get('/tanah-desa/{id}', [TanahDesaController::class, 'show'])->name('tanah-desa.show');
            Route::get('/tanah-desa/{id}/edit', [TanahDesaController::class, 'edit'])->name('tanah-desa.edit');
            Route::put('/tanah-desa/{id}', [TanahDesaController::class, 'update'])->name('tanah-desa.update');
            Route::delete('/tanah-desa/{id}', [TanahDesaController::class, 'destroy'])->name('tanah-desa.destroy');

            Route::get('/agenda-surat-keluar', [AgendaSuratKeluarController::class, 'index'])->name('agenda-surat-keluar.index');
            Route::get('/agenda-surat-keluar/create', [AgendaSuratKeluarController::class, 'create'])->name('agenda-surat-keluar.create');
            Route::post('/agenda-surat-keluar', [AgendaSuratKeluarController::class, 'store'])->name('agenda-surat-keluar.store');
            Route::get('/agenda-surat-keluar/{id}', [AgendaSuratKeluarController::class, 'show'])->name('agenda-surat-keluar.show');
            Route::get('/agenda-surat-keluar/{id}/edit', [AgendaSuratKeluarController::class, 'edit'])->name('agenda-surat-keluar.edit');
            Route::put('/agenda-surat-keluar/{id}', [AgendaSuratKeluarController::class, 'update'])->name('agenda-surat-keluar.update');
            Route::delete('/agenda-surat-keluar/{id}', [AgendaSuratKeluarController::class, 'destroy'])->name('agenda-surat-keluar.destroy');

            Route::get('/agenda-surat-masuk', [AgendaSuratMasukController::class, 'index'])->name('agenda-surat-masuk.index');
            Route::get('/agenda-surat-masuk/create', [AgendaSuratMasukController::class, 'create'])->name('agenda-surat-masuk.create');
            Route::post('/agenda-surat-masuk', [AgendaSuratMasukController::class, 'store'])->name('agenda-surat-masuk.store');
            Route::get('/agenda-surat-masuk/{id}', [AgendaSuratMasukController::class, 'show'])->name('agenda-surat-masuk.show');
            Route::get('/agenda-surat-masuk/{id}/edit', [AgendaSuratMasukController::class, 'edit'])->name('agenda-surat-masuk.edit');
            Route::put('/agenda-surat-masuk/{id}', [AgendaSuratMasukController::class, 'update'])->name('agenda-surat-masuk.update');
            Route::delete('/agenda-surat-masuk/{id}', [AgendaSuratMasukController::class, 'destroy'])->name('agenda-surat-masuk.destroy');

            Route::get('/ekspedisi', [EkspedisiController::class, 'index'])->name('ekspedisi.index');
            Route::get('/ekspedisi/create', [EkspedisiController::class, 'create'])->name('ekspedisi.create');
            Route::post('/ekspedisi', [EkspedisiController::class, 'store'])->name('ekspedisi.store');
            Route::get('/ekspedisi/{id}', [EkspedisiController::class, 'show'])->name('ekspedisi.show');
            Route::get('/ekspedisi/{id}/edit', [EkspedisiController::class, 'edit'])->name('ekspedisi.edit');
            Route::put('/ekspedisi/{id}', [EkspedisiController::class, 'update'])->name('ekspedisi.update');
            Route::delete('/ekspedisi/{id}', [EkspedisiController::class, 'destroy'])->name('ekspedisi.destroy');

            Route::get('/lembaran-desa', [LembaranDesaController::class, 'index'])->name('lembaran-desa.index');
            Route::get('/lembaran-desa/create', [LembaranDesaController::class, 'create'])->name('lembaran-desa.create');
            Route::post('/lembaran-desa', [LembaranDesaController::class, 'store'])->name('lembaran-desa.store');
            Route::get('/lembaran-desa/{id}', [LembaranDesaController::class, 'show'])->name('lembaran-desa.show');
            Route::get('/lembaran-desa/{id}/edit', [LembaranDesaController::class, 'edit'])->name('lembaran-desa.edit');
            Route::put('/lembaran-desa/{id}', [LembaranDesaController::class, 'update'])->name('lembaran-desa.update');
            Route::delete('/lembaran-desa/{id}', [LembaranDesaController::class, 'destroy'])->name('lembaran-desa.destroy');
        });

        // ==========================================
        // 2. ADMIN PENDUDUK
        // ==========================================
        Route::prefix('penduduk')->name('penduduk.')->group(function () {
            Route::get('/', [BukuPendudukController::class, 'index'])->name('index');

            Route::prefix('induk-penduduk')->name('induk-penduduk.')->group(function () {
                Route::get('/', [BukuIndukPendudukController::class, 'index'])->name('index');
                Route::get('/export-excel', [BukuIndukPendudukController::class, 'exportExcel'])->name('export.excel');
                Route::get('/export-pdf', [BukuIndukPendudukController::class, 'exportPdf'])->name('export.pdf');
            });

            Route::prefix('mutasi-penduduk')->name('mutasi-penduduk.')->group(function () {
                Route::get('/', [BukuMutasiPendudukController::class, 'index'])->name('index');
                Route::get('/create', [BukuMutasiPendudukController::class, 'create'])->name('create');
                Route::post('/', [BukuMutasiPendudukController::class, 'store'])->name('store');
                Route::get('/{mutasiPenduduk}', [BukuMutasiPendudukController::class, 'show'])->name('show');
                Route::get('/{mutasiPenduduk}/edit', [BukuMutasiPendudukController::class, 'edit'])->name('edit');
                Route::put('/{mutasiPenduduk}', [BukuMutasiPendudukController::class, 'update'])->name('update');
                Route::delete('/{mutasiPenduduk}', [BukuMutasiPendudukController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('rekapitulasi-penduduk')->name('rekapitulasi-penduduk.')->group(function () {
                Route::get('/', [BukuRekapitulasiPendudukController::class, 'index'])->name('index');
            });

            Route::prefix('penduduk-sementara')->name('penduduk-sementara.')->group(function () {
                Route::get('/', [BukuPendudukSementaraController::class, 'index'])->name('index');
                Route::get('/create', [BukuPendudukSementaraController::class, 'create'])->name('create');
                Route::post('/', [BukuPendudukSementaraController::class, 'store'])->name('store');
                Route::get('/{pendudukSementara}', [BukuPendudukSementaraController::class, 'show'])->name('show');
                Route::get('/{pendudukSementara}/edit', [BukuPendudukSementaraController::class, 'edit'])->name('edit');
                Route::put('/{pendudukSementara}', [BukuPendudukSementaraController::class, 'update'])->name('update');
                Route::delete('/{pendudukSementara}', [BukuPendudukSementaraController::class, 'destroy'])->name('destroy');
            });

            Route::get('/ktp-kk', [KtpKkController::class, 'index'])->name('ktp-kk.index');

            Route::prefix('ktp-kk/ktp')->name('ktp-kk.ktp.')->group(function () {
                Route::get('/', [KtpKkController::class, 'indexKtp'])->name('index');
                Route::get('/create', [KtpKkController::class, 'createKtp'])->name('create');
                Route::post('/', [KtpKkController::class, 'storeKtp'])->name('store');
                Route::get('/{ktp}', [KtpKkController::class, 'showKtp'])->name('show');
                Route::get('/{ktp}/edit', [KtpKkController::class, 'editKtp'])->name('edit');
                Route::put('/{ktp}', [KtpKkController::class, 'updateKtp'])->name('update');
                Route::delete('/{ktp}', [KtpKkController::class, 'destroyKtp'])->name('destroy');
            });

            Route::prefix('ktp-kk/kk')->name('ktp-kk.kk.')->group(function () {
                Route::get('/', [KtpKkController::class, 'indexKk'])->name('index');
                Route::get('/create', [KtpKkController::class, 'createKk'])->name('create');
                Route::post('/', [KtpKkController::class, 'storeKk'])->name('store');
                Route::get('/{kk}', [KtpKkController::class, 'showKk'])->name('show');
                Route::get('/{kk}/edit', [KtpKkController::class, 'editKk'])->name('edit');
                Route::put('/{kk}', [KtpKkController::class, 'updateKk'])->name('update');
                Route::delete('/{kk}', [KtpKkController::class, 'destroyKk'])->name('destroy');
            });
        });

        // ==========================================
        // 3. ADMIN PEMBANGUNAN
        // ==========================================
        Route::prefix('pembangunan')->name('pembangunan.')->group(function () {
            Route::get('/', [BukuPembangunanController::class, 'index'])->name('index');

            Route::resource('rencana-kerja', BukuRencanaKerjaPembangunanController::class)->only(['index']);
            Route::get('rencana-kerja/cetak', [BukuRencanaKerjaPembangunanController::class, 'cetak'])->name('rencana-kerja.cetak');

            Route::resource('kegiatan', BukuActivitiesPembangunanController::class);
            Route::post('kegiatan/{kegiatan}/dokumentasi', [BukuActivitiesPembangunanController::class, 'storeDokumentasi'])->name('kegiatan.dokumentasi.store');
            Route::delete('kegiatan/dokumentasi/{dokumentasi}', [BukuActivitiesPembangunanController::class, 'destroyDokumentasi'])->name('kegiatan.dokumentasi.destroy');

            Route::resource('inventaris', BukuInventarisPembangunanController::class);
            Route::resource('kader-pemberdayaan', BukuKaderPemberdayaanController::class);

            Route::get('/rencana', [RencanaPembangunanController::class, 'index'])->name('rencana.index');
            Route::get('/rencana/create', [RencanaPembangunanController::class, 'create'])->name('rencana.create');
            Route::post('/rencana', [RencanaPembangunanController::class, 'store'])->name('rencana.store');
            Route::get('/rencana/{id}/edit', [RencanaPembangunanController::class, 'edit'])->name('rencana.edit');
            Route::put('/rencana/{id}', [RencanaPembangunanController::class, 'update'])->name('rencana.update');
            Route::delete('/rencana/{id}', [RencanaPembangunanController::class, 'destroy'])->name('rencana.destroy');
        });

        // ==========================================
        // 4. ARSIP DESA
        // ==========================================
        Route::prefix('arsip')->name('arsip.')->group(function () {
            Route::get('/', [ArsipDesaController::class, 'index'])->name('index');
            Route::get('/{id}', [ArsipDesaController::class, 'show'])->name('show');
            Route::patch('/{id}/lokasi', [ArsipDesaController::class, 'updateLokasi'])->name('updateLokasi');
            Route::get('/{id}/lihat', [ArsipDesaController::class, 'lihat'])->name('lihat');
            Route::get('/{id}/unduh', [ArsipDesaController::class, 'unduh'])->name('unduh');

            Route::get('/filter/cari', function (\Illuminate\Http\Request $request) {
                $jenisDokumen = $request->jenis_dokumen;
                $tahun        = $request->tahun;
                $arsip        = collect([]);
                $totalDokumen = 0;
                $suratMasuk = 0;
                $suratKeluar = 0;
                $kependudukan = 0;
                $layananSurat = 0;
                return view('admin.buku-administrasi.arsip', compact('arsip', 'totalDokumen', 'suratMasuk', 'suratKeluar', 'kependudukan', 'layananSurat'));
            })->name('cari');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | KEHADIRAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('kehadiran')->name('kehadiran.')->group(function () {
        Route::prefix('jam-kerja')->name('jam-kerja.')->group(function () {
            Route::get('/', [JamKerjaController::class, 'index'])->name('index');
            Route::post('/', [JamKerjaController::class, 'store'])->name('store');
            Route::put('/{jamKerja}', [JamKerjaController::class, 'update'])->name('update');
            Route::delete('/{jamKerja}', [JamKerjaController::class, 'destroy'])->name('destroy');
            Route::patch('/{jamKerja}/toggle', [JamKerjaController::class, 'toggleStatus'])->name('toggle');
        });

        Route::prefix('hari-libur')->name('hari-libur.')->group(function () {
            Route::get('/', [HariLiburController::class, 'index'])->name('index');
            Route::post('/', [HariLiburController::class, 'store'])->name('store');
            Route::put('/{hariLibur}', [HariLiburController::class, 'update'])->name('update');
            Route::delete('/{hariLibur}', [HariLiburController::class, 'destroy'])->name('destroy');
            Route::post('/import-nasional', [HariLiburController::class, 'importNasional'])->name('import-nasional');
            Route::get('/preview-nasional', [HariLiburController::class, 'previewNasional'])->name('preview-nasional');
            Route::post('/clear-cache', [HariLiburController::class, 'clearCache'])->name('clear-cache');
        });

        Route::prefix('rekapitulasi')->name('rekapitulasi.')->group(function () {
            Route::get('/', [RekapitulasiController::class, 'index'])->name('index');
            Route::get('/export-pdf', [RekapitulasiController::class, 'exportPdf'])->name('export-pdf');
            Route::get('/export-excel', [RekapitulasiController::class, 'exportExcel'])->name('export-excel');
        });

        Route::prefix('pengaduan-kehadiran')->name('pengaduan-kehadiran.')->group(function () {
            Route::get('/', [PengaduanKehadiranController::class, 'index'])->name('index');
            Route::get('/{pengaduanKehadiran}', [PengaduanKehadiranController::class, 'show'])->name('show');
            Route::post('/{pengaduanKehadiran}/approve', [PengaduanKehadiranController::class, 'approve'])->name('approve');
            Route::post('/{pengaduanKehadiran}/reject', [PengaduanKehadiranController::class, 'reject'])->name('reject');
            Route::delete('/{pengaduanKehadiran}', [PengaduanKehadiranController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('input')->name('input.')->group(function () {
            Route::get('/', [InputKehadiranController::class, 'index'])->name('index');
            Route::post('/simpan-manual', [InputKehadiranController::class, 'simpanManual'])->name('simpan-manual');
            Route::post('/preview-fingerprint', [InputKehadiranController::class, 'previewFingerprint'])->name('preview-fingerprint');
            Route::post('/simpan-fingerprint', [InputKehadiranController::class, 'simpanFingerprint'])->name('simpan-fingerprint');
            Route::post('/hapus', [InputKehadiranController::class, 'hapusKehadiran'])->name('hapus');
        });
    });

    // ==========================================================
    // GRUP ROUTE KEUANGAN
    // ==========================================================
    Route::prefix('keuangan')->name('keuangan.')->group(function () {

        Route::get('/laporan-keuangan', [KeuanganController::class, 'laporanKeuangan'])
            ->name('laporan-keuangan');


        // ------------------------------------------------------
        // A. MASUK KE KEUANGAN CONTROLLER (Fitur Master / Laporan)
        // ------------------------------------------------------
        Route::get('/laporan', [KeuanganController::class, 'laporan'])->name('laporan');
        // Laporan APBDes — ⚠️ 'bulk' & 'kirim' HARUS sebelum /{id}
        Route::get('/laporan-apbdes', [KeuanganController::class, 'laporanApbdes'])->name('laporan-apbdes');
        Route::post('/laporan-apbdes', [KeuanganController::class, 'laporanApbdesStore'])->name('laporan-apbdes.store');
        Route::delete('/laporan-apbdes/bulk', [KeuanganController::class, 'laporanApbdesBulkDestroy'])->name('laporan-apbdes.bulk-destroy');
        Route::post('/laporan-apbdes/kirim', [KeuanganController::class, 'laporanApbdesKirimOpenDK'])->name('laporan-apbdes.kirim');
        Route::put('/laporan-apbdes/{id}', [KeuanganController::class, 'laporanApbdesUpdate'])->name('laporan-apbdes.update');
        Route::delete('/laporan-apbdes/{id}', [KeuanganController::class, 'laporanApbdesDestroy'])->name('laporan-apbdes.destroy');
        Route::delete('/{id}', [KeuanganController::class, 'destroy'])->name('destroy');

        // Rute Kas Desa
        Route::get('/kas-desa', [KeuanganController::class, 'kasDesa'])->name('kas-desa');
        Route::get('/kas-desa/create', [KeuanganController::class, 'kasDesaCreate'])->name('kas-desa.create');
        Route::post('/kas-desa', [KeuanganController::class, 'kasDesaStore'])->name('kas-desa.store');
        Route::get('/kas-desa/{id}/edit', [KeuanganController::class, 'kasDesaEdit'])->name('kas-desa.edit');
        Route::put('/kas-desa/{id}', [KeuanganController::class, 'kasDesaUpdate'])->name('kas-desa.update');
        Route::delete('/kas-desa/{id}', [KeuanganController::class, 'kasDesaDestroy'])->name('kas-desa.destroy');

        // Rute APBDes
        Route::get('/apbdes', [KeuanganController::class, 'apbdes'])->name('apbdes');
        Route::get('/apbdes/create', [KeuanganController::class, 'apbdesCreate'])->name('apbdes.create');
        Route::post('/apbdes', [KeuanganController::class, 'apbdesStore'])->name('apbdes.store');
        Route::get('/apbdes/{id}/edit', [KeuanganController::class, 'apbdesEdit'])->name('apbdes.edit');
        Route::put('/apbdes/{id}', [KeuanganController::class, 'apbdesUpdate'])->name('apbdes.update');
        Route::delete('/apbdes/{id}', [KeuanganController::class, 'apbdesDestroy'])->name('apbdes.destroy');
        Route::post('/apbdes/{apbdesId}/realisasi', [KeuanganController::class, 'realisasiStore'])->name('apbdes.realisasi.store');

        // ------------------------------------------------------
        // B. MASUK KE INPUT CONTROLLER (Fitur Input Data)
        // ------------------------------------------------------

        // 1. Fitur Input Transaksi Kas (Lama)
        // URL: /admin/keuangan/input-data
        Route::get('/input-data', [InputController::class, 'inputData'])->name('input-data');
        Route::post('/input-data', [InputController::class, 'store'])->name('store');

        // 2. Fitur Input Tabel Anggaran & Realisasi (Template Baru)
        // URL: /admin/keuangan/input-template
        Route::get('/input-template', [InputController::class, 'index'])->name('input.index');
        Route::post('/input-template/tambah', [InputController::class, 'tambahTemplate'])->name('input.tambah-template');
        Route::put('/input-template/{id}', [InputController::class, 'updateNominal'])->name('input.update-nominal');
    });

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
    Route::resource('analisis', AnalisisMasterController::class)->parameters(['analisis' => 'analisi']);
    Route::post('analisis/{analisi}/toggle-status', [AnalisisMasterController::class, 'toggleStatus'])->name('analisis.toggle-status');
    Route::post('analisis/{analisi}/toggle-lock', [AnalisisMasterController::class, 'toggleLock'])->name('analisis.toggle-lock');

    Route::get('analisis/{analisi}/export',       [AnalisisMasterController::class, 'export'])->name('analisis.export');
    Route::post('analisis/{analisi}/sinkronisasi', [AnalisisMasterController::class, 'sinkronisasi'])->name('analisis.sinkronisasi');
    Route::post('analisis/import',                 [AnalisisMasterController::class, 'import'])->name('analisis.import');

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

    Route::get('/bantuan/import', [BantuanController::class, 'importForm'])->name('bantuan.import');
    Route::post('/bantuan/import', [BantuanController::class, 'import'])->name('bantuan.import.store');
    Route::get('/bantuan/contoh-format', [BantuanController::class, 'contohFormat'])
        ->name('bantuan.contoh-format');
    Route::get('/bantuan/bersihkan', [BantuanController::class, 'bersihkan'])->name('bantuan.bersihkan');
    Route::delete('/bantuan/bersihkan/destroy', [BantuanController::class, 'bersihkanDestroy'])->name('bantuan.bersihkan.destroy');

    Route::resource('bantuan', BantuanController::class);

    Route::prefix('bantuan/{bantuan}/peserta')->name('bantuan.peserta.')->group(function () {
        Route::get('/create', [BantuanPesertaController::class, 'create'])->name('create');
        Route::post('/', [BantuanPesertaController::class, 'store'])->name('store');
        Route::get('/search', [BantuanPesertaController::class, 'search'])->name('search');
        Route::get('/template', [BantuanPesertaController::class, 'downloadTemplate'])->name('template');
        Route::post('/import', [BantuanPesertaController::class, 'import'])->name('import');
        Route::get('/export/excel', [BantuanPesertaController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [BantuanPesertaController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/{peserta}/edit', [BantuanPesertaController::class, 'edit'])->name('edit');
        Route::put('/{peserta}', [BantuanPesertaController::class, 'update'])->name('update');
        Route::delete('/bulk-destroy', [BantuanPesertaController::class, 'bulkDestroy'])->name('bulk-destroy');
        Route::delete('/{peserta}', [BantuanPesertaController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | KESEHATAN
    |--------------------------------------------------------------------------
    */
    if (file_exists(__DIR__ . '/kesehatan.php')) {
        require __DIR__ . '/kesehatan.php';
    }

    /*
    |--------------------------------------------------------------------------
    | PEMBANGUNAN UTAMA
    |--------------------------------------------------------------------------
    */
    Route::prefix('pembangunan-utama')->name('pembangunan-utama.')->group(function () {
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

        Route::post('{pembangunan}/dokumentasi', [PembangunanController::class, 'storeDokumentasi'])->name('dokumentasi.store');
        Route::delete('{pembangunan}/dokumentasi/{dokumentasi}', [PembangunanController::class, 'destroyDokumentasi'])->name('dokumentasi.destroy');
        Route::patch('{pembangunan}/toggle-status', [PembangunanController::class, 'toggleStatus'])->name('toggle-status');

        // Lokasi Peta & GPX
        Route::get('{pembangunan}/lokasi', [PembangunanController::class, 'lokasi'])->name('lokasi');
        Route::patch('{pembangunan}/lokasi', [PembangunanController::class, 'lokasiUpdate'])->name('lokasi.update');
        Route::get('{pembangunan}/lokasi/gpx', [PembangunanController::class, 'lokasiGpx'])->name('lokasi.gpx');
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
| WISATA
|--------------------------------------------------------------------------
*/
    Route::prefix('wisata')->name('wisata.')->group(function () {
        Route::get('/', [WisataController::class, 'index'])->name('index');
        Route::get('/tambah', [WisataController::class, 'create'])->name('create');
        Route::post('/', [WisataController::class, 'store'])->name('store');
        Route::get('/{wisata}', [WisataController::class, 'show'])->name('show');
        Route::get('/{wisata}/edit', [WisataController::class, 'edit'])->name('edit');
        Route::put('/{wisata}', [WisataController::class, 'update'])->name('update');
        Route::delete('/{wisata}', [WisataController::class, 'destroy'])->name('destroy');
        Route::patch('/{wisata}/toggle-status', [WisataController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/wisata/{id}/ulasan', [FrontendController::class, 'storeUlasanWisata'])->name('wisata.ulasan.store');
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
        'edit'   => 'info-desa.wilayah-administratif.edit',
        'update'  => 'info-desa.wilayah-administratif.update',
        'destroy' => 'info-desa.wilayah-administratif.destroy',
    ]);
    Route::get('/info-desa/wilayah-administratif/{wilayah}/delete', [WilayahController::class, 'confirmDestroy'])->name('info-desa.wilayah-administratif.confirm-destroy');

    /*
    |--------------------------------------------------------------------------
    | PEMERINTAH DESA
    |--------------------------------------------------------------------------
    */
    Route::get('/pemerintah-desa', function () {
        return redirect()->route('admin.buku-administrasi.umum.pemerintah.index');
    })->name('pemerintah-desa.index');

    /*
    |--------------------------------------------------------------------------
    | INFO DESA — STATUS DESA
    |--------------------------------------------------------------------------
    */
    Route::get('status-desa', function () {
        return redirect()->route('admin.info-desa.status-desa.index');
    })->name('status-desa.redirect');

    Route::prefix('info-desa/status-desa')->name('info-desa.status-desa.')->group(function () {
        Route::get('/',          [StatusDesaController::class, 'index'])->name('index');
        Route::post('/perbarui', [StatusDesaController::class, 'perbaruiSkor'])->name('perbarui');
        Route::post('/simpan',   [StatusDesaController::class, 'simpan'])->name('simpan');
        Route::post('/salin',    [StatusDesaController::class, 'salinTahunSebelumnya'])->name('salin');
        Route::post('/sdgs/perbarui', [StatusDesaController::class, 'perbaruiSdgs'])->name('sdgs.perbarui');
    });

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

    /*
    |--------------------------------------------------------------------------
    | LAYANAN MANDIRI
    |--------------------------------------------------------------------------
    */
    Route::prefix('layanan-mandiri')->name('layanan-mandiri.')->group(function () {

        Route::prefix('pendaftar')->name('pendaftar.')->group(function () {
            Route::get('/',                            [PendaftarController::class, 'index'])->name('index');
            Route::post('/',                           [PendaftarController::class, 'store'])->name('store');
            Route::delete('/{pendaftar}',              [PendaftarController::class, 'destroy'])->name('destroy');
            Route::post('/{pendaftar}/reset-pin',      [PendaftarController::class, 'resetPin'])->name('reset-pin');
            Route::post('/{pendaftar}/simpan-telepon', [PendaftarController::class, 'simpanTelepon'])->name('simpan-telepon');
        });

        Route::get('cari-penduduk', [PendaftarController::class, 'cariPenduduk'])->name('cari-penduduk');

        // ── Tambahkan di sini ──────────────────────────────────────
        Route::get('pengaturan',  [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::put('pengaturan',  [PengaturanController::class, 'update'])->name('pengaturan.update');
    });

    /*
    |--------------------------------------------------------------------------
    | PPID
    |--------------------------------------------------------------------------
    */
    Route::prefix('ppid')->name('ppid.')->group(function () {

        // Spesifik dulu sebelum wildcard /{ppid}
        Route::prefix('jenis')->name('jenis.')->group(function () {
            Route::get('/',                       [PpidJenisController::class, 'index'])->name('index');
            Route::get('/tambah',                 [PpidJenisController::class, 'create'])->name('create');
            Route::post('/',                      [PpidJenisController::class, 'store'])->name('store');
            Route::delete('/bulk-destroy',        [PpidJenisController::class, 'bulkDestroy'])->name('bulk-destroy');
            Route::get('/{jeni}/edit',            [PpidJenisController::class, 'edit'])->name('edit');
            Route::put('/{jeni}',                 [PpidJenisController::class, 'update'])->name('update');
            Route::delete('/{jeni}',              [PpidJenisController::class, 'destroy'])->name('destroy');
            Route::patch('/{jeni}/toggle-status', [PpidJenisController::class, 'toggleStatus'])->name('toggle-status');
        });

        Route::prefix('permohonan-informasi')->name('permohonan-informasi.')->group(function () {
            Route::get('/',                                         [PermohonanInformasiController::class, 'index'])->name('index');
            Route::get('/tambah',                                   [PermohonanInformasiController::class, 'create'])->name('create');
            Route::post('/',                                        [PermohonanInformasiController::class, 'store'])->name('store');
            Route::delete('/bulk-destroy',                          [PermohonanInformasiController::class, 'bulkDestroy'])->name('bulk-destroy');
            Route::patch('/bulk-update-status',                     [PermohonanInformasiController::class, 'bulkUpdateStatus'])->name('bulk-update-status');
            Route::get('/{permohonanInformasi}',                    [PermohonanInformasiController::class, 'show'])->name('show');
            Route::get('/{permohonanInformasi}/edit',               [PermohonanInformasiController::class, 'edit'])->name('edit');
            Route::put('/{permohonanInformasi}',                    [PermohonanInformasiController::class, 'update'])->name('update');
            Route::delete('/{permohonanInformasi}',                 [PermohonanInformasiController::class, 'destroy'])->name('destroy');
            Route::patch('/{permohonanInformasi}/update-status',    [PermohonanInformasiController::class, 'updateStatus'])->name('update-status');
        });

        // Wildcard PPID di bawah
        Route::get('/',               [PpidController::class, 'index'])->name('index');
        Route::get('/tambah',         [PpidController::class, 'create'])->name('create');
        Route::post('/',              [PpidController::class, 'store'])->name('store');
        Route::delete('/bulk-destroy', [PpidController::class, 'bulkDestroy'])->name('bulk-destroy');
        Route::get('/{ppid}',         [PpidController::class, 'show'])->name('show');
        Route::get('/{ppid}/edit',    [PpidController::class, 'edit'])->name('edit');
        Route::put('/{ppid}',         [PpidController::class, 'update'])->name('update');
        Route::delete('/{ppid}',      [PpidController::class, 'destroy'])->name('destroy');
    });
}); // <--- PENUTUP GROUP ADMIN UTAMA (Semua route admin dan ppid aman di dalam sini)
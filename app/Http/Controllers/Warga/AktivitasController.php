<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SuratPermohonan;
use App\Models\Pesan;
use Carbon\Carbon;

class AktivitasController extends Controller
{
    public function index(Request $request)
    {
        dd('controller jalan'); 
        $user = Auth::user();

        // ── Filter periode ────────────────────────────────────────────
        $filterTanggal = $request->input('tanggal', 'semua');
        $dateFrom = match ($filterTanggal) {
            'hari_ini' => Carbon::today(),
            '7_hari'   => Carbon::now()->subDays(7),
            '30_hari'  => Carbon::now()->subDays(30),
            default    => null,
        };

        // ── Filter tipe ───────────────────────────────────────────────
        $filterTipe = $request->input('tipe', 'semua');

        // ── Statistik ─────────────────────────────────────────────────
        $totalSurat    = 0;
        $suratProses   = 0;
        $suratSelesai  = 0;

        if ($user->penduduk_id) {
            $totalSurat   = SuratPermohonan::where('penduduk_id', $user->penduduk_id)->count();
            $suratProses  = SuratPermohonan::where('penduduk_id', $user->penduduk_id)
                                ->whereIn('status', ['menunggu', 'diajukan', 'diproses'])->count();
            $suratSelesai = SuratPermohonan::where('penduduk_id', $user->penduduk_id)
                                ->whereIn('status', ['selesai', 'disetujui'])->count();
        }

        $stats = [
            'total_surat'        => $totalSurat,
            'surat_proses'       => $suratProses,
            'surat_selesai'      => $suratSelesai,
            'total_pesan'        => Pesan::where('penerima_id', $user->id)->count(),
            'pesan_belum_dibaca' => Pesan::where('penerima_id', $user->id)->where('sudah_dibaca', false)->count(),
        ];

        // ── Kumpulkan aktivitas ───────────────────────────────────────
        $aktivitas = collect();

        // Surat Permohonan
        if (in_array($filterTipe, ['semua', 'surat']) && $user->penduduk_id) {
            SuratPermohonan::where('penduduk_id', $user->penduduk_id)
                ->when($dateFrom, fn($q) => $q->where('created_at', '>=', $dateFrom))
                ->latest()
                ->get()
                ->each(function ($item) use (&$aktivitas) {
                    $aktivitas->push([
                        'tipe'        => 'surat',
                        'label'       => 'Surat Permohonan',
                        'deskripsi'   => $item->jenis_surat ?? $item->nama_surat ?? 'Permohonan surat',
                        'status'      => $item->status ?? '-',
                        'waktu'       => $item->created_at,
                        'waktu_human' => $item->created_at->diffForHumans(),
                        'url'         => route('warga.surat.index'),
                    ]);
                });
        }

        // Pesan Masuk
        if (in_array($filterTipe, ['semua', 'pesan'])) {
            Pesan::where('penerima_id', $user->id)
                ->when($dateFrom, fn($q) => $q->where('created_at', '>=', $dateFrom))
                ->latest()
                ->get()
                ->each(function ($item) use (&$aktivitas) {
                    $aktivitas->push([
                        'tipe'        => 'pesan',
                        'label'       => 'Pesan Masuk',
                        'deskripsi'   => $item->isi
                                            ? \Illuminate\Support\Str::limit($item->isi, 60)
                                            : 'Pesan baru dari admin',
                        'status'      => $item->sudah_dibaca ? 'dibaca' : 'belum_dibaca',
                        'waktu'       => $item->created_at,
                        'waktu_human' => $item->created_at->diffForHumans(),
                        'url'         => route('warga.pesan.index'),
                    ]);
                });
        }

        // Urutkan terbaru ke terlama lalu paginasi
        $aktivitas = $aktivitas->sortByDesc('waktu')->values();

        $perPage   = 10;
        $page      = $request->input('page', 1);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $aktivitas->forPage($page, $perPage)->values(),
            $aktivitas->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('warga.aktivitas.index', [
            'aktivitas'     => $paginator,
            'stats'         => $stats,
            'filterTanggal' => $filterTanggal,
            'filterTipe'    => $filterTipe,
            'user'          => $user,
        ]);
    }
}
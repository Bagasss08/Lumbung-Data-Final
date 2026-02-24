<?php

namespace App\Http\Controllers\Admin\statistik;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatistikController extends Controller {
    public function index() {
        $penduduks = Penduduk::where('status_hidup', 'hidup')
            ->select('tanggal_lahir', 'jenis_kelamin', 'pendidikan', 'pekerjaan', 'status_perkawinan')
            ->get();

        $total_penduduk = Penduduk::where('status_hidup', 'hidup')->count();
        $laki_laki = Penduduk::where('status_hidup', 'hidup')
            ->where('jenis_kelamin', 'L')
            ->count();
        $perempuan = Penduduk::where('status_hidup', 'hidup')
            ->where('jenis_kelamin', 'P')
            ->count();

        $usia = [
            '0_5'    => 0,
            '6_17'   => 0,
            '18_59'  => 0,
            '60_plus' => 0,
        ];

        foreach ($penduduks as $p) {
            if (!$p->tanggal_lahir) continue;
            try {
                $age = Carbon::parse($p->tanggal_lahir)->age;
            } catch (\Exception $e) {
                continue;
            }

            if ($age <= 5)                    $usia['0_5']++;
            elseif ($age >= 6  && $age <= 17) $usia['6_17']++;
            elseif ($age >= 18 && $age <= 59) $usia['18_59']++;
            else                              $usia['60_plus']++;
        }

        $pendidikan_data = Penduduk::where('status_hidup', 'hidup')
            ->groupBy('pendidikan')
            ->selectRaw('pendidikan as label, COUNT(*) as jumlah')
            ->orderByRaw('jumlah DESC')
            ->get()->toArray();

        $pendidikan = [];
        foreach ($pendidikan_data as $item) {
            if (!empty($item['label'])) {
                $pendidikan[] = ['label' => ucfirst($item['label']), 'jumlah' => (int) $item['jumlah']];
            }
        }

        $pekerjaan_data = Penduduk::where('status_hidup', 'hidup')
            ->groupBy('pekerjaan')
            ->selectRaw('pekerjaan as label, COUNT(*) as jumlah')
            ->orderByRaw('jumlah DESC')
            ->get()->toArray();

        $pekerjaan = [];
        foreach ($pekerjaan_data as $item) {
            if (!empty($item['label'])) {
                $pekerjaan[] = ['label' => ucfirst($item['label']), 'jumlah' => (int) $item['jumlah']];
            }
        }

        $status_nikah_data = Penduduk::where('status_hidup', 'hidup')
            ->groupBy('status_perkawinan')
            ->selectRaw('status_perkawinan as label, COUNT(*) as jumlah')
            ->orderByRaw('jumlah DESC')
            ->get()->toArray();

        $status_perkawinan = [];
        foreach ($status_nikah_data as $item) {
            if (!empty($item['label'])) {
                $status_perkawinan[] = ['label' => ucfirst($item['label']), 'jumlah' => (int) $item['jumlah']];
            }
        }

        $data = [
            'total_penduduk'   => (int) $total_penduduk,
            'laki_laki'        => (int) $laki_laki,
            'perempuan'        => (int) $perempuan,
            'kepala_keluarga'  => Keluarga::count(),
            'rt'               => Wilayah::whereNotNull('rt')->where('rt', '!=', '')->distinct('rt')->count('rt'),
            'rw'               => Wilayah::whereNotNull('rw')->where('rw', '!=', '')->distinct('rw')->count('rw'),
            'usia'             => $usia,
            'pendidikan'       => $pendidikan,
            'pekerjaan'        => $pekerjaan,
            'status_perkawinan' => $status_perkawinan,
        ];

        return view('admin.statistik.statistik', compact('data'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    public function penduduk() {
        $penduduk = Penduduk::with(['keluargas'])
            ->where('status_hidup', 'hidup')
            ->orderBy('nama')
            ->paginate(50);

        $total_penduduk  = Penduduk::where('status_hidup', 'hidup')->count();
        $laki_laki       = Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'L')->count();
        $perempuan       = Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'P')->count();
        $kepala_keluarga = Keluarga::count();

        $data = compact('penduduk', 'total_penduduk', 'laki_laki', 'perempuan', 'kepala_keluarga');

        return view('admin.statistik.penduduk', compact('data'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    public function kependudukan() {
        $total_penduduk  = Penduduk::where('status_hidup', 'hidup')->count();
        $laki_laki       = Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'L')->count();
        $perempuan       = Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'P')->count();
        $kepala_keluarga = Keluarga::count();

        $rt = Wilayah::whereNotNull('rt')->where('rt', '!=', '')->distinct('rt')->count('rt');
        $rw = Wilayah::whereNotNull('rw')->where('rw', '!=', '')->distinct('rw')->count('rw');

        $balita = Penduduk::where('status_hidup', 'hidup')
            ->whereRaw('YEAR(FROM_DAYS(DATEDIFF(now(),tanggal_lahir))) < 5')->count();
        $remaja = Penduduk::where('status_hidup', 'hidup')
            ->whereRaw('YEAR(FROM_DAYS(DATEDIFF(now(),tanggal_lahir))) BETWEEN 5 AND 18')->count();
        $dewasa = Penduduk::where('status_hidup', 'hidup')
            ->whereRaw('YEAR(FROM_DAYS(DATEDIFF(now(),tanggal_lahir))) BETWEEN 19 AND 59')->count();
        $lansia = Penduduk::where('status_hidup', 'hidup')
            ->whereRaw('YEAR(FROM_DAYS(DATEDIFF(now(),tanggal_lahir))) >= 60')->count();

        $pendidikan_data = Penduduk::select('pendidikan')
            ->where('status_hidup', 'hidup')->groupBy('pendidikan')
            ->selectRaw('pendidikan as label, COUNT(*) as jumlah')->get()->toArray();
        $pendidikan = [];
        foreach ($pendidikan_data as $item) {
            if (!empty($item['label'])) $pendidikan[] = ['label' => ucfirst($item['label']), 'jumlah' => $item['jumlah']];
        }

        $pekerjaan_data = Penduduk::select('pekerjaan')
            ->where('status_hidup', 'hidup')->groupBy('pekerjaan')
            ->selectRaw('pekerjaan as label, COUNT(*) as jumlah')->get()->toArray();
        $pekerjaan = [];
        foreach ($pekerjaan_data as $item) {
            if (!empty($item['label'])) $pekerjaan[] = ['label' => ucfirst($item['label']), 'jumlah' => $item['jumlah']];
        }

        $agama_data = Penduduk::select('agama')
            ->where('status_hidup', 'hidup')->groupBy('agama')
            ->selectRaw('agama as label, COUNT(*) as jumlah')->get()->toArray();
        $agama = [];
        foreach ($agama_data as $item) {
            if (!empty($item['label'])) $agama[] = ['label' => ucfirst($item['label']), 'jumlah' => $item['jumlah']];
        }

        $golongan_darah_data = Penduduk::select('golongan_darah')
            ->where('status_hidup', 'hidup')->whereNotNull('golongan_darah')->groupBy('golongan_darah')
            ->selectRaw('golongan_darah as label, COUNT(*) as jumlah')->get()->toArray();
        $golongan_darah = [];
        foreach ($golongan_darah_data as $item) {
            if (!empty($item['label'])) $golongan_darah[] = ['label' => $item['label'], 'jumlah' => $item['jumlah']];
        }

        $wilayah_data = Penduduk::select('wilayah.dusun')
            ->join('wilayah', 'penduduk.wilayah_id', '=', 'wilayah.id')
            ->where('penduduk.status_hidup', 'hidup')->whereNotNull('wilayah.dusun')
            ->groupBy('wilayah.dusun')
            ->selectRaw('wilayah.dusun as label, COUNT(*) as jumlah')
            ->orderByRaw('jumlah DESC')->get()->toArray();
        $wilayah = [];
        foreach ($wilayah_data as $item) {
            if (!empty($item['label'])) $wilayah[] = ['label' => $item['label'], 'jumlah' => $item['jumlah']];
        }

        $data = [
            'total_penduduk'  => $total_penduduk,
            'laki_laki'       => $laki_laki,
            'perempuan'       => $perempuan,
            'kepala_keluarga' => $kepala_keluarga,
            'rt'              => $rt,
            'rw'              => $rw,
            'usia'            => compact('balita', 'remaja', 'dewasa', 'lansia'),
            'pendidikan'      => $pendidikan,
            'pekerjaan'       => $pekerjaan,
            'agama'           => $agama,
            'golongan_darah'  => $golongan_darah,
            'wilayah'         => $wilayah,
        ];

        return view('admin.statistik.kependudukan', compact('data'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    public function laporanBulanan(Request $request) {
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

        $total_penduduk = Penduduk::where('status_hidup', 'hidup')->count();

        $lahir = Penduduk::whereYear('tanggal_lahir', $year)
            ->whereMonth('tanggal_lahir', $month)
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $created  = Penduduk::whereBetween('created_at', [$start, $end])->count();
        $datang   = max(0, $created - $lahir);

        $meninggal = Penduduk::where('status_hidup', 'meninggal')
            ->whereBetween('updated_at', [$start, $end])->count();

        $pindah = 0;

        $mutasi = compact('lahir', 'meninggal', 'datang', 'pindah');

        $makePercent = fn($count) => ($total_penduduk > 0 ? '+' . round($count / $total_penduduk * 100, 2) : '+0') . '%';

        $laporan = [
            ['kategori' => 'Kelahiran',  'jumlah' => $lahir,     'persen' => $makePercent($lahir)],
            ['kategori' => 'Kematian',   'jumlah' => $meninggal, 'persen' => $makePercent($meninggal)],
            ['kategori' => 'Pendatang',  'jumlah' => $datang,    'persen' => $makePercent($datang)],
            ['kategori' => 'Pindah',     'jumlah' => $pindah,    'persen' => $makePercent($pindah)],
        ];

        $data = [
            'bulan'          => $start->translatedFormat('F Y'),
            'total_penduduk' => $total_penduduk,
            'mutasi'         => $mutasi,
            'laporan'        => $laporan,
        ];

        return view('admin.statistik.laporan-bulanan', compact('data'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    /**
     * Laporan Kelompok Rentan
     * Mengacu pada kategori kelompok rentan OpenSID:
     * Balita · Anak-anak · Remaja · Lansia · Perempuan Usia Subur
     * Janda/Duda · Cerai Hidup · Dewasa Muda Lajang
     */
    public function kelompokRentan(Request $request) {
        // ── Filter wilayah (opsional) ─────────────────────────────────────
        $wilayahId = $request->get('wilayah_id');

        $base = Penduduk::where('status_hidup', 'hidup');
        if ($wilayahId) {
            $base->where('wilayah_id', $wilayahId);
        }

        $total_penduduk = (clone $base)->count();

        // ── Balita 0–5 ───────────────────────────────────────────────────
        $balitaL = (clone $base)->where('jenis_kelamin', 'L')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 5')->count();
        $balitaP = (clone $base)->where('jenis_kelamin', 'P')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 5')->count();
        $balita  = $balitaL + $balitaP;

        // ── Anak-anak 6–12 ───────────────────────────────────────────────
        $anakL = (clone $base)->where('jenis_kelamin', 'L')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 6 AND 12')->count();
        $anakP = (clone $base)->where('jenis_kelamin', 'P')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 6 AND 12')->count();
        $anak  = $anakL + $anakP;

        // ── Remaja 13–17 ─────────────────────────────────────────────────
        $remajaL = (clone $base)->where('jenis_kelamin', 'L')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 13 AND 17')->count();
        $remajaP = (clone $base)->where('jenis_kelamin', 'P')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 13 AND 17')->count();
        $remaja  = $remajaL + $remajaP;

        // ── Lansia 60+ ───────────────────────────────────────────────────
        $lansiaL = (clone $base)->where('jenis_kelamin', 'L')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60')->count();
        $lansiaP = (clone $base)->where('jenis_kelamin', 'P')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60')->count();
        $lansia  = $lansiaL + $lansiaP;

        // ── Perempuan Usia Subur (PUS) 15–49 ─────────────────────────────
        $pusP = (clone $base)->where('jenis_kelamin', 'P')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 15 AND 49')->count();
        $pus  = $pusP;

        // ── Janda / Duda (cerai mati) ─────────────────────────────────────
        $janda = (clone $base)->where('jenis_kelamin', 'P')->where('status_kawin', 'Cerai Mati')->count();
        $duda  = (clone $base)->where('jenis_kelamin', 'L')->where('status_kawin', 'Cerai Mati')->count();
        $jandaDuda = $janda + $duda;

        // ── Cerai Hidup ───────────────────────────────────────────────────
        // Nilai 'Cerai Hidup' belum ditemukan di DB saat ini, query tetap disiapkan
        $ceraiHidupP = (clone $base)->where('jenis_kelamin', 'P')->where('status_kawin', 'Cerai Hidup')->count();
        $ceraiHidupL = (clone $base)->where('jenis_kelamin', 'L')->where('status_kawin', 'Cerai Hidup')->count();
        $ceraiHidup  = $ceraiHidupP + $ceraiHidupL;

        // ── Dewasa Muda Lajang 18–30 ──────────────────────────────────────
        $dewasaMudaL = (clone $base)->where('jenis_kelamin', 'L')->where('status_kawin', 'Belum Kawin')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 30')->count();
        $dewasaMudaP = (clone $base)->where('jenis_kelamin', 'P')->where('status_kawin', 'Belum Kawin')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 30')->count();
        $dewasaMuda  = $dewasaMudaL + $dewasaMudaP;

        // ── Helper persentase ─────────────────────────────────────────────
        $pct = fn($n) => $total_penduduk > 0 ? round($n / $total_penduduk * 100, 1) : 0;

        // ── Struktur array kelompok rentan ────────────────────────────────
        $kelompokRentan = [
            [
                'nama' => 'Balita',
                'deskripsi' => 'Usia 0 – 5 tahun',
                'icon' => 'baby',
                'color' => 'rose',
                'total' => $balita,
                'laki' => $balitaL,
                'perempuan' => $balitaP,
                'persen' => $pct($balita),
            ],
            [
                'nama' => 'Anak-anak',
                'deskripsi' => 'Usia 6 – 12 tahun',
                'icon' => 'child',
                'color' => 'orange',
                'total' => $anak,
                'laki' => $anakL,
                'perempuan' => $anakP,
                'persen' => $pct($anak),
            ],
            [
                'nama' => 'Remaja',
                'deskripsi' => 'Usia 13 – 17 tahun',
                'icon' => 'teen',
                'color' => 'amber',
                'total' => $remaja,
                'laki' => $remajaL,
                'perempuan' => $remajaP,
                'persen' => $pct($remaja),
            ],
            [
                'nama' => 'Lansia',
                'deskripsi' => 'Usia 60 tahun ke atas',
                'icon' => 'elder',
                'color' => 'purple',
                'total' => $lansia,
                'laki' => $lansiaL,
                'perempuan' => $lansiaP,
                'persen' => $pct($lansia),
            ],
            [
                'nama' => 'Perempuan Usia Subur',
                'deskripsi' => 'Perempuan usia 15 – 49 tahun',
                'icon' => 'woman',
                'color' => 'pink',
                'total' => $pus,
                'laki' => 0,
                'perempuan' => $pusP,
                'persen' => $pct($pus),
            ],
            [
                'nama' => 'Janda / Duda',
                'deskripsi' => 'Status kawin: cerai mati',
                'icon' => 'alone',
                'color' => 'slate',
                'total' => $jandaDuda,
                'laki' => $duda,
                'perempuan' => $janda,
                'persen' => $pct($jandaDuda),
            ],
            [
                'nama' => 'Cerai Hidup',
                'deskripsi' => 'Status kawin: cerai hidup',
                'icon' => 'split',
                'color' => 'cyan',
                'total' => $ceraiHidup,
                'laki' => $ceraiHidupL,
                'perempuan' => $ceraiHidupP,
                'persen' => $pct($ceraiHidup),
            ],
            [
                'nama' => 'Dewasa Muda Lajang',
                'deskripsi' => 'Usia 18–30 belum menikah',
                'icon' => 'youth',
                'color' => 'teal',
                'total' => $dewasaMuda,
                'laki' => $dewasaMudaL,
                'perempuan' => $dewasaMudaP,
                'persen' => $pct($dewasaMuda),
            ],
        ];

        // ── Distribusi per wilayah (top 10 konsentrasi tertinggi) ─────────
        $distribusiWilayah = Penduduk::selectRaw('
                wilayah.dusun,
                wilayah.rt,
                wilayah.rw,
                COUNT(*) as total,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, penduduk.tanggal_lahir, CURDATE()) BETWEEN 0 AND 5  THEN 1 ELSE 0 END) as balita,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, penduduk.tanggal_lahir, CURDATE()) >= 60            THEN 1 ELSE 0 END) as lansia,
                SUM(CASE WHEN penduduk.status_kawin = "cerai_mati"                                    THEN 1 ELSE 0 END) as janda_duda
            ')
            ->join('wilayah', 'penduduk.wilayah_id', '=', 'wilayah.id')
            ->where('penduduk.status_hidup', 'hidup')
            ->when($wilayahId, fn($q) => $q->where('penduduk.wilayah_id', $wilayahId))
            ->groupBy('wilayah.dusun', 'wilayah.rt', 'wilayah.rw')
            ->orderByRaw('(balita + lansia + janda_duda) DESC')
            ->limit(10)
            ->get();

        // ── List wilayah untuk dropdown filter ───────────────────────────
        $wilayahList = Wilayah::orderBy('dusun')->orderBy('rw')->orderBy('rt')->get();

        $totalRentan = $balita + $anak + $remaja + $lansia + $pus + $jandaDuda + $ceraiHidup;

        $data = [
            'total_penduduk'    => $total_penduduk,
            'kelompokRentan'    => $kelompokRentan,
            'distribusiWilayah' => $distribusiWilayah,
            'totalRentan'       => $totalRentan,
            'wilayahList'       => $wilayahList,
            'wilayahId'         => $wilayahId,
        ];

        return view('admin.statistik.kelompok-rentan', compact('data'));
    }
}
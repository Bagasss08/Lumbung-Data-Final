<?php

namespace App\Http\Controllers\Admin\statistik;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller {
    public function index() {
        $penduduks = Penduduk::where('status_hidup', 'hidup')
            ->select('tanggal_lahir', 'jenis_kelamin')->get();

        $total_penduduk = Penduduk::where('status_hidup', 'hidup')->count();
        $laki_laki = Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'L')->count();
        $perempuan = Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'P')->count();

        $usia = ['0_5' => 0, '6_17' => 0, '18_59' => 0, '60_plus' => 0];
        foreach ($penduduks as $p) {
            if (!$p->tanggal_lahir) continue;
            try {
                $age = Carbon::parse($p->tanggal_lahir)->age;
            } catch (\Exception $e) {
                continue;
            }
            if ($age <= 5) $usia['0_5']++;
            elseif ($age >= 6 && $age <= 17) $usia['6_17']++;
            elseif ($age >= 18 && $age <= 59) $usia['18_59']++;
            else $usia['60_plus']++;
        }

        $pendidikan_data = DB::table('penduduk')
            ->join('ref_pendidikan', 'penduduk.pendidikan_kk_id', '=', 'ref_pendidikan.id')
            ->where('penduduk.status_hidup', 'hidup')->whereNull('penduduk.deleted_at')
            ->groupBy('ref_pendidikan.nama')
            ->selectRaw('ref_pendidikan.nama as label, COUNT(*) as jumlah')
            ->orderByRaw('jumlah DESC')->get()->toArray();
        $pendidikan = [];
        foreach ($pendidikan_data as $item) {
            if (!empty($item->label)) $pendidikan[] = ['label' => ucfirst($item->label), 'jumlah' => (int)$item->jumlah];
        }

        $pekerjaan_data = DB::table('penduduk')
            ->join('ref_pekerjaan', 'penduduk.pekerjaan_id', '=', 'ref_pekerjaan.id')
            ->where('penduduk.status_hidup', 'hidup')->whereNull('penduduk.deleted_at')
            ->groupBy('ref_pekerjaan.nama')
            ->selectRaw('ref_pekerjaan.nama as label, COUNT(*) as jumlah')
            ->orderByRaw('jumlah DESC')->get()->toArray();
        $pekerjaan = [];
        foreach ($pekerjaan_data as $item) {
            if (!empty($item->label)) $pekerjaan[] = ['label' => ucfirst($item->label), 'jumlah' => (int)$item->jumlah];
        }

        $status_nikah_data = DB::table('penduduk')
            ->join('ref_status_kawin', 'penduduk.status_kawin_id', '=', 'ref_status_kawin.id')
            ->where('penduduk.status_hidup', 'hidup')->whereNull('penduduk.deleted_at')
            ->groupBy('ref_status_kawin.nama')
            ->selectRaw('ref_status_kawin.nama as label, COUNT(*) as jumlah')
            ->orderByRaw('jumlah DESC')->get()->toArray();
        $status_perkawinan = [];
        foreach ($status_nikah_data as $item) {
            if (!empty($item->label)) $status_perkawinan[] = ['label' => ucfirst($item->label), 'jumlah' => (int)$item->jumlah];
        }

        $data = [
            'total_penduduk'    => (int)$total_penduduk,
            'laki_laki'         => (int)$laki_laki,
            'perempuan'         => (int)$perempuan,
            'kepala_keluarga'   => Keluarga::count(),
            'rt'                => Wilayah::whereNotNull('rt')->where('rt', '!=', '')->distinct('rt')->count('rt'),
            'rw'                => Wilayah::whereNotNull('rw')->where('rw', '!=', '')->distinct('rw')->count('rw'),
            'usia'              => $usia,
            'pendidikan'        => $pendidikan,
            'pekerjaan'         => $pekerjaan,
            'status_perkawinan' => $status_perkawinan,
        ];

        return view('admin.statistik.statistik', compact('data'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    public function penduduk() {
        $penduduk = Penduduk::with(['keluarga', 'agama', 'pendidikanKk', 'pekerjaan', 'statusKawin'])
            ->where('status_hidup', 'hidup')
            ->when(request('search'), fn($q, $s) => $q->where('nama', 'like', "%$s%")->orWhere('nik', 'like', "%$s%"))
            ->when(request('jenis_kelamin'), fn($q, $jk) => $q->where('jenis_kelamin', $jk))
            ->when(request('agama'), fn($q, $a) => $q->whereHas('agama', fn($r) => $r->where('nama', $a)))
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
    public function kependudukan(Request $request) {
        $dusunFilter = $request->get('dusun');
        $kategori    = $request->get('kategori', 'pendidikan');

        // Base query helper
        $base = fn() => DB::table('penduduk')
            ->where('penduduk.status_hidup', 'hidup')
            ->whereNull('penduduk.deleted_at')
            ->when($dusunFilter, function ($q) use ($dusunFilter) {
                $q->join('wilayah as w_filter', 'penduduk.wilayah_id', '=', 'w_filter.id')
                    ->where('w_filter.dusun', $dusunFilter);
            });

        $total_penduduk  = $base()->count();
        $laki_laki       = $base()->where('penduduk.jenis_kelamin', 'L')->count();
        $perempuan       = $base()->where('penduduk.jenis_kelamin', 'P')->count();
        $kepala_keluarga = Keluarga::count();
        $rt = Wilayah::whereNotNull('rt')->where('rt', '!=', '')->distinct('rt')->count('rt');
        $rw = Wilayah::whereNotNull('rw')->where('rw', '!=', '')->distinct('rw')->count('rw');

        // Helper buat tabel breakdown L/P
        $makeTable = function (array $rows, int $total): array {
            $result = [];
            foreach ($rows as $item) {
                $label = !empty($item->label) ? ucfirst($item->label) : '(Tidak Diisi)';
                $tot = (int)$item->total;
                $l   = (int)$item->laki;
                $p   = (int)$item->perempuan;
                $result[] = [
                    'label'            => $label,
                    'total'            => $tot,
                    'laki'             => $l,
                    'perempuan'        => $p,
                    'persen'           => $total > 0 ? round($tot / $total * 100, 2) : 0,
                    'persen_laki'      => $total > 0 ? round($l / $total * 100, 2)   : 0,
                    'persen_perempuan' => $total > 0 ? round($p / $total * 100, 2)   : 0,
                ];
            }
            return $result;
        };

        // ── USIA ──────────────────────────────────────────────────────────
        $rentangUsia = [
            ['label' => 'Balita (0–4 th)',  'min' => 0,  'max' => 4],
            ['label' => 'Anak (5–12 th)',   'min' => 5,  'max' => 12],
            ['label' => 'Remaja (13–17 th)', 'min' => 13, 'max' => 17],
            ['label' => 'Dewasa (18–59 th)', 'min' => 18, 'max' => 59],
            ['label' => 'Lansia (60+ th)',  'min' => 60, 'max' => 999],
        ];
        $usia_rows = [];
        foreach ($rentangUsia as $r) {
            $q = $base();
            if ($r['max'] < 999) $q->whereRaw("TIMESTAMPDIFF(YEAR,penduduk.tanggal_lahir,CURDATE()) BETWEEN {$r['min']} AND {$r['max']}");
            else               $q->whereRaw("TIMESTAMPDIFF(YEAR,penduduk.tanggal_lahir,CURDATE()) >= {$r['min']}");
            $tot = $q->count();
            $l   = (clone $q)->where('penduduk.jenis_kelamin', 'L')->count();
            $p   = (clone $q)->where('penduduk.jenis_kelamin', 'P')->count();
            $usia_rows[] = (object)['label' => $r['label'], 'total' => $tot, 'laki' => $l, 'perempuan' => $p];
        }
        $usia = $makeTable($usia_rows, $total_penduduk);

        // ── PENDIDIKAN ────────────────────────────────────────────────────
        $pendidikan = $makeTable(
            $base()->leftJoin('ref_pendidikan', 'penduduk.pendidikan_kk_id', '=', 'ref_pendidikan.id')
                ->groupBy('ref_pendidikan.nama')
                ->selectRaw('ref_pendidikan.nama as label,
                    COUNT(*) as total,
                    SUM(CASE WHEN penduduk.jenis_kelamin="L" THEN 1 ELSE 0 END) as laki,
                    SUM(CASE WHEN penduduk.jenis_kelamin="P" THEN 1 ELSE 0 END) as perempuan')
                ->orderByRaw('total DESC')->get()->toArray(),
            $total_penduduk
        );

        // ── PEKERJAAN ─────────────────────────────────────────────────────
        $pekerjaan = $makeTable(
            $base()->leftJoin('ref_pekerjaan', 'penduduk.pekerjaan_id', '=', 'ref_pekerjaan.id')
                ->groupBy('ref_pekerjaan.nama')
                ->selectRaw('ref_pekerjaan.nama as label,
                    COUNT(*) as total,
                    SUM(CASE WHEN penduduk.jenis_kelamin="L" THEN 1 ELSE 0 END) as laki,
                    SUM(CASE WHEN penduduk.jenis_kelamin="P" THEN 1 ELSE 0 END) as perempuan')
                ->orderByRaw('total DESC')->get()->toArray(),
            $total_penduduk
        );

        // ── AGAMA ─────────────────────────────────────────────────────────
        $agama = $makeTable(
            $base()->leftJoin('ref_agama', 'penduduk.agama_id', '=', 'ref_agama.id')
                ->groupBy('ref_agama.nama')
                ->selectRaw('ref_agama.nama as label,
                    COUNT(*) as total,
                    SUM(CASE WHEN penduduk.jenis_kelamin="L" THEN 1 ELSE 0 END) as laki,
                    SUM(CASE WHEN penduduk.jenis_kelamin="P" THEN 1 ELSE 0 END) as perempuan')
                ->orderByRaw('total DESC')->get()->toArray(),
            $total_penduduk
        );

        // ── GOLONGAN DARAH ────────────────────────────────────────────────
        $golongan_darah = $makeTable(
            $base()->leftJoin('ref_golongan_darah', 'penduduk.golongan_darah_id', '=', 'ref_golongan_darah.id')
                ->groupBy('ref_golongan_darah.nama')
                ->selectRaw('ref_golongan_darah.nama as label,
                    COUNT(*) as total,
                    SUM(CASE WHEN penduduk.jenis_kelamin="L" THEN 1 ELSE 0 END) as laki,
                    SUM(CASE WHEN penduduk.jenis_kelamin="P" THEN 1 ELSE 0 END) as perempuan')
                ->orderByRaw('total DESC')->get()->toArray(),
            $total_penduduk
        );

        // ── STATUS KAWIN ──────────────────────────────────────────────────
        $status_kawin = $makeTable(
            $base()->leftJoin('ref_status_kawin', 'penduduk.status_kawin_id', '=', 'ref_status_kawin.id')
                ->groupBy('ref_status_kawin.nama')
                ->selectRaw('ref_status_kawin.nama as label,
                    COUNT(*) as total,
                    SUM(CASE WHEN penduduk.jenis_kelamin="L" THEN 1 ELSE 0 END) as laki,
                    SUM(CASE WHEN penduduk.jenis_kelamin="P" THEN 1 ELSE 0 END) as perempuan')
                ->orderByRaw('total DESC')->get()->toArray(),
            $total_penduduk
        );

        // ── JENIS KELAMIN ─────────────────────────────────────────────────
        $jenis_kelamin = [
            [
                'label' => 'Laki-laki',
                'total' => $laki_laki,
                'laki' => $laki_laki,
                'perempuan' => 0,
                'persen' => $total_penduduk > 0 ? round($laki_laki / $total_penduduk * 100, 2) : 0,
                'persen_laki' => $total_penduduk > 0 ? round($laki_laki / $total_penduduk * 100, 2) : 0,
                'persen_perempuan' => 0
            ],
            [
                'label' => 'Perempuan',
                'total' => $perempuan,
                'laki' => 0,
                'perempuan' => $perempuan,
                'persen' => $total_penduduk > 0 ? round($perempuan / $total_penduduk * 100, 2) : 0,
                'persen_laki' => 0,
                'persen_perempuan' => $total_penduduk > 0 ? round($perempuan / $total_penduduk * 100, 2) : 0
            ],
        ];

        // ── WILAYAH ───────────────────────────────────────────────────────
        $wilayah = $makeTable(
            DB::table('penduduk')
                ->join('wilayah', 'penduduk.wilayah_id', '=', 'wilayah.id')
                ->where('penduduk.status_hidup', 'hidup')->whereNull('penduduk.deleted_at')
                ->whereNotNull('wilayah.dusun')
                ->when($dusunFilter, fn($q) => $q->where('wilayah.dusun', $dusunFilter))
                ->groupBy('wilayah.dusun')
                ->selectRaw('wilayah.dusun as label,
                    COUNT(*) as total,
                    SUM(CASE WHEN penduduk.jenis_kelamin="L" THEN 1 ELSE 0 END) as laki,
                    SUM(CASE WHEN penduduk.jenis_kelamin="P" THEN 1 ELSE 0 END) as perempuan')
                ->orderByRaw('total DESC')->get()->toArray(),
            $total_penduduk
        );

        // ── Daftar dusun ──────────────────────────────────────────────────
        $dusunList = Wilayah::whereNotNull('dusun')->where('dusun', '!=', '')
            ->distinct()->orderBy('dusun')->pluck('dusun');

        // ── Daftar perangkat untuk modal cetak/unduh ──────────────────────
        $perangkatList = DB::table('perangkat_desa')
            ->leftJoin('jabatan_perangkat', 'perangkat_desa.jabatan_id', '=', 'jabatan_perangkat.id')
            ->select('perangkat_desa.nama', 'jabatan_perangkat.nama as jabatan')
            ->whereNull('perangkat_desa.deleted_at')
            ->orderBy('perangkat_desa.urutan')
            ->get();

        // Jika tabel perangkat_desa kosong, gunakan identitas_desa sebagai fallback
        if ($perangkatList->isEmpty()) {
            $identitas = DB::table('identitas_desa')->first();
            $namaKades = $identitas->kepala_desa ?? ($identitas->nama_kepala_desa ?? 'Kepala Desa');
            $perangkatList = collect([(object)['nama' => $namaKades, 'jabatan' => 'Kepala Desa']]);
        }

        $data = [
            'total_penduduk'  => $total_penduduk,
            'laki_laki'       => $laki_laki,
            'perempuan'       => $perempuan,
            'kepala_keluarga' => $kepala_keluarga,
            'rt'              => $rt,
            'rw'              => $rw,
            'usia'            => $usia,
            'pendidikan'      => $pendidikan,
            'pekerjaan'       => $pekerjaan,
            'agama'           => $agama,
            'golongan_darah'  => $golongan_darah,
            'status_kawin'    => $status_kawin,
            'jenis_kelamin'   => $jenis_kelamin,
            'wilayah'         => $wilayah,
            'dusunList'       => $dusunList,
            'dusunFilter'     => $dusunFilter,
            'kategori'        => $kategori,
            'perangkatList'   => $perangkatList,
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
                $start = Carbon::createFromDate((int)$year, (int)$month, 1)->startOfDay();
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
        $lahir   = Penduduk::whereYear('tanggal_lahir', $year)->whereMonth('tanggal_lahir', $month)->whereBetween('created_at', [$start, $end])->count();
        $created = Penduduk::whereBetween('created_at', [$start, $end])->count();
        $datang  = max(0, $created - $lahir);
        $meninggal = Penduduk::where('status_hidup', 'meninggal')->whereBetween('updated_at', [$start, $end])->count();
        $pindah  = 0;
        $mutasi  = compact('lahir', 'meninggal', 'datang', 'pindah');

        $makePercent = fn($count) => ($total_penduduk > 0 ? '+' . round($count / $total_penduduk * 100, 2) : '+0') . '%';
        $laporan = [
            ['kategori' => 'Kelahiran', 'jumlah' => $lahir,    'persen' => $makePercent($lahir)],
            ['kategori' => 'Kematian', 'jumlah' => $meninggal, 'persen' => $makePercent($meninggal)],
            ['kategori' => 'Pendatang', 'jumlah' => $datang,   'persen' => $makePercent($datang)],
            ['kategori' => 'Pindah',   'jumlah' => $pindah,   'persen' => $makePercent($pindah)],
        ];

        $data = ['bulan' => $start->translatedFormat('F Y'), 'total_penduduk' => $total_penduduk, 'mutasi' => $mutasi, 'laporan' => $laporan];
        return view('admin.statistik.laporan-bulanan', compact('data'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    public function kelompokRentan(Request $request) {
        $wilayahId = $request->get('wilayah_id');
        $base = Penduduk::where('status_hidup', 'hidup');
        if ($wilayahId) $base->where('wilayah_id', $wilayahId);
        $total_penduduk = (clone $base)->count();

        $balitaL = (clone $base)->where('jenis_kelamin', 'L')->whereRaw('TIMESTAMPDIFF(YEAR,tanggal_lahir,CURDATE()) BETWEEN 0 AND 5')->count();
        $balitaP = (clone $base)->where('jenis_kelamin', 'P')->whereRaw('TIMESTAMPDIFF(YEAR,tanggal_lahir,CURDATE()) BETWEEN 0 AND 5')->count();
        $balita = $balitaL + $balitaP;

        $anakL = (clone $base)->where('jenis_kelamin', 'L')->whereRaw('TIMESTAMPDIFF(YEAR,tanggal_lahir,CURDATE()) BETWEEN 6 AND 12')->count();
        $anakP = (clone $base)->where('jenis_kelamin', 'P')->whereRaw('TIMESTAMPDIFF(YEAR,tanggal_lahir,CURDATE()) BETWEEN 6 AND 12')->count();
        $anak = $anakL + $anakP;

        $remajaL = (clone $base)->where('jenis_kelamin', 'L')->whereRaw('TIMESTAMPDIFF(YEAR,tanggal_lahir,CURDATE()) BETWEEN 13 AND 17')->count();
        $remajaP = (clone $base)->where('jenis_kelamin', 'P')->whereRaw('TIMESTAMPDIFF(YEAR,tanggal_lahir,CURDATE()) BETWEEN 13 AND 17')->count();
        $remaja = $remajaL + $remajaP;

        $lansiaL = (clone $base)->where('jenis_kelamin', 'L')->whereRaw('TIMESTAMPDIFF(YEAR,tanggal_lahir,CURDATE()) >= 60')->count();
        $lansiaP = (clone $base)->where('jenis_kelamin', 'P')->whereRaw('TIMESTAMPDIFF(YEAR,tanggal_lahir,CURDATE()) >= 60')->count();
        $lansia = $lansiaL + $lansiaP;

        $pusP = (clone $base)->where('jenis_kelamin', 'P')->whereRaw('TIMESTAMPDIFF(YEAR,tanggal_lahir,CURDATE()) BETWEEN 15 AND 49')->count();
        $pus = $pusP;

        $janda = (clone $base)->where('jenis_kelamin', 'P')->whereHas('statusKawin', fn($q) => $q->whereRaw('LOWER(nama) LIKE ?', ['%cerai mati%']))->count();
        $duda = (clone $base)->where('jenis_kelamin', 'L')->whereHas('statusKawin', fn($q) => $q->whereRaw('LOWER(nama) LIKE ?', ['%cerai mati%']))->count();
        $jandaDuda = $janda + $duda;

        $ceraiHidupP = (clone $base)->where('jenis_kelamin', 'P')->whereHas('statusKawin', fn($q) => $q->whereRaw('LOWER(nama) LIKE ?', ['%cerai hidup%']))->count();
        $ceraiHidupL = (clone $base)->where('jenis_kelamin', 'L')->whereHas('statusKawin', fn($q) => $q->whereRaw('LOWER(nama) LIKE ?', ['%cerai hidup%']))->count();
        $ceraiHidup = $ceraiHidupP + $ceraiHidupL;

        $dewasaMudaL = (clone $base)->where('jenis_kelamin', 'L')->whereHas('statusKawin', fn($q) => $q->whereRaw('LOWER(nama) LIKE ?', ['%belum kawin%']))->whereRaw('TIMESTAMPDIFF(YEAR,tanggal_lahir,CURDATE()) BETWEEN 18 AND 30')->count();
        $dewasaMudaP = (clone $base)->where('jenis_kelamin', 'P')->whereHas('statusKawin', fn($q) => $q->whereRaw('LOWER(nama) LIKE ?', ['%belum kawin%']))->whereRaw('TIMESTAMPDIFF(YEAR,tanggal_lahir,CURDATE()) BETWEEN 18 AND 30')->count();
        $dewasaMuda = $dewasaMudaL + $dewasaMudaP;

        $pct = fn($n) => $total_penduduk > 0 ? round($n / $total_penduduk * 100, 1) : 0;

        $kelompokRentan = [
            ['nama' => 'Balita',             'deskripsi' => 'Usia 0–5 tahun',            'icon' => 'baby', 'color' => 'rose',  'total' => $balita,    'laki' => $balitaL,    'perempuan' => $balitaP,    'persen' => $pct($balita)],
            ['nama' => 'Anak-anak',          'deskripsi' => 'Usia 6–12 tahun',           'icon' => 'child', 'color' => 'orange', 'total' => $anak,      'laki' => $anakL,      'perempuan' => $anakP,      'persen' => $pct($anak)],
            ['nama' => 'Remaja',             'deskripsi' => 'Usia 13–17 tahun',          'icon' => 'teen', 'color' => 'amber', 'total' => $remaja,    'laki' => $remajaL,    'perempuan' => $remajaP,    'persen' => $pct($remaja)],
            ['nama' => 'Lansia',             'deskripsi' => 'Usia 60 tahun ke atas',     'icon' => 'elder', 'color' => 'purple', 'total' => $lansia,    'laki' => $lansiaL,    'perempuan' => $lansiaP,    'persen' => $pct($lansia)],
            ['nama' => 'Perempuan Usia Subur', 'deskripsi' => 'Perempuan usia 15–49',     'icon' => 'woman', 'color' => 'pink',  'total' => $pus,       'laki' => 0,           'perempuan' => $pusP,       'persen' => $pct($pus)],
            ['nama' => 'Janda / Duda',       'deskripsi' => 'Status kawin: cerai mati',  'icon' => 'alone', 'color' => 'slate', 'total' => $jandaDuda, 'laki' => $duda,       'perempuan' => $janda,      'persen' => $pct($jandaDuda)],
            ['nama' => 'Cerai Hidup',        'deskripsi' => 'Status kawin: cerai hidup', 'icon' => 'split', 'color' => 'cyan',  'total' => $ceraiHidup, 'laki' => $ceraiHidupL, 'perempuan' => $ceraiHidupP, 'persen' => $pct($ceraiHidup)],
            ['nama' => 'Dewasa Muda Lajang', 'deskripsi' => 'Usia 18–30 belum menikah', 'icon' => 'youth', 'color' => 'teal',  'total' => $dewasaMuda, 'laki' => $dewasaMudaL, 'perempuan' => $dewasaMudaP, 'persen' => $pct($dewasaMuda)],
        ];

        $distribusiWilayah = DB::table('penduduk')
            ->join('wilayah', 'penduduk.wilayah_id', '=', 'wilayah.id')
            ->where('penduduk.status_hidup', 'hidup')->whereNull('penduduk.deleted_at')
            ->when($wilayahId, fn($q) => $q->where('penduduk.wilayah_id', $wilayahId))
            ->selectRaw('wilayah.dusun,wilayah.rt,wilayah.rw,COUNT(*) as total,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR,penduduk.tanggal_lahir,CURDATE()) BETWEEN 0 AND 5 THEN 1 ELSE 0 END) as balita,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR,penduduk.tanggal_lahir,CURDATE()) >= 60 THEN 1 ELSE 0 END) as lansia')
            ->groupBy('wilayah.dusun', 'wilayah.rt', 'wilayah.rw')
            ->orderByRaw('(balita+lansia) DESC')->limit(10)->get();

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

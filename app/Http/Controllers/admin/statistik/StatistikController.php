<?php

namespace App\Http\Controllers\Admin\statistik;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\Wilayah;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function index()
    {
        // Ambil data penduduk hidup (untuk perhitungan usia dan agregasi lainnya)
        $penduduks = Penduduk::where('status_hidup', 'hidup')
            ->select('tanggal_lahir', 'jenis_kelamin', 'pendidikan', 'pekerjaan', 'status_perkawinan')
            ->get();

        // Total & gender menggunakan query Eloquent langsung (DB menyimpan 'L' untuk laki, 'P' untuk perempuan)
        $total_penduduk = Penduduk::where('status_hidup', 'hidup')->count();
        $laki_laki = Penduduk::where('status_hidup', 'hidup')
            ->where('jenis_kelamin', 'L')
            ->count();
        $perempuan = Penduduk::where('status_hidup', 'hidup')
            ->where('jenis_kelamin', 'P')
            ->count();

        // Kelompok umur menggunakan Carbon
        $usia = [
            '0_5' => 0,    // 0-5
            '6_17' => 0,   // 6-17
            '18_59' => 0,  // 18-59
            '60_plus' => 0 // 60+
        ];

        foreach ($penduduks as $p) {
            if (!$p->tanggal_lahir) {
                continue;
            }
            try {
                $age = Carbon::parse($p->tanggal_lahir)->age;
            } catch (\Exception $e) {
                continue;
            }

            if ($age <= 5) {
                $usia['0_5']++;
            } elseif ($age >= 6 && $age <= 17) {
                $usia['6_17']++;
            } elseif ($age >= 18 && $age <= 59) {
                $usia['18_59']++;
            } else {
                $usia['60_plus']++;
            }
        }

        // Pendidikan (aggregasi)
        $pendidikan_data = Penduduk::where('status_hidup', 'hidup')
            ->groupBy('pendidikan')
            ->selectRaw('pendidikan as label, COUNT(*) as jumlah')
            ->orderByRaw('jumlah DESC')
            ->get()
            ->toArray();

        $pendidikan = [];
        foreach ($pendidikan_data as $item) {
            if (isset($item['label']) && $item['label'] !== null && $item['label'] !== '') {
                $pendidikan[] = [
                    'label' => ucfirst($item['label']),
                    'jumlah' => (int) $item['jumlah']
                ];
            }
        }

        // Pekerjaan (aggregasi)
        $pekerjaan_data = Penduduk::where('status_hidup', 'hidup')
            ->groupBy('pekerjaan')
            ->selectRaw('pekerjaan as label, COUNT(*) as jumlah')
            ->orderByRaw('jumlah DESC')
            ->get()
            ->toArray();

        $pekerjaan = [];
        foreach ($pekerjaan_data as $item) {
            if (isset($item['label']) && $item['label'] !== null && $item['label'] !== '') {
                $pekerjaan[] = [
                    'label' => ucfirst($item['label']),
                    'jumlah' => (int) $item['jumlah']
                ];
            }
        }

        // Status Perkawinan (aggregasi)
        $status_nikah_data = Penduduk::where('status_hidup', 'hidup')
            ->groupBy('status_perkawinan')
            ->selectRaw('status_perkawinan as label, COUNT(*) as jumlah')
            ->orderByRaw('jumlah DESC')
            ->get()
            ->toArray();

        $status_perkawinan = [];
        foreach ($status_nikah_data as $item) {
            if (isset($item['label']) && $item['label'] !== null && $item['label'] !== '') {
                $status_perkawinan[] = [
                    'label' => ucfirst($item['label']),
                    'jumlah' => (int) $item['jumlah']
                ];
            }
        }

        $data = [
            'total_penduduk' => (int) $total_penduduk,
            'laki_laki' => (int) $laki_laki,
            'perempuan' => (int) $perempuan,
            'kepala_keluarga' => Keluarga::count(),
            'rt' => Wilayah::whereNotNull('rt')->where('rt', '!=', '')->distinct('rt')->count('rt'),
            'rw' => Wilayah::whereNotNull('rw')->where('rw', '!=', '')->distinct('rw')->count('rw'),
            'usia' => [
                '0_5' => $usia['0_5'],
                '6_17' => $usia['6_17'],
                '18_59' => $usia['18_59'],
                '60_plus' => $usia['60_plus'],
            ],
            'pendidikan' => $pendidikan,
            'pekerjaan' => $pekerjaan,
            'status_perkawinan' => $status_perkawinan,
        ];

        return view('admin.statistik.statistik', compact('data'));
    }

    public function penduduk()
    {
        // Get all population data with relationships for detailed report
        $penduduk = Penduduk::with(['keluargas'])
            ->where('status_hidup', 'hidup')
            ->orderBy('nama')
            ->paginate(50);

        // Statistics for summary cards
        $total_penduduk = Penduduk::where('status_hidup', 'hidup')->count();
        $laki_laki = Penduduk::where('status_hidup', 'hidup')
            ->where('jenis_kelamin', 'L')
            ->count();
        $perempuan = Penduduk::where('status_hidup', 'hidup')
            ->where('jenis_kelamin', 'P')
            ->count();
        $kepala_keluarga = Keluarga::count();

        $data = [
            'penduduk' => $penduduk,
            'total_penduduk' => $total_penduduk,
            'laki_laki' => $laki_laki,
            'perempuan' => $perempuan,
            'kepala_keluarga' => $kepala_keluarga,
        ];

        return view('admin.statistik.penduduk', compact('data'));
    }

    public function kependudukan()
    {
        // Total & Gender Statistics
        $total_penduduk = Penduduk::where('status_hidup', 'hidup')->count();
        $laki_laki = Penduduk::where('status_hidup', 'hidup')
            ->where('jenis_kelamin', 'L')
            ->count();
        $perempuan = Penduduk::where('status_hidup', 'hidup')
            ->where('jenis_kelamin', 'P')
            ->count();

        // Kepala Keluarga (head of family)
        $kepala_keluarga = Keluarga::count();

        // RT & RW count (distinct values)
        $rt = Wilayah::whereNotNull('rt')
            ->where('rt', '!=', '')
            ->distinct('rt')
            ->count('rt');
        $rw = Wilayah::whereNotNull('rw')
            ->where('rw', '!=', '')
            ->distinct('rw')
            ->count('rw');

        // Age Distribution
        $today = Carbon::now();
        $balita = Penduduk::where('status_hidup', 'hidup')
            ->whereRaw('YEAR(FROM_DAYS(DATEDIFF(now(),tanggal_lahir))) < 5')
            ->count();
        $remaja = Penduduk::where('status_hidup', 'hidup')
            ->whereRaw('YEAR(FROM_DAYS(DATEDIFF(now(),tanggal_lahir))) BETWEEN 5 AND 18')
            ->count();
        $dewasa = Penduduk::where('status_hidup', 'hidup')
            ->whereRaw('YEAR(FROM_DAYS(DATEDIFF(now(),tanggal_lahir))) BETWEEN 19 AND 59')
            ->count();
        $lansia = Penduduk::where('status_hidup', 'hidup')
            ->whereRaw('YEAR(FROM_DAYS(DATEDIFF(now(),tanggal_lahir))) >= 60')
            ->count();

        // Education Level
        $pendidikan_data = Penduduk::select('pendidikan')
            ->where('status_hidup', 'hidup')
            ->groupBy('pendidikan')
            ->selectRaw('pendidikan as label, COUNT(*) as jumlah')
            ->get()
            ->toArray();

        $pendidikan = [];
        foreach ($pendidikan_data as $item) {
            if ($item['label'] && $item['label'] !== '') {
                $pendidikan[] = [
                    'label' => ucfirst($item['label']),
                    'jumlah' => $item['jumlah']
                ];
            }
        }

        // Occupation
        $pekerjaan_data = Penduduk::select('pekerjaan')
            ->where('status_hidup', 'hidup')
            ->groupBy('pekerjaan')
            ->selectRaw('pekerjaan as label, COUNT(*) as jumlah')
            ->get()
            ->toArray();

        $pekerjaan = [];
        foreach ($pekerjaan_data as $item) {
            if ($item['label'] && $item['label'] !== '') {
                $pekerjaan[] = [
                    'label' => ucfirst($item['label']),
                    'jumlah' => $item['jumlah']
                ];
            }
        }

        // Religion
        $agama_data = Penduduk::select('agama')
            ->where('status_hidup', 'hidup')
            ->groupBy('agama')
            ->selectRaw('agama as label, COUNT(*) as jumlah')
            ->get()
            ->toArray();

        $agama = [];
        foreach ($agama_data as $item) {
            if ($item['label'] && $item['label'] !== '') {
                $agama[] = [
                    'label' => ucfirst($item['label']),
                    'jumlah' => $item['jumlah']
                ];
            }
        }

        // Blood Type (Golongan Darah)
        $golongan_darah_data = Penduduk::select('golongan_darah')
            ->where('status_hidup', 'hidup')
            ->whereNotNull('golongan_darah')
            ->groupBy('golongan_darah')
            ->selectRaw('golongan_darah as label, COUNT(*) as jumlah')
            ->get()
            ->toArray();

        $golongan_darah = [];
        foreach ($golongan_darah_data as $item) {
            if ($item['label'] && $item['label'] !== '') {
                $golongan_darah[] = [
                    'label' => $item['label'],
                    'jumlah' => $item['jumlah']
                ];
            }
        }

        // Wilayah/Dusun (Region/Hamlet)
        $wilayah_data = Penduduk::select('wilayah.dusun')
            ->join('wilayah', 'penduduk.wilayah_id', '=', 'wilayah.id')
            ->where('penduduk.status_hidup', 'hidup')
            ->whereNotNull('wilayah.dusun')
            ->groupBy('wilayah.dusun')
            ->selectRaw('wilayah.dusun as label, COUNT(*) as jumlah')
            ->orderByRaw('jumlah DESC')
            ->get()
            ->toArray();

        $wilayah = [];
        foreach ($wilayah_data as $item) {
            if ($item['label'] && $item['label'] !== '') {
                $wilayah[] = [
                    'label' => $item['label'],
                    'jumlah' => $item['jumlah']
                ];
            }
        }

        $data = [
            'total_penduduk'  => $total_penduduk,
            'laki_laki'       => $laki_laki,
            'perempuan'       => $perempuan,
            'kepala_keluarga' => $kepala_keluarga,
            'rt'              => $rt,
            'rw'              => $rw,
            'usia' => [
                'balita' => $balita,
                'remaja' => $remaja,
                'dewasa' => $dewasa,
                'lansia' => $lansia,
            ],
            'pendidikan' => $pendidikan,
            'pekerjaan' => $pekerjaan,
            'agama' => $agama,
            'golongan_darah' => $golongan_darah,
            'wilayah' => $wilayah,
        ];

        return view('admin.statistik.kependudukan', compact('data'));
    }

    public function laporanBulanan(\Illuminate\Http\Request $request)
    {
        // Bulan dan tahun bisa diteruskan via query ?month=1&year=2024
        $month = $request->query('month');
        $year = $request->query('year');

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
        $end = $start->copy()->endOfMonth()->endOfDay();

        $year = $start->year;
        $month = $start->month;

        // Total penduduk hidup saat ini
        $total_penduduk = Penduduk::where('status_hidup', 'hidup')->count();

        // Kelahiran: penduduk yang ber-tanggal_lahir pada bulan ini dan catatan dibuat pada bulan ini
        $lahir = Penduduk::whereYear('tanggal_lahir', $year)
            ->whereMonth('tanggal_lahir', $month)
            ->whereBetween('created_at', [$start, $end])
            ->count();

        // Penduduk baru yang tercatat pada bulan ini
        $created = Penduduk::whereBetween('created_at', [$start, $end])->count();

        // Pendatang: entri baru selain kelahiran
        $datang = max(0, $created - $lahir);

        // Kematian: penduduk yang status_hidup berubah menjadi 'meninggal' pada bulan ini (updated_at)
        $meninggal = Penduduk::where('status_hidup', 'meninggal')
            ->whereBetween('updated_at', [$start, $end])
            ->count();

        // Pindah: tidak ada field eksplisit, set 0 (atau modifikasi jika ada tabel mutasi)
        $pindah = 0;

        $mutasi = [
            'lahir' => $lahir,
            'meninggal' => $meninggal,
            'datang' => $datang,
            'pindah' => $pindah,
        ];

        // Detail laporan dengan persentase terhadap total penduduk
        $makePercent = function ($count) use ($total_penduduk) {
            $pct = $total_penduduk > 0 ? round(($count / $total_penduduk) * 100, 2) : 0;
            $sign = $pct >= 0 ? '+' : '';
            return $sign . $pct . '%';
        };

        $laporan = [
            ['kategori' => 'Kelahiran', 'jumlah' => $lahir, 'persen' => $makePercent($lahir)],
            ['kategori' => 'Kematian', 'jumlah' => $meninggal, 'persen' => $makePercent($meninggal)],
            ['kategori' => 'Pendatang', 'jumlah' => $datang, 'persen' => $makePercent($datang)],
            ['kategori' => 'Pindah', 'jumlah' => $pindah, 'persen' => $makePercent($pindah)],
        ];

        $data = [
            'bulan' => $start->translatedFormat('F Y'),
            'total_penduduk' => $total_penduduk,
            'mutasi' => $mutasi,
            'laporan' => $laporan,
        ];

        return view('admin.statistik.laporan-bulanan', compact('data'));
    }
}

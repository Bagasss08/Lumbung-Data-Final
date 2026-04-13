<?php

namespace App\Http\Controllers\Admin\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\TransaksiKas;
use App\Models\KasDesa;
use App\Models\Apbdes;
use App\Models\RealisasiAnggaran;
use App\Models\TahunAnggaran;
use App\Models\BidangAnggaran;
use App\Models\KegiatanAnggaran;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\LaporanApbdes;
use Illuminate\Support\Facades\Storage;
use App\Models\AkunRekening;
use App\Models\AnggaranTahunan;

class KeuanganController extends Controller {
    // ================================================================
    // LAPORAN TRANSAKSI KAS
    // ================================================================
    public function laporan(Request $request) {
        $tahun  = $request->get('tahun');
        $bulan  = $request->get('bulan');
        $jenis  = $request->get('jenis');
        $search = $request->get('search');

        $availableYears = TransaksiKas::selectRaw('YEAR(tanggal) as year')
            ->distinct()->pluck('year')->sortDesc()->toArray();

        $currentYear = Carbon::now()->year;
        if (!in_array($currentYear, $availableYears)) {
            array_unshift($availableYears, $currentYear);
        }

        $bulanOptions = [
            ''   => 'Semua',
            '1'  => 'Januari',
            '2'  => 'Februari',
            '3'  => 'Maret',
            '4'  => 'April',
            '5'  => 'Mei',
            '6'  => 'Juni',
            '7'  => 'Juli',
            '8'  => 'Agustus',
            '9'  => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $query = TransaksiKas::query();

        if ($tahun) $query->whereYear('tanggal', $tahun);
        if ($bulan) $query->whereMonth('tanggal', $bulan);

        if ($jenis && $jenis !== 'Semua') {
            if ($jenis === 'Pemasukan')   $query->where('tipe', 'masuk');
            if ($jenis === 'Pengeluaran') $query->where('tipe', 'keluar');
        }

        if ($search) {
            $query->where('keterangan', 'like', "%{$search}%");
        }

        $transactions = $query->orderBy('tanggal', 'asc')->orderBy('id', 'asc')->paginate(20);

        // Running balance
        $runningBalance = 0;
        foreach ($transactions as $transaction) {
            $runningBalance += $transaction->tipe === 'masuk'
                ? $transaction->jumlah
                : -$transaction->jumlah;
            $transaction->running_balance = $runningBalance;
        }

        $totalPemasukan = TransaksiKas::where('tipe', 'masuk')
            ->when($tahun, fn($q) => $q->whereYear('tanggal', $tahun))
            ->when($bulan, fn($q) => $q->whereMonth('tanggal', $bulan))
            ->sum('jumlah');

        $totalPengeluaran = TransaksiKas::where('tipe', 'keluar')
            ->when($tahun, fn($q) => $q->whereYear('tanggal', $tahun))
            ->when($bulan, fn($q) => $q->whereMonth('tanggal', $bulan))
            ->sum('jumlah');

        $saldoSaatIni  = $totalPemasukan - $totalPengeluaran;
        $averageMonthly = $transactions->total() > 0
            ? ($totalPemasukan + $totalPengeluaran) / 12
            : 0;

        return view('admin.keuangan.laporan', compact(
            'availableYears',
            'bulanOptions',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoSaatIni',
            'averageMonthly',
            'transactions'
        ));
    }

    // ================================================================
    // INPUT TRANSAKSI KAS
    // ================================================================
    public function inputData() {
        $recentTransactions = TransaksiKas::orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')->limit(10)->get();

        $kasDesa = KasDesa::all();

        return view('admin.keuangan.input-data', compact('recentTransactions', 'kasDesa'));
    }

    public function store(Request $request) {
        $request->validate([
            'tanggal' => 'required|date',
            'tipe'    => 'required|in:masuk,keluar',
            'jumlah'  => 'required|numeric|min:1',
            'kas_id'  => 'required|exists:kas_desa,id',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'tipe.required'    => 'Jenis transaksi wajib dipilih',
            'jumlah.required'  => 'Jumlah wajib diisi',
            'jumlah.min'       => 'Jumlah minimal 1',
            'kas_id.required'  => 'Kas desa wajib dipilih',
            'kas_id.exists'    => 'Kas desa tidak valid',
        ]);

        try {
            TransaksiKas::create([
                'tanggal' => $request->tanggal,
                'tipe'    => $request->tipe,
                'jumlah'  => $request->jumlah,
                'kas_id'  => $request->kas_id,
            ]);

            return redirect()->route('admin.keuangan.input-data')
                ->with('success', 'Data transaksi berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->route('admin.keuangan.input-data')
                ->with('error', 'Gagal menyimpan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id) {
        try {
            TransaksiKas::findOrFail($id)->delete();
            return redirect()->route('admin.keuangan.laporan')
                ->with('success', 'Data transaksi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.keuangan.laporan')
                ->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // ================================================================
    // KAS DESA CRUD
    // ================================================================
    public function kasDesa(Request $request) {
        $search = $request->get('search');
        $query  = KasDesa::with('tahun');

        if ($search) $query->where('nama', 'like', "%{$search}%");

        $kasDesa       = $query->orderBy('created_at', 'desc')->paginate(10);
        $tahunAnggaran = TahunAnggaran::orderBy('tahun', 'desc')->get();

        return view('admin.keuangan.kas-desa', compact('kasDesa', 'tahunAnggaran'));
    }

    public function kasDesaCreate() {
        $tahunAnggaran = TahunAnggaran::orderBy('tahun', 'desc')->get();
        return view('admin.keuangan.kas-desa-create', compact('tahunAnggaran'));
    }

    public function kasDesaStore(Request $request) {
        $request->validate([
            'tahun_id'   => 'required|exists:tahun_anggaran,id',
            'nama'       => 'required|string|max:255',
            'saldo_awal' => 'required|numeric|min:0',
        ]);

        try {
            KasDesa::create([
                'tahun_id'    => $request->tahun_id,
                'nama'        => $request->nama,
                'saldo_awal'  => $request->saldo_awal,
                'saldo_akhir' => $request->saldo_awal,
            ]);

            return redirect()->route('admin.keuangan.kas-desa')
                ->with('success', 'Data Kas Desa berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->route('admin.keuangan.kas-desa')
                ->with('error', 'Gagal menyimpan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function kasDesaEdit($id) {
        $kasDesa       = KasDesa::findOrFail($id);
        $tahunAnggaran = TahunAnggaran::orderBy('tahun', 'desc')->get();
        return view('admin.keuangan.kas-desa-edit', compact('kasDesa', 'tahunAnggaran'));
    }

    public function kasDesaUpdate(Request $request, $id) {
        $request->validate([
            'tahun_id'   => 'required|exists:tahun_anggaran,id',
            'nama'       => 'required|string|max:255',
            'saldo_awal' => 'required|numeric|min:0',
        ]);

        try {
            $kasDesa        = KasDesa::findOrFail($id);
            $difference     = $request->saldo_awal - $kasDesa->saldo_awal;
            $newSaldoAkhir  = $kasDesa->saldo_akhir + $difference;

            $kasDesa->update([
                'tahun_id'    => $request->tahun_id,
                'nama'        => $request->nama,
                'saldo_awal'  => $request->saldo_awal,
                'saldo_akhir' => $newSaldoAkhir,
            ]);

            return redirect()->route('admin.keuangan.kas-desa')
                ->with('success', 'Data Kas Desa berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('admin.keuangan.kas-desa')
                ->with('error', 'Gagal memperbarui: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function kasDesaDestroy($id) {
        try {
            $kasDesa = KasDesa::findOrFail($id);

            if ($kasDesa->transaksi()->count() > 0) {
                return redirect()->route('admin.keuangan.kas-desa')
                    ->with('error', 'Kas Desa tidak dapat dihapus karena masih memiliki transaksi');
            }

            $kasDesa->delete();
            return redirect()->route('admin.keuangan.kas-desa')
                ->with('success', 'Data Kas Desa berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.keuangan.kas-desa')
                ->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    public function laporanKeuangan(Request $request) {
        $tahun = $request->get('tahun', Carbon::now()->year);
        $jenis = $request->get('jenis', 'laporan-manual');

        // Ambil semua data anggaran tahunan beserta relasi akun rekening
        $allData = AnggaranTahunan::with('akunRekening')
            ->where('tahun', $tahun)
            ->get()
            ->sortBy(fn($item) => $item->akunRekening->kode_rekening)
            ->values();

        // Jika data kosong, redirect ke halaman input
        if ($allData->isEmpty()) {
            return redirect()->route('admin.keuangan.input.index')
                ->with('warning', "Belum ada data anggaran untuk tahun {$tahun}. Silakan input data terlebih dahulu.");
        }

        // Pisahkan data berdasarkan kategori kode rekening
        $pendapatan  = $allData->filter(fn($item) => str_starts_with($item->akunRekening->kode_rekening, '4'));
        $belanja     = $allData->filter(fn($item) => str_starts_with($item->akunRekening->kode_rekening, '5'));
        $pembiayaan  = $allData->filter(fn($item) => str_starts_with($item->akunRekening->kode_rekening, '6'));

        // Helper: ambil anggaran dari record dengan kode tertentu
        $getAnggaran = fn(string $kode) => $allData
            ->first(fn($item) => $item->akunRekening->kode_rekening === $kode)?->anggaran ?? 0;

        $getRealisasi = fn(string $kode) => $allData
            ->first(fn($item) => $item->akunRekening->kode_rekening === $kode)?->realisasi ?? 0;

        // Hitung total & kalkulasi keuangan utama
        $totalPendapatan      = $getAnggaran('4');
        $totalBelanja         = $getAnggaran('5');
        $surplusDefisit       = $totalPendapatan - $totalBelanja;
        $pembiayaanPenerimaan = $getAnggaran('6.1');
        $pembiayaanPengeluaran = $getAnggaran('6.2');
        $totalPembiayaanNetto = $pembiayaanPenerimaan - $pembiayaanPengeluaran;
        $silpa                = $surplusDefisit + $totalPembiayaanNetto;

        $realisasiPendapatan  = $getRealisasi('4');
        $realisasiBelanja     = $getRealisasi('5');

        // Daftar tahun yang tersedia untuk dropdown
        $tahunList = AnggaranTahunan::select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('admin.keuangan.laporan-keuangan', compact(
            'allData',
            'pendapatan',
            'belanja',
            'pembiayaan',
            'tahunList',
            'tahun',
            'jenis',
            'totalPendapatan',
            'totalBelanja',
            'surplusDefisit',
            'totalPembiayaanNetto',
            'silpa',
            'realisasiPendapatan',
            'realisasiBelanja',
        ));
    }


    // ================================================================
    // LAPORAN APBDES (Dokumen PDF - mirip OpenSID)
    // ================================================================
    public function laporanApbdes(Request $request) {
        $tahun = $request->get('tahun');

        $laporan = LaporanApbdes::filterTahun($tahun)
            ->orderByDesc('tgl_upload')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $tahunList = LaporanApbdes::select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('admin.keuangan.laporan-apbdes', compact('laporan', 'tahunList', 'tahun'));
    }

    public function laporanApbdesStore(Request $request) {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'tahun'    => 'required|integer|min:2000|max:2099',
            'semester' => 'required|in:1,2',
            'file'     => 'required|file|mimes:pdf|max:32768',
        ]);

        $path = $request->file('file')->store('laporan-apbdes', 'public');

        LaporanApbdes::create([
            'judul'      => $request->judul,
            'tahun'      => $request->tahun,
            'semester'   => $request->semester,
            'file'       => $path,
            'tgl_upload' => Carbon::now(),
        ]);

        return redirect()->route('admin.keuangan.laporan-apbdes')
            ->with('success', 'Laporan APBDes berhasil ditambahkan.');
    }

    public function laporanApbdesUpdate(Request $request, $id) {
        $laporan = LaporanApbdes::findOrFail($id);

        $request->validate([
            'judul'    => 'required|string|max:255',
            'tahun'    => 'required|integer|min:2000|max:2099',
            'semester' => 'required|in:1,2',
            'file'     => 'nullable|file|mimes:pdf|max:32768',
        ]);

        $data = [
            'judul'    => $request->judul,
            'tahun'    => $request->tahun,
            'semester' => $request->semester,
        ];

        if ($request->hasFile('file')) {
            if ($laporan->file && Storage::disk('public')->exists($laporan->file)) {
                Storage::disk('public')->delete($laporan->file);
            }
            $data['file']       = $request->file('file')->store('laporan-apbdes', 'public');
            $data['tgl_upload'] = Carbon::now();
        }

        $laporan->update($data);

        return redirect()->route('admin.keuangan.laporan-apbdes')
            ->with('success', 'Laporan APBDes berhasil diperbarui.');
    }

    public function laporanApbdesDestroy($id) {
        $laporan = LaporanApbdes::findOrFail($id);

        if ($laporan->file && Storage::disk('public')->exists($laporan->file)) {
            Storage::disk('public')->delete($laporan->file);
        }

        $laporan->delete();

        return redirect()->route('admin.keuangan.laporan-apbdes')
            ->with('success', 'Laporan APBDes berhasil dihapus.');
    }

    public function laporanApbdesBulkDestroy(Request $request) {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:laporan_apbdes,id',
        ]);

        $laporanList = LaporanApbdes::whereIn('id', $request->ids)->get();

        foreach ($laporanList as $laporan) {
            if ($laporan->file && Storage::disk('public')->exists($laporan->file)) {
                Storage::disk('public')->delete($laporan->file);
            }
            $laporan->delete();
        }

        return redirect()->route('admin.keuangan.laporan-apbdes')
            ->with('success', count($request->ids) . ' laporan APBDes berhasil dihapus.');
    }

    public function laporanApbdesKirimOpenDK(Request $request) {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:laporan_apbdes,id',
        ]);

        LaporanApbdes::whereIn('id', $request->ids)
            ->update(['tgl_kirim' => Carbon::now()]);

        return redirect()->route('admin.keuangan.laporan-apbdes')
            ->with('success', count($request->ids) . ' laporan berhasil dikirim ke OpenDK.');
    }

    // ================================================================
    // APBDES CRUD
    // ================================================================
    public function apbdes(Request $request) {
        $search      = $request->get('search');
        $tahunFilter = $request->get('tahun');
        $kategori    = $request->get('kategori');

        $query = Apbdes::with(['tahun', 'kegiatanAnggaran', 'sumberDana', 'realisasi'])
            ->orderBy('kategori')->orderBy('id');

        if ($search) {
            $query->whereHas(
                'kegiatanAnggaran',
                fn($q) =>
                $q->where('nama_kegiatan', 'like', "%{$search}%")
            );
        }
        if ($tahunFilter) {
            $query->whereHas('tahun', fn($q) => $q->where('tahun', $tahunFilter));
        }
        if ($kategori && in_array($kategori, ['pendapatan', 'belanja'])) {
            $query->where('kategori', $kategori);
        }

        $apbdesList     = $query->paginate(15)->withQueryString();
        $tahunAnggaran  = TahunAnggaran::orderBy('tahun', 'desc')->get();
        $availableYears = TahunAnggaran::pluck('tahun')->toArray();

        return view('admin.keuangan.apbdes', compact(
            'apbdesList',
            'tahunAnggaran',
            'availableYears'
        ));
    }

    public function apbdesCreate() {
        $tahunAnggaran = TahunAnggaran::orderBy('tahun', 'desc')->get();
        $bidang        = BidangAnggaran::with('kegiatanAnggaran')->orderBy('nama_bidang')->get();
        $sumberDana    = SumberDana::orderBy('nama_sumber')->get();

        return view('admin.keuangan.laporan-apbdes-create', compact(
            'tahunAnggaran',
            'bidang',
            'sumberDana'
        ));
    }

    public function apbdesStore(Request $request) {
        $request->validate([
            'tahun_id'       => 'required|exists:tahun_anggaran,id',
            'kegiatan_id'    => 'required|exists:kegiatan_anggaran,id',
            'sumber_dana_id' => 'required|exists:sumber_dana,id',
            'anggaran'       => 'required|numeric|min:1',
            'kategori'       => 'required|in:pendapatan,belanja',
        ], [
            'tahun_id.required'       => 'Tahun anggaran wajib dipilih',
            'kegiatan_id.required'    => 'Kegiatan wajib dipilih',
            'sumber_dana_id.required' => 'Sumber dana wajib dipilih',
            'anggaran.required'       => 'Jumlah anggaran wajib diisi',
            'anggaran.min'            => 'Jumlah anggaran minimal Rp 1',
            'kategori.required'       => 'Kategori wajib dipilih',
        ]);

        $existing = Apbdes::where('tahun_id', $request->tahun_id)
            ->where('kegiatan_id', $request->kegiatan_id)
            ->where('kategori', $request->kategori)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Kegiatan ini sudah ada di APBDes tahun tersebut.')
                ->withInput();
        }

        try {
            Apbdes::create([
                'tahun_id'       => $request->tahun_id,
                'kegiatan_id'    => $request->kegiatan_id,
                'sumber_dana_id' => $request->sumber_dana_id,
                'anggaran'       => $request->anggaran,
                'kategori'       => $request->kategori,
            ]);

            return redirect()->route('admin.keuangan.apbdes')
                ->with('success', 'Data APBDes berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function apbdesEdit($id) {
        $apbdes        = Apbdes::with(['realisasi'])->findOrFail($id);
        $tahunAnggaran = TahunAnggaran::orderBy('tahun', 'desc')->get();
        $bidang        = BidangAnggaran::with('kegiatanAnggaran')->orderBy('nama_bidang')->get();
        $sumberDana    = SumberDana::orderBy('nama_sumber')->get();

        // ✅ view path sesuai nama file aktual di folder keuangan
        return view('admin.keuangan.laporan-apbdes-edit', compact(
            'apbdes',
            'tahunAnggaran',
            'bidang',
            'sumberDana'
        ));
    }

    public function apbdesUpdate(Request $request, $id) {
        $request->validate([
            'tahun_id'       => 'required|exists:tahun_anggaran,id',
            'kegiatan_id'    => 'required|exists:kegiatan_anggaran,id',
            'sumber_dana_id' => 'required|exists:sumber_dana,id',
            'anggaran'       => 'required|numeric|min:1',
            'kategori'       => 'required|in:pendapatan,belanja',
        ]);

        try {
            Apbdes::findOrFail($id)->update([
                'tahun_id'       => $request->tahun_id,
                'kegiatan_id'    => $request->kegiatan_id,
                'sumber_dana_id' => $request->sumber_dana_id,
                'anggaran'       => $request->anggaran,
                'kategori'       => $request->kategori,
            ]);

            return redirect()->route('admin.keuangan.apbdes')
                ->with('success', 'Data APBDes berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function apbdesDestroy($id) {
        try {
            $apbdes = Apbdes::findOrFail($id);

            if ($apbdes->realisasi()->count() > 0) {
                return redirect()->route('admin.keuangan.apbdes')
                    ->with('error', 'APBDes tidak dapat dihapus karena sudah memiliki data realisasi.');
            }

            $apbdes->delete();
            return redirect()->route('admin.keuangan.apbdes')
                ->with('success', 'Data APBDes berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.keuangan.apbdes')
                ->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    public function realisasiStore(Request $request, $apbdesId) {
        $request->validate([
            'tanggal'    => 'required|date',
            'jumlah'     => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:500',
        ]);

        try {
            $apbdes         = Apbdes::findOrFail($apbdesId);
            $totalRealisasi = $apbdes->realisasi()->sum('jumlah');

            if (($totalRealisasi + $request->jumlah) > $apbdes->anggaran) {
                return redirect()->back()
                    ->with('error', 'Total realisasi melebihi jumlah anggaran.')
                    ->withInput();
            }

            RealisasiAnggaran::create([
                'apbdes_id'  => $apbdesId,
                'tanggal'    => $request->tanggal,
                'jumlah'     => $request->jumlah,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->route('admin.keuangan.apbdes')
                ->with('success', 'Realisasi berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan realisasi: ' . $e->getMessage())
                ->withInput();
        }
    }
}

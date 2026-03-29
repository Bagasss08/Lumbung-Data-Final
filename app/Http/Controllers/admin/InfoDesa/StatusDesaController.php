<?php

namespace App\Http\Controllers\Admin\InfoDesa;

use App\Http\Controllers\Controller;
use App\Models\IdmIndikator;
use App\Models\IdmRekap;
use App\Models\SdgsRekap;
use App\Models\SdgsTujuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatusDesaController extends Controller {
    // ─────────────────────────────────────────────────────────────────
    // INDEX
    // ─────────────────────────────────────────────────────────────────

    public function index(Request $request): View {
        $tab   = $request->get('tab', 'idm');
        $tahun = (int) $request->get('tahun', date('Y'));

        // Daftar tahun tersedia (gabungan IDM + SDGS)
        $tahunList = IdmRekap::orderByDesc('tahun')->pluck('tahun')
            ->merge(SdgsRekap::orderByDesc('tahun')->pluck('tahun'))
            ->unique()
            ->sortDesc()
            ->values();

        // ── Data IDM ──────────────────────────────────────────────────
        $rekap = IdmRekap::where('tahun', $tahun)->first();

        $indikator = IdmIndikator::where('tahun', $tahun)
            ->orderBy('no_urut')
            ->get();

        $indikatorIks = $indikator->where('dimensi', 'IKS');
        $indikatorIke = $indikator->where('dimensi', 'IKE');
        $indikatorIkl = $indikator->where('dimensi', 'IKL');

        $pieData = $rekap
            ? ['iks' => $rekap->skor_iks, 'ike' => $rekap->skor_ike, 'ikl' => $rekap->skor_ikl]
            : ['iks' => 0, 'ike' => 0, 'ikl' => 0];

        // ── Data SDGS ─────────────────────────────────────────────────
        $sdgsRekap  = SdgsRekap::where('tahun', $tahun)->first();
        $sdgsTujuan = SdgsTujuan::where('tahun', $tahun)
            ->orderBy('no_tujuan')
            ->get();

        // Jika belum ada data SDGS untuk tahun ini, tampilkan semua 18 tujuan
        // dengan nilai 0 agar tampilan tetap muncul
        if ($sdgsTujuan->isEmpty()) {
            $masterTujuan = SdgsTujuan::masterTujuan();
            $sdgsTujuan   = collect(array_map(
                fn($no, $nama) => (object) [
                    'no_tujuan'  => $no,
                    'nama_tujuan' => $nama,
                    'nilai'      => 0,
                ],
                array_keys($masterTujuan),
                $masterTujuan
            ));
        }

        return view('admin.info-desa.status-desa.index', compact(
            'tab',
            'tahun',
            'tahunList',
            'rekap',
            'indikator',
            'indikatorIks',
            'indikatorIke',
            'indikatorIkl',
            'pieData',
            'sdgsRekap',
            'sdgsTujuan',
        ));
    }

    // ─────────────────────────────────────────────────────────────────
    // IDM: Hitung ulang skor
    // ─────────────────────────────────────────────────────────────────

    public function perbaruiSkor(Request $request): RedirectResponse {
        $tahun = (int) $request->get('tahun', date('Y'));
        $rekap = $this->hitungDanSimpan($tahun);

        return redirect()
            ->route('admin.info-desa.status-desa.index', ['tahun' => $tahun])
            ->with('success', "Skor IDM {$tahun} berhasil diperbarui. Skor IDM: {$rekap->skor_idm} ({$rekap->status_idm})");
    }

    // ─────────────────────────────────────────────────────────────────
    // IDM: Simpan semua skor indikator
    // ─────────────────────────────────────────────────────────────────

    public function simpan(Request $request): RedirectResponse {
        $tahun = (int) $request->get('tahun', date('Y'));

        $validated = $request->validate([
            'skor'   => 'required|array',
            'skor.*' => 'integer|min:0|max:5',
        ]);

        foreach ($validated['skor'] as $id => $skor) {
            IdmIndikator::where('id', $id)
                ->where('tahun', $tahun)
                ->update(['skor' => $skor]);
        }

        $rekap = $this->hitungDanSimpan($tahun);

        return redirect()
            ->route('admin.info-desa.status-desa.index', ['tahun' => $tahun])
            ->with('success', "Data IDM {$tahun} berhasil disimpan. Skor IDM: {$rekap->skor_idm} ({$rekap->status_idm})");
    }

    // ─────────────────────────────────────────────────────────────────
    // IDM: Salin dari tahun sebelumnya
    // ─────────────────────────────────────────────────────────────────

    public function salinTahunSebelumnya(Request $request): RedirectResponse {
        $tahunBaru   = (int) $request->get('tahun_baru');
        $tahunSumber = $tahunBaru - 1;

        if (IdmIndikator::where('tahun', $tahunBaru)->exists()) {
            return back()->with('error', "Data IDM tahun {$tahunBaru} sudah ada.");
        }

        $sumber = IdmIndikator::where('tahun', $tahunSumber)->get();
        if ($sumber->isEmpty()) {
            return back()->with('error', "Data IDM tahun {$tahunSumber} tidak ditemukan.");
        }

        foreach ($sumber as $row) {
            IdmIndikator::create(array_merge(
                $row->only([
                    'no_urut',
                    'dimensi',
                    'nama_indikator',
                    'keterangan',
                    'kegiatan_dilakukan',
                    'nilai_tambah',
                    'pelaksana_pusat',
                    'pelaksana_provinsi',
                    'pelaksana_kabupaten',
                    'pelaksana_desa',
                    'pelaksana_csr',
                    'pelaksana_lainnya',
                    'catatan',
                ]),
                ['tahun' => $tahunBaru, 'skor' => 0]
            ));
        }

        return redirect()
            ->route('admin.info-desa.status-desa.index', ['tahun' => $tahunBaru])
            ->with('success', "Indikator IDM tahun {$tahunBaru} berhasil disalin dari tahun {$tahunSumber}.");
    }

    // ─────────────────────────────────────────────────────────────────
    // SDGS: Perbarui skor (hitung rata-rata dari sdgs_tujuan)
    // ─────────────────────────────────────────────────────────────────

    public function perbaruiSdgs(Request $request): RedirectResponse {
        $tahun   = (int) $request->get('tahun', date('Y'));
        $tujuan  = SdgsTujuan::where('tahun', $tahun)->get();

        $skor = $tujuan->count() > 0
            ? round($tujuan->avg('nilai'), 2)
            : 0;

        SdgsRekap::updateOrCreate(
            ['tahun' => $tahun],
            ['skor_sdgs' => $skor]
        );

        return redirect()
            ->route('admin.info-desa.status-desa.index', ['tab' => 'sdgs', 'tahun' => $tahun])
            ->with('success', "Skor SDGs {$tahun} berhasil diperbarui: {$skor}");
    }

    // ─────────────────────────────────────────────────────────────────
    // Private helpers
    // ─────────────────────────────────────────────────────────────────

    private function hitungDanSimpan(int $tahun): IdmRekap {
        $indikator = IdmIndikator::where('tahun', $tahun)->get();

        $grupIks = $indikator->where('dimensi', 'IKS');
        $grupIke = $indikator->where('dimensi', 'IKE');
        $grupIkl = $indikator->where('dimensi', 'IKL');

        $skorIks = $grupIks->count() > 0 ? $grupIks->avg('skor') / 5 : 0;
        $skorIke = $grupIke->count() > 0 ? $grupIke->avg('skor') / 5 : 0;
        $skorIkl = $grupIkl->count() > 0 ? $grupIkl->avg('skor') / 5 : 0;

        $skorIdm   = ($skorIks + $skorIke + $skorIkl) / 3;
        $statusIdm = IdmRekap::statusDariSkor($skorIdm);
        $next      = IdmRekap::skorMinimalBerikutnya($statusIdm);

        return IdmRekap::updateOrCreate(
            ['tahun' => $tahun],
            [
                'skor_idm'         => round($skorIdm, 4),
                'status_idm'       => $statusIdm,
                'skor_idm_minimal' => $next['skor'],
                'target_status'    => $next['target'],
                'skor_iks'         => round($skorIks, 4),
                'skor_ike'         => round($skorIke, 4),
                'skor_ikl'         => round($skorIkl, 4),
            ]
        );
    }
}

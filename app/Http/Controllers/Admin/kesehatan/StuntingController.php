<?php

namespace App\Http\Controllers\Admin\kesehatan;

use App\Http\Controllers\Controller;
use App\Models\Kia;
use App\Models\PemantauanBumil;
use App\Models\PemantauanAnak;
use App\Models\Posyandu;
use App\Models\StuntingScorecard;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StuntingController extends Controller {
    // ============================================================
    // POSYANDU (sub-tab Stunting)
    // ============================================================
    public function posyandu(Request $request): View {
        $posyandu = Posyandu::withCount('kia')
            ->when($request->search, fn($q) => $q->where('nama_posyandu', 'like', '%' . $request->search . '%'))
            ->paginate(10)->withQueryString();

        return view('admin.kesehatan.stunting.posyandu', compact('posyandu'));
    }

    // ============================================================
    // KIA (sub-tab Stunting: Kesehatan Ibu dan Anak)
    // ============================================================
    public function kia(Request $request): View {
        $query = Kia::with('posyandu');

        if ($request->filled('posyandu_id')) {
            $query->where('posyandu_id', $request->posyandu_id);
        }

        if ($request->filled('status_kehamilan')) {
            $query->where('status_kehamilan', $request->status_kehamilan);
        }

        $kia = $query->latest()->paginate(10)->withQueryString();
        $posyanduList = Posyandu::aktif()->orderBy('nama_posyandu')->get();

        return view('admin.kesehatan.stunting.kia', compact('kia', 'posyanduList'));
    }

    // ============================================================
    // PEMANTAUAN BULANAN IBU HAMIL
    // ============================================================
    public function pemantauanBumil(Request $request): View {
        $query = PemantauanBumil::with(['kia', 'posyandu']);

        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        } else {
            $query->where('tahun', date('Y'));
        }
        if ($request->filled('posyandu_id')) {
            $query->where('posyandu_id', $request->posyandu_id);
        }
        if ($request->filled('kia_id')) {
            $query->where('kia_id', $request->kia_id);
        }

        $pemantauan = $query->orderBy('tanggal_pemantauan', 'desc')->paginate(10)->withQueryString();
        $posyanduList = Posyandu::aktif()->orderBy('nama_posyandu')->get();
        $kiaList = Kia::hamil()->orderBy('nama_ibu')->get();

        // Get selected KIA if kia_id is provided
        $selectedKia = null;
        if ($request->filled('kia_id')) {
            $selectedKia = Kia::with('posyandu')->find($request->kia_id);
        }

        return view('admin.kesehatan.stunting.pemantauan-bumil', compact('pemantauan', 'posyanduList', 'kiaList', 'selectedKia'));
    }

    public function storePemantauanBumil(Request $request): RedirectResponse {
        $validated = $request->validate([
            'kia_id'                   => 'required|exists:kia,id',
            'posyandu_id'              => 'nullable|exists:posyandu,id',
            'tanggal_pemantauan'       => 'required|date',
            'bulan'                    => 'required|integer|min:1|max:12',
            'tahun'                    => 'required|integer|min:2000',
            'usia_kehamilan'           => 'nullable|integer|min:1|max:42',
            'berat_badan'              => 'nullable|numeric|min:0',
            'tinggi_badan'             => 'nullable|numeric|min:0',
            'tekanan_darah_sistole'    => 'nullable|numeric',
            'tekanan_darah_diastole'   => 'nullable|numeric',
            'lingkar_lengan'           => 'nullable|numeric|min:0',
            'status_kehamilan'         => 'required|in:hamil,melahirkan',
            'dapat_pil_fe'             => 'required|in:ya,tidak',
            'jumlah_pil_fe'            => 'nullable|integer|min:0',
            'imunisasi_tt'             => 'required|in:ya,tidak',
            'dapat_vit_a'              => 'required|in:ya,tidak',
            'dapat_tablet_tambah_darah' => 'required|in:ya,tidak',
            'pemeriksaan_lab'          => 'required|in:ya,tidak',
            'konseling_gizi'           => 'required|in:ya,tidak',
            'anemia'                   => 'required|in:ya,tidak,tidak_diketahui',
            'kek'                      => 'required|in:ya,tidak,tidak_diketahui',
            'petugas'                  => 'nullable|string|max:100',
            'catatan'                  => 'nullable|string',
        ]);

        PemantauanBumil::create($validated);

        return redirect()->route('admin.kesehatan.stunting.pemantauan-bumil')
            ->with('success', 'Data pemantauan ibu hamil berhasil disimpan.');
    }

    // ============================================================
    // PEMANTAUAN BULANAN ANAK
    // ============================================================
    public function pemantauanAnak(Request $request): View {
        $query = PemantauanAnak::with(['kia', 'posyandu']);

        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        } else {
            $query->where('tahun', date('Y'));
        }
        if ($request->filled('posyandu_id')) {
            $query->where('posyandu_id', $request->posyandu_id);
        }
        if ($request->filled('status_gizi')) {
            $query->where('status_tb_u', $request->status_gizi);
        }

        $pemantauan = $query->orderBy('tanggal_pemantauan', 'desc')->paginate(10)->withQueryString();
        $posyanduList = Posyandu::aktif()->orderBy('nama_posyandu')->get();
        $kiaList = Kia::punyaAnak()->orderBy('nama_anak')->get();

        // Get selected KIA if kia_id is provided
        $selectedKia = null;
        if ($request->filled('kia_id')) {
            $selectedKia = Kia::with('posyandu')->find($request->kia_id);
        }

        // Statistik stunting
        $statStunting = PemantauanAnak::where('tahun', $request->tahun ?? date('Y'))
            ->when($request->bulan, fn($q) => $q->where('bulan', $request->bulan))
            ->selectRaw('status_tb_u, COUNT(*) as jumlah')
            ->groupBy('status_tb_u')
            ->pluck('jumlah', 'status_tb_u');

        return view(
            'admin.kesehatan.stunting.pemantauan-anak',
            compact('pemantauan', 'posyanduList', 'kiaList', 'statStunting', 'selectedKia')
        );
    }

    public function storePemantauanAnak(Request $request): RedirectResponse {
        $validated = $request->validate([
            'kia_id'          => 'required|exists:kia,id',
            'posyandu_id'     => 'nullable|exists:posyandu,id',
            'tanggal_pemantauan' => 'required|date',
            'bulan'           => 'required|integer|min:1|max:12',
            'tahun'           => 'required|integer|min:2000',
            'umur_bulan'      => 'required|integer|min:0|max:72',
            'berat_badan'     => 'nullable|numeric|min:0|max:50',
            'tinggi_badan'    => 'nullable|numeric|min:0|max:200',
            'lingkar_kepala'  => 'nullable|numeric|min:0|max:100',
            'lingkar_lengan'  => 'nullable|numeric|min:0|max:50',
            'status_bb_u'     => 'nullable|in:sangat_kurang,kurang,normal,lebih',
            'status_tb_u'     => 'nullable|in:sangat_pendek,pendek,normal,tinggi',
            'status_bb_tb'    => 'nullable|in:sangat_kurus,kurus,normal,gemuk,obesitas',
            'dapat_vit_a'     => 'required|in:ya,tidak',
            'status_imunisasi' => 'required|in:lengkap,belum_lengkap,tidak_imunisasi',
            'asi_eksklusif'   => 'required|in:ya,tidak,tidak_berlaku',
            'perkembangan'    => 'nullable|in:sesuai,meragukan,penyimpangan',
            'petugas'         => 'nullable|string|max:100',
            'catatan'         => 'nullable|string',
        ]);

        PemantauanAnak::create($validated);

        return redirect()->route('admin.kesehatan.stunting.pemantauan-anak')
            ->with('success', 'Data pemantauan anak berhasil disimpan.');
    }

    // ============================================================
    // SCORECARD KONVERGENSI
    // ============================================================
    public function scorecard(Request $request): View {
        $tahun = $request->tahun ?? date('Y');
        
        // Handle triwulan - can be string (TW1) or integer (1)
        $triwulanInput = $request->triwulan;
        if ($triwulanInput) {
            // If it's like "TW1", extract the number
            if (is_string($triwulanInput) && str_starts_with($triwulanInput, 'TW')) {
                $triwulan = (int) substr($triwulanInput, 2);
            } else {
                $triwulan = (int) $triwulanInput;
            }
        } else {
            $triwulan = (int) ceil(date('n') / 3);
        }

        $scorecards = StuntingScorecard::with('kia')
            ->where('tahun', $tahun)
            ->where('triwulan', $triwulan)
            ->paginate(10)->withQueryString();

        $kiaList = Kia::orderBy('nama_ibu')->get();

        // Get selected KIA if kia_id is provided
        $selectedKia = null;
        if ($request->filled('kia_id')) {
            $selectedKia = Kia::with('posyandu')->find($request->kia_id);
        }

        // Rekap scorecard
        $rekapSkor = StuntingScorecard::where('tahun', $tahun)
            ->where('triwulan', $triwulan)
            ->selectRaw('
                AVG(skor_konvergensi) as rata_rata,
                MIN(skor_konvergensi) as minimum,
                MAX(skor_konvergensi) as maksimum,
                COUNT(*) as total
            ')->first();

        // Create stats array for the view
        $stats = [
            'total' => $rekapSkor->total ?? 0,
            'rata_rata' => $rekapSkor->rata_rata ?? 0,
            'min' => $rekapSkor->minimum ?? 0,
            'max' => $rekapSkor->maksimum ?? 0,
        ];

        return view(
            'admin.kesehatan.stunting.scorecard',
            compact('scorecards', 'kiaList', 'tahun', 'triwulan', 'stats', 'selectedKia')
        );
    }

    public function storeScorecard(Request $request): RedirectResponse {
        $validated = $request->validate([
            'kia_id'                  => 'required|exists:kia,id',
            'triwulan'                => 'required|integer|in:1,2,3,4',
            'tahun'                   => 'required|integer|min:2000',
            'fe90'                    => 'required|in:ya,tidak',
            'ifa'                     => 'required|in:ya,tidak',
            'pmtbumil'                => 'required|in:ya,tidak',
            'pemeriksaan_kehamilan'   => 'required|in:ya,tidak',
            'akt_bumil'               => 'required|in:ya,tidak',
            'imunisasi_dasar'         => 'required|in:ya,tidak',
            'pmtbalita'               => 'required|in:ya,tidak',
            'vit_a'                   => 'required|in:ya,tidak',
            'stimulasi'               => 'required|in:ya,tidak',
            'paud'                    => 'required|in:ya,tidak',
            'jkn'                     => 'required|in:ya,tidak',
            'air_bersih'              => 'required|in:ya,tidak',
            'sanitasi'                => 'required|in:ya,tidak',
            'perlindungan_sosial'     => 'required|in:ya,tidak',
            'keterangan'              => 'nullable|string',
        ]);

        StuntingScorecard::updateOrCreate(
            ['kia_id' => $validated['kia_id'], 'triwulan' => $validated['triwulan'], 'tahun' => $validated['tahun']],
            $validated
        );

        return redirect()->route('admin.kesehatan.stunting.scorecard')
            ->with('success', 'Data scorecard konvergensi berhasil disimpan.');
    }
}

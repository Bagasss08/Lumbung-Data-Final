<?php

namespace App\Http\Controllers\Admin\Analisis;

use App\Http\Controllers\Controller;
use App\Models\AnalisisMaster;
use App\Models\AnalisisIndikator;
use App\Models\AnalisisPeriode;
use App\Models\AnalisisKlasifikasi;
use App\Models\AnalisisResponden;
use App\Models\AnalisisResponJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalisisRespondenController extends Controller {
    public function index(Request $request, AnalisisMaster $analisi) {
        $periodeList = $analisi->periodeList()->aktif()->get();
        $periodeAktif = $request->id_periode
            ? $analisi->periodeList()->find($request->id_periode)
            : $analisi->periodeList()->where('aktif', true)->latest()->first();

        $responden = collect();
        if ($periodeAktif) {
            $query = AnalisisResponden::where('id_master', $analisi->id)
                ->where('id_periode', $periodeAktif->id);

            if ($request->kategori) {
                $query->where('kategori_hasil', $request->kategori);
            }
            if ($request->search) {
                // Filter subjek (disederhanakan - sesuaikan dengan tabel penduduk/keluarga Anda)
                $query->where(function ($q) use ($request) {
                    $q->where('id_penduduk', 'like', '%' . $request->search . '%')
                        ->orWhere('kategori_hasil', 'like', '%' . $request->search . '%');
                });
            }

            $responden = $query->orderByDesc('total_skor')->paginate(15)->withQueryString();
        }

        $kategoris = $analisi->klasifikasi()->pluck('nama')->toArray();

        return view('admin.analisis.responden.index', compact(
            'analisi',
            'periodeList',
            'periodeAktif',
            'responden',
            'kategoris'
        ));
    }

    public function create(Request $request, AnalisisMaster $analisi) {
        $request->validate(['id_periode' => 'required|exists:analisis_periode,id']);

        $periode   = AnalisisPeriode::findOrFail($request->id_periode);
        $indikator = $analisi->indikator()->where('aktif', true)->with('jawaban')->get();

        // Ambil data subjek berdasarkan tipe
        $subjekList = match ($analisi->subjek) {
            'PENDUDUK' => \App\Models\Penduduk::where('status_hidup', 'hidup')
                ->orderBy('nama')
                ->get()
                ->map(fn($p) => [
                    'id' => $p->id,
                    'label' => $p->nama . ' - ' . $p->nik
                ]),
            'KELUARGA' => \App\Models\Keluarga::orderBy('no_kk')
                ->get()
                ->map(fn($k) => [
                    'id' => $k->id,
                    'label' => $k->no_kk
                ]),
            'RUMAH_TANGGA' => \App\Models\RumahTangga::orderBy('no_rumah_tangga')
                ->get()
                ->map(fn($r) => [
                    'id' => $r->id,
                    'label' => $r->no_rumah_tangga
                ]),
            'KELOMPOK' => \App\Models\Kelompok::where('aktif', '1')
                ->orderBy('nama')
                ->get()
                ->map(fn($k) => [
                    'id' => $k->id,
                    'label' => $k->nama . ($k->singkat ? " ({$k->singkat})" : '')
                ]),
            default => collect(),
        };

        return view('admin.analisis.responden.create', compact('analisi', 'periode', 'indikator', 'subjekList'));
    }

    public function store(Request $request, AnalisisMaster $analisi) {
        $request->validate([
            'id_periode'  => 'required|exists:analisis_periode,id',
            'id_subjek'   => 'required|integer',
            'jawaban'     => 'required|array',
        ]);

        $subjekColumn = match ($analisi->subjek) {
            'PENDUDUK'     => 'id_penduduk',
            'KELUARGA'     => 'id_keluarga',
            'RUMAH_TANGGA' => 'id_rtm',
            'KELOMPOK'     => 'id_kelompok',
        };

        // Cek duplikat responden
        $exists = AnalisisResponden::where('id_master', $analisi->id)
            ->where('id_periode', $request->id_periode)
            ->where($subjekColumn, $request->id_subjek)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('warning', 'Data subjek ini sudah pernah diinput pada periode yang sama. Data lama akan ditimpa.');
        }

        DB::transaction(function () use ($request, $analisi, $subjekColumn) {
            $responden = AnalisisResponden::updateOrCreate(
                [
                    'id_master'    => $analisi->id,
                    'id_periode'   => $request->id_periode,
                    $subjekColumn  => $request->id_subjek,
                ],
                ['tgl_survei' => now()]
            );

            $indikator = $analisi->indikator()->where('aktif', true)->with('jawaban')->get();
            $totalSkor = 0;

            foreach ($indikator as $ind) {
                $jawabanInput = $request->jawaban[$ind->id] ?? null;
                if ($jawabanInput === null) continue;

                $nilai      = 0;
                $idJawaban  = null;
                $jawabanTeks = null;

                if ($ind->isChoice()) {
                    // Handle array (checkbox - multiple answers) or single value (radio)
                    if (is_array($jawabanInput)) {
                        // Multiple answers (checkbox) - sum all nilai
                        $nilai = 0;
                        $idJawabanList = [];
                        foreach ($jawabanInput as $jawId) {
                            $jawabanObj = $ind->jawaban()->find($jawId);
                            if ($jawabanObj) {
                                $idJawabanList[] = $jawabanObj->id;
                                $nilai += $jawabanObj->nilai;
                            }
                        }
                        $idJawaban = implode(',', $idJawabanList);
                    } else {
                        // Single answer (radio)
                        $jawabanObj = $ind->jawaban()->find($jawabanInput);
                        if ($jawabanObj) {
                            $idJawaban = $jawabanObj->id;
                            $nilai     = $jawabanObj->nilai;
                        }
                    }
                } else {
                    $jawabanTeks = $jawabanInput;
                }

                AnalisisResponJawaban::updateOrCreate(
                    ['id_responden' => $responden->id, 'id_indikator' => $ind->id],
                    ['id_jawaban'  => $idJawaban, 'jawaban_teks' => $jawabanTeks, 'nilai' => $nilai]
                );

                $totalSkor += $nilai;
            }

            // Klasifikasikan hasil
            $klasifikasi = AnalisisKlasifikasi::where('id_master', $analisi->id)
                ->orderBy('skor_min')
                ->get()
                ->first(fn($k) => $k->containsSkor((float) $totalSkor));

            $responden->update([
                'total_skor'     => $totalSkor,
                'kategori_hasil' => $klasifikasi?->nama,
            ]);
        });

        return redirect()
            ->route('admin.analisis.responden.index', [$analisi, 'id_periode' => $request->id_periode])
            ->with('success', 'Data responden berhasil disimpan!');
    }

    public function show(AnalisisMaster $analisi, AnalisisResponden $responden) {
        $responden->load(['periode', 'responJawaban.indikator', 'responJawaban.jawaban']);
        $indikator = $analisi->indikator()->with('jawaban')->get();

        return view('admin.analisis.responden.show', compact('analisi', 'responden', 'indikator'));
    }

    public function destroy(AnalisisMaster $analisi, AnalisisResponden $responden) {
        $responden->delete();
        return back()->with('success', 'Data responden berhasil dihapus!');
    }

    // ── Export CSV ───────────────────────────────────────────────────────────

    public function export(Request $request, AnalisisMaster $analisi) {
        $request->validate(['id_periode' => 'required|exists:analisis_periode,id']);

        $periode = AnalisisPeriode::findOrFail($request->id_periode);

        $responden = AnalisisResponden::where('id_master', $analisi->id)
            ->where('id_periode', $periode->id)
            ->with(['responJawaban.indikator', 'responJawaban.jawaban'])
            ->get();

        $indikator = $analisi->indikator()->where('aktif', true)->get();

        $filename = 'analisis_' . $analisi->kode . '_' . $periode->nama . '_' . now()->format('Ymd') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($responden, $indikator, $analisi) {
            $file = fopen('php://output', 'w');

            // Header CSV
            $header = ['No', 'Subjek', 'Tanggal Survei'];
            foreach ($indikator as $ind) {
                $header[] = $ind->pertanyaan;
            }
            $header[] = 'Total Skor';
            $header[] = 'Kategori';
            fputcsv($file, $header);

            // Data
            foreach ($responden as $i => $resp) {
                $row = [
                    $i + 1,
                    $resp->nama_subjek,
                    $resp->tgl_survei?->format('d/m/Y') ?? '-',
                ];

                foreach ($indikator as $ind) {
                    $rj = $resp->responJawaban->where('id_indikator', $ind->id)->first();
                    if (!$rj) {
                        $row[] = '-';
                    } elseif ($ind->isChoice()) {
                        $row[] = $rj->jawaban?->jawaban ?? '-';
                    } else {
                        $row[] = $rj->jawaban_teks ?? '-';
                    }
                }

                $row[] = $resp->total_skor;
                $row[] = $resp->kategori_hasil ?? '-';

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ── Export Rekapitulasi PDF (via view) ───────────────────────────────────

    public function exportRekap(Request $request, AnalisisMaster $analisi) {
        $request->validate(['id_periode' => 'required|exists:analisis_periode,id']);
        $periode = AnalisisPeriode::findOrFail($request->id_periode);

        $responden = AnalisisResponden::where('id_master', $analisi->id)
            ->where('id_periode', $periode->id)
            ->orderByDesc('total_skor')
            ->get();

        $klasifikasi     = $analisi->klasifikasi;
        $distribusi      = $responden->groupBy('kategori_hasil')->map->count();
        $totalResponden  = $responden->count();
        $rerataSkor      = $responden->avg('total_skor') ?? 0;

        return view('admin.analisis.export.rekap', compact(
            'analisi',
            'periode',
            'responden',
            'klasifikasi',
            'distribusi',
            'totalResponden',
            'rerataSkor'
        ));
    }
}

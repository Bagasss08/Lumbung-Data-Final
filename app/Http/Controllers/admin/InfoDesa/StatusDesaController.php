<?php

namespace App\Http\Controllers\Admin\InfoDesa;

use App\Http\Controllers\Controller;
use App\Models\StatusDesa;
use App\Traits\ActivityLogger;
use App\Exports\StatusDesaExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class StatusDesaController extends Controller {
    use ActivityLogger;

    private const ALLOWED_MIMES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    public function index() {
        $statusDesa = StatusDesa::terbaru()->paginate(10);
        $terbaru    = StatusDesa::terbaru()->first();

        $stats = [
            'total'   => StatusDesa::count(),
            'terbaru' => $terbaru,
            'tren'    => StatusDesa::dataTren(),
        ];

        return view('admin.info-desa.status-desa.index', compact('statusDesa', 'stats'));
    }

    public function create() {
        return view('admin.info-desa.status-desa.create', [
            'daftarStatus' => StatusDesa::daftarStatus(),
            'statusDesa'   => new StatusDesa(),
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama_status'            => 'required|string|max:100',
            'tahun'                  => 'required|digits:4|integer|min:2000|max:' . (date('Y') + 1),
            'nilai'                  => 'required|numeric|min:0|max:1',
            'status'                 => 'required|in:' . implode(',', StatusDesa::daftarStatus()),
            'skor_ketahanan_sosial'  => 'required|numeric|min:0|max:1',
            'skor_ketahanan_ekonomi' => 'required|numeric|min:0|max:1',
            'skor_ketahanan_ekologi' => 'required|numeric|min:0|max:1',
            'status_target'          => 'nullable|in:' . implode(',', StatusDesa::daftarStatus()),
            'nilai_target'           => 'nullable|numeric|min:0|max:1',
            'keterangan'             => 'nullable|string|max:1000',
            'dokumen'                => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $validated['dokumen']   = $this->simpanDokumen($request, 'status-desa');
        $validated['config_id'] = 1;

        $data = StatusDesa::create($validated);

        $this->catat('status_desa', "Menambahkan data IDM tahun {$data->tahun}", $data, [
            'tahun'  => $data->tahun,
            'nilai'  => $data->nilai,
            'status' => $data->status,
        ]);

        return redirect()->route('admin.status-desa.index')
            ->with('success', "Data IDM tahun {$data->tahun} berhasil ditambahkan.");
    }

    public function show(StatusDesa $statusDesa) {
        $tren = StatusDesa::dataTren();
        return view('admin.info-desa.status-desa.show', compact('statusDesa', 'tren'));
    }

    public function edit(StatusDesa $statusDesa) {
        return view('admin.info-desa.status-desa.edit', [
            'statusDesa'   => $statusDesa,
            'daftarStatus' => StatusDesa::daftarStatus(),
        ]);
    }

    public function update(Request $request, StatusDesa $statusDesa) {
        $validated = $request->validate([
            'nama_status'            => 'required|string|max:100',
            'tahun'                  => 'required|digits:4|integer|min:2000|max:' . (date('Y') + 1),
            'nilai'                  => 'required|numeric|min:0|max:1',
            'status'                 => 'required|in:' . implode(',', StatusDesa::daftarStatus()),
            'skor_ketahanan_sosial'  => 'required|numeric|min:0|max:1',
            'skor_ketahanan_ekonomi' => 'required|numeric|min:0|max:1',
            'skor_ketahanan_ekologi' => 'required|numeric|min:0|max:1',
            'status_target'          => 'nullable|in:' . implode(',', StatusDesa::daftarStatus()),
            'nilai_target'           => 'nullable|numeric|min:0|max:1',
            'keterangan'             => 'nullable|string|max:1000',
            'dokumen'                => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $dokumenBaru = $this->simpanDokumen($request, 'status-desa');
        if ($dokumenBaru) {
            $this->hapusDokumen($statusDesa->dokumen);
            $validated['dokumen'] = $dokumenBaru;
        }

        $lama = ['nilai' => $statusDesa->nilai, 'status' => $statusDesa->status];
        $statusDesa->update($validated);

        $this->catat('status_desa', "Memperbarui data IDM tahun {$statusDesa->tahun}", $statusDesa, [
            'dari' => $lama,
            'ke'   => ['nilai' => $statusDesa->nilai, 'status' => $statusDesa->status],
        ]);

        return redirect()->route('admin.status-desa.index')
            ->with('success', "Data IDM tahun {$statusDesa->tahun} berhasil diperbarui.");
    }

    public function destroy(StatusDesa $statusDesa) {
        $tahun = $statusDesa->tahun;

        $this->catat('status_desa', "Menghapus data IDM tahun {$tahun}", $statusDesa);
        $this->hapusDokumen($statusDesa->dokumen);
        $statusDesa->delete();

        return redirect()->route('admin.status-desa.index')
            ->with('success', "Data IDM tahun {$tahun} berhasil dihapus.");
    }

    // ── Export Excel ──────────────────────────────────────────────

    public function exportExcel() {
        $this->catat('status_desa', 'Export Excel data status desa');

        return Excel::download(
            new StatusDesaExport(),
            'status-desa-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    // ── Export PDF ────────────────────────────────────────────────

    public function exportPdf() {
        $statusDesa = StatusDesa::terbaru()->get();

        $this->catat('status_desa', 'Export PDF data status desa');

        $pdf = Pdf::loadView(
            'admin.info-desa.status-desa.pdf',
            ['statusDesa' => $statusDesa]
        )->setPaper('a4', 'landscape');

        return $pdf->download('status-desa-' . now()->format('Ymd-His') . '.pdf');
    }

    // ── Private Helpers ───────────────────────────────────────────

    private function simpanDokumen(Request $request, string $folder): ?string {
        if (!$request->hasFile('dokumen') || !$request->file('dokumen')->isValid()) {
            return null;
        }

        $file = $request->file('dokumen');

        if (!in_array($file->getMimeType(), self::ALLOWED_MIMES)) {
            abort(422, 'Tipe file tidak diizinkan.');
        }

        $ext = $file->getClientOriginalExtension();
        return $file->storeAs($folder, Str::uuid() . '.' . $ext, 'public');
    }

    private function hapusDokumen(?string $path): void {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

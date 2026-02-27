<?php

namespace App\Http\Controllers\Admin\InfoDesa;

use App\Http\Controllers\Controller;
use App\Models\LayananPelanggan;
use App\Traits\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LayananPelangganExport;

class LayananPelangganController extends Controller {
    use ActivityLogger;

    // ── Index ─────────────────────────────────────────────────────

    public function index(Request $request) {
        $query = LayananPelanggan::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_layanan',   'like', "%{$request->search}%")
                    ->orWhere('jenis_layanan', 'like', "%{$request->search}%")
                    ->orWhere('kode_layanan', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('jenis'))  $query->where('jenis_layanan', $request->jenis);
        if ($request->filled('status')) $query->where('status', $request->status);

        $layanan = $query->urut()->paginate(10)->withQueryString();

        $stats = [
            'total'        => LayananPelanggan::count(),
            'aktif'        => LayananPelanggan::aktif()->count(),
            'nonaktif'     => LayananPelanggan::where('status', 'nonaktif')->count(),
            'dengan_surat' => LayananPelanggan::whereNotNull('surat_format_id')->count(),
        ];

        // ── Cek modul surat dengan aman ──────────────────────────
        $modulSuratAda  = LayananPelanggan::modulSuratTersedia();
        $suratFormats   = $modulSuratAda
            ? \App\Models\SuratFormat::orderBy('nama')->get(['id', 'nama'])
            : collect();

        return view(
            'admin.info-desa.layanan-pelanggan.index',
            compact('layanan', 'stats', 'suratFormats', 'modulSuratAda')
        );
    }

    // ── Create ────────────────────────────────────────────────────

    public function create() {
        $modulSuratAda = LayananPelanggan::modulSuratTersedia();
        $suratFormats  = $modulSuratAda
            ? \App\Models\SuratFormat::orderBy('nama')->get(['id', 'nama'])
            : collect();

        return view('admin.info-desa.layanan-pelanggan.create', [
            'daftarJenis'      => LayananPelanggan::daftarJenis(),
            'layananPelanggan' => new LayananPelanggan(),
            'suratFormats'     => $suratFormats,
            'modulSuratAda'    => $modulSuratAda,
        ]);
    }

    // ── Store ─────────────────────────────────────────────────────

    public function store(Request $request) {
        $validated = $request->validate([
            'nama_layanan'       => 'required|string|max:200',
            'jenis_layanan'      => 'nullable|string|max:100',
            'deskripsi'          => 'nullable|string|max:2000',
            'persyaratan'        => 'nullable|string',
            'penanggung_jawab'   => 'nullable|string|max:150',
            'waktu_penyelesaian' => 'nullable|string|max:100',
            'biaya'              => 'nullable|string|max:100',
            'status'             => 'required|in:aktif,nonaktif',
            'urutan'             => 'nullable|integer|min:0',
            'kode_layanan'       => 'nullable|string|max:50|unique:layanan_pelanggan,kode_layanan',
            'dasar_hukum'        => 'nullable|string|max:255',
            'surat_format_id'    => 'nullable|integer',
        ]);

        $validated['config_id'] = 1;
        $data = LayananPelanggan::create($validated);

        $this->catat('layanan_pelanggan', "Menambahkan layanan \"{$data->nama_layanan}\"", $data);

        return redirect()->route('admin.layanan-pelanggan.index')
            ->with('success', "Layanan \"{$data->nama_layanan}\" berhasil ditambahkan.");
    }

    // ── Show ──────────────────────────────────────────────────────

    public function show(LayananPelanggan $layananPelanggan) {
        return view('admin.info-desa.layanan-pelanggan.show', compact('layananPelanggan'));
    }

    // ── Edit ──────────────────────────────────────────────────────

    public function edit(LayananPelanggan $layananPelanggan) {
        $modulSuratAda = LayananPelanggan::modulSuratTersedia();
        $suratFormats  = $modulSuratAda
            ? \App\Models\SuratFormat::orderBy('nama')->get(['id', 'nama'])
            : collect();

        return view('admin.info-desa.layanan-pelanggan.edit', [
            'layananPelanggan' => $layananPelanggan,
            'daftarJenis'      => LayananPelanggan::daftarJenis(),
            'suratFormats'     => $suratFormats,
            'modulSuratAda'    => $modulSuratAda,
        ]);
    }

    // ── Update ────────────────────────────────────────────────────

    public function update(Request $request, LayananPelanggan $layananPelanggan) {
        $validated = $request->validate([
            'nama_layanan'       => 'required|string|max:200',
            'jenis_layanan'      => 'nullable|string|max:100',
            'deskripsi'          => 'nullable|string|max:2000',
            'persyaratan'        => 'nullable|string',
            'penanggung_jawab'   => 'nullable|string|max:150',
            'waktu_penyelesaian' => 'nullable|string|max:100',
            'biaya'              => 'nullable|string|max:100',
            'status'             => 'required|in:aktif,nonaktif',
            'urutan'             => 'nullable|integer|min:0',
            'kode_layanan'       => 'nullable|string|max:50|unique:layanan_pelanggan,kode_layanan,' . $layananPelanggan->id,
            'dasar_hukum'        => 'nullable|string|max:255',
            'surat_format_id'    => 'nullable|integer',
        ]);

        $layananPelanggan->update($validated);

        $this->catat('layanan_pelanggan', "Memperbarui layanan \"{$layananPelanggan->nama_layanan}\"", $layananPelanggan);

        return redirect()->route('admin.layanan-pelanggan.index')
            ->with('success', "Layanan \"{$layananPelanggan->nama_layanan}\" berhasil diperbarui.");
    }

    // ── Destroy ───────────────────────────────────────────────────

    public function destroy(LayananPelanggan $layananPelanggan) {
        $nama = $layananPelanggan->nama_layanan;

        $this->catat('layanan_pelanggan', "Menghapus layanan \"{$nama}\"", $layananPelanggan);
        $layananPelanggan->delete();

        return redirect()->route('admin.layanan-pelanggan.index')
            ->with('success', "Layanan \"{$nama}\" berhasil dihapus.");
    }

    // ── Export Excel ──────────────────────────────────────────────

    public function exportExcel() {
        $this->catat('layanan_pelanggan', 'Export Excel data layanan pelanggan');

        return Excel::download(
            new LayananPelangganExport(),
            'layanan-pelanggan-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    // ── Export PDF ────────────────────────────────────────────────

    public function exportPdf() {
        $layanan = LayananPelanggan::urut()->get();

        $this->catat('layanan_pelanggan', 'Export PDF data layanan pelanggan');

        $pdf = Pdf::loadView(
            'admin.info-desa.layanan-pelanggan.pdf',
            ['layanan' => $layanan]
        )->setPaper('a4', 'landscape');

        return $pdf->download('layanan-pelanggan-' . now()->format('Ymd-His') . '.pdf');
    }
}

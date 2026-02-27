<?php

namespace App\Http\Controllers\Admin\InfoDesa;

use App\Http\Controllers\Controller;
use App\Models\Kerjasama;
use App\Traits\ActivityLogger;
use App\Exports\KerjasamaExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class KerjasamaController extends Controller {
    use ActivityLogger;

    private const ALLOWED_MIMES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    public function index(Request $request) {
        $query = Kerjasama::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_mitra',        'like', "%{$request->search}%")
                    ->orWhere('nomor_perjanjian', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status'))      $query->where('status', $request->status);
        if ($request->filled('jenis_mitra')) $query->where('jenis_mitra', $request->jenis_mitra);

        $kerjasama = $query->orderByDesc('tanggal_mulai')->paginate(10)->withQueryString();

        $stats = [
            'total'           => Kerjasama::count(),
            'aktif'           => Kerjasama::where('status', 'aktif')->count(),
            'berakhir'        => Kerjasama::where('status', 'berakhir')->count(),
            'ditangguhkan'    => Kerjasama::where('status', 'ditangguhkan')->count(),
            'hampir_berakhir' => Kerjasama::hampirBerakhir()->count(),
        ];

        return view('admin.info-desa.kerjasama.index', compact('kerjasama', 'stats'));
    }

    public function create() {
        return view('admin.info-desa.kerjasama.create', [
            'kerjasama'            => new Kerjasama(),
            'daftarJenisMitra'     => Kerjasama::daftarJenisMitra(),
            'daftarJenisKerjasama' => Kerjasama::daftarJenisKerjasama(),
        ]);
    }

    public function store(Request $request) {
        $validated = $this->validasiRequest($request);
        $validated['dokumen']   = $this->simpanDokumen($request);
        $validated['config_id'] = 1;

        $data = Kerjasama::create($validated);

        $this->catat('kerjasama', "Menambahkan kerjasama dengan \"{$data->nama_mitra}\"", $data);

        return redirect()->route('admin.kerjasama.index')
            ->with('success', "Kerjasama dengan \"{$data->nama_mitra}\" berhasil ditambahkan.");
    }

    public function show(Kerjasama $kerjasama) {
        return view('admin.info-desa.kerjasama.show', compact('kerjasama'));
    }

    public function edit(Kerjasama $kerjasama) {
        return view('admin.info-desa.kerjasama.edit', [
            'kerjasama'            => $kerjasama,
            'daftarJenisMitra'     => Kerjasama::daftarJenisMitra(),
            'daftarJenisKerjasama' => Kerjasama::daftarJenisKerjasama(),
        ]);
    }

    public function update(Request $request, Kerjasama $kerjasama) {
        $validated   = $this->validasiRequest($request);
        $dokumenBaru = $this->simpanDokumen($request);

        if ($dokumenBaru) {
            $this->hapusDokumen($kerjasama->dokumen);
            $validated['dokumen'] = $dokumenBaru;
        }

        $kerjasama->update($validated);

        $this->catat('kerjasama', "Memperbarui kerjasama \"{$kerjasama->nama_mitra}\"", $kerjasama);

        return redirect()->route('admin.kerjasama.index')
            ->with('success', "Kerjasama dengan \"{$kerjasama->nama_mitra}\" berhasil diperbarui.");
    }

    public function destroy(Kerjasama $kerjasama) {
        $nama = $kerjasama->nama_mitra;

        $this->catat('kerjasama', "Menghapus kerjasama \"{$nama}\"", $kerjasama);
        $this->hapusDokumen($kerjasama->dokumen);
        $kerjasama->delete();

        return redirect()->route('admin.kerjasama.index')
            ->with('success', "Kerjasama dengan \"{$nama}\" berhasil dihapus.");
    }

    // ── Export Excel ──────────────────────────────────────────────

    public function exportExcel() {
        $this->catat('kerjasama', 'Export Excel data kerjasama');

        return Excel::download(
            new KerjasamaExport(),
            'kerjasama-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    // ── Export PDF ────────────────────────────────────────────────

    public function exportPdf() {
        $kerjasama = Kerjasama::orderByDesc('tanggal_mulai')->get();

        $this->catat('kerjasama', 'Export PDF data kerjasama');

        $pdf = Pdf::loadView(
            'admin.info-desa.kerjasama.pdf',
            ['kerjasama' => $kerjasama]
        )->setPaper('a4', 'landscape');

        return $pdf->download('kerjasama-' . now()->format('Ymd-His') . '.pdf');
    }

    // ── Private Helpers ───────────────────────────────────────────

    private function validasiRequest(Request $request): array {
        return $request->validate([
            'nomor_perjanjian' => 'nullable|string|max:100',
            'nama_mitra'       => 'required|string|max:200',
            'jenis_mitra'      => 'nullable|string|max:100',
            'alamat_mitra'     => 'nullable|string',
            'kontak_mitra'     => 'nullable|string|max:100',
            'jenis_kerjasama'  => 'nullable|string|max:150',
            'ruang_lingkup'    => 'nullable|string',
            'tanggal_mulai'    => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status'           => 'required|in:aktif,berakhir,ditangguhkan',
            'dokumen'          => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'keterangan'       => 'nullable|string|max:1000',
        ]);
    }

    private function simpanDokumen(Request $request): ?string {
        if (!$request->hasFile('dokumen') || !$request->file('dokumen')->isValid()) {
            return null;
        }

        $file = $request->file('dokumen');

        if (!in_array($file->getMimeType(), self::ALLOWED_MIMES)) {
            abort(422, 'Tipe file tidak diizinkan.');
        }

        $ext = $file->getClientOriginalExtension();
        return $file->storeAs('kerjasama', Str::uuid() . '.' . $ext, 'public');
    }

    private function hapusDokumen(?string $path): void {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

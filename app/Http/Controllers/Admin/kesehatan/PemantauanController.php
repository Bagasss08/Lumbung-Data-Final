<?php

namespace App\Http\Controllers\Admin\kesehatan;

use App\Http\Controllers\Controller;
use App\Models\RekapKesehatan;
use App\Models\Kia;
use App\Models\Vaksin;
use App\Models\PemantauanAnak;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PemantauanController extends Controller {
    /**
     * Halaman Rekap Kesehatan Desa (sub-menu Pemantauan)
     */
    public function index(): View {
        $rekap = RekapKesehatan::orderBy('tahun', 'desc')->get();

        // Data real-time dari tabel lain untuk perbandingan
        $realtimeData = [
            'ibu_hamil'     => Kia::hamil()->count(),
            'balita'        => Kia::punyaAnak()->whereHas('pemantauanAnak', fn($q) => $q->where('umur_bulan', '<=', 60))->count(),
            'stunting'      => PemantauanAnak::where('tahun', date('Y'))->whereIn('status_tb_u', ['pendek', 'sangat_pendek'])->count(),
            'posyandu'      => Posyandu::aktif()->count(),
            'vaksin'        => Vaksin::where('status', 'sudah')->whereYear('tanggal_vaksin', date('Y'))->count(),
        ];

        return view('admin.kesehatan.pemantauan.index', compact('rekap', 'realtimeData'));
    }

    public function createRekap(): View {
        $tahunTersedia = RekapKesehatan::pluck('tahun')->toArray();
        return view('admin.kesehatan.pemantauan.rekap-form', compact('tahunTersedia'));
    }

    public function storeRekap(Request $request): RedirectResponse {
        $validated = $request->validate([
            'tahun'                    => 'required|integer|min:2000|max:2100|unique:rekap_kesehatan,tahun',
            'jumlah_puskesmas'         => 'nullable|integer|min:0',
            'jumlah_pustu'             => 'nullable|integer|min:0',
            'jumlah_posyandu'          => 'nullable|integer|min:0',
            'jumlah_polindes'          => 'nullable|integer|min:0',
            'jumlah_dokter'            => 'nullable|integer|min:0',
            'jumlah_bidan'             => 'nullable|integer|min:0',
            'jumlah_perawat'           => 'nullable|integer|min:0',
            'jumlah_kader_aktif'       => 'nullable|integer|min:0',
            'jumlah_ibu_hamil'         => 'nullable|integer|min:0',
            'jumlah_balita'            => 'nullable|integer|min:0',
            'jumlah_bayi'              => 'nullable|integer|min:0',
            'jumlah_anak_pra_sekolah'  => 'nullable|integer|min:0',
            'jumlah_lansia'            => 'nullable|integer|min:0',
            'kasus_diare'              => 'nullable|integer|min:0',
            'kasus_ispa'               => 'nullable|integer|min:0',
            'kasus_dbd'                => 'nullable|integer|min:0',
            'kasus_tb'                 => 'nullable|integer|min:0',
            'kasus_malaria'            => 'nullable|integer|min:0',
            'kasus_hipertensi'         => 'nullable|integer|min:0',
            'kasus_diabetes'           => 'nullable|integer|min:0',
            'kasus_lainnya'            => 'nullable|integer|min:0',
            'cakupan_imunisasi_dasar'  => 'nullable|integer|min:0|max:100',
            'cakupan_asi_eksklusif'    => 'nullable|integer|min:0|max:100',
            'cakupan_kia'              => 'nullable|integer|min:0|max:100',
            'prevalensi_stunting'      => 'nullable|integer|min:0|max:100',
            'prevalensi_gizi_buruk'    => 'nullable|integer|min:0|max:100',
            'keterangan'               => 'nullable|string',
        ]);

        RekapKesehatan::create($validated);

        return redirect()->route('admin.kesehatan.pemantauan')
            ->with('success', 'Data rekap kesehatan tahun ' . $validated['tahun'] . ' berhasil disimpan.');
    }

    public function editRekap(RekapKesehatan $rekapKesehatan): View {
        return view('admin.kesehatan.pemantauan.rekap-form', ['rekap' => $rekapKesehatan]);
    }

    public function updateRekap(Request $request, RekapKesehatan $rekapKesehatan): RedirectResponse {
        $validated = $request->validate([
            'tahun'                    => 'required|integer|min:2000|max:2100|unique:rekap_kesehatan,tahun,' . $rekapKesehatan->id,
            'jumlah_puskesmas'         => 'nullable|integer|min:0',
            'jumlah_pustu'             => 'nullable|integer|min:0',
            'jumlah_posyandu'          => 'nullable|integer|min:0',
            'jumlah_polindes'          => 'nullable|integer|min:0',
            'jumlah_dokter'            => 'nullable|integer|min:0',
            'jumlah_bidan'             => 'nullable|integer|min:0',
            'jumlah_perawat'           => 'nullable|integer|min:0',
            'jumlah_kader_aktif'       => 'nullable|integer|min:0',
            'jumlah_ibu_hamil'         => 'nullable|integer|min:0',
            'jumlah_balita'            => 'nullable|integer|min:0',
            'jumlah_bayi'              => 'nullable|integer|min:0',
            'jumlah_anak_pra_sekolah'  => 'nullable|integer|min:0',
            'jumlah_lansia'            => 'nullable|integer|min:0',
            'kasus_diare'              => 'nullable|integer|min:0',
            'kasus_ispa'               => 'nullable|integer|min:0',
            'kasus_dbd'                => 'nullable|integer|min:0',
            'kasus_tb'                 => 'nullable|integer|min:0',
            'kasus_malaria'            => 'nullable|integer|min:0',
            'kasus_hipertensi'         => 'nullable|integer|min:0',
            'kasus_diabetes'           => 'nullable|integer|min:0',
            'kasus_lainnya'            => 'nullable|integer|min:0',
            'cakupan_imunisasi_dasar'  => 'nullable|integer|min:0|max:100',
            'cakupan_asi_eksklusif'    => 'nullable|integer|min:0|max:100',
            'cakupan_kia'              => 'nullable|integer|min:0|max:100',
            'prevalensi_stunting'      => 'nullable|integer|min:0|max:100',
            'prevalensi_gizi_buruk'    => 'nullable|integer|min:0|max:100',
            'keterangan'               => 'nullable|string',
        ]);

        $rekapKesehatan->update($validated);

        return redirect()->route('admin.kesehatan.pemantauan')
            ->with('success', 'Data rekap kesehatan berhasil diperbarui.');
    }

    public function destroyRekap(RekapKesehatan $rekapKesehatan): RedirectResponse {
        $rekapKesehatan->delete();
        return redirect()->route('admin.kesehatan.pemantauan')
            ->with('success', 'Data rekap kesehatan berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin\InfoDesa;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use App\Models\IdentitasDesa; // [PERBAIKAN 1] Ubah Desa menjadi IdentitasDesa
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index()
    {
        $wilayahRecords = Wilayah::all();

        $data = [
            'total_dusun' => $wilayahRecords->count(),
            'total_rw' => $wilayahRecords->sum('rw'),
            'total_rt' => $wilayahRecords->sum('rt'),
            'total_penduduk' => $wilayahRecords->sum('laki_laki') + $wilayahRecords->sum('perempuan'),
            'wilayah' => $wilayahRecords->map(function ($wilayah) {
                return [
                    'id' => $wilayah->id,
                    'nama' => $wilayah->dusun,
                    'kepala_wilayah' => $wilayah->ketua_rw,
                    'rw' => $wilayah->rw,
                    'rt' => $wilayah->rt,
                    'kk' => $wilayah->jumlah_kk,
                    'laki_laki' => $wilayah->laki_laki,
                    'perempuan' => $wilayah->perempuan,
                ];
            })->toArray()
        ];

        return view('admin.info-desa.wilayah-administratif', compact('data'));
    }

    public function create()
    {
        return view('admin.info-desa.wilayah-create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'kepala_wilayah' => 'required|string|max:255',
            'rw' => 'required|integer|min:1',
            'rt' => 'required|integer|min:1',
            'kk' => 'required|integer|min:0',
            'laki_laki' => 'required|integer|min:0',
            'perempuan' => 'required|integer|min:0',
        ]);

        // [PERBAIKAN 2] Gunakan IdentitasDesa, bukan Desa
        $desa = IdentitasDesa::first();
        
        if (!$desa) {
            return redirect()->back()->with('error', 'Data desa belum diatur. Silakan atur identitas desa terlebih dahulu.');
        }

        Wilayah::create([
            'desa_id' => $desa->id,
            'dusun' => $request->nama,
            'ketua_rw' => $request->kepala_wilayah,
            'rw' => $request->rw,
            'rt' => $request->rt,
            'jumlah_kk' => $request->kk,
            'laki_laki' => $request->laki_laki,
            'perempuan' => $request->perempuan,
            'jumlah_penduduk' => $request->laki_laki + $request->perempuan,
        ]);

        return redirect()->route('admin.info-desa.wilayah-administratif')
                        ->with('success', 'Dusun berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $wilayahRecord = Wilayah::findOrFail($id);
        $wilayah = [
            'id' => $wilayahRecord->id,
            'nama' => $wilayahRecord->dusun,
            'kepala_wilayah' => $wilayahRecord->ketua_rw,
            'rw' => $wilayahRecord->rw,
            'rt' => $wilayahRecord->rt,
            'kk' => $wilayahRecord->jumlah_kk,
            'laki_laki' => $wilayahRecord->laki_laki,
            'perempuan' => $wilayahRecord->perempuan,
        ];

        return view('admin.info-desa.wilayah-edit', compact('wilayah'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'kepala_wilayah' => 'required|string|max:255',
            'rw' => 'required|integer|min:1',
            'rt' => 'required|integer|min:1',
            'kk' => 'required|integer|min:0',
            'laki_laki' => 'required|integer|min:0',
            'perempuan' => 'required|integer|min:0',
        ]);

        $wilayah = Wilayah::findOrFail($id);
        $wilayah->update([
            'dusun' => $request->nama,
            'ketua_rw' => $request->kepala_wilayah,
            'rw' => $request->rw,
            'rt' => $request->rt,
            'jumlah_kk' => $request->kk,
            'laki_laki' => $request->laki_laki,
            'perempuan' => $request->perempuan,
            'jumlah_penduduk' => $request->laki_laki + $request->perempuan,
        ]);

        return redirect()->route('admin.info-desa.wilayah-administratif')
                        ->with('success', 'Dusun berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $wilayah = Wilayah::findOrFail($id);

        // Check for related records (including soft deleted)
        $relatedPenduduk = $wilayah->penduduk()->count();
        $relatedKeluarga = $wilayah->keluarga()->withTrashed()->count();
        $relatedRumahTangga = \App\Models\RumahTangga::where('wilayah_id', $id)->count();

        if ($relatedPenduduk > 0 || $relatedKeluarga > 0 || $relatedRumahTangga > 0) {
            return redirect()->route('admin.info-desa.wilayah-administratif')
                            ->with('error', 'Dusun tidak dapat dihapus karena masih memiliki data terkait: ' .
                                    ($relatedPenduduk > 0 ? $relatedPenduduk . ' penduduk, ' : '') .
                                    ($relatedKeluarga > 0 ? $relatedKeluarga . ' keluarga, ' : '') .
                                    ($relatedRumahTangga > 0 ? $relatedRumahTangga . ' rumah tangga' : '') .
                                    '. Hapus data terkait terlebih dahulu.');
        }

        $wilayah->delete();

        return redirect()->route('admin.info-desa.wilayah-administratif')
                        ->with('success', 'Dusun berhasil dihapus!');
    }

    public function confirmDestroy($id)
    {
        $wilayah = Wilayah::findOrFail($id);

        // Check for related records
        $relatedPenduduk = $wilayah->penduduk()->count();
        $relatedKeluarga = $wilayah->keluarga()->withTrashed()->count();
        $relatedRumahTangga = \App\Models\RumahTangga::where('wilayah_id', $id)->count();

        return view('admin.info-desa.wilayah-delete', compact('wilayah', 'relatedPenduduk', 'relatedKeluarga', 'relatedRumahTangga'));
    }
}
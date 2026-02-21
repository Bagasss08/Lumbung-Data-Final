<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RumahTangga;
use App\Models\RumahTanggaPenduduk;
use Illuminate\Http\Request;

class RumahTanggaAnggotaController extends Controller
{
    public function index(RumahTangga $rumahTangga)
    {
        $anggota = $rumahTangga->penduduks()->withPivot('hubungan_rumah_tangga')->get();

        return view('admin.rumah-tangga-anggota.index', compact('rumahTangga', 'anggota'));
    }

    public function create(RumahTangga $rumahTangga)
    {
        // Get penduduk that are not already in this rumah tangga
        $availablePenduduk = \App\Models\Penduduk::whereDoesntHave('rumahTanggas', function($query) use ($rumahTangga) {
            $query->where('rumah_tangga_id', $rumahTangga->id);
        })->get();

        return view('admin.rumah-tangga-anggota.create', compact('rumahTangga', 'availablePenduduk'));
    }

    public function store(Request $request, RumahTangga $rumahTangga)
    {
        $validated = $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'hubungan_rumah_tangga' => 'required|string|max:255',
        ]);

        // Check if penduduk is already in this rumah tangga
        $exists = $rumahTangga->penduduks()->where('penduduk_id', $request->penduduk_id)->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['penduduk_id' => 'Penduduk sudah ada dalam rumah tangga ini.']);
        }

        $rumahTangga->penduduks()->attach($request->penduduk_id, [
            'hubungan_rumah_tangga' => $request->hubungan_rumah_tangga
        ]);

        return redirect()->route('admin.rumah-tangga-anggota.index', $rumahTangga)
            ->with('success', 'Anggota rumah tangga berhasil ditambahkan.');
    }

    public function edit(RumahTangga $rumahTangga, $anggotaId)
    {
        $anggota = $rumahTangga->penduduks()->where('penduduk_id', $anggotaId)->withPivot('hubungan_rumah_tangga')->first();

        if (!$anggota) {
            abort(404);
        }

        return view('admin.rumah-tangga-anggota.edit', compact('rumahTangga', 'anggota'));
    }

    public function update(Request $request, RumahTangga $rumahTangga, $anggotaId)
    {
        $validated = $request->validate([
            'hubungan_rumah_tangga' => 'required|string|max:255',
        ]);

        $rumahTangga->penduduks()->updateExistingPivot($anggotaId, [
            'hubungan_rumah_tangga' => $request->hubungan_rumah_tangga
        ]);

        return redirect()->route('admin.rumah-tangga-anggota.index', $rumahTangga)
            ->with('success', 'Anggota rumah tangga berhasil diperbarui.');
    }

    public function destroy(RumahTangga $rumahTangga, $anggotaId)
    {
        $rumahTangga->penduduks()->detach($anggotaId);

        return redirect()->route('admin.rumah-tangga-anggota.index', $rumahTangga)
            ->with('success', 'Anggota rumah tangga berhasil dihapus.');
    }
}

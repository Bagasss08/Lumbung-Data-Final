<?php

namespace App\Http\Controllers\Admin\Kependudukan;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\RumahTangga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class RumahTanggaAnggotaController extends Controller {
    // =========================================================================
    // PATCH /admin/rumah-tangga/{rumahTangga}/anggota/{penduduk}/hubungan
    // Dipanggil dari modal "Ubah Hubungan RT" di blade
    // =========================================================================
    public function updateHubungan(Request $request, RumahTangga $rumahTangga, Penduduk $penduduk) {
        $request->validate([
            'hubungan_rumah_tangga' => 'required|in:Kepala Rumah Tangga,Anggota',
        ]);

        // Validasi: penduduk harus benar-benar anggota RT ini (via KK-nya)
        $isAnggota = $rumahTangga->keluarga()
            ->whereHas('anggota', fn($q) => $q->where('penduduk.id', $penduduk->id))
            ->exists();

        if (! $isAnggota) {
            return back()->with('error', 'Penduduk tidak terdaftar dalam rumah tangga ini.');
        }

        if ($request->hubungan_rumah_tangga === 'Kepala Rumah Tangga') {
            // Jadikan penduduk ini kepala RT
            if (Schema::hasColumn('rumah_tangga', 'kepala_penduduk_id')) {
                $rumahTangga->update(['kepala_penduduk_id' => $penduduk->id]);
            }
        } else {
            // Turunkan menjadi Anggota: reset kepala jika dia yang sedang menjabat
            if (
                Schema::hasColumn('rumah_tangga', 'kepala_penduduk_id') &&
                (int) $rumahTangga->kepala_penduduk_id === $penduduk->id
            ) {
                $rumahTangga->update(['kepala_penduduk_id' => null]);
            }
        }

        return back()->with('success', "Hubungan rumah tangga {$penduduk->nama} berhasil diperbarui.");
    }

    // =========================================================================
    // DELETE /admin/rumah-tangga/{rumahTangga}/anggota/{penduduk}
    // Dipanggil dari modal "Hapus satu anggota" di blade
    // Melepas KK-nya dari RT (data penduduk tidak dihapus)
    // =========================================================================
    public function destroy(RumahTangga $rumahTangga, Penduduk $penduduk) {
        $kk = $penduduk->keluarga;

        if (! $kk || (int) $kk->rumah_tangga_id !== $rumahTangga->id) {
            return back()->with('error', 'Penduduk tidak terdaftar dalam rumah tangga ini.');
        }

        $kk->update(['rumah_tangga_id' => null]);

        // Reset kepala RT jika dia yang sedang menjabat
        if (
            Schema::hasColumn('rumah_tangga', 'kepala_penduduk_id') &&
            (int) $rumahTangga->kepala_penduduk_id === $penduduk->id
        ) {
            $rumahTangga->update(['kepala_penduduk_id' => null]);
        }

        return back()->with(
            'success',
            "{$penduduk->nama} berhasil dilepas dari rumah tangga {$rumahTangga->no_rumah_tangga}."
        );
    }

    // =========================================================================
    // DELETE /admin/rumah-tangga/{rumahTangga}/anggota/bulk-destroy
    // Dipanggil dari modal "Hapus Bulk" di blade show
    // ids[] berisi penduduk_id (bukan rt_id)
    // =========================================================================
    public function bulkDestroy(Request $request, RumahTangga $rumahTangga) {
        $ids = array_filter((array) $request->input('ids', []));

        if (empty($ids)) {
            return back()->with('error', 'Pilih minimal satu anggota untuk dihapus.');
        }

        $berhasil = 0;
        $gagal    = 0;

        $penduduks = Penduduk::whereIn('id', $ids)->with('keluarga')->get();

        foreach ($penduduks as $penduduk) {
            $kk = $penduduk->keluarga;

            if (! $kk || (int) $kk->rumah_tangga_id !== $rumahTangga->id) {
                $gagal++;
                continue;
            }

            $kk->update(['rumah_tangga_id' => null]);

            if (
                Schema::hasColumn('rumah_tangga', 'kepala_penduduk_id') &&
                (int) $rumahTangga->kepala_penduduk_id === $penduduk->id
            ) {
                $rumahTangga->update(['kepala_penduduk_id' => null]);
            }

            $berhasil++;
        }

        $msg = "{$berhasil} anggota berhasil dilepas dari rumah tangga.";
        if ($gagal > 0) {
            $msg .= " {$gagal} tidak dapat diproses.";
        }

        return back()->with($berhasil > 0 ? 'success' : 'error', $msg);
    }
}

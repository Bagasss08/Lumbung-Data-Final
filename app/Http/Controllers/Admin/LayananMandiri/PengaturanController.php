<?php

namespace App\Http\Controllers\Admin\LayananMandiri;

use App\Http\Controllers\Controller;
use App\Models\LayananMandiriPengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller {
    /**
     * Tampilkan halaman pengaturan Layanan Mandiri.
     */
    public function index() {
        $pengaturan = LayananMandiriPengaturan::first();

        return view('admin.layanan-mandiri.pengaturan', compact('pengaturan'));
    }

    /**
     * Simpan / update pengaturan Layanan Mandiri.
     */
    public function update(Request $request) {
        $request->validate([
            'aktif'                  => 'required|in:Ya,Tidak',
            'tampilkan_pendaftaran'  => 'required|in:Ya,Tidak',
            'tampilkan_ektp'         => 'required|in:Ya,Tidak',
            'latar_login'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'latar_login.image'  => 'File harus berupa gambar.',
            'latar_login.mimes'  => 'Format gambar harus JPG, PNG, atau WEBP.',
            'latar_login.max'    => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $pengaturan = LayananMandiriPengaturan::firstOrNew([]);

        // Handle hapus latar
        if ($request->boolean('hapus_latar') && $pengaturan->latar_login) {
            Storage::disk('public')->delete('layanan-mandiri/' . $pengaturan->latar_login);
            $pengaturan->latar_login = null;
        }

        // Handle upload latar baru
        if ($request->hasFile('latar_login')) {
            // Hapus latar lama jika ada
            if ($pengaturan->latar_login) {
                Storage::disk('public')->delete('layanan-mandiri/' . $pengaturan->latar_login);
            }

            $file     = $request->file('latar_login');
            $fileName = 'latar_' . time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('layanan-mandiri', $fileName, 'public');
            $pengaturan->latar_login = $fileName;
        }

        $pengaturan->aktif                 = $request->aktif;
        $pengaturan->tampilkan_pendaftaran = $request->tampilkan_pendaftaran;
        $pengaturan->tampilkan_ektp        = $request->tampilkan_ektp;
        $pengaturan->save();

        return redirect()
            ->route('admin.layanan-mandiri.pengaturan.index')
            ->with('success', 'Pengaturan Layanan Mandiri berhasil disimpan.');
    }
}

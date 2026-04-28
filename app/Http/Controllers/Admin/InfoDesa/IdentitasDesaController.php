<?php

namespace App\Http\Controllers\Admin\InfoDesa;

use App\Http\Controllers\Controller;
use App\Models\IdentitasDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IdentitasDesaController extends Controller {
    public function index() {
        $desa = IdentitasDesa::first();

        if (!$desa) {
            $desa = IdentitasDesa::create([
                'nama_desa' => '',
                'kode_desa' => '',   // ← FIX: wajib ada agar tidak NULL
                'kecamatan' => '',
                'kabupaten' => '',
                'provinsi'  => '',
            ]);
        }

        return view('admin.identitas-desa.index', compact('desa'));
    }

    public function edit() {
        $desa = IdentitasDesa::first();

        if (!$desa) {
            $desa = IdentitasDesa::create([
                'nama_desa' => 'Desa Belum Diatur',
                'kode_desa' => '',   // ← FIX: sebelumnya tidak ada, menyebabkan NOT NULL error
                'kecamatan' => '-',
                'kabupaten' => '-',
                'provinsi'  => '-',
            ]);
        }

        return view('admin.identitas-desa.edit', compact('desa'));
    }

    public function update(Request $request) {
        $request->validate([
            'nama_desa'       => 'required|string|max:255',   // ← FIX: wajib diisi
            'kode_desa'       => 'nullable|string|max:255',
            'kode_bps_desa'   => 'nullable|string|max:255',
            'kode_pos'        => 'nullable|string|max:255',
            'kecamatan'       => 'required|string|max:255',   // ← FIX: wajib diisi
            'kode_kecamatan'  => 'nullable|string|max:255',
            'nama_camat'      => 'nullable|string|max:255',
            'nip_camat'       => 'nullable|string|max:255',
            'kabupaten'       => 'required|string|max:255',   // ← FIX: wajib diisi
            'kode_kabupaten'  => 'nullable|string|max:255',
            'provinsi'        => 'required|string|max:255',   // ← FIX: wajib diisi
            'kode_provinsi'   => 'nullable|string|max:255',
            'kepala_desa'     => 'nullable|string|max:255',
            'nip_kepala_desa' => 'nullable|string|max:255',
            'alamat_kantor'   => 'nullable|string',
            'email_desa'      => 'nullable|email',
            'telepon_desa'    => 'nullable|string|max:255',
            'ponsel_desa'     => 'nullable|string|max:255',
            'link_peta'       => 'nullable|string',
            'website_desa'    => [
                'nullable',
                'url',
                'regex:/^https:\/\//'
            ],
            'facebook'        => 'nullable|url|max:255',
            'instagram'       => 'nullable|url|max:255',
            'youtube'         => 'nullable|url|max:255',
            'logo_desa'       => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'gambar_kantor'   => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'nama_desa.required'     => 'Nama desa wajib diisi.',
            'kecamatan.required'     => 'Nama kecamatan wajib diisi.',
            'kabupaten.required'     => 'Nama kabupaten wajib diisi.',
            'provinsi.required'      => 'Nama provinsi wajib diisi.',
            'website_desa.url'       => 'Format website tidak valid.',
            'website_desa.regex'     => 'Website harus menggunakan https://',
            'email_desa.email'       => 'Format email tidak valid.',
            'facebook.url'           => 'URL Facebook tidak valid. Contoh: https://facebook.com/namahalaman',
            'instagram.url'          => 'URL Instagram tidak valid. Contoh: https://instagram.com/namaakun',
            'youtube.url'            => 'URL YouTube tidak valid. Contoh: https://youtube.com/@namachannel',
            'logo_desa.image'        => 'File logo harus berupa gambar.',
            'logo_desa.mimes'        => 'Logo hanya boleh format PNG, JPG, atau JPEG.',
            'logo_desa.max'          => 'Ukuran logo maksimal 2MB.',
            'gambar_kantor.image'    => 'File gambar kantor harus berupa gambar.',
            'gambar_kantor.mimes'    => 'Gambar kantor hanya boleh format PNG, JPG, atau JPEG.',
            'gambar_kantor.max'      => 'Ukuran gambar kantor maksimal 2MB.',
        ]);

        $desa = IdentitasDesa::first();

        if (!$desa) {
            $desa = new IdentitasDesa();
        }

        // ── FIX: Cegah NOT NULL violation ─────────────────────────────────
        // Laravel middleware ConvertEmptyStringsToNull mengubah '' menjadi null
        // Kolom-kolom ini di DB pakai default('') bukan nullable, jadi harus ''
        $notNullFields = ['kode_desa', 'kecamatan', 'kabupaten', 'provinsi'];
        foreach ($notNullFields as $field) {
            if (is_null($request->input($field))) {
                $request->merge([$field => '']);
            }
        }
        // ──────────────────────────────────────────────────────────────────

        // Handle logo upload
        if ($request->hasFile('logo_desa')) {
            if ($desa->logo_desa && Storage::disk('public')->exists('logo-desa/' . $desa->logo_desa)) {
                Storage::disk('public')->delete('logo-desa/' . $desa->logo_desa);
            }
            $logoPath = $request->file('logo_desa')->store('logo-desa', 'public');
            $desa->logo_desa = basename($logoPath);
        }

        // Handle gambar kantor upload
        if ($request->hasFile('gambar_kantor')) {
            if ($desa->gambar_kantor && Storage::disk('public')->exists('gambar-kantor/' . $desa->gambar_kantor)) {
                Storage::disk('public')->delete('gambar-kantor/' . $desa->gambar_kantor);
            }
            $kantorPath = $request->file('gambar_kantor')->store('gambar-kantor', 'public');
            $desa->gambar_kantor = basename($kantorPath);
        }

        $desa->fill($request->except(['logo_desa', 'gambar_kantor']));
        $desa->save();

        return redirect()
            ->route('admin.identitas-desa.index')
            ->with('success', 'Identitas Desa berhasil diperbarui');
    }
}

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
                'kode_desa' => '',
                'kecamatan' => '',
                'kabupaten' => '',
                'provinsi' => '',
            ]);
        }

        return view('admin.identitas-desa.index', compact('desa'));
    }

    public function edit() {
        $desa = IdentitasDesa::first();

        if (!$desa) {
            $desa = IdentitasDesa::create([
                'nama_desa' => 'Desa Belum Diatur',
                'kecamatan' => '-',
                'kabupaten' => '-',
                'provinsi' => '-',
            ]);
        }

        return view('admin.identitas-desa.edit', compact('desa'));
    }

    public function update(Request $request) {
        $request->validate([
            'nama_desa'     => 'nullable|string|max:255',
            'kode_desa'     => 'nullable|string|max:255',
            'kode_bps_desa' => 'nullable|string|max:255',
            'kode_pos'      => 'nullable|string|max:255',
            'kecamatan'     => 'nullable|string|max:255',
            'kode_kecamatan' => 'nullable|string|max:255',
            'nama_camat'    => 'nullable|string|max:255',
            'nip_camat'     => 'nullable|string|max:255',
            'kabupaten'     => 'nullable|string|max:255',
            'kode_kabupaten' => 'nullable|string|max:255',
            'provinsi'      => 'nullable|string|max:255',
            'kepala_desa'   => 'nullable|string|max:255',
            'nip_kepala_desa' => 'nullable|string|max:255',
            'alamat_kantor' => 'nullable|string',
            'email_desa'    => 'nullable|email',
            'telepon_desa'  => 'nullable|string|max:255',
            'ponsel_desa'   => 'nullable|string|max:255',
            'website_desa' => [
                'nullable',
                'url',
                'regex:/^https:\/\//'
            ],
            'logo_desa'     => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'gambar_kantor' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'website_desa.url' => 'Format website tidak valid.',
            'website_desa.regex' => 'Website harus menggunakan https://',
        ]);

        $desa = IdentitasDesa::first();

        if (!$desa) {
            $desa = new IdentitasDesa();
        }

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

        // Update other fields
        $desa->fill($request->except(['logo_desa', 'gambar_kantor']));
        $desa->save();

        return redirect()
            ->route('admin.identitas-desa.index')
            ->with('success', 'Identitas Desa berhasil diperbarui');
    }
}

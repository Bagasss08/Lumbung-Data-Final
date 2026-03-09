<?php

namespace App\Http\Controllers\Admin\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BukuPemerintah;

class PemerintahController extends Controller
{
    public function index()
    {
        $pemerintah = BukuPemerintah::latest()->paginate(10);
        return view('admin.buku-administrasi.umum.pemerintah.index', compact('pemerintah'));
    }

    public function create()
    {
        return view('admin.buku-administrasi.umum.pemerintah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'niap' => 'nullable|string|max:100',
            'nip' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'pangkat_golongan' => 'nullable|string|max:100',
            'jabatan' => 'required|string|max:100',
            'pendidikan_terakhir' => 'required|string|max:100',
            'nomor_keputusan_pengangkatan' => 'required|string|max:100',
            'tanggal_keputusan_pengangkatan' => 'required|date',
            'nomor_keputusan_pemberhentian' => 'nullable|string|max:100',
            'tanggal_keputusan_pemberhentian' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        BukuPemerintah::create($validated);

        return redirect()->route('admin.buku-administrasi.umum.pemerintah.index')
                         ->with('success', 'Data Aparatur Pemerintah Desa berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $pemerintah = BukuPemerintah::findOrFail($id);
        return view('admin.buku-administrasi.umum.pemerintah.edit', compact('pemerintah'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'niap' => 'nullable|string|max:100',
            'nip' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'pangkat_golongan' => 'nullable|string|max:100',
            'jabatan' => 'required|string|max:100',
            'pendidikan_terakhir' => 'required|string|max:100',
            'nomor_keputusan_pengangkatan' => 'required|string|max:100',
            'tanggal_keputusan_pengangkatan' => 'required|date',
            'nomor_keputusan_pemberhentian' => 'nullable|string|max:100',
            'tanggal_keputusan_pemberhentian' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $pemerintah = BukuPemerintah::findOrFail($id);
        $pemerintah->update($validated);

        return redirect()->route('admin.buku-administrasi.umum.pemerintah.index')
                         ->with('success', 'Data Aparatur Pemerintah Desa berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pemerintah = BukuPemerintah::findOrFail($id);
        $pemerintah->delete();

        return redirect()->route('admin.buku-administrasi.umum.pemerintah.index')
                         ->with('success', 'Data Aparatur Pemerintah Desa berhasil dihapus.');
    }
}
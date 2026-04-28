<?php

namespace App\Http\Controllers\Admin; // <--- INI BAGIAN PENTINGNYA

use App\Http\Controllers\Controller;
use App\Models\RencanaDesa;
use Illuminate\Http\Request;

class RencanaPembangunanController extends Controller
{
    public function index(Request $request)
    {
        $query = RencanaDesa::query();

        if ($request->filled('search')) {
            $query->where('nama_proyek', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('pelaksana')) {
            $query->where('pelaksana', 'like', '%' . $request->pelaksana . '%');
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        $perPage      = $request->get('per_page', 10);
        $data_rencana = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.buku-administrasi.pembangunan.rencana', compact('data_rencana'));
    }

    public function create()
    {
        return view('admin.buku-administrasi.pembangunan.rencana-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek'     => 'required|string|max:255',
            'lokasi'          => 'required|string|max:255',
            'pelaksana'       => 'required|string|max:255',
            'dana_pemerintah' => 'nullable|numeric|min:0',
            'dana_provinsi'   => 'nullable|numeric|min:0',
            'dana_kab_kota'   => 'nullable|numeric|min:0',
            'dana_swadaya'    => 'nullable|numeric|min:0',
            'jumlah_total'    => 'nullable|numeric|min:0',
            'manfaat'         => 'nullable|string|max:255',
            'keterangan'      => 'nullable|string',
        ]);

        RencanaDesa::create([
            'nama_proyek'     => $request->nama_proyek,
            'lokasi'          => $request->lokasi,
            'pelaksana'       => $request->pelaksana,
            'dana_pemerintah' => $request->dana_pemerintah ?? 0,
            'dana_provinsi'   => $request->dana_provinsi ?? 0,
            'dana_kab_kota'   => $request->dana_kab_kota ?? 0,
            'dana_swadaya'    => $request->dana_swadaya ?? 0,
            'jumlah_total'    => $request->jumlah_total ?? 0,
            'manfaat'         => $request->manfaat,
            'keterangan'      => $request->keterangan,
        ]);

        return redirect()
            ->route('admin.buku-administrasi.pembangunan.rencana.index')
            ->with('success', 'Data rencana pembangunan berhasil ditambahkan.');
    }

    public function show(RencanaDesa $rencana)
    {
        return view('admin.buku-administrasi.pembangunan.rencana-show', compact('rencana'));
    }

    public function edit(RencanaDesa $rencana)
    {
        return view('admin.buku-administrasi.pembangunan.rencana-edit', compact('rencana'));
    }

    public function update(Request $request, RencanaDesa $rencana)
    {
        $request->validate([
            'nama_proyek'     => 'required|string|max:255',
            'lokasi'          => 'required|string|max:255',
            'pelaksana'       => 'required|string|max:255',
            'dana_pemerintah' => 'nullable|numeric|min:0',
            'dana_provinsi'   => 'nullable|numeric|min:0',
            'dana_kab_kota'   => 'nullable|numeric|min:0',
            'dana_swadaya'    => 'nullable|numeric|min:0',
            'jumlah_total'    => 'nullable|numeric|min:0',
            'manfaat'         => 'nullable|string|max:255',
            'keterangan'      => 'nullable|string',
        ]);

        $rencana->update([
            'nama_proyek'     => $request->nama_proyek,
            'lokasi'          => $request->lokasi,
            'pelaksana'       => $request->pelaksana,
            'dana_pemerintah' => $request->dana_pemerintah ?? 0,
            'dana_provinsi'   => $request->dana_provinsi ?? 0,
            'dana_kab_kota'   => $request->dana_kab_kota ?? 0,
            'dana_swadaya'    => $request->dana_swadaya ?? 0,
            'jumlah_total'    => $request->jumlah_total ?? 0,
            'manfaat'         => $request->manfaat,
            'keterangan'      => $request->keterangan,
        ]);

        return redirect()
            ->route('admin.buku-administrasi.pembangunan.rencana.index')
            ->with('success', 'Data rencana pembangunan berhasil diperbarui.');
    }

    public function destroy(RencanaDesa $rencana)
    {
        $rencana->delete();

        return redirect()
            ->route('admin.buku-administrasi.pembangunan.rencana.index')
            ->with('success', 'Data rencana pembangunan berhasil dihapus.');
    }
}
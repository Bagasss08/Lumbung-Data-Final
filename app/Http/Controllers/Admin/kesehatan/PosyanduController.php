<?php

namespace App\Http\Controllers\Admin\kesehatan;

use App\Http\Controllers\Controller;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PosyanduController extends Controller {
    public function index(Request $request): View {
        $query = Posyandu::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_posyandu', 'like', '%' . $request->search . '%')
                    ->orWhere('dusun', 'like', '%' . $request->search . '%')
                    ->orWhere('penanggung_jawab', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status_posyandu', $request->status);
        }

        if ($request->filled('dusun')) {
            $query->where('dusun', $request->dusun);
        }

        $posyandu = $query->orderBy('nama_posyandu')->paginate(10)->withQueryString();
        $dusunList = Posyandu::distinct()->pluck('dusun')->filter()->sort()->values();

        return view('admin.kesehatan.pendataan.posyandu', compact('posyandu', 'dusunList'));
    }

    public function create(): View {
        return view('admin.kesehatan.pendataan.posyandu-form');
    }

    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'nama_posyandu'    => 'required|string|max:100',
            'dusun'            => 'nullable|string|max:100',
            'alamat'           => 'nullable|string',
            'rt'               => 'nullable|string|max:5',
            'rw'               => 'nullable|string|max:5',
            'hari_kegiatan'    => 'nullable|string|max:20',
            'jam_mulai'        => 'nullable|date_format:H:i',
            'jam_selesai'      => 'nullable|date_format:H:i',
            'penanggung_jawab' => 'nullable|string|max:100',
            'jumlah_kader'     => 'nullable|integer|min:0',
            'status_posyandu'  => 'required|in:aktif,tidak_aktif',
            'keterangan'       => 'nullable|string',
        ]);

        Posyandu::create($validated);

        return redirect()->route('admin.kesehatan.pendataan.posyandu')
            ->with('success', 'Data posyandu berhasil ditambahkan.');
    }

    public function edit(Posyandu $posyandu): View {
        return view('admin.kesehatan.pendataan.posyandu-form', compact('posyandu'));
    }

    public function update(Request $request, Posyandu $posyandu): RedirectResponse {
        $validated = $request->validate([
            'nama_posyandu'    => 'required|string|max:100',
            'dusun'            => 'nullable|string|max:100',
            'alamat'           => 'nullable|string',
            'rt'               => 'nullable|string|max:5',
            'rw'               => 'nullable|string|max:5',
            'hari_kegiatan'    => 'nullable|string|max:20',
            'jam_mulai'        => 'nullable|date_format:H:i',
            'jam_selesai'      => 'nullable|date_format:H:i',
            'penanggung_jawab' => 'nullable|string|max:100',
            'jumlah_kader'     => 'nullable|integer|min:0',
            'status_posyandu'  => 'required|in:aktif,tidak_aktif',
            'keterangan'       => 'nullable|string',
        ]);

        $posyandu->update($validated);

        return redirect()->route('admin.kesehatan.pendataan.posyandu')
            ->with('success', 'Data posyandu berhasil diperbarui.');
    }

    public function destroy(Posyandu $posyandu): RedirectResponse {
        $posyandu->delete();
        return redirect()->route('admin.kesehatan.pendataan.posyandu')
            ->with('success', 'Data posyandu berhasil dihapus.');
    }

    public function show(Posyandu $posyandu): View {
        $posyandu->load(['kia' => function ($q) {
            $q->latest()->take(10);
        }]);
        return view('admin.kesehatan.pendataan.posyandu-show', compact('posyandu'));
    }
}

<?php

namespace App\Http\Controllers\Admin\kesehatan;

use App\Http\Controllers\Controller;
use App\Models\Kia;
use App\Models\Penduduk;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KiaController extends Controller {
    public function index(Request $request): View {
        $query = Kia::with('posyandu');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_ibu', 'like', '%' . $request->search . '%')
                    ->orWhere('nik_ibu', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_anak', 'like', '%' . $request->search . '%')
                    ->orWhere('no_register', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status_kehamilan')) {
            $query->where('status_kehamilan', $request->status_kehamilan);
        }

        if ($request->filled('status_resiko')) {
            $query->where('status_resiko', $request->status_resiko);
        }

        if ($request->filled('posyandu_id')) {
            $query->where('posyandu_id', $request->posyandu_id);
        }

        $kia          = $query->latest()->paginate(10)->withQueryString();
        $posyanduList = Posyandu::aktif()->orderBy('nama_posyandu')->get();

        return view('admin.kesehatan.pendataan.kia', compact('kia', 'posyanduList'));
    }

    public function create(): View {
        $posyanduList  = Posyandu::aktif()->orderBy('nama_posyandu')->get();
        $pendudukIbu   = Penduduk::where('jenis_kelamin', 'P')
            ->where('status_hidup', 'hidup')
            ->with('wilayah')
            ->orderBy('nama')
            ->get(['id', 'nama', 'nik', 'tanggal_lahir', 'alamat', 'wilayah_id']);
        $pendudukAnak  = Penduduk::where('status_hidup', 'hidup')
            ->with('wilayah')
            ->orderBy('nama')
            ->get(['id', 'nama', 'nik', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'wilayah_id']);
        $noRegister    = Kia::generateNoRegister();

        return view(
            'admin.kesehatan.pendataan.kia-form',
            compact('posyanduList', 'pendudukIbu', 'pendudukAnak', 'noRegister')
        );
    }

    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'no_register'         => 'nullable|string|max:50|unique:kia',
            'posyandu_id'         => 'nullable|exists:posyandu,id',
            'penduduk_id_ibu'     => 'nullable|exists:penduduk,id',
            'penduduk_id_anak'    => 'nullable|exists:penduduk,id',
            'nik_ibu'             => 'nullable|string|max:20',
            'nama_ibu'            => 'required|string|max:100',
            'tgl_lahir_ibu'       => 'nullable|date',
            'umur_ibu'            => 'nullable|integer|min:0|max:120',
            'alamat_ibu'          => 'nullable|string',
            'dusun'               => 'nullable|string|max:100',
            'rt'                  => 'nullable|string|max:5',
            'rw'                  => 'nullable|string|max:5',
            'no_hp'               => 'nullable|string|max:20',
            'kehamilan_ke'        => 'nullable|integer|min:1',
            'hpht'                => 'nullable|date',
            'taksiran_lahir'      => 'nullable|date',
            'status_kehamilan'    => 'required|in:hamil,melahirkan,selesai',
            'status_resiko'       => 'required|in:normal,resiko_rendah,resiko_tinggi',
            'tempat_pemeriksaan'  => 'nullable|string|max:100',
            'tanggal_melahirkan'  => 'nullable|date',
            'jenis_persalinan'    => 'nullable|in:normal,sesar,vakum',
            'penolong_persalinan' => 'nullable|string|max:100',
            'nik_anak'            => 'nullable|string|max:20',
            'nama_anak'           => 'nullable|string|max:100',
            'jenis_kelamin_anak'  => 'nullable|in:L,P',
            'tgl_lahir_anak'      => 'nullable|date',
            'berat_lahir'         => 'nullable|numeric|min:0|max:20',
            'panjang_lahir'       => 'nullable|numeric|min:0|max:100',
            'keterangan'          => 'nullable|string',
        ]);

        if (empty($validated['no_register'])) {
            $validated['no_register'] = Kia::generateNoRegister();
        }

        Kia::create($validated);

        return redirect()->route('admin.kesehatan.pendataan.kia')
            ->with('success', 'Data KIA berhasil ditambahkan. No. Register: ' . $validated['no_register']);
    }

    public function show(Kia $kia): View {
        $kia->load([
            'posyandu',
            'ibu',
            'anak',
            'pemantauanBumil' => fn($q) => $q->orderBy('tanggal_pemantauan', 'desc'),
            'pemantauanAnak'  => fn($q) => $q->orderBy('tanggal_pemantauan', 'desc'),
            'stuntingScorecard' => fn($q) => $q->orderBy('tahun', 'desc')->orderBy('triwulan', 'desc'),
        ]);

        return view('admin.kesehatan.pendataan.kia-show', compact('kia'));
    }

    public function edit(Kia $kia): View {
        $posyanduList  = Posyandu::aktif()->orderBy('nama_posyandu')->get();
        $pendudukIbu   = Penduduk::where('jenis_kelamin', 'P')
            ->where('status_hidup', 'hidup')
            ->orderBy('nama')
            ->get(['id', 'nama', 'nik', 'tanggal_lahir']);
        $pendudukAnak  = Penduduk::where('status_hidup', 'hidup')
            ->orderBy('nama')
            ->get(['id', 'nama', 'nik', 'tanggal_lahir', 'jenis_kelamin']);

        return view(
            'admin.kesehatan.pendataan.kia-form',
            compact('kia', 'posyanduList', 'pendudukIbu', 'pendudukAnak')
        );
    }

    public function update(Request $request, Kia $kia): RedirectResponse {
        $validated = $request->validate([
            'no_register'         => 'nullable|string|max:50|unique:kia,no_register,' . $kia->id,
            'posyandu_id'         => 'nullable|exists:posyandu,id',
            'penduduk_id_ibu'     => 'nullable|exists:penduduk,id',
            'penduduk_id_anak'    => 'nullable|exists:penduduk,id',
            'nik_ibu'             => 'nullable|string|max:20',
            'nama_ibu'            => 'required|string|max:100',
            'tgl_lahir_ibu'       => 'nullable|date',
            'umur_ibu'            => 'nullable|integer|min:0|max:120',
            'alamat_ibu'          => 'nullable|string',
            'dusun'               => 'nullable|string|max:100',
            'rt'                  => 'nullable|string|max:5',
            'rw'                  => 'nullable|string|max:5',
            'no_hp'               => 'nullable|string|max:20',
            'kehamilan_ke'        => 'nullable|integer|min:1',
            'hpht'                => 'nullable|date',
            'taksiran_lahir'      => 'nullable|date',
            'status_kehamilan'    => 'required|in:hamil,melahirkan,selesai',
            'status_resiko'       => 'required|in:normal,resiko_rendah,resiko_tinggi',
            'tempat_pemeriksaan'  => 'nullable|string|max:100',
            'tanggal_melahirkan'  => 'nullable|date',
            'jenis_persalinan'    => 'nullable|in:normal,sesar,vakum',
            'penolong_persalinan' => 'nullable|string|max:100',
            'nik_anak'            => 'nullable|string|max:20',
            'nama_anak'           => 'nullable|string|max:100',
            'jenis_kelamin_anak'  => 'nullable|in:L,P',
            'tgl_lahir_anak'      => 'nullable|date',
            'berat_lahir'         => 'nullable|numeric|min:0|max:20',
            'panjang_lahir'       => 'nullable|numeric|min:0|max:100',
            'keterangan'          => 'nullable|string',
        ]);

        $kia->update($validated);

        return redirect()->route('admin.kesehatan.pendataan.kia')
            ->with('success', 'Data KIA berhasil diperbarui.');
    }

    public function destroy(Kia $kia): RedirectResponse {
        $kia->delete();

        return redirect()->route('admin.kesehatan.pendataan.kia')
            ->with('success', 'Data KIA berhasil dihapus.');
    }
}

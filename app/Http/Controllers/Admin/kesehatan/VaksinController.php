<?php

namespace App\Http\Controllers\Admin\kesehatan;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\Vaksin;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class VaksinController extends Controller {
    private array $jenisVaksin = [
        'covid19'        => ['Sinovac', 'Pfizer', 'Moderna', 'AstraZeneca', 'Janssen', 'Sinopharm'],
        'imunisasi_anak' => ['BCG', 'DPT-HB-Hib', 'Polio', 'Campak', 'MMR', 'Hepatitis B', 'PCV'],
        'lainnya'        => ['Influenza', 'Typhoid', 'Hepatitis A', 'Meningitis'],
    ];

    public function index(Request $request): View {
        $query = Vaksin::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_penerima', 'like', '%' . $request->search . '%')
                    ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('jenis_vaksin')) {
            $query->where('jenis_vaksin', $request->jenis_vaksin);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori_vaksin', $request->kategori);
        }

        $vaksin = $query->orderBy('tanggal_vaksin', 'desc')->paginate(15)->withQueryString();

        $stats = [
            'sudah' => Vaksin::where('status', 'sudah')->count(),
            'belum' => Vaksin::where('status', 'belum')->count(),
            'tunda' => Vaksin::where('status', 'tunda')->count(),
            'total' => Vaksin::count(),
        ];

        $dusunList       = Vaksin::distinct()->pluck('dusun')->filter()->sort()->values();
        $jenisVaksinList = Vaksin::distinct()->pluck('jenis_vaksin')->filter()->sort()->values();

        return view(
            'admin.kesehatan.vaksin.index',
            compact('vaksin', 'stats', 'dusunList', 'jenisVaksinList')
        );
    }

    public function create(): View {
        $jenisVaksinOptions = Arr::flatten($this->jenisVaksin);
        $pendudukList       = Penduduk::where('status_hidup', 'hidup')
            ->orderBy('nama')
            ->get(['id', 'nama', 'nik', 'tanggal_lahir', 'jenis_kelamin']);

        return view(
            'admin.kesehatan.vaksin.form',
            compact('jenisVaksinOptions', 'pendudukList')
        );
    }

    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'penduduk_id'      => 'nullable|exists:penduduk,id',
            'nik'              => 'nullable|string|max:20',
            'nama_penerima'    => 'required|string|max:100',
            'jenis_kelamin'    => 'nullable|in:L,P',
            'tgl_lahir'        => 'nullable|date',
            'umur'             => 'nullable|integer|min:0|max:150',
            'dusun'            => 'nullable|string|max:100',
            'rt'               => 'nullable|string|max:5',
            'rw'               => 'nullable|string|max:5',
            'alamat'           => 'nullable|string',
            'jenis_vaksin'     => 'required|string|max:100',
            'kategori_vaksin'  => 'nullable|string|max:50',
            'dosis'            => 'required|string|max:20',
            'tanggal_vaksin'   => 'required|date',
            'tempat_pelayanan' => 'nullable|string|max:150',
            'petugas'          => 'nullable|string|max:100',
            'batch_vaksin'     => 'nullable|string|max:50',
            'status'           => 'required|in:sudah,belum,tunda',
            'no_sertifikat'    => 'nullable|string|max:100',
            'keterangan'       => 'nullable|string',
        ]);

        Vaksin::create($validated);

        return redirect()->route('admin.kesehatan.vaksin.index')
            ->with('success', 'Data vaksin berhasil ditambahkan.');
    }

    public function show(Vaksin $vaksin): View {
        $vaksin->load(['penduduk', 'wilayah', 'user']);

        return view('admin.kesehatan.vaksin.show', compact('vaksin'));
    }

    public function edit(Vaksin $vaksin): View {
        $jenisVaksinOptions = Arr::flatten($this->jenisVaksin);
        $pendudukList       = Penduduk::where('status_hidup', 'hidup')
            ->orderBy('nama')
            ->get(['id', 'nama', 'nik', 'tanggal_lahir', 'jenis_kelamin']);

        return view(
            'admin.kesehatan.vaksin.form',
            compact('vaksin', 'jenisVaksinOptions', 'pendudukList')
        );
    }

    public function update(Request $request, Vaksin $vaksin): RedirectResponse {
        $validated = $request->validate([
            'penduduk_id'      => 'nullable|exists:penduduk,id',
            'nik'              => 'nullable|string|max:20',
            'nama_penerima'    => 'required|string|max:100',
            'jenis_kelamin'    => 'nullable|in:L,P',
            'tgl_lahir'        => 'nullable|date',
            'umur'             => 'nullable|integer|min:0|max:150',
            'dusun'            => 'nullable|string|max:100',
            'rt'               => 'nullable|string|max:5',
            'rw'               => 'nullable|string|max:5',
            'alamat'           => 'nullable|string',
            'jenis_vaksin'     => 'required|string|max:100',
            'kategori_vaksin'  => 'nullable|string|max:50',
            'dosis'            => 'required|string|max:20',
            'tanggal_vaksin'   => 'required|date',
            'tempat_pelayanan' => 'nullable|string|max:150',
            'petugas'          => 'nullable|string|max:100',
            'batch_vaksin'     => 'nullable|string|max:50',
            'status'           => 'required|in:sudah,belum,tunda',
            'no_sertifikat'    => 'nullable|string|max:100',
            'keterangan'       => 'nullable|string',
        ]);

        $vaksin->update($validated);

        return redirect()->route('admin.kesehatan.vaksin.index')
            ->with('success', 'Data vaksin berhasil diperbarui.');
    }

    public function destroy(Vaksin $vaksin): RedirectResponse {
        $vaksin->delete();

        return redirect()->route('admin.kesehatan.vaksin.index')
            ->with('success', 'Data vaksin berhasil dihapus.');
    }
}

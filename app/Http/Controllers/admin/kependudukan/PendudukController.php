<?php

namespace App\Http\Controllers\Admin\kependudukan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\RumahTangga;
use App\Models\Wilayah;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $query = Penduduk::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        // Filter by jenis kelamin
        if ($request->has('jenis_kelamin') && !empty($request->jenis_kelamin) && $request->jenis_kelamin !== 'Semua') {
            $query->where('jenis_kelamin', $request->jenis_kelamin === 'Laki-laki' ? 'L' : 'P');
        }

        // Filter by agama
        if ($request->has('agama') && !empty($request->agama) && $request->agama !== 'Semua Agama') {
            $query->where('agama', $request->agama);
        }

        $penduduk = $query->paginate(10)->appends($request->query());

        $total_penduduk = Penduduk::count();
        $laki_laki = Penduduk::where('jenis_kelamin', 'L')->count();
        $perempuan = Penduduk::where('jenis_kelamin', 'P')->count();
        $keluarga = Keluarga::count(); // Total keluarga (KK)
        $wilayah = Wilayah::all();

        return view('admin.penduduk', compact('penduduk', 'total_penduduk', 'laki_laki', 'perempuan', 'keluarga', 'wilayah'));
    }

    public function create()
    {
        $keluarga = Keluarga::all();
        $rumahTangga = RumahTangga::all();
        $wilayah = Wilayah::all();

        return view('admin.penduduk-create', compact('keluarga', 'rumahTangga', 'wilayah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:16|unique:penduduk,nik',
            'nama' => 'required|string|max:255',
            'wilayah_id' => 'nullable|exists:wilayah,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'golongan_darah' => 'nullable|string|max:3',
            'agama' => 'required|string|max:255',
            'pendidikan' => 'nullable|string|max:255',
            'pekerjaan' => 'required|in:bekerja,tidak bekerja',
            'status_kawin' => 'required|string|max:255',
            'status_hidup' => 'nullable|in:hidup,meninggal',
            'kewarganegaraan' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'keluarga_id' => 'nullable|exists:keluarga,id',
            'hubungan_keluarga' => 'nullable|string|max:255',
            'rumah_tangga_id' => 'nullable|exists:rumah_tangga,id',
            'hubungan_rumah_tangga' => 'nullable|string|max:255',
        ]);

        $penduduk = Penduduk::create($validated);

        // Attach relationships if provided
        if ($request->filled('keluarga_id') && $request->filled('hubungan_keluarga')) {
            $penduduk->keluargas()->attach($request->keluarga_id, ['hubungan_keluarga' => $request->hubungan_keluarga]);
        }

        if ($request->filled('rumah_tangga_id') && $request->filled('hubungan_rumah_tangga')) {
            $penduduk->rumahTanggas()->attach($request->rumah_tangga_id, ['hubungan_rumah_tangga' => $request->hubungan_rumah_tangga]);
        }

        return redirect()->route('admin.penduduk')->with('success', 'Penduduk berhasil ditambahkan.');
    }

    public function show(Penduduk $penduduk)
    {
        return view('admin.penduduk-show', compact('penduduk'));
    }

    public function edit(Penduduk $penduduk)
    {
        $keluarga = Keluarga::all();
        $rumahTangga = RumahTangga::all();
        $wilayah = Wilayah::all();

        // Get current pivot relationships
        $currentKeluarga = $penduduk->keluargas()->withPivot('hubungan_keluarga')->first();
        $currentRumahTangga = $penduduk->rumahTanggas()->withPivot('hubungan_rumah_tangga')->first();

        return view('admin.penduduk-edit', compact('penduduk', 'keluarga', 'rumahTangga', 'wilayah', 'currentKeluarga', 'currentRumahTangga'));
    }

    public function update(Request $request, Penduduk $penduduk)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:16|unique:penduduk,nik,' . $penduduk->id,
            'nama' => 'required|string|max:255',
            'wilayah_id' => 'nullable|exists:wilayah,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'golongan_darah' => 'nullable|string|max:3',
            'agama' => 'required|string|max:255',
            'pendidikan' => 'nullable|string|max:255',
            'pekerjaan' => 'required|in:bekerja,tidak bekerja',
            'status_kawin' => 'required|string|max:255',
            'status_hidup' => 'nullable|in:hidup,meninggal',
            'kewarganegaraan' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'keluarga_id' => 'nullable|exists:keluarga,id',
            'hubungan_keluarga' => 'nullable|string|max:255',
            'rumah_tangga_id' => 'nullable|exists:rumah_tangga,id',
            'hubungan_rumah_tangga' => 'nullable|string|max:255',
        ]);

        $penduduk->update($validated);

        // Sync relationships - detach existing and attach new ones if provided
        if ($request->filled('keluarga_id') && $request->filled('hubungan_keluarga')) {
            $penduduk->keluargas()->sync([$request->keluarga_id => ['hubungan_keluarga' => $request->hubungan_keluarga]]);
        } else {
            $penduduk->keluargas()->detach();
        }

        if ($request->filled('rumah_tangga_id') && $request->filled('hubungan_rumah_tangga')) {
            $penduduk->rumahTanggas()->sync([$request->rumah_tangga_id => ['hubungan_rumah_tangga' => $request->hubungan_rumah_tangga]]);
        } else {
            $penduduk->rumahTanggas()->detach();
        }

        return redirect()->route('admin.penduduk')->with('success', 'Penduduk berhasil diperbarui.');
    }

    public function confirmDestroy(Penduduk $penduduk)
    {
        return view('admin.penduduk-delete', compact('penduduk'));
    }

    public function destroy(Penduduk $penduduk)
    {
        // Detach relationships from pivot tables before deleting
        $penduduk->keluargas()->detach();
        $penduduk->rumahTanggas()->detach();

        $penduduk->delete();

        return redirect()->route('admin.penduduk')->with('success', 'Penduduk berhasil dihapus.');
    }

    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:csv,xls,xlsx'
    //     ]);

    //     Excel::import(new PendudukImport, $request->file('file'));

    //     return redirect()->route('admin.penduduk')->with('success', 'Data penduduk berhasil diimpor.');
    // }
}

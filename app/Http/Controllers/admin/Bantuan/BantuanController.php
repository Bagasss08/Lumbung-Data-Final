<?php

namespace App\Http\Controllers\Admin\Bantuan;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BantuanController extends Controller
{
    public function index(Request $request)
    {
        $query = Program::withCount('peserta');

        // Apply filters using scopeFilter if available
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('sasaran') && $request->sasaran) {
            $query->where('sasaran', $request->sasaran);
        }

        if ($request->has('search') && $request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $perPage = $request->get('per_page', 10);
        $bantuan = $query->paginate($perPage)->appends($request->query());

        return view('admin.bantuan.index', compact('bantuan'));
    }

    public function create()
    {
        $bantuan = null;

        return view('admin.bantuan.create', compact('bantuan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'            => 'required|string|max:255',
            'sasaran'         => 'required|in:1,2',
            'asal_dana'       => 'nullable|string|max:100', // ← ganti dari sumber_dana
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'publikasi'       => 'required|in:0,1',
            'keterangan'      => 'nullable|string',
        ]);

        Program::create($validated);

        return redirect()->route('admin.bantuan.index')->with('success', 'Program bantuan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $bantuan = Program::findOrFail($id);
        $peserta = $bantuan->peserta()->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.bantuan.show', compact('bantuan', 'peserta'));
    }

    public function edit($id)
    {
        $bantuan = Program::findOrFail($id);

        return view('admin.bantuan.edit', compact('bantuan'));
    }

    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $validated = $request->validate([
            'nama'            => 'required|string|max:255',
            'sasaran'         => 'required|in:1,2',
            'asal_dana'       => 'nullable|string|max:100', // ← ganti dari sumber_dana
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'publikasi'       => 'required|in:0,1',
            'keterangan'      => 'nullable|string',
        ]);

        $program->update($validated);

        return redirect()->route('admin.bantuan.index')->with('success', 'Program bantuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();

        return redirect()->route('admin.bantuan.index')->with('success', 'Program bantuan berhasil dihapus.');
    }

    public function importForm()
    {
        return abort(204);
    }

    public function import(Request $request)
    {
        return abort(204);
    }

    public function bersihkan()
    {
        $pesertaTidakValid = DB::table('program_peserta')
            ->leftJoin('program', 'program_peserta.program_id', '=', 'program.id')
            ->leftJoin('penduduk', 'program_peserta.penduduk_id', '=', 'penduduk.id')
            ->whereNull('program.id')
            ->select([
                'program_peserta.*',
                'program.nama as program_nama',
                'program.sasaran as program_sasaran',
                'penduduk.nama as peserta_nama',
            ])
            ->get();

        $pesertaDuplikat = DB::table('program_peserta')
            ->select('program_id', 'penduduk_id', DB::raw('COUNT(*) as jumlah_duplikat'))
            ->groupBy('program_id', 'penduduk_id')
            ->having('jumlah_duplikat', '>', 1)
            ->get()
            ->flatMap(function ($item) {
                return DB::table('program_peserta')
                    ->leftJoin('program', 'program_peserta.program_id', '=', 'program.id')
                    ->leftJoin('penduduk', 'program_peserta.penduduk_id', '=', 'penduduk.id')
                    ->where('program_peserta.program_id', $item->program_id)
                    ->where('program_peserta.penduduk_id', $item->penduduk_id)
                    ->select([
                        'program_peserta.*',
                        'program.nama as program_nama',
                        'program.sasaran as program_sasaran',
                        'penduduk.nama as peserta_nama',
                        DB::raw((int) $item->jumlah_duplikat . ' as jumlah_duplikat'),
                    ])
                    ->get();
            });

        return view('admin.bantuan.bersihkan', compact('pesertaTidakValid', 'pesertaDuplikat'));
    }

    public function bersihkanDestroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!empty($ids)) {
            DB::table('program_peserta')->whereIn('id', $ids)->delete();
        }

        return redirect()->route('admin.bantuan.bersihkan')->with('success', 'Data peserta tidak valid dan duplikat berhasil dihapus.');
    }
    public function contohFormat() {
        // Implementasi nanti, sementara return 404
        abort(404, 'Template belum tersedia');
    }
}

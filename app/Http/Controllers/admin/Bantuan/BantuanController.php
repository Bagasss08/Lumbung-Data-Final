<?php

namespace App\Http\Controllers\Admin\Bantuan;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class BantuanController extends Controller {
    public function index() {
        $programs = Program::withCount('peserta')->latest()->paginate(10);
        return view('admin.bantuan.index', compact('programs'));
    }

    public function create() {
        return view('admin.bantuan.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'sumber_dana'    => 'nullable|string|max:255',
            'tahun'          => 'nullable|integer|min:2000|max:2099',
            'nominal'        => 'nullable|numeric|min:0',
            'sasaran'        => 'required|in:1,2',
            'tanggal_mulai'  => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        Program::create($request->all());

        return redirect()->route('admin.bantuan.index')
            ->with('success', 'Program bantuan berhasil ditambahkan.');
    }

    public function show(Program $bantuan) {
        $peserta = $bantuan->peserta()->paginate(10);
        return view('admin.bantuan.show', compact('bantuan', 'peserta'));
    }

    public function edit(Program $bantuan) {
        return view('admin.bantuan.edit', compact('bantuan'));
    }

    public function update(Request $request, Program $bantuan) {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'sumber_dana'    => 'nullable|string|max:255',
            'tahun'          => 'nullable|integer|min:2000|max:2099',
            'nominal'        => 'nullable|numeric|min:0',
            'sasaran'        => 'required|in:1,2',
            'tanggal_mulai'  => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $bantuan->update($request->all());

        return redirect()->route('admin.bantuan.index')
            ->with('success', 'Program bantuan berhasil diperbarui.');
    }

    public function destroy(Program $bantuan) {
        $bantuan->delete();
        return redirect()->route('admin.bantuan.index')
            ->with('success', 'Program bantuan berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin\Ppid;

use App\Http\Controllers\Controller;
use App\Models\PermohonanInformasi;
use Illuminate\Http\Request;

class PermohonanInformasiController extends Controller {
    public function index(Request $request) {
        $query = PermohonanInformasi::query();

        // Filter status via dropdown (Semua / menunggu / proses / selesai / ditolak)
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pemohon', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('informasi_yang_dibutuhkan', 'like', "%{$search}%")
                    ->orWhere('nomor_permohonan', 'like', "%{$search}%");
            });
        }

        $perPage = in_array((int) $request->get('per_page'), [10, 25, 50, 100])
            ? (int) $request->get('per_page')
            : 10;

        $data = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.ppid.permohonan-informasi.index', compact('data', 'perPage'));
    }

    public function create() {
        return view('admin.ppid.permohonan-informasi.form');
    }

    public function store(Request $request) {
        $request->validate([
            'nama_pemohon'             => 'required|string|max:255',
            'nik'                      => 'nullable|digits_between:15,16',
            'tempat_lahir'             => 'nullable|string|max:100',
            'tanggal_lahir'            => 'nullable|date',
            'jenis_kelamin'            => 'nullable|in:L,P',
            'pekerjaan'                => 'nullable|string|max:100',
            'alamat'                   => 'nullable|string',
            'no_telp'                  => 'nullable|string|max:20',
            'email'                    => 'nullable|email|max:100',
            'informasi_yang_dibutuhkan'   => 'required|string',
            'tujuan_penggunaan'        => 'nullable|string',
            'cara_memperoleh'          => 'nullable|string|max:50',
            'cara_mendapatkan_salinan' => 'nullable|string|max:50',
            'tanggal_permohonan'       => 'nullable|date',
        ]);

        PermohonanInformasi::create(array_merge($request->all(), [
            'nomor_permohonan' => PermohonanInformasi::generateNomor(),
            'status'           => 'menunggu',
        ]));

        return redirect()->route('admin.ppid.permohonan-informasi.index')
            ->with('success', 'Permohonan informasi berhasil ditambahkan!');
    }

    public function show(PermohonanInformasi $permohonanInformasi) {
        return view('admin.ppid.permohonan-informasi.show', ['item' => $permohonanInformasi]);
    }

    public function edit(PermohonanInformasi $permohonanInformasi) {
        return view('admin.ppid.permohonan-informasi.form', ['item' => $permohonanInformasi]);
    }

    public function update(Request $request, PermohonanInformasi $permohonanInformasi) {
        $request->validate([
            'nama_pemohon'             => 'required|string|max:255',
            'nik'                      => 'nullable|digits_between:15,16',
            'tempat_lahir'             => 'nullable|string|max:100',
            'tanggal_lahir'            => 'nullable|date',
            'jenis_kelamin'            => 'nullable|in:L,P',
            'pekerjaan'                => 'nullable|string|max:100',
            'alamat'                   => 'nullable|string',
            'no_telp'                  => 'nullable|string|max:20',
            'email'                    => 'nullable|email|max:100',
            'informasi_yang_dibutuhkan'   => 'required|string',
            'tujuan_penggunaan'        => 'nullable|string',
            'cara_memperoleh'          => 'nullable|string|max:50',
            'cara_mendapatkan_salinan' => 'nullable|string|max:50',
            'status'                   => 'required|in:menunggu,proses,selesai,ditolak',
            'tindak_lanjut'            => 'nullable|string',
            'alasan_penolakan'         => 'nullable|string',
            'tanggal_permohonan'       => 'nullable|date',
            'tanggal_selesai'          => 'nullable|date',
        ]);

        // Otomatis isi tanggal_selesai jika status berubah jadi selesai
        $data = $request->all();
        if ($request->status === 'selesai' && !$permohonanInformasi->tanggal_selesai) {
            $data['tanggal_selesai'] = now()->toDateString();
        }

        $permohonanInformasi->update($data);

        return redirect()->route('admin.ppid.permohonan-informasi.index')
            ->with('success', 'Permohonan informasi berhasil diperbarui!');
    }

    public function destroy(PermohonanInformasi $permohonanInformasi) {
        $permohonanInformasi->delete();

        return redirect()->route('admin.ppid.permohonan-informasi.index')
            ->with('success', 'Permohonan informasi berhasil dihapus!');
    }

    public function bulkDestroy(Request $request) {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:permohonan_informasi,id',
        ]);

        PermohonanInformasi::whereIn('id', $request->ids)->delete();

        return redirect()->route('admin.ppid.permohonan-informasi.index')
            ->with('success', count($request->ids) . ' permohonan berhasil dihapus!');
    }

    /**
     * Bulk update status — dipanggil oleh tombol Tolak / Proses / Selesai di index.
     * Persis perilaku OpenSID: centang banyak data, klik tombol, status berubah sekaligus.
     */
    public function bulkUpdateStatus(Request $request) {
        $request->validate([
            'ids'    => 'required|array',
            'ids.*'  => 'integer|exists:permohonan_informasi,id',
            'status' => 'required|in:menunggu,proses,selesai,ditolak',
        ]);

        $update = ['status' => $request->status];

        // Otomatis isi tanggal_selesai
        if ($request->status === 'selesai') {
            $update['tanggal_selesai'] = now()->toDateString();
        }

        PermohonanInformasi::whereIn('id', $request->ids)->update($update);

        $label = match ($request->status) {
            'proses'   => 'diproses',
            'selesai'  => 'diselesaikan',
            'ditolak'  => 'ditolak',
            'menunggu' => 'direset ke menunggu',
            default    => 'diperbarui',
        };

        return redirect()->route('admin.ppid.permohonan-informasi.index')
            ->with('success', count($request->ids) . ' permohonan berhasil ' . $label . '!');
    }

    /**
     * Update status satu record dari halaman show (tombol Ubah Status Cepat).
     */
    public function updateStatus(Request $request, PermohonanInformasi $permohonanInformasi) {
        $request->validate([
            'status'           => 'required|in:menunggu,proses,selesai,ditolak',
            'alasan_penolakan' => 'nullable|string',
            'tindak_lanjut'    => 'nullable|string',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'selesai' && !$permohonanInformasi->tanggal_selesai) {
            $data['tanggal_selesai'] = now()->toDateString();
        }
        if ($request->filled('alasan_penolakan')) {
            $data['alasan_penolakan'] = $request->alasan_penolakan;
        }
        if ($request->filled('tindak_lanjut')) {
            $data['tindak_lanjut'] = $request->tindak_lanjut;
        }

        $permohonanInformasi->update($data);

        return back()->with('success', 'Status permohonan berhasil diperbarui!');
    }
}

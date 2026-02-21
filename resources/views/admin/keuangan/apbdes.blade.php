@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Kelola APBDes</h1>
                <p class="text-slate-600">Anggaran Pendapatan dan Belanja Desa</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.keuangan.laporan-apbdes') }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    <i class="fas fa-chart-bar mr-2"></i>Lihat Laporan
                </a>
                <a href="{{ route('admin.keuangan.apbdes.create') }}"
                    class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
                    <i class="fas fa-plus mr-2"></i>Tambah APBDes
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
        <i class="fas fa-check-circle mr-3"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center">
        <i class="fas fa-exclamation-circle mr-3"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
        <form action="{{ route('admin.keuangan.apbdes') }}" method="GET" class="flex flex-wrap gap-3">
            <select name="tahun"
                class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                <option value="">Semua Tahun</option>
                @foreach($availableYears as $year)
                <option value="{{ $year }}" {{ request('tahun')==$year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
            <select name="kategori"
                class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                <option value="">Semua Kategori</option>
                <option value="pendapatan" {{ request('kategori')=='pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                <option value="belanja" {{ request('kategori')=='belanja' ? 'selected' : '' }}>Belanja</option>
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kegiatan..."
                class="flex-1 min-w-[200px] px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            <button type="submit"
                class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition text-sm">
                <i class="fas fa-search mr-2"></i>Filter
            </button>
            @if(request()->hasAny(['search', 'tahun', 'kategori']))
            <a href="{{ route('admin.keuangan.apbdes') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm">
                Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Tahun</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Kegiatan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Sumber Dana</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Anggaran</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Realisasi</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 uppercase tracking-wider">%
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($apbdesList as $index => $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 text-sm text-slate-600">
                            {{ $apbdesList->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-900">
                            {{ $item->tahun->tahun ?? '-' }}
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $item->kategori === 'pendapatan' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($item->kategori) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-900 max-w-[200px]">
                            {{ $item->kegiatanAnggaran->nama_kegiatan ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600">
                            {{ $item->sumberDana->nama_sumber ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-900 text-right font-medium">
                            Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                        </td>
                        <td
                            class="px-4 py-3 text-sm text-right font-medium {{ $item->total_realisasi > 0 ? 'text-blue-600' : 'text-slate-400' }}">
                            Rp {{ number_format($item->total_realisasi ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @php
                            $persen = $item->anggaran > 0 ? round(($item->total_realisasi / $item->anggaran) * 100, 1) :
                            0;
                            $color = $persen >= 100 ? 'bg-emerald-500' : ($persen >= 50 ? 'bg-blue-500' :
                            'bg-amber-400');
                            @endphp
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-slate-200 rounded-full h-2 min-w-[60px]">
                                    <div class="{{ $color }} h-2 rounded-full transition-all"
                                        style="width: {{ min($persen, 100) }}%"></div>
                                </div>
                                <span class="text-xs text-slate-600 w-10 text-right">{{ $persen }}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{-- FIX: Gunakan flex-nowrap agar tombol tidak terpotong --}}
                            <div class="flex items-center gap-2 flex-nowrap">
                                <!-- Tombol Tambah Realisasi -->
                                <button type="button"
                                    onclick="openRealisasiModal({{ $item->id }}, '{{ addslashes($item->kegiatanAnggaran->nama_kegiatan ?? 'Kegiatan') }}', {{ $item->anggaran }}, {{ $item->total_realisasi ?? 0 }})"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition text-xs font-medium whitespace-nowrap"
                                    title="Tambah Realisasi">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Realisasi</span>
                                </button>

                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.keuangan.apbdes.edit', $item->id) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-xs font-medium whitespace-nowrap"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit</span>
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('admin.keuangan.apbdes.destroy', $item->id) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Hapus data APBDes ini? Pastikan tidak ada realisasi.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-xs font-medium whitespace-nowrap"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-10 text-center text-sm text-slate-500">
                            <i class="fas fa-inbox text-4xl mb-3 block text-slate-300"></i>
                            <p class="font-medium">Belum ada data APBDes</p>
                            <a href="{{ route('admin.keuangan.apbdes.create') }}"
                                class="mt-2 inline-block text-emerald-600 hover:text-emerald-700 font-medium">
                                Tambah APBDes Sekarang
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($apbdesList->hasPages())
        <div class="px-4 py-3 border-t border-slate-200">
            {{ $apbdesList->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Tambah Realisasi -->
<div id="realisasiModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeRealisasiModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
            <div class="p-6 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-800">Tambah Realisasi</h3>
                <p id="modalKegiatanName" class="text-sm text-slate-500 mt-1"></p>
            </div>

            <form id="realisasiForm" method="POST" class="p-6 space-y-4">
                @csrf

                <!-- Info Anggaran -->
                <div class="bg-slate-50 rounded-lg p-3 text-sm grid grid-cols-2 gap-2">
                    <div>
                        <span class="text-slate-500">Total Anggaran:</span>
                        <span id="modalAnggaran" class="font-semibold text-slate-800 ml-1"></span>
                    </div>
                    <div>
                        <span class="text-slate-500">Sudah Terealisasi:</span>
                        <span id="modalRealisasi" class="font-semibold text-blue-600 ml-1"></span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-slate-500">Sisa:</span>
                        <span id="modalSisa" class="font-semibold text-emerald-600 ml-1"></span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Jumlah Realisasi (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="jumlah" min="1" placeholder="0"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="2" placeholder="Misal: Tahap I, Triwulan II, dst"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeRealisasiModal()"
                        class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function formatRupiah(angka) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
}

function openRealisasiModal(id, nama, anggaran, realisasi) {
    const sisa = anggaran - realisasi;
    document.getElementById('modalKegiatanName').textContent = nama;
    document.getElementById('modalAnggaran').textContent = formatRupiah(anggaran);
    document.getElementById('modalRealisasi').textContent = formatRupiah(realisasi);
    document.getElementById('modalSisa').textContent = formatRupiah(sisa);
    document.getElementById('realisasiForm').action = `/admin/keuangan/apbdes/${id}/realisasi`;
    document.getElementById('realisasiModal').classList.remove('hidden');
}

function closeRealisasiModal() {
    document.getElementById('realisasiModal').classList.add('hidden');
    document.getElementById('realisasiForm').reset();
}

// Tutup modal dengan tombol ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRealisasiModal();
    }
});
</script>
@endsection
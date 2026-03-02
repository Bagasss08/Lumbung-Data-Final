@extends('layouts.admin')

@section('title', 'Hari Libur')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Kalender Hari Libur</h3>
            <p class="text-sm text-gray-500 mt-0.5">Hari libur nasional dan lokal yang dikecualikan dari kehadiran</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            {{-- Import Nasional --}}
            <button onclick="previewImport({{ $tahun }})"
                class="inline-flex items-center gap-2 h-10 bg-white border border-gray-200 text-gray-700 px-4 rounded-lg text-sm font-medium hover:bg-gray-50 transition-all shadow-sm whitespace-nowrap">
                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Import Nasional {{ $tahun }}
            </button>
            {{-- Clear Cache / Refresh --}}
            <form action="{{ route('admin.kehadiran.hari-libur.clear-cache') }}" method="POST" class="contents">
                @csrf
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <button type="submit" title="Hapus cache API agar data diambil ulang dari internet"
                    class="inline-flex items-center gap-1.5 h-10 bg-white border border-gray-200 text-gray-500 px-3 rounded-lg text-sm font-medium hover:bg-gray-50 hover:text-gray-700 transition-all shadow-sm whitespace-nowrap"
                    onclick="return confirm('Hapus cache & ambil ulang data API untuk tahun {{ $tahun }}?')">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh Cache
                </button>
            </form>
            {{-- Tambah Manual --}}
            <button onclick="openModal('modalTambah')"
                class="inline-flex items-center gap-2 h-10 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-4 rounded-lg text-sm font-semibold hover:from-emerald-600 hover:to-teal-700 transition-all shadow-sm hover:shadow-md whitespace-nowrap">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah
            </button>
        </div>
    </div>

    {{-- FILTER TAHUN --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <div class="flex items-center gap-3 flex-wrap">
            <span class="text-sm font-medium text-gray-600">Tampilkan Tahun:</span>
            @foreach($tahunList as $th)
            <a href="{{ route('admin.kehadiran.hari-libur.index', ['tahun' => $th]) }}"
                class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all
                        {{ $th == $tahun ? 'bg-emerald-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ $th }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- STATISTIK --}}
    @php
    $totalLibur = $hariLiburs->count();
    $nasional = $hariLiburs->where('jenis', 'nasional')->count();
    $lokal = $hariLiburs->where('jenis', 'lokal')->count();
    $aktif = $hariLiburs->where('is_aktif', true)->count();
    @endphp
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs text-gray-500 font-medium">Total</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalLibur }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs text-gray-500 font-medium">Nasional</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $nasional }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs text-gray-500 font-medium">Lokal</p>
            <p class="text-2xl font-bold text-purple-600 mt-1">{{ $lokal }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs text-gray-500 font-medium">Aktif</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $aktif }}</p>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($hariLiburs->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-gray-400">
            <svg class="w-16 h-16 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="font-medium text-gray-500">Tidak ada hari libur di tahun {{ $tahun }}</p>
            <p class="text-sm mt-1">Klik "Import Nasional" untuk mengisi otomatis</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Nama</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Tanggal</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Durasi</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Jenis</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($hariLiburs as $hl)
                    <tr
                        class="hover:bg-gray-50 transition-colors {{ $hl->tanggal->isPast() && !$hl->tanggal->isToday() ? 'opacity-60' : '' }}">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">{{ $hl->nama }}</div>
                            @if($hl->keterangan)
                            <div class="text-xs text-gray-400 mt-0.5">{{ $hl->keterangan }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-700">{{ $hl->tanggal->translatedFormat('d F Y') }}</div>
                            @if($hl->tanggal_selesai)
                            <div class="text-xs text-gray-400">s/d {{ $hl->tanggal_selesai->translatedFormat('d F Y') }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600 font-medium">{{ $hl->durasi_hari }} hari</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold
                                    {{ $hl->jenis === 'nasional' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                                {{ ucfirst($hl->jenis) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold
                                    {{ $hl->is_aktif ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                <span
                                    class="w-1.5 h-1.5 rounded-full {{ $hl->is_aktif ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                {{ $hl->is_aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick='openEditModalHL({{ $hl->id }}, {{ json_encode($hl) }})'
                                    class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" @click="$dispatch('buka-modal-hapus', {
                                    action: '{{ route('admin.kehadiran.hari-libur.destroy', $hl) }}',
                                    nama: '{{ addslashes($hl->nama) }} ({{ $hl->tanggal->translatedFormat('d F Y') }})'
                                })" class="inline-flex items-center justify-center w-8 h-8 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

{{-- MODAL TAMBAH --}}
<div id="modalTambah" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-800">Tambah Hari Libur</h3>
            <button onclick="closeModal('modalTambah')"
                class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.kehadiran.hari-libur.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Hari Libur <span
                        class="text-red-500">*</span></label>
                <input type="text" name="nama" placeholder="Contoh: Hari Raya Idul Fitri"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none"
                    required>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="tanggal"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika 1 hari</p>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis <span
                        class="text-red-500">*</span></label>
                <select name="jenis"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none bg-white"
                    required>
                    <option value="nasional">Nasional</option>
                    <option value="lokal">Lokal (Desa/Kecamatan)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="2" placeholder="Opsional..."
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none resize-none"></textarea>
            </div>
            <div class="flex items-center gap-3">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_aktif" value="1" class="sr-only peer" checked>
                    <div
                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-emerald-500 transition-all after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5">
                    </div>
                </label>
                <span class="text-sm text-gray-700 font-medium">Aktif</span>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('modalTambah')"
                    class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">Batal</button>
                <button type="submit"
                    class="px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-800">Edit Hari Libur</h3>
            <button onclick="closeModal('modalEdit')"
                class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="formEditHL" method="POST" class="p-6 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Hari Libur <span
                        class="text-red-500">*</span></label>
                <input type="text" id="hl_nama" name="nama"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none"
                    required>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai <span
                            class="text-red-500">*</span></label>
                    <input type="date" id="hl_tanggal" name="tanggal"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Selesai</label>
                    <input type="date" id="hl_tanggal_selesai" name="tanggal_selesai"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis <span
                        class="text-red-500">*</span></label>
                <select id="hl_jenis" name="jenis"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none bg-white"
                    required>
                    <option value="nasional">Nasional</option>
                    <option value="lokal">Lokal (Desa/Kecamatan)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                <textarea id="hl_keterangan" name="keterangan" rows="2"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none resize-none"></textarea>
            </div>
            <div class="flex items-center gap-3">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="hl_is_aktif" name="is_aktif" value="1" class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-emerald-500 transition-all after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5">
                    </div>
                </label>
                <span class="text-sm text-gray-700 font-medium">Aktif</span>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('modalEdit')"
                    class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">Batal</button>
                <button type="submit"
                    class="px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.getElementById(id).classList.add('flex');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('flex');
    document.getElementById(id).classList.add('hidden');
}

function openEditModalHL(id, data) {
    document.getElementById('formEditHL').action = '/admin/kehadiran/hari-libur/' + id;
    document.getElementById('hl_nama').value            = data.nama || '';
    document.getElementById('hl_tanggal').value         = data.tanggal ? data.tanggal.substring(0, 10) : '';
    document.getElementById('hl_tanggal_selesai').value = data.tanggal_selesai ? data.tanggal_selesai.substring(0, 10) : '';
    document.getElementById('hl_jenis').value           = data.jenis || 'nasional';
    document.getElementById('hl_keterangan').value      = data.keterangan || '';
    document.getElementById('hl_is_aktif').checked      = data.is_aktif == 1;
    openModal('modalEdit');
}

['modalTambah', 'modalEdit'].forEach(function(id) {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) closeModal(id);
    });
});

// =====================================================
// PREVIEW IMPORT HARI LIBUR NASIONAL
// =====================================================
function previewImport(tahun) {
    // Reset state
    document.getElementById('previewLoading').classList.remove('hidden');
    document.getElementById('previewError').classList.add('hidden');
    document.getElementById('previewStats').classList.add('hidden');
    document.getElementById('previewContent').classList.add('hidden');
    document.getElementById('previewFooter').classList.add('hidden');
    document.getElementById('previewSubtitle').textContent = 'Mengambil data dari API...';
    document.getElementById('inputTahunImport').value = tahun;

    openModal('modalPreviewImport');

    // Fetch preview dari server
    fetch(`{{ route('admin.kehadiran.hari-libur.preview-nasional') }}?tahun=${tahun}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(result => {
        document.getElementById('previewLoading').classList.add('hidden');

        if (!result.success) {
            document.getElementById('previewErrorMsg').innerHTML = result.message + '<br><span class="text-gray-500 text-xs mt-1 block">Sistem akan menggunakan data hari libur bawaan saat import.</span>';
            document.getElementById('previewError').classList.remove('hidden');
            document.getElementById('previewError').classList.add('flex');
            // Tetap tampilkan footer agar bisa import data statis
            document.getElementById('previewFooter').classList.remove('hidden');
            document.getElementById('btnImport').textContent = 'Import Data Bawaan';
            document.getElementById('btnImport').disabled = false;
            return;
        }

        // Update statistik
        // Badge sumber
        const srcEl = document.getElementById('apiSource');
        if (result.source === 'static') {
            srcEl.textContent = '⚠ Data Bawaan (offline)';
            srcEl.className = 'text-xs bg-amber-50 text-amber-700 px-2.5 py-1 rounded-lg font-medium';
        } else {
            srcEl.textContent = `✓ ${result.source || 'libur.workers.dev'}`;
            srcEl.className = 'text-xs bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg font-medium';
        }
        document.getElementById('statTotal').textContent = result.total;
        document.getElementById('statBaru').textContent  = result.baru;
        document.getElementById('statAda').textContent   = result.sudah_ada;
        document.getElementById('previewSubtitle').textContent = `Tahun ${result.tahun} — ${result.total} hari libur ditemukan`;

        // Isi tabel
        const tbody = document.getElementById('previewTableBody');
        tbody.innerHTML = '';
        const bulanId = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        result.data.forEach(item => {
            const d = new Date(item.tanggal);
            const tgl = `${d.getDate()} ${bulanId[d.getMonth()]} ${d.getFullYear()}`;
            const row = document.createElement('tr');
            row.className = item.sudah_ada ? 'bg-amber-50/50' : 'hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-5 py-3 font-mono text-xs text-gray-700 whitespace-nowrap">${tgl}</td>
                <td class="px-5 py-3 text-gray-800">${item.nama}</td>
                <td class="px-5 py-3 text-center">
                    ${item.sudah_ada
                        ? '<span class="inline-flex items-center gap-1 text-xs bg-amber-100 text-amber-700 px-2 py-1 rounded-lg font-medium">Sudah ada</span>'
                        : '<span class="inline-flex items-center gap-1 text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded-lg font-medium">✓ Baru</span>'
                    }
                </td>`;
            tbody.appendChild(row);
        });

        // Disable tombol import jika semua sudah ada
        const btnImport = document.getElementById('btnImport');
        if (result.baru === 0) {
            btnImport.disabled = true;
            btnImport.textContent = 'Semua sudah ada';
        } else {
            btnImport.disabled = false;
            btnImport.textContent = `Import ${result.baru} Data Baru`;
        }

        document.getElementById('previewStats').classList.remove('hidden');
        document.getElementById('previewContent').classList.remove('hidden');
        document.getElementById('previewFooter').classList.remove('hidden');
    })
    .catch(err => {
        document.getElementById('previewLoading').classList.add('hidden');
        document.getElementById('previewErrorMsg').textContent = 'Terjadi kesalahan saat menghubungi server.';
        document.getElementById('previewError').classList.remove('hidden');
        document.getElementById('previewError').classList.add('flex');
    });
}
</script>
@endsection

{{-- ========================================================= --}}
{{-- MODAL PREVIEW IMPORT HARI LIBUR NASIONAL --}}
{{-- ========================================================= --}}
<div id="modalPreviewImport"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 flex-shrink-0">
            <div>
                <h3 class="text-base font-semibold text-gray-800">Preview Import Hari Libur Nasional</h3>
                <p id="previewSubtitle" class="text-xs text-gray-500 mt-0.5">Mengambil data dari API...</p>
            </div>
            <button onclick="closeModal('modalPreviewImport')"
                class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Loading state --}}
        <div id="previewLoading" class="flex flex-col items-center justify-center py-16 gap-3">
            <div class="w-10 h-10 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin"></div>
            <p class="text-sm text-gray-500">Mengambil data hari libur dari API...</p>
        </div>

        {{-- Error state --}}
        <div id="previewError" class="hidden flex-col items-center justify-center py-12 gap-3 px-6">
            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p id="previewErrorMsg" class="text-sm text-red-600 text-center font-medium"></p>
            <p class="text-xs text-gray-400 text-center">Tidak perlu khawatir — klik <strong>Import Sekarang</strong>
                untuk menggunakan data bawaan yang tersedia.</p>
        </div>

        {{-- Statistik --}}
        <div id="previewStats" class="hidden px-6 py-3 bg-gray-50 border-b border-gray-100 flex-shrink-0">
            <div class="flex items-center gap-6">
                <div class="text-center">
                    <p id="statTotal" class="text-xl font-bold text-gray-800">-</p>
                    <p class="text-xs text-gray-500">Total</p>
                </div>
                <div class="text-center">
                    <p id="statBaru" class="text-xl font-bold text-emerald-600">-</p>
                    <p class="text-xs text-gray-500">Akan diimport</p>
                </div>
                <div class="text-center">
                    <p id="statAda" class="text-xl font-bold text-amber-500">-</p>
                    <p class="text-xs text-gray-500">Sudah ada</p>
                </div>
                <div class="ml-auto">
                    <span id="apiSource" class="text-xs bg-blue-50 text-blue-600 px-2.5 py-1 rounded-lg font-medium">
                        Sumber: libur.workers.dev
                    </span>
                </div>
            </div>
        </div>

        {{-- Tabel data --}}
        <div id="previewContent" class="hidden overflow-y-auto flex-1">
            <table class="w-full text-sm">
                <thead class="sticky top-0 bg-white shadow-sm">
                    <tr class="border-b border-gray-100">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Hari Libur
                        </th>
                        <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody id="previewTableBody" class="divide-y divide-gray-50">
                    {{-- Diisi via JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div id="previewFooter"
            class="hidden px-6 py-4 border-t border-gray-100 flex items-center justify-between flex-shrink-0">
            <p class="text-xs text-gray-400">Data sudah ada tidak akan ditimpa.</p>
            <div class="flex gap-3">
                <button onclick="closeModal('modalPreviewImport')"
                    class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">Batal</button>
                <form id="formImportNasional" action="{{ route('admin.kehadiran.hari-libur.import-nasional') }}"
                    method="POST" class="contents">
                    @csrf
                    <input type="hidden" name="tahun" id="inputTahunImport" value="{{ $tahun }}">
                    <button type="submit" id="btnImport"
                        class="px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed">
                        Import Sekarang
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
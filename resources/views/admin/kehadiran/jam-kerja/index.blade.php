@extends('layouts.admin')

@section('title', 'Jam Kerja')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Pengaturan Jam Kerja</h3>
            <p class="text-sm text-gray-500 mt-0.5">Kelola shift dan jam kerja perangkat desa</p>
        </div>
        <button onclick="openModal('modalTambah')"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-4 py-2.5 rounded-lg text-sm font-semibold hover:from-emerald-600 hover:to-teal-700 transition-all shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Jam Kerja
        </button>
    </div>

    {{-- TABEL --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($jamKerjas->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-gray-400">
            <svg class="w-16 h-16 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="font-medium text-gray-500">Belum ada jam kerja</p>
            <p class="text-sm mt-1">Klik tombol "Tambah Jam Kerja" untuk memulai</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Nama Shift</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Jam Masuk</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Jam Keluar</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Istirahat</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Toleransi</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Durasi</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($jamKerjas as $jk)
                    @php
                    $durasi = $jk->durasi_kerja;
                    $jam = intdiv($durasi, 60);
                    $menit = $durasi % 60;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">{{ $jk->nama_shift }}</div>
                            @if($jk->keterangan)
                            <div class="text-xs text-gray-400 mt-0.5">{{ $jk->keterangan }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-mono font-medium text-gray-700">
                            {{ \Carbon\Carbon::parse($jk->jam_masuk)->format('H:i') }}
                        </td>
                        <td class="px-6 py-4 font-mono font-medium text-gray-700">
                            {{ \Carbon\Carbon::parse($jk->jam_keluar)->format('H:i') }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            @if($jk->jam_istirahat_mulai)
                            <span class="font-mono text-xs">
                                {{ \Carbon\Carbon::parse($jk->jam_istirahat_mulai)->format('H:i') }}
                                – {{ \Carbon\Carbon::parse($jk->jam_istirahat_selesai)->format('H:i') }}
                            </span>
                            @else
                            <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center gap-1 text-amber-700 bg-amber-50 px-2.5 py-1 rounded-lg text-xs font-medium">
                                {{ $jk->toleransi_menit }} menit
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-700 font-medium">{{ $jam }}j {{ $menit }}m</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.kehadiran.jam-kerja.toggle', $jk) }}" method="POST"
                                class="inline">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all
                                            {{ $jk->is_aktif ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full {{ $jk->is_aktif ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                    {{ $jk->is_aktif ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick='openEditModal({{ $jk->id }}, {{ json_encode($jk) }})'
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" @click="$dispatch('buka-modal-hapus', {
                                    action: '{{ route('admin.kehadiran.jam-kerja.destroy', $jk) }}',
                                    nama: '{{ addslashes($jk->nama_shift) }} ({{ \Carbon\Carbon::parse($jk->jam_masuk)->format('H:i') }} - {{ \Carbon\Carbon::parse($jk->jam_keluar)->format('H:i') }})'
                                })" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
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
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white z-10">
            <h3 class="text-base font-semibold text-gray-800">Tambah Jam Kerja</h3>
            <button onclick="closeModal('modalTambah')"
                class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.kehadiran.jam-kerja.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Shift <span
                        class="text-red-500">*</span></label>
                <input type="text" name="nama_shift" placeholder="Contoh: Shift Normal, Shift Pagi"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none transition-all"
                    required>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jam Masuk <span
                            class="text-red-500">*</span></label>
                    <input type="time" name="jam_masuk"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jam Keluar <span
                            class="text-red-500">*</span></label>
                    <input type="time" name="jam_keluar"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none"
                        required>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Mulai Istirahat</label>
                    <input type="time" name="jam_istirahat_mulai"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Selesai Istirahat</label>
                    <input type="time" name="jam_istirahat_selesai"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Toleransi Keterlambatan (menit) <span
                        class="text-red-500">*</span></label>
                <input type="number" name="toleransi_menit" value="15" min="0" max="120"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none"
                    required>
                <p class="text-xs text-gray-400 mt-1">Pegawai datang lewat batas ini akan dicatat terlambat</p>
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
            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" onclick="closeModal('modalTambah')"
                    class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">Batal</button>
                <button type="submit"
                    class="px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white z-10">
            <h3 class="text-base font-semibold text-gray-800">Edit Jam Kerja</h3>
            <button onclick="closeModal('modalEdit')"
                class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="formEdit" method="POST" class="p-6 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Shift <span
                        class="text-red-500">*</span></label>
                <input type="text" id="edit_nama_shift" name="nama_shift"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none"
                    required>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jam Masuk <span
                            class="text-red-500">*</span></label>
                    <input type="time" id="edit_jam_masuk" name="jam_masuk"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jam Keluar <span
                            class="text-red-500">*</span></label>
                    <input type="time" id="edit_jam_keluar" name="jam_keluar"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none"
                        required>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Mulai Istirahat</label>
                    <input type="time" id="edit_jam_istirahat_mulai" name="jam_istirahat_mulai"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Selesai Istirahat</label>
                    <input type="time" id="edit_jam_istirahat_selesai" name="jam_istirahat_selesai"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Toleransi (menit) <span
                        class="text-red-500">*</span></label>
                <input type="number" id="edit_toleransi" name="toleransi_menit" min="0" max="120"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none"
                    required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                <textarea id="edit_keterangan" name="keterangan" rows="2"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none resize-none"></textarea>
            </div>
            <div class="flex items-center gap-3">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="edit_is_aktif" name="is_aktif" value="1" class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-emerald-500 transition-all after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5">
                    </div>
                </label>
                <span class="text-sm text-gray-700 font-medium">Aktif</span>
            </div>
            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" onclick="closeModal('modalEdit')"
                    class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">Batal</button>
                <button type="submit"
                    class="px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-lg">Perbarui</button>
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

function openEditModal(id, data) {
    document.getElementById('formEdit').action = '/admin/kehadiran/jam-kerja/' + id;
    document.getElementById('edit_nama_shift').value            = data.nama_shift || '';
    document.getElementById('edit_jam_masuk').value             = data.jam_masuk ? data.jam_masuk.substring(0, 5) : '';
    document.getElementById('edit_jam_keluar').value            = data.jam_keluar ? data.jam_keluar.substring(0, 5) : '';
    document.getElementById('edit_jam_istirahat_mulai').value   = data.jam_istirahat_mulai ? data.jam_istirahat_mulai.substring(0, 5) : '';
    document.getElementById('edit_jam_istirahat_selesai').value = data.jam_istirahat_selesai ? data.jam_istirahat_selesai.substring(0, 5) : '';
    document.getElementById('edit_toleransi').value             = data.toleransi_menit || 15;
    document.getElementById('edit_keterangan').value            = data.keterangan || '';
    document.getElementById('edit_is_aktif').checked            = data.is_aktif == 1;
    openModal('modalEdit');
}

// Tutup modal klik backdrop
['modalTambah', 'modalEdit'].forEach(function(id) {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) closeModal(id);
    });
});
</script>
@endsection
@extends('layouts.admin')

@section('title', 'Pengaduan Kehadiran')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Pengaduan Kehadiran</h3>
            <p class="text-sm text-gray-500 mt-0.5">Kelola permohonan koreksi data kehadiran dari perangkat desa</p>
        </div>
        @if($totalPending > 0)
        <div
            class="inline-flex items-center gap-2 bg-amber-50 border border-amber-200 text-amber-800 px-4 py-2.5 rounded-xl text-sm font-semibold">
            <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
            {{ $totalPending }} pengaduan menunggu
        </div>
        @endif
    </div>

    {{-- FILTER TAB STATUS --}}
    @php
    $tabList = [
    'semua' => 'Semua',
    'pending' => 'Menunggu',
    'disetujui' => 'Disetujui',
    'ditolak' => 'Ditolak',
    ];
    @endphp
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-1.5 flex gap-1">
        @foreach($tabList as $key => $label)
        <a href="{{ route('admin.kehadiran.pengaduan-kehadiran.index', ['status' => $key]) }}" class="flex-1 text-center px-4 py-2.5 rounded-xl text-sm font-medium transition-all
                {{ $status === $key
                    ? 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-gray-100' }}">
            {{ $label }}
            @if($key === 'pending' && $totalPending > 0)
            <span class="ml-1.5 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                {{ $totalPending }}
            </span>
            @endif
        </a>
        @endforeach
    </div>

    {{-- DAFTAR PENGADUAN --}}
    <div class="space-y-3">
        @forelse($pengaduans as $pengaduan)
        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

                    {{-- Info Perangkat --}}
                    <div class="flex items-start gap-4">
                        <div
                            class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                            {{ strtoupper(substr($pengaduan->perangkat->nama ?? '?', 0, 2)) }}
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">{{ $pengaduan->perangkat->nama ?? 'N/A' }}</h4>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $pengaduan->perangkat->jabatan ?? '-' }}</p>
                            <div class="flex items-center gap-3 mt-2">
                                <span class="inline-flex items-center gap-1.5 text-xs text-gray-600">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $pengaduan->tanggal_kehadiran->translatedFormat('d F Y') }}
                                </span>
                                <span class="text-gray-300">•</span>
                                <span class="text-xs text-gray-600">{{ $pengaduan->jenis_pengaduan }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Badge Status --}}
                    <div class="flex items-center gap-2 flex-shrink-0">
                        @if($pengaduan->status === 'pending')
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-amber-50 text-amber-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            Menunggu
                        </span>
                        @elseif($pengaduan->status === 'disetujui')
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Disetujui
                        </span>
                        @else
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-50 text-red-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                            Ditolak
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Alasan --}}
                <div class="mt-4 p-3.5 bg-gray-50 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Alasan Pengaduan</p>
                    <p class="text-sm text-gray-700">{{ $pengaduan->alasan }}</p>
                </div>

                {{-- Data yang diajukan --}}
                @if($pengaduan->jam_masuk_diajukan || $pengaduan->jam_keluar_diajukan || $pengaduan->status_diajukan)
                <div class="mt-3 flex flex-wrap gap-3">
                    @if($pengaduan->jam_masuk_diajukan)
                    <div class="text-xs bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg font-medium">
                        Masuk: {{ \Carbon\Carbon::parse($pengaduan->jam_masuk_diajukan)->format('H:i') }}
                    </div>
                    @endif
                    @if($pengaduan->jam_keluar_diajukan)
                    <div class="text-xs bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg font-medium">
                        Keluar: {{ \Carbon\Carbon::parse($pengaduan->jam_keluar_diajukan)->format('H:i') }}
                    </div>
                    @endif
                    @if($pengaduan->status_diajukan)
                    @php $statusLabels =
                    ['hadir'=>'Hadir','terlambat'=>'Terlambat','izin'=>'Izin','sakit'=>'Sakit','alpa'=>'Alpa','dinas_luar'=>'Dinas
                    Luar','cuti'=>'Cuti','libur'=>'Libur']; @endphp
                    <div class="text-xs bg-purple-50 text-purple-700 px-3 py-1.5 rounded-lg font-medium">
                        Status: {{ $statusLabels[$pengaduan->status_diajukan] ?? $pengaduan->status_diajukan }}
                    </div>
                    @endif
                </div>
                @endif

                {{-- Catatan admin --}}
                @if($pengaduan->catatan_admin)
                <div
                    class="mt-3 p-3 rounded-r-xl border-l-4 {{ $pengaduan->status === 'disetujui' ? 'border-emerald-400 bg-emerald-50' : 'border-red-400 bg-red-50' }}">
                    <p
                        class="text-xs font-semibold {{ $pengaduan->status === 'disetujui' ? 'text-emerald-700' : 'text-red-700' }}">
                        Catatan Admin:</p>
                    <p
                        class="text-sm mt-0.5 {{ $pengaduan->status === 'disetujui' ? 'text-emerald-800' : 'text-red-800' }}">
                        {{ $pengaduan->catatan_admin }}</p>
                </div>
                @endif

                {{-- Tombol Aksi --}}
                @if($pengaduan->status === 'pending')
                <div class="mt-4 flex items-center gap-3">
                    <button onclick="openApproveModal({{ $pengaduan->id }})"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Setujui
                    </button>
                    <button onclick="openRejectModal({{ $pengaduan->id }})"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Tolak
                    </button>
                    <a href="{{ route('admin.kehadiran.pengaduan-kehadiran.show', $pengaduan) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-all">
                        Detail
                    </a>
                </div>
                @else
                <div class="mt-3 text-xs text-gray-400">
                    Diproses oleh <strong>{{ $pengaduan->pemroses->name ?? 'Admin' }}</strong>
                    pada {{ $pengaduan->diproses_pada?->translatedFormat('d F Y, H:i') }}
                </div>
                @endif
            </div>
        </div>
        @empty
        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center py-16 text-gray-400">
            <svg class="w-16 h-16 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
            <p class="font-medium text-gray-500">Tidak ada pengaduan</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($pengaduans->hasPages())
    <div class="flex justify-center">
        {{ $pengaduans->links() }}
    </div>
    @endif

</div>

{{-- MODAL SETUJUI --}}
<div id="modalApprove" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-800">Setujui Pengaduan</h3>
            </div>
            <button onclick="closeModal('modalApprove')"
                class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="formApprove" method="POST" class="p-6 space-y-4">
            @csrf
            <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                <p class="text-sm text-emerald-800">Data kehadiran akan diperbarui sesuai pengaduan secara otomatis.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Catatan (opsional)</label>
                <textarea name="catatan_admin" rows="3" placeholder="Catatan untuk pegawai..."
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none resize-none"></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalApprove')"
                    class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">Batal</button>
                <button type="submit"
                    class="px-4 py-2.5 text-sm font-semibold text-white bg-emerald-500 hover:bg-emerald-600 rounded-lg">Setujui</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL TOLAK --}}
<div id="modalReject" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-800">Tolak Pengaduan</h3>
            </div>
            <button onclick="closeModal('modalReject')"
                class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="formReject" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Alasan Penolakan <span class="text-red-500">*</span>
                </label>
                <textarea name="catatan_admin" rows="3" placeholder="Jelaskan alasan penolakan..."
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-red-400 focus:ring-2 focus:ring-red-100 text-sm outline-none resize-none"
                    required></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalReject')"
                    class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">Batal</button>
                <button type="submit"
                    class="px-4 py-2.5 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-lg">Tolak
                    Pengaduan</button>
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
function openApproveModal(id) {
    document.getElementById('formApprove').action = '/admin/kehadiran/pengaduan-kehadiran/' + id + '/approve';
    openModal('modalApprove');
}
function openRejectModal(id) {
    document.getElementById('formReject').action = '/admin/kehadiran/pengaduan-kehadiran/' + id + '/reject';
    openModal('modalReject');
}
['modalApprove','modalReject'].forEach(function(id) {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) closeModal(id);
    });
});
</script>
@endsection
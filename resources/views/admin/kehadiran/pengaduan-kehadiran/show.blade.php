@extends('layouts.admin')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="space-y-6 max-w-3xl">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('admin.kehadiran.pengaduan-kehadiran.index') }}"
            class="hover:text-emerald-600 transition-colors">
            Pengaduan Kehadiran
        </a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-800 font-medium">Detail Pengaduan #{{ $pengaduanKehadiran->id }}</span>
    </div>

    {{-- Info Utama --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold text-lg">
                    {{ strtoupper(substr($pengaduanKehadiran->perangkat->nama ?? '?', 0, 2)) }}
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $pengaduanKehadiran->perangkat->nama ?? 'N/A' }}</h3>
                    <p class="text-sm text-gray-500">{{ $pengaduanKehadiran->perangkat->jabatan ?? '-' }}</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold
                @if($pengaduanKehadiran->status === 'pending')   bg-amber-50 text-amber-700
                @elseif($pengaduanKehadiran->status === 'disetujui') bg-emerald-50 text-emerald-700
                @else bg-red-50 text-red-700 @endif">
                {{ $pengaduanKehadiran->status_label }}
            </span>
        </div>

        <div class="p-6 grid grid-cols-2 gap-6">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tanggal Kehadiran</p>
                <p class="text-sm font-semibold text-gray-800">
                    {{ $pengaduanKehadiran->tanggal_kehadiran->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Jenis Pengaduan</p>
                <p class="text-sm font-semibold text-gray-800">{{ $pengaduanKehadiran->jenis_pengaduan }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Alasan</p>
                <p class="text-sm text-gray-700 leading-relaxed">{{ $pengaduanKehadiran->alasan }}</p>
            </div>
        </div>
    </div>

    {{-- Perbandingan Data --}}
    <div class="grid grid-cols-2 gap-4">

        {{-- Data Asli --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                Data Kehadiran Saat Ini
            </h4>
            @if($kehadiranAsli)
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Status</span>
                    <span class="font-semibold text-gray-800">
                        {{ \App\Models\KehadiranPegawai::$statusLabel[$kehadiranAsli->status] ?? '-' }}
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Jam Masuk</span>
                    <span class="font-mono font-semibold text-gray-800">
                        {{ $kehadiranAsli->jam_masuk_aktual ?
                        \Carbon\Carbon::parse($kehadiranAsli->jam_masuk_aktual)->format('H:i') : '—' }}
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Jam Keluar</span>
                    <span class="font-mono font-semibold text-gray-800">
                        {{ $kehadiranAsli->jam_keluar_aktual ?
                        \Carbon\Carbon::parse($kehadiranAsli->jam_keluar_aktual)->format('H:i') : '—' }}
                    </span>
                </div>
            </div>
            @else
            <p class="text-sm text-gray-400 italic">Tidak ada data kehadiran di tanggal ini</p>
            @endif
        </div>

        {{-- Data yang Diajukan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-5">
            <h4 class="text-sm font-semibold text-blue-700 mb-4 flex items-center gap-2">
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                Koreksi yang Diajukan
            </h4>
            <div class="space-y-3">
                @if($pengaduanKehadiran->status_diajukan)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Status</span>
                    <span class="font-semibold text-blue-700">
                        {{ \App\Models\KehadiranPegawai::$statusLabel[$pengaduanKehadiran->status_diajukan] ?? '-' }}
                    </span>
                </div>
                @endif
                @if($pengaduanKehadiran->jam_masuk_diajukan)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Jam Masuk</span>
                    <span class="font-mono font-semibold text-blue-700">
                        {{ \Carbon\Carbon::parse($pengaduanKehadiran->jam_masuk_diajukan)->format('H:i') }}
                    </span>
                </div>
                @endif
                @if($pengaduanKehadiran->jam_keluar_diajukan)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Jam Keluar</span>
                    <span class="font-mono font-semibold text-blue-700">
                        {{ \Carbon\Carbon::parse($pengaduanKehadiran->jam_keluar_diajukan)->format('H:i') }}
                    </span>
                </div>
                @endif
                @if(!$pengaduanKehadiran->status_diajukan && !$pengaduanKehadiran->jam_masuk_diajukan &&
                !$pengaduanKehadiran->jam_keluar_diajukan)
                <p class="text-sm text-gray-400 italic">Tidak ada perubahan spesifik</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Aksi (hanya pending) --}}
    @if($pengaduanKehadiran->status === 'pending')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
        <p class="text-sm text-gray-600">Ambil tindakan untuk pengaduan ini:</p>
        <div class="flex items-center gap-3">
            <button onclick="openApproveModal({{ $pengaduanKehadiran->id }})"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Setujui
            </button>
            <button onclick="openRejectModal({{ $pengaduanKehadiran->id }})"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Tolak
            </button>
        </div>
    </div>
    @elseif($pengaduanKehadiran->catatan_admin)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Catatan Admin</p>
        <p class="text-sm text-gray-700">{{ $pengaduanKehadiran->catatan_admin }}</p>
        <p class="text-xs text-gray-400 mt-2">
            Oleh {{ $pengaduanKehadiran->pemroses->name ?? 'Admin' }}
            pada {{ $pengaduanKehadiran->diproses_pada?->translatedFormat('d F Y, H:i') }}
        </p>
    </div>
    @endif

</div>

{{-- Reuse modal dari index (include partial jika diperlukan) --}}
<div id="modalApprove" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 space-y-4">
        <h3 class="text-base font-semibold text-gray-800">Setujui Pengaduan</h3>
        <form id="formApprove" method="POST">
            @csrf
            <textarea name="catatan_admin" rows="3" placeholder="Catatan (opsional)..."
                class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm outline-none resize-none focus:border-emerald-400"></textarea>
            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="closeModal('modalApprove')"
                    class="px-4 py-2.5 text-sm bg-gray-100 text-gray-700 rounded-lg">Batal</button>
                <button type="submit"
                    class="px-4 py-2.5 text-sm font-semibold text-white bg-emerald-500 rounded-lg">Setujui</button>
            </div>
        </form>
    </div>
</div>
<div id="modalReject" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 space-y-4">
        <h3 class="text-base font-semibold text-gray-800">Tolak Pengaduan</h3>
        <form id="formReject" method="POST">
            @csrf
            <textarea name="catatan_admin" rows="3" placeholder="Alasan penolakan..." required
                class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm outline-none resize-none focus:border-red-400"></textarea>
            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="closeModal('modalReject')"
                    class="px-4 py-2.5 text-sm bg-gray-100 text-gray-700 rounded-lg">Batal</button>
                <button type="submit"
                    class="px-4 py-2.5 text-sm font-semibold text-white bg-red-500 rounded-lg">Tolak</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.replace('hidden','flex'); }
function closeModal(id) { document.getElementById(id).classList.replace('flex','hidden'); }

function openApproveModal(id) {
    document.getElementById('formApprove').action = `/admin/kehadiran/pengaduan-kehadiran/${id}/approve`;
    openModal('modalApprove');
}
function openRejectModal(id) {
    document.getElementById('formReject').action = `/admin/kehadiran/pengaduan-kehadiran/${id}/reject`;
    openModal('modalReject');
}
</script>
@endsection
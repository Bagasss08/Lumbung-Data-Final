@extends('layouts.admin')

@section('title', 'Pemerintah Desa')

@section('content')
<div class="space-y-6">

    {{-- ── Header ──────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="text-xs text-gray-500 mb-1">
                <span>Info Desa</span>
                <span class="mx-1">›</span>
                <span class="text-emerald-600 font-medium">Pemerintah Desa</span>
            </nav>
            <p class="text-sm text-gray-500">Kelola data perangkat dan BPD desa</p>
        </div>
        <a href="{{ route('admin.pemerintah-desa.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl shadow hover:shadow-md hover:brightness-105 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Perangkat
        </a>
    </div>

    {{-- ── Alert ───────────────────────────────────────────────── --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">
        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Stats Cards ─────────────────────────────────────────── --}}
    @php
    $total = $perangkat->total();
    $aktif = \App\Models\PerangkatDesa::where('status','1')->count();
    $nonaktif = \App\Models\PerangkatDesa::where('status','2')->count();
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Perangkat</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $total }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs font-medium text-emerald-600 uppercase tracking-wider">Aktif</p>
            <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $aktif }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs font-medium text-red-500 uppercase tracking-wider">Non-Aktif</p>
            <p class="text-3xl font-bold text-red-500 mt-1">{{ $nonaktif }}</p>
        </div>
    </div>

    {{-- ── Filter & Search ─────────────────────────────────────── --}}
    <form method="GET" action="{{ route('admin.pemerintah-desa.index') }}"
        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            {{-- Search --}}
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIK..."
                    class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent">
            </div>

            {{-- Filter Golongan --}}
            <select name="golongan"
                class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 bg-white">
                <option value="">Semua Golongan</option>
                <option value="pemerintah_desa" {{ request('golongan')==='pemerintah_desa' ? 'selected' : '' }}>
                    Pemerintah Desa</option>
                <option value="bpd" {{ request('golongan')==='bpd' ? 'selected' : '' }}>BPD</option>
            </select>

            {{-- Filter Status --}}
            <div class="flex gap-2">
                <select name="status"
                    class="flex-1 px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 bg-white">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status')==='1' ? 'selected' : '' }}>Aktif</option>
                    <option value="2" {{ request('status')==='2' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                <button type="submit"
                    class="px-4 py-2.5 bg-emerald-500 text-white rounded-xl text-sm font-medium hover:bg-emerald-600 transition">
                    Filter
                </button>
                @if(request()->hasAny(['search','status','golongan']))
                <a href="{{ route('admin.pemerintah-desa.index') }}"
                    class="px-3 py-2.5 bg-gray-100 text-gray-600 rounded-xl text-sm hover:bg-gray-200 transition flex items-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
                @endif
            </div>
        </div>
    </form>

    {{-- ── Table ───────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($perangkat->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-gray-400">
            <svg class="w-16 h-16 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <p class="text-lg font-semibold text-gray-500">Belum ada data perangkat</p>
            <p class="text-sm mt-1">Klik tombol "Tambah Perangkat" untuk mulai menambahkan data.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th
                            class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-10">
                            No</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Perangkat</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Jabatan</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No.
                            SK</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Periode</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($perangkat as $index => $item)
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        {{-- No --}}
                        <td class="px-5 py-4 text-gray-400 font-medium">
                            {{ $perangkat->firstItem() + $index }}
                        </td>

                        {{-- Perangkat --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0 bg-emerald-50">
                                    @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                                        class="w-full h-full object-cover">
                                    @else
                                    <div
                                        class="w-full h-full flex items-center justify-center text-emerald-500 font-bold text-sm">
                                        {{ strtoupper(substr($item->nama, 0, 2)) }}
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $item->nama }}</p>
                                    <p class="text-xs text-gray-400">{{ $item->nik ?? '-' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Jabatan --}}
                        <td class="px-5 py-4">
                            <p class="font-medium text-gray-800">{{ $item->jabatan->nama ?? '-' }}</p>
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $item->jabatan?->golongan === 'bpd'
                                    ? 'bg-blue-100 text-blue-600'
                                    : 'bg-emerald-100 text-emerald-700' }}">
                                {{ $item->jabatan?->label_golongan ?? '-' }}
                            </span>
                        </td>

                        {{-- No SK --}}
                        <td class="px-5 py-4 text-gray-600">
                            {{ $item->no_sk ?? '-' }}
                        </td>

                        {{-- Periode --}}
                        <td class="px-5 py-4 text-gray-500 text-xs">
                            @if($item->periode_mulai)
                            {{ $item->periode_mulai->format('d/m/Y') }}
                            @if($item->periode_selesai)
                            <br>– {{ $item->periode_selesai->format('d/m/Y') }}
                            @endif
                            @else
                            -
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-4 text-center">
                            <button onclick="toggleStatus({{ $item->id }}, this)" data-status="{{ $item->status }}"
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition-all {{ $item->badge_status }}">
                                {{ $item->label_status }}
                            </button>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-1">
                                {{-- Detail --}}
                                <a href="{{ route('admin.pemerintah-desa.show', $item) }}"
                                    class="p-1.5 rounded-lg text-blue-500 hover:bg-blue-50 transition" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                {{-- Edit --}}
                                <a href="{{ route('admin.pemerintah-desa.edit', $item) }}"
                                    class="p-1.5 rounded-lg text-amber-500 hover:bg-amber-50 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                {{-- Hapus --}}
                                <button onclick="confirmDelete({{ $item->id }}, '{{ $item->nama }}')"
                                    class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 transition" title="Hapus">
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

        {{-- Pagination --}}
        @if($perangkat->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $perangkat->links() }}
        </div>
        @endif
        @endif
    </div>
</div>

{{-- ── Delete Modal ─────────────────────────────────────────── --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Konfirmasi Hapus</h3>
                <p class="text-sm text-gray-500" id="deleteMsg">Yakin ingin menghapus data ini?</p>
            </div>
        </div>
        <div class="flex gap-3 justify-end">
            <button onclick="closeDeleteModal()"
                class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                Batal
            </button>
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-xl hover:bg-red-600 transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // ── Delete Confirmation ──────────────────────────────────────
function confirmDelete(id, nama) {
    document.getElementById('deleteMsg').textContent = `Yakin ingin menghapus perangkat "${nama}"?`;
    document.getElementById('deleteForm').action = `/admin/pemerintah-desa/${id}`;
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// ── Toggle Status ────────────────────────────────────────────
function toggleStatus(id, btn) {
    fetch(`/admin/pemerintah-desa/${id}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                            || '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const isAktif = data.status === '1';
            btn.textContent  = isAktif ? 'Aktif' : 'Non-Aktif';
            btn.dataset.status = data.status;
            btn.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition-all '
                + (isAktif ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600');
        }
    });
}
</script>
@endsection
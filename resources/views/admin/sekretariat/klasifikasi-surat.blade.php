@extends('layouts.admin')

@section('title', 'Klasifikasi Surat')

@section('content')
<div x-data="{
    selectedIds: [],
    selectAll: false,
    toggleAll() {
        if (this.selectAll) {
            this.selectedIds = Array.from(document.querySelectorAll('.row-checkbox')).map(el => el.value);
        } else {
            this.selectedIds = [];
        }
    },
    toggleOne() {
        const all = Array.from(document.querySelectorAll('.row-checkbox')).map(el => el.value);
        this.selectAll = all.length > 0 && all.every(id => this.selectedIds.includes(id));
    }
}" class="space-y-6">

    {{-- PAGE HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Klasifikasi Surat</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola klasifikasi dan kodefikasi surat desa</p>
            <p class="text-sm text-slate-500 mt-1">
                Kode Klasifikasi Arsip ini sudah sesuai dengan Permendagri Nomor 83 Tahun 2022 
                <a href="https://peraturan.bpk.go.id/Details/247841/Permendagri%20No.%2083%20Tahun%202022" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline font-medium">Cek di sini</a>
            </p>
        </div>
    </div>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-end="opacity-0"
        class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-6 py-4 rounded-xl flex items-start gap-3 shadow-sm">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-sm border border-blue-200 p-6 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600 mb-1">Total Klasifikasi</p>
                    <p class="text-3xl font-bold text-blue-700">{{ $stats['total'] ?? 0 }}</p>
                    <p class="text-xs text-blue-500 mt-1">Semua klasifikasi</p>
                </div>
                <div class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl shadow-sm border border-emerald-200 p-6 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-600 mb-1">Aktif Digunakan</p>
                    <p class="text-3xl font-bold text-emerald-700">{{ $stats['aktif'] ?? 0 }}</p>
                    <p class="text-xs text-emerald-500 mt-1">Sedang digunakan</p>
                </div>
                <div class="w-14 h-14 bg-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Tidak Aktif</p>
                    <p class="text-3xl font-bold text-gray-700">{{ $stats['tidak_aktif'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">Dinonaktifkan</p>
                </div>
                <div class="w-14 h-14 bg-gray-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD UTAMA: Aksi, Pencarian, & Tabel --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        {{-- Toolbar Atas: Tombol Aksi --}}
        <div class="flex items-center gap-2 px-6 pt-6 pb-4 border-b border-gray-100">
            {{-- Tambah --}}
            <a href="{{ route('admin.sekretariat.klasifikasi-surat.create') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Klasifikasi
            </a>

            {{-- Hapus Bulk --}}
            <form method="POST" action="{{ route('admin.sekretariat.klasifikasi-surat.bulk-destroy') }}" id="form-bulk-hapus">
                @csrf
                @method('DELETE')
                <template x-for="id in selectedIds" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <button type="button"
                    :disabled="selectedIds.length === 0"
                    @click="selectedIds.length > 0 && $dispatch('buka-modal-hapus', { bulkCount: selectedIds.length, onConfirm: () => document.getElementById('form-bulk-hapus').submit() })"
                    :class="selectedIds.length > 0
                        ? 'bg-red-500 hover:bg-red-600 shadow-sm cursor-pointer'
                        : 'bg-red-300 cursor-not-allowed opacity-60'"
                    class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-medium rounded-lg transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus
                    <span x-show="selectedIds.length > 0">(<span x-text="selectedIds.length"></span>)</span>
                </button>
            </form>
        </div>

        {{-- Area Filter & Search --}}
        <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100">
            {{-- TAMBAHAN ID "form-filter" --}}
            <form id="form-filter" method="GET" action="{{ route('admin.sekretariat.klasifikasi-surat') }}" class="flex flex-col sm:flex-row gap-4">
                
                {{-- Dropdown Pilihan Jumlah Data --}}
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium text-slate-600">Tampilkan</span>
                    {{-- MENGGUNAKAN document.getElementById UNTUK SUBMIT --}}
                    <select name="per_page" onchange="document.getElementById('form-filter').submit()" 
                        class="border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm py-2 pl-3 pr-8 bg-white cursor-pointer">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                        <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </div>

                {{-- Kolom Pencarian --}}
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari kode, klasifikasi, atau nama..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                    </div>
                </div>

                {{-- Tombol Cari & Reset --}}
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition-all shadow-sm flex items-center gap-2">
                        Cari
                    </button>
                    @if(request('search') || request('per_page'))
                    <a href="{{ route('admin.sekretariat.klasifikasi-surat') }}"
                        class="px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white rounded-lg text-sm font-medium transition-all shadow-sm flex items-center gap-2">
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 w-10">
                            <input type="checkbox" x-model="selectAll" @change="toggleAll()"
                                class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider w-16">
                            NO
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Kode
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Nama Klasifikasi
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Nama
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">
                    @forelse ($klasifikasiSurat as $index => $klasifikasi)
                    <tr class="hover:bg-slate-50 transition-colors duration-150"
                        :class="selectedIds.includes('{{ $klasifikasi->id }}') ? 'bg-emerald-50/50' : ''">
                        
                        {{-- Checkbox --}}
                        <td class="px-6 py-4">
                            <input type="checkbox"
                                class="row-checkbox w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                value="{{ $klasifikasi->id }}"
                                x-model="selectedIds"
                                @change="toggleOne()">
                        </td>
                        
                        {{-- Angka / No --}}
                        <td class="px-4 py-4 text-sm text-slate-500 font-medium">
                            {{ $klasifikasiSurat->firstItem() + $index }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700 text-sm font-bold rounded-lg">
                                {{ $klasifikasi->kode }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-slate-900">{{ $klasifikasi->nama_klasifikasi }}</div>
                            @if($klasifikasi->keterangan)
                            <div class="text-sm text-slate-500 line-clamp-2 mt-1">{{ Str::limit($klasifikasi->keterangan, 100) }}</div>
                            @endif
                        </td>
                        
                        {{-- Kolom Nama --}}
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1.5 text-xs font-semibold bg-gradient-to-r from-indigo-100 to-indigo-200 text-indigo-700 rounded-xl shadow-sm border border-indigo-200 leading-relaxed">
                                {{ $klasifikasi->nama }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4">
                            @if($klasifikasi->status)
                            <span class="inline-flex px-3 py-1 text-xs font-semibold bg-gradient-to-r from-emerald-100 to-emerald-200 text-emerald-700 rounded-full">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Aktif
                            </span>
                            @else
                            <span class="inline-flex px-3 py-1 text-xs font-semibold bg-gradient-to-r from-red-100 to-red-200 text-red-700 rounded-full">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                Tidak Aktif
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.sekretariat.klasifikasi-surat.show', $klasifikasi->id) }}"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <a href="{{ route('admin.sekretariat.klasifikasi-surat.edit', $klasifikasi->id) }}"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <form method="POST"
                                    action="{{ route('admin.sekretariat.klasifikasi-surat.destroy', $klasifikasi->id) }}"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus klasifikasi surat ini?')"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                        title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-500 text-lg font-medium">Tidak ada data klasifikasi surat</p>
                                <p class="text-gray-400 text-sm mt-1">Mulai dengan menambahkan klasifikasi baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($klasifikasiSurat->hasPages())
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-semibold">{{ $klasifikasiSurat->firstItem() ?? 0 }}</span>
                    sampai <span class="font-semibold">{{ $klasifikasiSurat->lastItem() ?? 0 }}</span>
                    dari <span class="font-semibold">{{ $klasifikasiSurat->total() }}</span> hasil
                </div>
                <div class="flex items-center gap-2">
                    {{ $klasifikasiSurat->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Modal Hapus --}}
    @includeIf('admin.partials.modal-hapus')

</div>
@endsection
@extends('layouts.admin')

@section('title', 'Kategori Lembaga')

@section('content')
    <div x-data="{
        selectedIds: [],
        selectAll: false,
        toggleAll() {
            if (this.selectAll) {
                this.selectedIds = Array.from(document.querySelectorAll('.kategori-row-checkbox')).map(el => el.value);
            } else {
                this.selectedIds = [];
            }
        },
        toggleOne() {
            const all = Array.from(document.querySelectorAll('.kategori-row-checkbox')).map(el => el.value);
            this.selectAll = all.every(id => this.selectedIds.includes(id));
        }
    }">

        {{-- ── Page Header with Breadcrumb ── --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-slate-100">Kategori Lembaga</h2>
            <nav class="flex items-center gap-1.5 text-sm">
                <a href="/admin/dashboard"
                    class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Beranda
                </a>
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('admin.lembaga-desa.index') }}"
                    class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                    Daftar Lembaga
                </a>
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-600 dark:text-slate-300 font-medium">Kategori Lembaga</span>
            </nav>
        </div>

        {{-- ── Main Card ── --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">

            {{-- ── Toolbar: Buttons (top bar, inside card) ── --}}
            <div
                class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50 flex flex-wrap items-center gap-2">

                {{-- Tambah --}}
                <a href="{{ route('admin.lembaga-kategori.create') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </a>

                {{-- Hapus (bulk) --}}
                <form method="POST" action="{{ route('admin.lembaga-kategori.bulk-destroy') }}" id="form-bulk-hapus">
                    @csrf
                    @method('DELETE')
                    <template x-for="id in selectedIds" :key="id">
                        <input type="hidden" name="ids[]" :value="id">
                    </template>
                    <button type="button" :disabled="selectedIds.length === 0"
                        @click="selectedIds.length > 0 && $dispatch('buka-modal-hapus', {
                            action: '{{ route('admin.lembaga-kategori.bulk-destroy') }}',
                            nama: selectedIds.length + ' kategori yang dipilih',
                            formId: 'form-bulk-hapus'
                        })"
                        :class="selectedIds.length > 0 ?
                            'bg-rose-600 hover:bg-rose-700 cursor-pointer' :
                            'bg-rose-300 dark:bg-rose-900/50 cursor-not-allowed opacity-60'"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                        <span x-show="selectedIds.length > 0">(<span x-text="selectedIds.length"></span>)</span>
                    </button>
                </form>

                {{-- Kembali ke Daftar Lembaga --}}
                <a href="{{ route('admin.lembaga-desa.index') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Lembaga
                </a>
            </div>

            {{-- ── Table Controls: per_page + search (inside card) ── --}}
            <div
                class="px-4 py-2.5 flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800">

                {{-- Tampilkan N entri --}}
                <form method="GET" class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    <input type="hidden" name="dir" value="{{ request('dir') }}">
                    <label>Tampilkan</label>
                    <select name="per_page" onchange="this.form.submit()"
                        class="border border-gray-300 dark:border-slate-600 rounded px-2 py-1 text-sm bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 focus:ring-1 focus:ring-emerald-500 outline-none">
                        @foreach ([10, 25, 50, 100] as $n)
                            <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>
                                {{ $n }}
                            </option>
                        @endforeach
                    </select>
                    <label>entri</label>
                </form>

                {{-- Search --}}
                <form method="GET" class="flex items-center gap-2">
                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    <input type="hidden" name="dir" value="{{ request('dir') }}">
                    <div class="flex items-center gap-2" x-data="{ showTip: false }">
                        <label class="text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">Cari:</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="kata kunci pencarian" maxlength="50"
                                @focus="showTip = true" @blur="showTip = false"
                                class="border border-gray-300 dark:border-slate-600 rounded-md pl-3 pr-8 py-1.5 text-sm bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors w-52">
                            <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <div x-show="showTip" x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-1"
                                class="absolute right-0 top-full mt-1.5 z-50 w-64 bg-gray-800 dark:bg-slate-900 text-white text-xs rounded-md px-3 py-2 shadow-lg pointer-events-none leading-relaxed"
                                style="display:none">
                                <div
                                    class="absolute -top-1.5 right-4 w-3 h-3 bg-gray-800 dark:bg-slate-900 rotate-45 rounded-sm">
                                </div>
                                Masukkan kata kunci untuk mencari (maksimal 50 karakter)
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ── Table ── --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-slate-900/70 border-b border-gray-200 dark:border-slate-700">
                            <th class="px-4 py-3 w-10">
                                <input type="checkbox" x-model="selectAll" @change="toggleAll()"
                                    class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap w-14">
                                NO
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
                                AKSI
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'dir' => request('sort') === 'nama' && request('dir') === 'asc' ? 'desc' : 'asc']) }}"
                                    class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                    KATEGORI LEMBAGA
                                    <span class="flex flex-col gap-px opacity-50 group-hover:opacity-100">
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'nama' && request('dir') === 'asc' ? 'text-emerald-500' : '' }}"
                                            viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 0L10 6H0L5 0z" />
                                        </svg>
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'nama' && request('dir') === 'desc' ? 'text-emerald-500' : '' }}"
                                            viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 6L0 0H10L5 6z" />
                                        </svg>
                                    </span>
                                </a>
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'deskripsi', 'dir' => request('sort') === 'deskripsi' && request('dir') === 'asc' ? 'desc' : 'asc']) }}"
                                    class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                    DESKRIPSI LEMBAGA
                                    <span class="flex flex-col gap-px opacity-50 group-hover:opacity-100">
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'deskripsi' && request('dir') === 'asc' ? 'text-emerald-500' : '' }}"
                                            viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 0L10 6H0L5 0z" />
                                        </svg>
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'deskripsi' && request('dir') === 'desc' ? 'text-emerald-500' : '' }}"
                                            viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 6L0 0H10L5 6z" />
                                        </svg>
                                    </span>
                                </a>
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'lembaga_count', 'dir' => request('sort') === 'lembaga_count' && request('dir') === 'asc' ? 'desc' : 'asc']) }}"
                                    class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                    JUMLAH LEMBAGA
                                    <span class="flex flex-col gap-px opacity-50 group-hover:opacity-100">
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'lembaga_count' && request('dir') === 'asc' ? 'text-emerald-500' : '' }}"
                                            viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 0L10 6H0L5 0z" />
                                        </svg>
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'lembaga_count' && request('dir') === 'desc' ? 'text-emerald-500' : '' }}"
                                            viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 6L0 0H10L5 6z" />
                                        </svg>
                                    </span>
                                </a>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($kategoris as $index => $kategori)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/40 transition-colors group"
                                :class="selectedIds.includes('{{ $kategori->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' : ''">
                                <td class="px-4 py-3">
                                    <input type="checkbox"
                                        class="kategori-row-checkbox w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        value="{{ $kategori->id }}" x-model="selectedIds" @change="toggleOne()">
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 text-center">
                                    {{ $kategoris->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('admin.lembaga-kategori.edit', $kategori->id) }}"
                                            title="Ubah Data"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded bg-orange-500 hover:bg-orange-600 text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button type="button" title="Hapus"
                                            @click="$dispatch('buka-modal-hapus', {
                                                action: '{{ route('admin.lembaga-kategori.destroy', $kategori->id) }}',
                                                nama: '{{ addslashes($kategori->nama) }}'
                                            })"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded bg-rose-500 hover:bg-rose-600 text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-800 dark:text-slate-200">
                                    {{ $kategori->nama }}
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400">
                                    {{ Str::limit($kategori->deskripsi, 60, '...') ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center min-w-[2rem] px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                                        {{ $kategori->lembaga_desa_count }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3 text-gray-400 dark:text-slate-600">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-sm font-medium">Belum ada kategori lembaga.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ── Footer: Info + Pagination ── --}}
            <div
                class="px-4 py-3 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/40 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-sm text-gray-600 dark:text-slate-400">
                    Menampilkan
                    <span
                        class="font-semibold text-gray-800 dark:text-slate-200">{{ $kategoris->firstItem() ?? 0 }}</span>
                    sampai
                    <span
                        class="font-semibold text-gray-800 dark:text-slate-200">{{ $kategoris->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-semibold text-gray-800 dark:text-slate-200">{{ $kategoris->total() }}</span>
                    entri
                </p>

                <div class="flex items-center gap-1 text-sm">
                    @if ($kategoris->onFirstPage())
                        <span
                            class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-400 dark:text-slate-600 bg-white dark:bg-slate-800 cursor-not-allowed select-none">
                            Sebelumnya
                        </span>
                    @else
                        <a href="{{ $kategoris->previousPageUrl() }}"
                            class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">
                            Sebelumnya
                        </a>
                    @endif

                    @foreach ($kategoris->getUrlRange(max(1, $kategoris->currentPage() - 2), min($kategoris->lastPage(), $kategoris->currentPage() + 2)) as $page => $url)
                        @if ($page == $kategoris->currentPage())
                            <span
                                class="px-3 py-1.5 rounded border border-emerald-500 bg-emerald-500 text-white font-semibold select-none">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if ($kategoris->hasMorePages())
                        <a href="{{ $kategoris->nextPageUrl() }}"
                            class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">
                            Selanjutnya
                        </a>
                    @else
                        <span
                            class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-400 dark:text-slate-600 bg-white dark:bg-slate-800 cursor-not-allowed select-none">
                            Selanjutnya
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Hapus (single & bulk) --}}
    @include('admin.partials.modal-hapus')

@endsection
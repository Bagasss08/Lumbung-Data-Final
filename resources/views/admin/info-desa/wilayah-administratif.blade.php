@extends('layouts.admin')

@section('title', 'Wilayah Administratif')

@section('content')

<div x-data>

    {{-- ============================================================ --}}
    {{-- HEADER: Title kiri + Breadcrumb                             --}}
    {{-- ============================================================ --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Wilayah Administratif</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Data dusun, RW, dan RT dalam wilayah desa</p>
        </div>
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
            <span class="text-gray-600 dark:text-slate-300 font-medium">Wilayah Administratif</span>
        </nav>
    </div>

    {{-- ============================================================ --}}
    {{-- CARD UTAMA                                                   --}}
    {{-- ============================================================ --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700" style="overflow: visible">

        {{-- ── TOOLBAR ── --}}
        <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

            {{-- Tambah --}}
            <a href="{{ route('admin.info-desa.wilayah-administratif.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah
            </a>

            {{-- Cetak/Unduh (belum tersedia) --}}
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-orange-300 dark:bg-orange-900/40 text-white dark:text-orange-300/60 text-sm font-semibold rounded-lg opacity-60 cursor-not-allowed"
                    title="Fitur belum tersedia">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Laporan
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition
                    class="absolute left-0 top-full mt-1 w-44 z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-lg overflow-hidden"
                    style="display:none">
                    {{-- Cetak — disabled --}}
                    <span class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 dark:text-slate-600 cursor-not-allowed select-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak
                        <span class="ml-auto text-[10px] bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-slate-500 rounded px-1 py-0.5 leading-none">Soon</span>
                    </span>
                    {{-- Unduh — disabled --}}
                    <span class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 dark:text-slate-600 cursor-not-allowed select-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh
                        <span class="ml-auto text-[10px] bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-slate-500 rounded px-1 py-0.5 leading-none">Soon</span>
                    </span>
                </div>
            </div>

        </div>

        {{-- ── TOOLBAR: Tampilkan X entri + Search ── --}}
        <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 border-b border-gray-100 dark:border-slate-700">

            {{-- Tampilkan X entri --}}
            <form method="GET" action="{{ url('/admin/info-desa/wilayah-administratif') }}" id="form-per-page-wilayah"
                class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                @foreach (request()->except('per_page', 'page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <input type="hidden" name="per_page" id="val-per-page-wilayah" value="{{ request('per_page', 10) }}">

                <span>Tampilkan</span>

                <div class="relative w-24" x-data="{
                    open: false,
                    selected: '{{ request('per_page', 10) }}',
                    options: [
                        { value: '10', label: '10' },
                        { value: '25', label: '25' },
                        { value: '50', label: '50' },
                        { value: '100', label: '100' },
                    ],
                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? '10'; },
                    choose(opt) {
                        this.selected = opt.value;
                        document.getElementById('val-per-page-wilayah').value = opt.value;
                        this.open = false;
                        document.getElementById('form-per-page-wilayah').submit();
                    }
                }" @click.away="open = false">
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-1.5 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                        <span x-text="label" class="text-gray-700 dark:text-slate-200"></span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-1"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                        style="display:none">
                        <ul class="py-1">
                            <template x-for="opt in options" :key="opt.value">
                                <li @click="choose(opt)"
                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                    :class="selected === opt.value ?
                                        'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                        'text-gray-700 dark:text-slate-200'"
                                    x-text="opt.label"></li>
                            </template>
                        </ul>
                    </div>
                </div>

                <span>entri</span>
            </form>

            {{-- Search --}}
            <form method="GET" action="{{ url('/admin/info-desa/wilayah-administratif') }}"
                class="flex items-center gap-2">
                @foreach (request()->except('search', 'page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
                <div class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="kata kunci pencarian" maxlength="50"
                        @input.debounce.400ms="$el.form.submit()"
                        class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-52">
                    <div class="absolute bottom-full right-0 mb-2 hidden group-focus-within:block z-50 pointer-events-none">
                        <div class="bg-gray-800 dark:bg-slate-700 text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap shadow-lg">
                            Masukkan kata kunci untuk mencari (maksimal 50 karakter)
                            <div class="absolute top-full right-4 border-4 border-transparent border-t-gray-800 dark:border-t-slate-700"></div>
                        </div>
                    </div>
                </div>
            </form>

        </div>

        {{-- ── TABEL ── --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-10">
                            No
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider"
                            style="min-width:160px">
                            Aksi
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                            Nama Dusun
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                            Kepala Wilayah
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                            RW
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                            RT
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                            KK
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                            Laki-laki
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                            Perempuan
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($data['wilayah'] as $index => $wilayah)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">

                        {{-- NO --}}
                        <td class="px-3 py-3 text-gray-500 dark:text-slate-400 tabular-nums text-sm">
                            {{ $index + 1 }}
                        </td>

                        {{-- AKSI --}}
                        <td class="px-3 py-3">
                            <div class="flex items-center gap-1 flex-nowrap">

                                {{-- Edit (amber) --}}
                                <a href="{{ route('admin.info-desa.wilayah-administratif.edit', $wilayah['id'] ?? 1) }}"
                                    title="Edit Dusun"
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                {{-- Hapus (red) --}}
                                <button type="button"
                                    title="Hapus Dusun"
                                    @click="$dispatch('buka-modal-hapus', {
                                        action: '/admin/info-desa/wilayah-administratif/{{ $wilayah['id'] ?? 1 }}',
                                        nama: '{{ addslashes($wilayah['nama']) }}'
                                    })"
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>

                            </div>
                        </td>

                        {{-- NAMA DUSUN --}}
                        <td class="px-3 py-3">
                            <span class="font-semibold text-gray-900 dark:text-slate-100 text-sm">{{ $wilayah['nama'] }}</span>
                        </td>

                        {{-- KEPALA WILAYAH --}}
                        <td class="px-3 py-3 text-sm text-gray-600 dark:text-slate-300 whitespace-nowrap">
                            {{ $wilayah['kepala_wilayah'] }}
                        </td>

                        {{-- RW --}}
                        <td class="px-3 py-3 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full text-sm font-semibold text-blue-700 dark:text-blue-300">
                                {{ str_pad($wilayah['rw'], 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>

                        {{-- RT --}}
                        <td class="px-3 py-3 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-emerald-100 dark:bg-emerald-900/30 rounded-full text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                                {{ str_pad($wilayah['rt'], 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>

                        {{-- KK --}}
                        <td class="px-3 py-3 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 dark:bg-slate-700 rounded-full text-sm font-semibold text-gray-700 dark:text-slate-300">
                                {{ number_format($wilayah['kk']) }}
                            </span>
                        </td>

                        {{-- LAKI-LAKI --}}
                        <td class="px-3 py-3 text-sm text-center font-semibold text-blue-600 dark:text-blue-400">
                            {{ number_format($wilayah['laki_laki']) }}
                        </td>

                        {{-- PEREMPUAN --}}
                        <td class="px-3 py-3 text-sm text-center font-semibold text-pink-600 dark:text-pink-400">
                            {{ number_format($wilayah['perempuan']) }}
                        </td>

                        {{-- TOTAL --}}
                        <td class="px-3 py-3 text-center">
                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300">
                                {{ number_format($wilayah['laki_laki'] + $wilayah['perempuan']) }}
                            </span>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-14 h-14 text-gray-300 dark:text-slate-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <p class="text-gray-500 dark:text-slate-400 font-medium">Tidak ada data yang tersedia pada tabel ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── PAGINATION ── --}}
        @php
            $totalWilayah  = count($data['wilayah'] ?? []);
            $perPage       = (int) request('per_page', 10);
            $currentPage   = (int) request('page', 1);
            $lastPage      = $totalWilayah > 0 ? (int) ceil($totalWilayah / $perPage) : 1;
            $firstItem     = $totalWilayah > 0 ? ($currentPage - 1) * $perPage + 1 : 0;
            $lastItem      = min($currentPage * $perPage, $totalWilayah);
            $baseQuery     = array_merge(request()->except('page'), []);
        @endphp
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
            <p class="text-sm text-gray-500 dark:text-slate-400">
                Menampilkan {{ $firstItem }} sampai {{ $lastItem }} dari {{ number_format($totalWilayah) }} entri
            </p>
            <div class="flex items-center gap-1">
                {{-- Sebelumnya --}}
                @if ($currentPage <= 1)
                    <span class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ url('/admin/info-desa/wilayah-administratif') }}?{{ http_build_query(array_merge($baseQuery, ['page' => $currentPage - 1])) }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Sebelumnya</a>
                @endif

                {{-- Nomor halaman --}}
                @for ($p = max(1, $currentPage - 2); $p <= min($lastPage, $currentPage + 2); $p++)
                    @if ($p == $currentPage)
                        <span class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $p }}</span>
                    @else
                        <a href="{{ url('/admin/info-desa/wilayah-administratif') }}?{{ http_build_query(array_merge($baseQuery, ['page' => $p])) }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $p }}</a>
                    @endif
                @endfor

                {{-- Selanjutnya --}}
                @if ($currentPage >= $lastPage)
                    <span class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Selanjutnya</span>
                @else
                    <a href="{{ url('/admin/info-desa/wilayah-administratif') }}?{{ http_build_query(array_merge($baseQuery, ['page' => $currentPage + 1])) }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Selanjutnya</a>
                @endif
            </div>
        </div>

    </div>

    {{-- Modal Hapus --}}
    @include('admin.partials.modal-hapus')

</div>{{-- end x-data --}}
@endsection
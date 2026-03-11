@extends('layouts.admin')

@section('title',
    'Arsip Desa | ' .
    match ($kategori) {
        'surat_masuk'   => 'Surat Masuk',
        'surat_keluar'  => 'Surat Keluar',
        'kependudukan'  => 'Kependudukan',
        'layanan_surat' => 'Layanan Surat',
        default         => 'Dokumen Desa',
    }
)

@section('content')

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">
                Arsip Desa
                <span class="text-gray-400 font-normal">|</span>
                <span class="text-emerald-600">
                    {{ match ($kategori) {
                        'surat_masuk'   => 'Surat Masuk',
                        'surat_keluar'  => 'Surat Keluar',
                        'kependudukan'  => 'Kependudukan',
                        'layanan_surat' => 'Layanan Surat',
                        default         => 'Dokumen Desa',
                    } }}
                </span>
            </h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">
                {{ match ($kategori) {
                    'dokumen_desa'  => 'Dokumen resmi desa (SK Kades, Perdes, dan lainnya)',
                    'surat_masuk'   => 'Arsip surat yang diterima oleh kantor desa',
                    'surat_keluar'  => 'Arsip surat yang dikirim dari kantor desa',
                    'kependudukan'  => 'Arsip dokumen kependudukan desa',
                    'layanan_surat' => 'Arsip surat layanan yang telah diterbitkan',
                    default         => 'Kelola arsip dokumen desa',
                } }}
            </p>
        </div>
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-1 text-gray-400 hover:text-emerald-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Arsip Desa</span>
        </nav>
    </div>

    {{-- ALERT --}}
    @if (session('success'))
        <div class="flex items-center gap-3 p-4 mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-400 rounded-xl text-sm font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- CARDS KATEGORI --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">

        @php $isActive = $kategori === 'dokumen_desa'; @endphp
        <a href="{{ route('admin.buku-administrasi.arsip.index', ['kategori' => 'dokumen_desa']) }}"
            class="stat-card group rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 {{ $isActive ? 'bg-orange-600' : 'bg-orange-500 hover:bg-orange-600' }}">
            <div class="flex items-center justify-between px-6 py-5 flex-1">
                <div class="relative z-10">
                    <p class="text-4xl font-bold text-white leading-none">{{ $stats['dokumen_desa'] }}</p>
                    <p class="text-sm font-semibold text-white/90 mt-2">Dokumen Desa</p>
                </div>
                <div class="relative z-10 opacity-30 group-hover:scale-125 transition-transform duration-300">
                    <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM6 20V4h5v7h7v9H6z" />
                    </svg>
                </div>
            </div>
            <div class="bg-black/20 px-6 py-2.5 flex items-center justify-center gap-2 text-white/90 text-sm font-medium">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </a>

        @php $isActive = $kategori === 'surat_masuk'; @endphp
        <a href="{{ route('admin.buku-administrasi.arsip.index', ['kategori' => 'surat_masuk']) }}"
            class="stat-card group rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 {{ $isActive ? 'bg-cyan-600' : 'bg-cyan-500 hover:bg-cyan-600' }}">
            <div class="flex items-center justify-between px-6 py-5 flex-1">
                <div class="relative z-10">
                    <p class="text-4xl font-bold text-white leading-none">{{ $stats['surat_masuk'] }}</p>
                    <p class="text-sm font-semibold text-white/90 mt-2">Surat Masuk</p>
                </div>
                <div class="relative z-10 opacity-30 group-hover:scale-125 transition-transform duration-300">
                    <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z" />
                    </svg>
                </div>
            </div>
            <div class="bg-black/20 px-6 py-2.5 flex items-center justify-center gap-2 text-white/90 text-sm font-medium">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </a>

        @php $isActive = $kategori === 'surat_keluar'; @endphp
        <a href="{{ route('admin.buku-administrasi.arsip.index', ['kategori' => 'surat_keluar']) }}"
            class="stat-card group rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 {{ $isActive ? 'bg-blue-700' : 'bg-blue-500 hover:bg-blue-600' }}">
            <div class="flex items-center justify-between px-6 py-5 flex-1">
                <div class="relative z-10">
                    <p class="text-4xl font-bold text-white leading-none">{{ $stats['surat_keluar'] }}</p>
                    <p class="text-sm font-semibold text-white/90 mt-2">Surat Keluar</p>
                </div>
                <div class="relative z-10 opacity-30 group-hover:scale-125 transition-transform duration-300">
                    <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z" />
                    </svg>
                </div>
            </div>
            <div class="bg-black/20 px-6 py-2.5 flex items-center justify-center gap-2 text-white/90 text-sm font-medium">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </a>

        @php $isActive = $kategori === 'kependudukan'; @endphp
        <a href="{{ route('admin.buku-administrasi.arsip.index', ['kategori' => 'kependudukan']) }}"
            class="stat-card group rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 {{ $isActive ? 'bg-purple-700' : 'bg-purple-500 hover:bg-purple-600' }}">
            <div class="flex items-center justify-between px-6 py-5 flex-1">
                <div class="relative z-10">
                    <p class="text-4xl font-bold text-white leading-none">{{ $stats['kependudukan'] }}</p>
                    <p class="text-sm font-semibold text-white/90 mt-2">Kependudukan</p>
                </div>
                <div class="relative z-10 opacity-30 group-hover:scale-125 transition-transform duration-300">
                    <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
                    </svg>
                </div>
            </div>
            <div class="bg-black/20 px-6 py-2.5 flex items-center justify-center gap-2 text-white/90 text-sm font-medium">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </a>

        @php $isActive = $kategori === 'layanan_surat'; @endphp
        <a href="{{ route('admin.buku-administrasi.arsip.index', ['kategori' => 'layanan_surat']) }}"
            class="stat-card group rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 {{ $isActive ? 'bg-emerald-700' : 'bg-emerald-500 hover:bg-emerald-600' }}">
            <div class="flex items-center justify-between px-6 py-5 flex-1">
                <div class="relative z-10">
                    <p class="text-4xl font-bold text-white leading-none">{{ $stats['layanan_surat'] }}</p>
                    <p class="text-sm font-semibold text-white/90 mt-2">Layanan Surat</p>
                </div>
                <div class="relative z-10 opacity-30 group-hover:scale-125 transition-transform duration-300">
                    <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM9 13h6v1.5H9V13zm0 3h6v1.5H9V16zm1-6h1.5v1.5H10V10z" />
                    </svg>
                </div>
            </div>
            <div class="bg-black/20 px-6 py-2.5 flex items-center justify-center gap-2 text-white/90 text-sm font-medium">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </a>

    </div>

    {{-- FILTER --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 mb-6">
        <form method="GET" action="{{ route('admin.buku-administrasi.arsip.index') }}"
            class="flex flex-wrap gap-4 items-end">
            <input type="hidden" name="kategori" value="{{ $kategori }}">

            @if ($kategori === 'dokumen_desa')
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Pilih Jenis Dokumen</label>
                    <select name="jenis_dokumen" onchange="this.form.submit()"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer">
                        <option value="">Semua Jenis Dokumen</option>
                        @foreach (\App\Models\PpidJenisDokumen::where('status','aktif')->orderBy('nama')->get() as $jenis)
                            <option value="{{ $jenis->nama }}" {{ request('jenis_dokumen') == $jenis->nama ? 'selected' : '' }}>
                                {{ $jenis->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="flex-1 min-w-[160px]">
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Pilih Tahun</label>
                <select name="tahun" onchange="this.form.submit()"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer">
                    <option value="">Semua Tahun</option>
                    @foreach ($tahunList as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Cari</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama / nomor dokumen..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z" />
                    </svg>
                </div>
            </div>

            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition-colors">Cari</button>

            @if (request()->hasAny(['tahun','jenis_dokumen','search']))
                <a href="{{ route('admin.buku-administrasi.arsip.index', ['kategori' => $kategori]) }}"
                    class="px-5 py-2.5 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 text-gray-700 dark:text-slate-300 rounded-lg text-sm font-medium transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- TABEL --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-12">NO</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-36">AKSI</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">NOMOR DOKUMEN</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">TANGGAL DOKUMEN</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">NAMA DOKUMEN</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">JENIS DOKUMEN</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">LOKASI ARSIP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">

                    @forelse($arsip as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">

                            {{-- NO --}}
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">
                                {{ $arsip->firstItem() + $loop->index }}
                            </td>

                            {{-- ===== AKSI (4 tombol sesuai OpenSID) ===== --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1">

                                    {{-- 1. TAMPILKAN → ke modul asal --}}
                                    <a href="{{ route('admin.buku-administrasi.arsip.show', [$item->id, 'kategori' => $kategori]) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded bg-indigo-600 hover:bg-indigo-700 text-white transition-colors"
                                        title="Tampilkan di modul asal">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 10h16M4 14h10" />
                                        </svg>
                                    </a>

                                    {{-- 2. UBAH → modal lokasi arsip --}}
                                    @php
                                        $lokasiSaatIni = $kategori === 'dokumen_desa'
                                            ? ($item->lokasi_arsip ?? '')
                                            : ($item->lokasi_arsip ?? '');
                                    @endphp
                                    <button
                                        onclick="openLokasiModal({{ $item->id }}, '{{ addslashes($lokasiSaatIni) }}', '{{ $kategori }}')"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded bg-amber-500 hover:bg-amber-600 text-white transition-colors"
                                        title="Ubah Lokasi Arsip">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    {{-- 3. LIHAT → preview file di tab baru (hanya jika ada file) --}}
                                    @php
                                        $hasFile = match($kategori) {
                                            'layanan_surat' => false,
                                            default         => !empty($item->file_path),
                                        };
                                    @endphp
                                    @if ($hasFile)
                                        <a href="{{ route('admin.buku-administrasi.arsip.lihat', [$item->id, 'kategori' => $kategori]) }}"
                                            target="_blank"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded bg-teal-500 hover:bg-teal-600 text-white transition-colors"
                                            title="Lihat File">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        {{-- 4. UNDUH → download file --}}
                                        <a href="{{ route('admin.buku-administrasi.arsip.unduh', [$item->id, 'kategori' => $kategori]) }}"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded bg-emerald-600 hover:bg-emerald-700 text-white transition-colors"
                                            title="Unduh File">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </a>
                                    @endif

                                </div>
                            </td>

                            {{-- ===== KOLOM DATA ===== --}}

                            @if ($kategori === 'dokumen_desa')
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">-</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-400">
                                    {{ $item->tanggal_terbit?->format('d/m/Y') ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-slate-200 max-w-xs">
                                    <span class="line-clamp-2" title="{{ $item->judul_dokumen }}">{{ $item->judul_dokumen }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400">
                                        {{ $item->jenisDokumen->nama ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-400">
                                    {{ $item->lokasi_arsip ?? '-' }}
                                </td>

                            @elseif ($isLayananSurat)
                                <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-slate-200">{{ $item->nomor_surat ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-400">
                                    {{ $item->tanggal_surat ? \Carbon\Carbon::parse($item->tanggal_surat)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-slate-200 max-w-xs">
                                    <span class="line-clamp-2">{{ $item->nama_pemohon ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                        {{ $item->jenis_surat ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-400">-</td>

                            @else
                                <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-slate-200">{{ $item->nomor_dokumen ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-400">
                                    {{ $item->tanggal_dokumen ? $item->tanggal_dokumen->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-slate-200 max-w-xs">
                                    <span class="line-clamp-2" title="{{ $item->nama_dokumen ?? '' }}">{{ $item->nama_dokumen ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeClass = match ($item->jenis_dokumen ?? '') {
                                            'surat_masuk'     => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400',
                                            'surat_keluar'    => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                            'keputusan_kades' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                            'peraturan_desa'  => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                            'kependudukan'    => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                            default           => 'bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-slate-400',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $badgeClass }}">
                                        {{ $item->jenis_label ?? ($item->jenis_dokumen ?? '-') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-400">
                                    {{ $item->lokasi_arsip ?? '-' }}
                                </td>
                            @endif

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-500 dark:text-slate-400 font-medium">Tidak ada data tersedia</p>
                                    <p class="text-gray-400 dark:text-slate-500 text-sm mt-1">
                                        @if ($kategori === 'dokumen_desa')
                                            Tambahkan dokumen melalui menu PPID → Daftar Dokumen
                                        @elseif ($isLayananSurat)
                                            Belum ada layanan surat yang diarsipkan
                                        @else
                                            Belum ada data pada kategori ini
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        @if (method_exists($arsip, 'hasPages') && $arsip->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
                <p class="text-sm text-gray-500 dark:text-slate-400">
                    Menampilkan {{ $arsip->firstItem() }}–{{ $arsip->lastItem() }} dari {{ $arsip->total() }} data
                </p>
                {{ $arsip->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL UBAH LOKASI ARSIP --}}
    <div id="lokasiModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeLokasiModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl max-w-md w-full">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-slate-200">Ubah</h3>
                </div>
                <form id="lokasiForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="kategori" id="lokasiKategori">
                    <input type="hidden" name="tahun"    value="{{ request('tahun') }}">
                    <input type="hidden" name="page"     value="{{ request('page') }}">
                    <div class="p-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                            Masukkan Lokasi Arsip
                        </label>
                        <input type="text" name="lokasi_arsip" id="lokasiInput"
                            placeholder="Contoh: Lemari 2, Box A"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors
                                   bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200">
                    </div>
                    <div class="px-6 py-4 flex justify-between items-center">
                        <button type="button" onclick="closeLokasiModal()"
                            class="flex items-center gap-1.5 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openLokasiModal(id, lokasi, kategori) {
            document.getElementById('lokasiModal').classList.remove('hidden');
            document.getElementById('lokasiForm').action = `/admin/buku-administrasi/arsip/${id}/lokasi`;
            document.getElementById('lokasiInput').value   = lokasi;
            document.getElementById('lokasiKategori').value = kategori;
            setTimeout(() => document.getElementById('lokasiInput').focus(), 100);
        }
        function closeLokasiModal() {
            document.getElementById('lokasiModal').classList.add('hidden');
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLokasiModal(); });

        document.querySelectorAll('.stat-card').forEach((card, i) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(16px)';
            card.style.transition = `opacity 0.35s ease ${i * 55}ms, transform 0.35s ease ${i * 55}ms`;
            requestAnimationFrame(() => setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 80 + i * 55));
        });
    </script>

@endsection
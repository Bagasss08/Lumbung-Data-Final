@extends('layouts.admin')

@section('title', 'Detail Suplemen: ' . $suplemen->nama)

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('admin.suplemen.index') }}" class="hover:text-emerald-600 transition-colors">Data Suplemen</a>
    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-gray-700 font-medium truncate max-w-xs">{{ $suplemen->nama }}</span>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- ── Kolom Kiri: Info Suplemen ─────────────────────────────── --}}
    <div class="xl:col-span-1 space-y-4">

        {{-- Profile Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="h-20 bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-700"></div>
            <div class="px-6 pb-6 -mt-10">
                {{-- Logo / Avatar --}}
                @if($suplemen->logo)
                <img src="{{ Storage::url($suplemen->logo) }}"
                    class="w-20 h-20 rounded-2xl object-cover border-4 border-white shadow-lg mb-4">
                @else
                <div
                    class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center border-4 border-white shadow-lg mb-4">
                    <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                @endif

                <h3 class="text-lg font-bold text-gray-900">{{ $suplemen->nama }}</h3>

                <div class="flex items-center gap-2 mt-2 flex-wrap">
                    {{-- Badge Sasaran --}}
                    @if($suplemen->sasaran == '1')
                    <span
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                        </svg>
                        Perorangan
                    </span>
                    @else
                    <span
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        Keluarga
                    </span>
                    @endif

                    {{-- Badge Status --}}
                    @if($suplemen->aktif)
                    <span
                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        Aktif
                    </span>
                    @else
                    <span
                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                        Nonaktif
                    </span>
                    @endif
                </div>

                @if($suplemen->keterangan)
                <p class="text-sm text-gray-500 mt-3 leading-relaxed">{{ $suplemen->keterangan }}</p>
                @endif

                {{-- Action Buttons --}}
                <div class="flex gap-2 mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.suplemen.edit', $suplemen) }}"
                        class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-semibold rounded-xl transition-colors border border-amber-100">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.suplemen.destroy', $suplemen) }}" method="POST" x-data
                        @submit.prevent="if(confirm('Yakin hapus suplemen ini beserta semua data terdata?')) $el.submit()">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="flex items-center justify-center gap-1.5 px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold rounded-xl transition-colors border border-red-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Info Detail --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50">
                <h3 class="text-sm font-semibold text-gray-700">Informasi</h3>
            </div>
            <div class="p-6 space-y-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Total Terdata</span>
                    <span class="font-bold text-emerald-600 text-lg">{{ $terdata->total() }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Tanggal Mulai</span>
                    <span class="font-medium text-gray-700">
                        {{ $suplemen->tgl_mulai?->format('d M Y') ?? '—' }}
                    </span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Tanggal Selesai</span>
                    <span class="font-medium text-gray-700">
                        {{ $suplemen->tgl_selesai?->format('d M Y') ?? '—' }}
                    </span>
                </div>
                <div class="h-px bg-gray-100"></div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Dibuat</span>
                    <span class="text-gray-600">{{ $suplemen->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Diperbarui</span>
                    <span class="text-gray-600">{{ $suplemen->updated_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Kolom Kanan: Daftar Terdata ───────────────────────────── --}}
    <div class="xl:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-gray-700">Daftar Anggota Terdata</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $terdata->total() }} anggota terdaftar</p>
                </div>
                <a href="{{ route('admin.suplemen.terdata.create', $suplemen) }}"
                    class="inline-flex items-center gap-2 px-3 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-xs font-semibold rounded-xl shadow-sm hover:shadow-md transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Tambah Terdata
                </a>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-100">
                            <th
                                class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">
                                #</th>
                            @if($suplemen->sasaran == '1')
                            <th
                                class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                NIK</th>
                            <th
                                class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Nama Penduduk</th>
                            @else
                            <th
                                class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                No. KK</th>
                            <th
                                class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Kepala Keluarga</th>
                            @endif
                            <th
                                class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Keterangan</th>
                            <th
                                class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Ditambahkan</th>
                            <th
                                class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($terdata as $t)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-400">
                                {{ $loop->iteration + ($terdata->currentPage()-1) * $terdata->perPage() }}
                            </td>

                            @if($suplemen->sasaran == '1')
                            <td class="px-6 py-4">
                                <code class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-lg">
                                        {{ $t->id_pend ?? '—' }}
                                    </code>
                            </td>
                            <td class="px-6 py-4">
                                @if($t->penduduk)
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                        {{ strtoupper(substr($t->penduduk->nama, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $t->penduduk->nama }}</p>
                                        @if($t->penduduk->alamat)
                                        <p class="text-xs text-gray-400 truncate max-w-[180px]">{{ $t->penduduk->alamat
                                            }}</p>
                                        @endif
                                    </div>
                                </div>
                                @else
                                <span class="text-sm text-gray-400 italic">Penduduk tidak ditemukan</span>
                                @endif
                            </td>
                            @else
                            <td class="px-6 py-4">
                                <code class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-lg">
                                        {{ $t->no_kk ?? '—' }}
                                    </code>
                            </td>
                            <td class="px-6 py-4">
                                @if($t->keluarga)
                                <p class="text-sm font-medium text-gray-900">{{ $t->keluarga->nama_kepala ?? '—' }}</p>
                                @else
                                <span class="text-sm text-gray-400 italic">—</span>
                                @endif
                            </td>
                            @endif

                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500">{{ $t->keterangan ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-gray-400">{{ $t->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.suplemen.terdata.destroy', [$suplemen, $t]) }}"
                                    method="POST" x-data
                                    @submit.prevent="if(confirm('Hapus anggota ini dari daftar terdata?')) $el.submit()">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors border border-red-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Belum ada anggota terdata</p>
                                        <p class="text-xs text-gray-400 mt-1">Klik "Tambah Terdata" untuk menambahkan
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($terdata->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-500">
                        Menampilkan {{ $terdata->firstItem() }}–{{ $terdata->lastItem() }} dari {{ $terdata->total() }}
                        data
                    </p>
                    {{ $terdata->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>

</div>

@endsection
@extends('layouts.admin')

@section('title', 'Calon Pemilih')

@section('content')

{{-- Page Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <p class="text-sm text-gray-500">Data calon pemilih / Daftar Pemilih Tetap (DPT)</p>
    </div>
    <a href="{{ route('admin.calon-pemilih.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
        </svg>
        Tambah Calon Pemilih
    </a>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Total Pemilih Aktif</p>
                <p class="text-xl font-bold text-gray-900">{{ number_format($totalLaki + $totalPerempuan) }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Laki-laki</p>
                <p class="text-xl font-bold text-gray-900">{{ number_format($totalLaki) }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Perempuan</p>
                <p class="text-xl font-bold text-gray-900">{{ number_format($totalPerempuan) }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Persentase</p>
                @php $total = $totalLaki + $totalPerempuan; @endphp
                <p class="text-xl font-bold text-gray-900">
                    {{ $total > 0 ? round($totalPerempuan / $total * 100) : 0 }}%
                    <span class="text-xs font-normal text-gray-400">P</span>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Gender Bar --}}
@if(($totalLaki + $totalPerempuan) > 0)
@php $total = $totalLaki + $totalPerempuan; $pctL = $total > 0 ? ($totalLaki / $total * 100) : 0; @endphp
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
    <div class="flex items-center justify-between mb-2">
        <span class="text-xs font-medium text-blue-600">Laki-laki {{ round($pctL) }}%</span>
        <span class="text-xs font-medium text-pink-500">Perempuan {{ round(100 - $pctL) }}%</span>
    </div>
    <div class="h-2.5 bg-pink-100 rounded-full overflow-hidden">
        <div class="h-full bg-blue-500 rounded-full" style="width: {{ $pctL }}%"></div>
    </div>
</div>
@endif

{{-- Filter --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
    <form method="GET" class="flex flex-col sm:flex-row gap-3 flex-wrap">
        <div class="flex-1 min-w-[200px] relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="NIK / Nama pemilih..."
                class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-gray-50">
        </div>
        <select name="dusun"
            class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-gray-50 min-w-[140px]">
            <option value="">Semua Dusun</option>
            @foreach($dusunList as $d)
            <option value="{{ $d }}" {{ request('dusun')==$d ? 'selected' : '' }}>{{ $d }}</option>
            @endforeach
        </select>
        <select name="jenis_kelamin"
            class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-gray-50 min-w-[130px]">
            <option value="">Semua JK</option>
            <option value="1" {{ request('jenis_kelamin')=='1' ? 'selected' : '' }}>Laki-laki</option>
            <option value="2" {{ request('jenis_kelamin')=='2' ? 'selected' : '' }}>Perempuan</option>
        </select>
        <select name="aktif"
            class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-gray-50 min-w-[130px]">
            <option value="">Semua Status</option>
            <option value="1" {{ request('aktif')=='1' ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ request('aktif')=='0' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        <div class="flex gap-2">
            <button type="submit"
                class="px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-xl transition-colors">Cari</button>
            @if(request()->hasAny(['q','dusun','jenis_kelamin','aktif']))
            <a href="{{ route('admin.calon-pemilih.index') }}"
                class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-xl transition-colors">Reset</a>
            @endif
        </div>
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-100">
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">
                        #</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">NIK
                    </th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama
                    </th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tgl
                        Lahir / Umur</th>
                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">JK
                    </th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Dusun
                        / RT-RW</th>
                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Status</th>
                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($calonPemilih as $cp)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-400">
                        {{ $loop->iteration + ($calonPemilih->currentPage()-1) * $calonPemilih->perPage() }}
                    </td>
                    <td class="px-6 py-4">
                        <code class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-lg">{{ $cp->nik }}</code>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0
                                {{ $cp->jenis_kelamin == 1 ? 'bg-gradient-to-br from-blue-400 to-blue-600' : 'bg-gradient-to-br from-pink-400 to-pink-600' }}">
                                {{ strtoupper(substr($cp->nama, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $cp->nama }}</p>
                                @if($cp->status_perkawinan)
                                <p class="text-xs text-gray-400">{{ $cp->status_perkawinan }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-gray-700">{{ $cp->tanggal_lahir?->format('d/m/Y') ?? '—' }}</p>
                        @if($cp->tanggal_lahir)
                        <p class="text-xs text-gray-400">{{ $cp->umur }} tahun</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($cp->jenis_kelamin == 1)
                        <span
                            class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-blue-100 text-blue-600"
                            title="Laki-laki">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H2z" />
                            </svg>
                        </span>
                        @elseif($cp->jenis_kelamin == 2)
                        <span
                            class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-pink-100 text-pink-500"
                            title="Perempuan">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H2z" />
                            </svg>
                        </span>
                        @else
                        <span class="text-gray-300 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-gray-700">{{ $cp->dusun ?? '—' }}</p>
                        @if($cp->rt || $cp->rw)
                        <p class="text-xs text-gray-400">RT {{ $cp->rt ?? '-' }} / RW {{ $cp->rw ?? '-' }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.calon-pemilih.toggle-aktif', $cp) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium transition-colors border
                                    {{ $cp->aktif
                                        ? 'bg-green-50 text-green-700 border-green-100 hover:bg-green-100'
                                        : 'bg-gray-100 text-gray-500 border-gray-200 hover:bg-gray-200' }}">
                                <span
                                    class="w-1.5 h-1.5 rounded-full {{ $cp->aktif ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                {{ $cp->aktif ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('admin.calon-pemilih.show', $cp) }}" title="Detail"
                                class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.calon-pemilih.edit', $cp) }}" title="Edit"
                                class="p-1.5 rounded-lg text-amber-500 hover:bg-amber-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.calon-pemilih.destroy', $cp) }}" method="POST" x-data
                                @submit.prevent="if(confirm('Hapus {{ addslashes($cp->nama) }} dari daftar calon pemilih?')) $el.submit()">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus"
                                    class="p-1.5 rounded-lg text-red-400 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">Belum ada data calon pemilih</p>
                            <p class="text-xs text-gray-400">Klik tombol "Tambah Calon Pemilih" untuk memulai</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($calonPemilih->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        <div class="flex items-center justify-between">
            <p class="text-xs text-gray-500">
                Menampilkan {{ $calonPemilih->firstItem() }}–{{ $calonPemilih->lastItem() }} dari {{
                $calonPemilih->total() }} data
            </p>
            {{ $calonPemilih->links() }}
        </div>
    </div>
    @endif
</div>

@endsection
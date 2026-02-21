@extends('layouts.admin')
@section('title', 'Vaksin')
@section('content')
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <p class="text-xs text-gray-500 mb-1">Total Terdaftar</p>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <p class="text-xs text-gray-500 mb-1">Sudah Vaksin</p>
        <p class="text-2xl font-bold text-emerald-600">{{ number_format($stats['sudah']) }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <p class="text-xs text-gray-500 mb-1">Belum Vaksin</p>
        <p class="text-2xl font-bold text-red-500">{{ number_format($stats['belum']) }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <p class="text-xs text-gray-500 mb-1">Ditunda</p>
        <p class="text-2xl font-bold text-amber-500">{{ number_format($stats['tunda']) }}</p>
    </div>
</div>

@if($stats['total'] > 0)
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm mb-6">
    @php $persen = round($stats['sudah'] / $stats['total'] * 100); @endphp
    <div class="flex justify-between text-sm font-medium text-gray-700 mb-2">
        <span>Cakupan Vaksinasi</span><span class="font-bold">{{ $persen }}%</span>
    </div>
    <div class="w-full bg-gray-100 rounded-full h-3">
        <div class="h-3 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500" style="width:{{ $persen }}%"></div>
    </div>
</div>
@endif

@if(session('success'))
<div
    class="flex items-center gap-3 p-4 mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <h3 class="text-base font-semibold text-gray-900">Data Penerima Vaksin</h3>
        <a href="{{ route('admin.kesehatan.vaksin.create') }}"
            class="flex items-center gap-2 px-4 py-2 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:shadow-md transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Data
        </a>
    </div>
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIK..."
                class="flex-1 min-w-[180px] px-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
            <select name="status"
                class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                <option value="">Semua Status</option>
                <option value="sudah" {{ request('status')==='sudah' ?'selected':'' }}>Sudah</option>
                <option value="belum" {{ request('status')==='belum' ?'selected':'' }}>Belum</option>
                <option value="tunda" {{ request('status')==='tunda' ?'selected':'' }}>Ditunda</option>
            </select>
            <select name="jenis_vaksin"
                class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                <option value="">Semua Jenis</option>
                @foreach($jenisVaksinList as $j)
                <option value="{{ $j }}" {{ request('jenis_vaksin')===$j?'selected':'' }}>{{ $j }}</option>
                @endforeach
            </select>
            <select name="dusun"
                class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                <option value="">Semua Dusun</option>
                @foreach($dusunList as $d)
                <option value="{{ $d }}" {{ request('dusun')===$d?'selected':'' }}>{{ $d }}</option>
                @endforeach
            </select>
            <button type="submit"
                class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-xl hover:bg-emerald-700 transition-colors">Cari</button>
            <a href="{{ route('admin.kesehatan.vaksin.index') }}"
                class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">Reset</a>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">No</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Nama / NIK</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">L/P</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Dusun</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Jenis Vaksin</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Dosis</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Tgl Vaksin</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($vaksin as $i => $v)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 text-sm text-gray-400">{{ $vaksin->firstItem() + $i }}</td>
                    <td class="px-4 py-3">
                        <p class="text-sm font-semibold text-gray-800">{{ $v->nama_penerima }}</p>
                        <p class="text-xs font-mono text-gray-400">{{ $v->nik ?? '-' }}</p>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $v->jenis_kelamin==='L' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700' }}">{{
                            $v->jenis_kelamin ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $v->dusun ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <p class="text-sm text-gray-700">{{ $v->jenis_vaksin }}</p>
                        @if($v->kategori_vaksin) <p class="text-xs text-gray-400">{{ $v->kategori_vaksin }}</p> @endif
                    </td>
                    <td class="px-4 py-3 text-center"><span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">{{
                            $v->dosi_label }}</span></td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $v->tanggal_vaksin->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-center">
                        @php $sb=['sudah'=>'bg-emerald-50 text-emerald-700','belum'=>'bg-red-50
                        text-red-700','tunda'=>'bg-amber-50 text-amber-700']; @endphp
                        <span
                            class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $sb[$v->status] ?? 'bg-gray-100 text-gray-600' }}">{{
                            $v->status_label }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('admin.kesehatan.vaksin.show', $v) }}"
                                class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.kesehatan.vaksin.edit', $v) }}"
                                class="p-1.5 rounded-lg text-amber-600 hover:bg-amber-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.kesehatan.vaksin.destroy', $v) }}"
                                class="inline" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 transition-colors">
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
                    <td colspan="9" class="px-6 py-16 text-center text-sm text-gray-400">Belum ada data vaksin.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($vaksin->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-4">
        <p class="text-sm text-gray-500">{{ $vaksin->firstItem() }}&ndash;{{ $vaksin->lastItem() }} dari {{
            $vaksin->total() }} data</p>
        {{ $vaksin->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
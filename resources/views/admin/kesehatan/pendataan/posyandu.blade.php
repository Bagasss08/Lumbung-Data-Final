@extends('layouts.admin')
@section('title', 'Pendataan Kesehatan')

@section('content')

{{-- Sub-tab Pendataan --}}
<div class="flex gap-2 mb-6">
    <a href="/admin/kesehatan/pendataan/posyandu"
        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors bg-emerald-100 text-emerald-700">
        Posyandu
    </a>
    <a href="/admin/kesehatan/pendataan/kia"
        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors text-gray-600 hover:bg-gray-100">
        Kesehatan Ibu &amp; Anak (KIA)
    </a>
</div>

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

    {{-- Header --}}
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <div>
            <h3 class="text-base font-semibold text-gray-900">Daftar Posyandu</h3>
            <p class="text-sm text-gray-500 mt-0.5">Total: {{ $posyandu->total() }} posyandu</p>
        </div>
        <a href="{{ route('admin.kesehatan.pendataan.posyandu.create') }}"
            class="flex items-center gap-2 px-4 py-2 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:shadow-md transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Posyandu
        </a>
    </div>

    {{-- Filter --}}
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama, dusun, penanggung jawab..."
                class="flex-1 min-w-[220px] px-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none bg-white">
            <select name="dusun"
                class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                <option value="">Semua Dusun</option>
                @foreach($dusunList as $d)
                <option value="{{ $d }}" {{ request('dusun')==$d ? 'selected' : '' }}>{{ $d }}</option>
                @endforeach
            </select>
            <select name="status"
                class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status')=='aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="tidak_aktif" {{ request('status')=='tidak_aktif' ? 'selected' : '' }}>Tidak Aktif
                </option>
            </select>
            <button type="submit"
                class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-xl hover:bg-emerald-700 transition-colors">Cari</button>
            <a href="{{ route('admin.kesehatan.pendataan.posyandu') }}"
                class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">Reset</a>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama
                        Posyandu</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Dusun
                    </th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Hari &
                        Jam</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Penanggung Jawab</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kader
                    </th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Status</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($posyandu as $i => $p)
                <tr class="hover:bg-gray-50/70 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-400">{{ $posyandu->firstItem() + $i }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.kesehatan.pendataan.posyandu.show', $p) }}"
                            class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">
                            {{ $p->nama_posyandu }}
                        </a>
                        @if($p->alamat)
                        <p class="text-xs text-gray-400 mt-0.5">{{ $p->alamat }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $p->dusun ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-700">{{ $p->hari_kegiatan ?? '-' }}</span>
                        @if($p->jam_mulai && $p->jam_selesai)
                        <p class="text-xs text-gray-400 mt-0.5">{{ substr($p->jam_mulai,0,5) }} &ndash; {{
                            substr($p->jam_selesai,0,5) }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $p->penanggung_jawab ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            {{ $p->jumlah_kader }} orang
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                            {{ $p->status_posyandu === 'aktif' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $p->status_posyandu === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('admin.kesehatan.pendataan.posyandu.show', $p) }}"
                                class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors"
                                title="Lihat Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.kesehatan.pendataan.posyandu.edit', $p) }}"
                                class="p-1.5 rounded-lg text-amber-600 hover:bg-amber-50 transition-colors"
                                title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.kesehatan.pendataan.posyandu.destroy', $p) }}"
                                class="inline" onsubmit="return confirm('Hapus posyandu ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 transition-colors"
                                    title="Hapus">
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
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-sm text-gray-400 font-medium">Belum ada data posyandu</p>
                        <a href="{{ route('admin.kesehatan.pendataan.posyandu.create') }}"
                            class="mt-1 text-sm text-emerald-600 hover:underline inline-block">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($posyandu->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-4">
        <p class="text-sm text-gray-500">Menampilkan {{ $posyandu->firstItem() }}&ndash;{{ $posyandu->lastItem() }} dari
            {{ $posyandu->total() }} data</p>
        {{ $posyandu->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
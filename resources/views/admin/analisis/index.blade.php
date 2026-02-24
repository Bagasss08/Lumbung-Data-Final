@extends('layouts.admin')

@section('title', 'Analisis')

@section('content')
<div class="space-y-6">

    {{-- ── Header + Tombol Tambah ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Daftar Analisis</h3>
            <p class="text-sm text-gray-500 mt-0.5">Kelola kategori analisis data penduduk desa</p>
        </div>
        <a href="{{ route('admin.analisis.create') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600
                  text-white text-sm font-semibold rounded-xl shadow hover:shadow-md transition-all hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Analisis
        </a>
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl">
        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-sm font-medium">{{ session('error') }}</span>
    </div>
    @endif

    {{-- ── Filter Bar ── --}}
    <form method="GET" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode..."
                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent">
            </div>
            <select name="subjek"
                class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
                <option value="">Semua Subjek</option>
                <option value="PENDUDUK" {{ request('subjek')==='PENDUDUK' ? 'selected' : '' }}>Penduduk</option>
                <option value="KELUARGA" {{ request('subjek')==='KELUARGA' ? 'selected' : '' }}>Keluarga</option>
                <option value="RUMAH_TANGGA" {{ request('subjek')==='RUMAH_TANGGA' ? 'selected' : '' }}>Rumah Tangga
                </option>
                <option value="KELOMPOK" {{ request('subjek')==='KELOMPOK' ? 'selected' : '' }}>Kelompok</option>
            </select>
            <select name="status"
                class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
                <option value="">Semua Status</option>
                <option value="AKTIF" {{ request('status')==='AKTIF' ? 'selected' : '' }}>Aktif</option>
                <option value="TIDAK_AKTIF" {{ request('status')==='TIDAK_AKTIF' ? 'selected' : '' }}>Tidak Aktif
                </option>
            </select>
            <button type="submit"
                class="px-5 py-2.5 bg-emerald-500 text-white text-sm font-medium rounded-xl hover:bg-emerald-600 transition-colors">
                Filter
            </button>
            @if(request()->anyFilled(['search','subjek','status']))
            <a href="{{ route('admin.analisis.index') }}"
                class="px-4 py-2.5 text-sm text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                Reset
            </a>
            @endif
        </div>
    </form>

    {{-- ── Tabel ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($masters->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-20 h-20 bg-emerald-50 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Belum ada data analisis</p>
            <p class="text-gray-400 text-sm mt-1">Klik tombol "Tambah Analisis" untuk memulai</p>
            <a href="{{ route('admin.analisis.create') }}"
                class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white text-sm font-medium rounded-xl hover:bg-emerald-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Sekarang
            </a>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th
                            class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-8">
                            No</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Nama Analisis</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Subjek</th>
                        <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Indikator</th>
                        <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Responden</th>
                        <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($masters as $i => $master)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 text-gray-400 font-medium">{{ $masters->firstItem() + $i }}</td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">
                                {{ $master->nama }}
                            </div>
                            <div class="text-xs text-gray-400 mt-0.5 flex items-center gap-2">
                                <span class="font-mono bg-gray-100 px-1.5 py-0.5 rounded">{{ $master->kode }}</span>
                                @if($master->periode)
                                <span>· {{ $master->periode }}</span>
                                @endif
                                @if($master->lock)
                                <span class="flex items-center gap-1 text-amber-600">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Dikunci
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium
                                {{ match($master->subjek) {
                                    'PENDUDUK'     => 'bg-blue-50 text-blue-700',
                                    'KELUARGA'     => 'bg-purple-50 text-purple-700',
                                    'RUMAH_TANGGA' => 'bg-orange-50 text-orange-700',
                                    'KELOMPOK'     => 'bg-teal-50 text-teal-700',
                                    default        => 'bg-gray-50 text-gray-600'
                                } }}">
                                {{ $master->subjek_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-semibold text-gray-700">{{ $master->indikator_count }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-semibold text-gray-700">{{ number_format($master->responden_count)
                                }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.analisis.toggle-status', $master) }}" method="POST"
                                class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium transition-all
                                               {{ $master->status_badge['class'] }} hover:opacity-80">
                                    {{ $master->status_badge['label'] }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('admin.analisis.show', $master) }}"
                                    class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors"
                                    title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.analisis.edit', $master) }}"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.analisis.responden.index', $master) }}"
                                    class="p-2 text-teal-600 hover:bg-teal-50 rounded-lg transition-colors"
                                    title="Data Responden">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.analisis.destroy', $master) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Hapus analisis \'{{ $master->nama }}\'? Semua data terkait akan ikut terhapus!')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
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
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($masters->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $masters->links() }}
        </div>
        @endif
        @endif
    </div>

</div>
@endsection
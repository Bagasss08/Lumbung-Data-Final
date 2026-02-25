@extends('layouts.admin')

@section('title', 'Program Bantuan')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-transition
    class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl mb-6 shadow-sm">
    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span class="text-sm font-medium">{{ session('success') }}</span>
    <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-600">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
@endif

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h3 class="text-xl font-bold text-gray-900">Daftar Program Bantuan</h3>
        <p class="text-sm text-gray-500 mt-1">Kelola program bantuan sosial untuk warga desa</p>
    </div>
    <a href="{{ route('admin.bantuan.create') }}"
        class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Program
    </a>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Program</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $programs->total() }}</p>
            </div>
            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Program Aktif</p>
                <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $programs->where('status', 1)->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Peserta</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $programs->sum('peserta_count') }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h4 class="font-semibold text-gray-900 text-sm">Semua Program</h4>
        <span class="text-xs text-gray-400">{{ $programs->total() }} data ditemukan</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Nama Program</th>
                    <th class="px-6 py-3 text-left">Sumber Dana</th>
                    <th class="px-6 py-3 text-left">Tahun</th>
                    <th class="px-6 py-3 text-left">Sasaran</th>
                    <th class="px-6 py-3 text-left">Nominal</th>
                    <th class="px-6 py-3 text-center">Peserta</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($programs as $i => $program)
                <tr class="hover:bg-gray-50/70 transition-colors duration-150">
                    <td class="px-6 py-4 text-sm text-gray-400">{{ $programs->firstItem() + $i }}</td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900 text-sm">{{ $program->nama }}</div>
                        @if($program->keterangan)
                        <div class="text-xs text-gray-400 mt-0.5 truncate max-w-[200px]">{{ $program->keterangan }}
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $program->sumber_dana ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $program->tahun ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium
                            {{ $program->sasaran == 1 ? 'bg-violet-50 text-violet-700' : 'bg-orange-50 text-orange-700' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full {{ $program->sasaran == 1 ? 'bg-violet-400' : 'bg-orange-400' }}"></span>
                            {{ $program->sasaran_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-700">
                        {{ $program->nominal ? 'Rp ' . number_format($program->nominal, 0, ',', '.') : '-' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.bantuan.show', $program->id) }}"
                            class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $program->peserta_count }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold
                            {{ $program->status == 1 ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full {{ $program->status == 1 ? 'bg-emerald-400' : 'bg-gray-400' }}"></span>
                            {{ $program->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.bantuan.show', $program->id) }}"
                                class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors"
                                title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.bantuan.edit', $program->id) }}"
                                class="p-1.5 rounded-lg text-amber-600 hover:bg-amber-50 transition-colors"
                                title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.bantuan.destroy', $program->id) }}" method="POST" x-data
                                @submit.prevent="if(confirm('Hapus program \'{{ addslashes($program->nama) }}\'?')) $el.submit()">
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
                    <td colspan="9" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-400">Belum ada program bantuan</p>
                            <a href="{{ route('admin.bantuan.create') }}"
                                class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">+ Tambah Program
                                Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($programs->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $programs->links() }}
    </div>
    @endif
</div>

@endsection
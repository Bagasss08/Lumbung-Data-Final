@extends('layouts.admin')
@section('title', 'Stunting - Pilih Posyandu')

@section('content')

{{-- Sub-tab Stunting --}}
<div class="flex gap-2 mb-6 overflow-x-auto">
    <a href="/admin/kesehatan/stunting/posyandu"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap bg-emerald-100 text-emerald-700 transition-colors">Posyandu</a>
    <a href="/admin/kesehatan/stunting/kia"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">KIA</a>
    <a href="/admin/kesehatan/stunting/pemantauan-bumil"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">Pemantauan
        Bumil</a>
    <a href="/admin/kesehatan/stunting/pemantauan-anak"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">Pemantauan
        Anak</a>
    <a href="/admin/kesehatan/stunting/scorecard"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">Scorecard</a>
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
    <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="text-base font-semibold text-gray-900">Daftar Posyandu</h3>
        <p class="text-sm text-gray-500 mt-0.5">Pilih posyandu untuk melihat data stunting</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">No</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Posyandu</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Dusun</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Total KIA</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Ibu Hamil</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Balita</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($posyandu as $i => $p)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-400">{{ $i + 1 }}</td>
                    <td class="px-6 py-4">
                        <p class="text-sm font-semibold text-gray-800">{{ $p->nama_posyandu }}</p>
                        @if($p->penanggung_jawab) <p class="text-xs text-gray-400 mt-0.5">{{ $p->penanggung_jawab }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $p->dusun ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            {{ $p->kia_count }} data
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm text-gray-700">{{ $p->kia->where('status_kehamilan', 'hamil')->count()
                            }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm text-gray-700">{{ $p->kia->whereNotNull('nama_anak')->count() }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="/admin/kesehatan/stunting/kia?posyandu_id={{ $p->id }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-emerald-50 text-emerald-700 rounded-lg hover:bg-emerald-100 transition-colors">
                            Lihat KIA
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center text-sm text-gray-400">Belum ada data posyandu.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
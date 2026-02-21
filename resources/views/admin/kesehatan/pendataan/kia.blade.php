@extends('layouts.admin')
@section('title', 'Kesehatan Ibu dan Anak')

@section('content')

{{-- Sub-tab Pendataan --}}
<div class="flex gap-2 mb-6">
    <a href="/admin/kesehatan/pendataan/posyandu"
        class="px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors">Posyandu</a>
    <a href="/admin/kesehatan/pendataan/kia"
        class="px-4 py-2 rounded-xl text-sm font-medium bg-emerald-100 text-emerald-700 transition-colors">Kesehatan Ibu
        &amp; Anak (KIA)</a>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
    $stats = [
    ['label'=>'Ibu Hamil', 'value'=> \App\Models\Kia::where('status_kehamilan','hamil')->count(), 'color'=>'blue'],
    ['label'=>'Risiko Tinggi', 'value'=> \App\Models\Kia::where('status_resiko','resiko_tinggi')->count(),
    'color'=>'red'],
    ['label'=>'Sudah Melahirkan', 'value'=> \App\Models\Kia::where('status_kehamilan','melahirkan')->count(),
    'color'=>'emerald'],
    ['label'=>'Total KIA', 'value'=> \App\Models\Kia::count(), 'color'=>'gray'],
    ];
    $colorMap = ['blue'=>'bg-blue-50 text-blue-700','red'=>'bg-red-50 text-red-700','emerald'=>'bg-emerald-50
    text-emerald-700','gray'=>'bg-gray-100 text-gray-700'];
    @endphp
    @foreach($stats as $s)
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <p class="text-xs font-medium text-gray-500 mb-1">{{ $s['label'] }}</p>
        <p class="text-2xl font-bold text-gray-900">{{ $s['value'] }}</p>
    </div>
    @endforeach
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

    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <div>
            <h3 class="text-base font-semibold text-gray-900">Data KIA</h3>
            <p class="text-sm text-gray-500 mt-0.5">Kesehatan Ibu dan Anak</p>
        </div>
        <a href="{{ route('admin.kesehatan.pendataan.kia.create') }}"
            class="flex items-center gap-2 px-4 py-2 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:shadow-md transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah KIA
        </a>
    </div>

    {{-- Filter --}}
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama ibu, NIK, no register..."
                class="flex-1 min-w-[200px] px-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
            <select name="status_kehamilan"
                class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                <option value="">Semua Status</option>
                <option value="hamil" {{ request('status_kehamilan')==='hamil' ? 'selected' : '' }}>Sedang Hamil
                </option>
                <option value="melahirkan" {{ request('status_kehamilan')==='melahirkan' ? 'selected' : '' }}>Sudah
                    Melahirkan</option>
                <option value="selesai" {{ request('status_kehamilan')==='selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            <select name="status_resiko"
                class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                <option value="">Semua Risiko</option>
                <option value="normal" {{ request('status_resiko')==='normal' ? 'selected' : '' }}>Normal</option>
                <option value="resiko_rendah" {{ request('status_resiko')==='resiko_rendah' ? 'selected' : '' }}>Risiko
                    Rendah</option>
                <option value="resiko_tinggi" {{ request('status_resiko')==='resiko_tinggi' ? 'selected' : '' }}>Risiko
                    Tinggi</option>
            </select>
            <select name="posyandu_id"
                class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                <option value="">Semua Posyandu</option>
                @foreach($posyanduList as $p)
                <option value="{{ $p->id }}" {{ request('posyandu_id')==$p->id ? 'selected' : '' }}>{{ $p->nama_posyandu
                    }}</option>
                @endforeach
            </select>
            <button type="submit"
                class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-xl hover:bg-emerald-700 transition-colors">Cari</button>
            <a href="{{ route('admin.kesehatan.pendataan.kia') }}"
                class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">Reset</a>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">No</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">No. Register</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Ibu / Anak</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Dusun</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Posyandu</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">HPL</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Risiko</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($kia as $i => $k)
                <tr
                    class="hover:bg-gray-50 transition-colors {{ $k->status_resiko === 'resiko_tinggi' ? 'bg-red-50/40' : '' }}">
                    <td class="px-4 py-4 text-sm text-gray-400">{{ $kia->firstItem() + $i }}</td>
                    <td class="px-4 py-4"><span class="text-xs font-mono text-gray-500">{{ $k->no_register ?? '-'
                            }}</span></td>
                    <td class="px-4 py-4">
                        <a href="{{ route('admin.kesehatan.pendataan.kia.show', $k) }}"
                            class="text-sm font-semibold text-emerald-600 hover:underline">{{ $k->nama_ibu }}</a>
                        @if($k->nama_anak) <p class="text-xs text-gray-400 mt-0.5">Anak: {{ $k->nama_anak }}</p> @endif
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-600">{{ $k->dusun ?? '-' }}</td>
                    <td class="px-4 py-4 text-sm text-gray-600">{{ $k->posyandu->nama_posyandu ?? '-' }}</td>
                    <td class="px-4 py-4 text-center">
                        @if($k->taksiran_lahir)
                        <span class="text-sm text-gray-700">{{ $k->taksiran_lahir->format('d/m/Y') }}</span>
                        @if($k->status_kehamilan === 'hamil')
                        @php $sisa = now()->diffInDays($k->taksiran_lahir, false); @endphp
                        <p class="text-xs {{ $sisa < 0 ? 'text-red-500' : 'text-amber-500' }} mt-0.5">
                            {{ $sisa >= 0 ? $sisa . ' hari lagi' : abs($sisa) . ' hari lewat' }}
                        </p>
                        @endif
                        @else <span class="text-sm text-gray-400">-</span> @endif
                    </td>
                    <td class="px-4 py-4 text-center">
                        @php $rb=['normal'=>'bg-emerald-50 text-emerald-700','resiko_rendah'=>'bg-amber-50
                        text-amber-700','resiko_tinggi'=>'bg-red-50 text-red-700'];
                        $rl=['normal'=>'Normal','resiko_rendah'=>'Rendah','resiko_tinggi'=>'Tinggi']; @endphp
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $rb[$k->status_resiko] ?? 'bg-gray-100 text-gray-600' }}">{{
                            $rl[$k->status_resiko] ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-4 text-center">
                        @php $bs=['hamil'=>'bg-blue-50 text-blue-700','melahirkan'=>'bg-emerald-50
                        text-emerald-700','selesai'=>'bg-gray-100 text-gray-500']; @endphp
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $bs[$k->status_kehamilan] ?? 'bg-gray-100 text-gray-500' }}">{{
                            ucfirst($k->status_kehamilan) }}</span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('admin.kesehatan.pendataan.kia.show', $k) }}"
                                class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.kesehatan.pendataan.kia.edit', $k) }}"
                                class="p-1.5 rounded-lg text-amber-600 hover:bg-amber-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.kesehatan.pendataan.kia.destroy', $k) }}"
                                class="inline" onsubmit="return confirm('Hapus data KIA ini?')">
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
                    <td colspan="9" class="px-6 py-16 text-center text-sm text-gray-400">Belum ada data KIA.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($kia->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-4">
        <p class="text-sm text-gray-500">{{ $kia->firstItem() }}&ndash;{{ $kia->lastItem() }} dari {{ $kia->total() }}
            data</p>
        {{ $kia->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
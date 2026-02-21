@extends('layouts.admin')
@section('title', 'Stunting - Data KIA')

@section('content')

<div class="flex gap-2 mb-6 overflow-x-auto">
    <a href="/admin/kesehatan/stunting/posyandu"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">Posyandu</a>
    <a href="/admin/kesehatan/stunting/kia"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap bg-emerald-100 text-emerald-700 transition-colors">KIA</a>
    <a href="/admin/kesehatan/stunting/pemantauan-bumil"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">Pemantauan
        Bumil</a>
    <a href="/admin/kesehatan/stunting/pemantauan-anak"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">Pemantauan
        Anak</a>
    <a href="/admin/kesehatan/stunting/scorecard"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">Scorecard</a>
</div>

{{-- Filter Posyandu --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 mb-5">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="posyandu_id"
            class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
            <option value="">Semua Posyandu</option>
            @foreach($posyanduList as $p)
            <option value="{{ $p->id }}" {{ request('posyandu_id')==$p->id ? 'selected' : '' }}>{{ $p->nama_posyandu }}
            </option>
            @endforeach
        </select>
        <select name="status_kehamilan"
            class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
            <option value="">Semua Status</option>
            <option value="hamil" {{ request('status_kehamilan')==='hamil' ?'selected':'' }}>Sedang Hamil</option>
            <option value="melahirkan" {{ request('status_kehamilan')==='melahirkan' ?'selected':'' }}>Sudah Melahirkan
            </option>
        </select>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama ibu / anak..."
            class="flex-1 min-w-[180px] px-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
        <button type="submit"
            class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-xl hover:bg-emerald-700 transition-colors">Filter</button>
        <a href="/admin/kesehatan/stunting/kia"
            class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">Reset</a>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="text-base font-semibold text-gray-900">Data KIA untuk Pemantauan Stunting</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">No</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Ibu / Anak</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Posyandu</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Pemantauan Bumil
                    </th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Pemantauan Anak</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Scorecard</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($kia as $i => $k)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-4 text-sm text-gray-400">{{ $kia->firstItem() + $i }}</td>
                    <td class="px-5 py-4">
                        <p class="text-sm font-semibold text-gray-800">{{ $k->nama_ibu }}</p>
                        @if($k->nama_anak) <p class="text-xs text-gray-400 mt-0.5">Anak: {{ $k->nama_anak }}</p> @endif
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-600">{{ $k->posyandu->nama_posyandu ?? '-' }}</td>
                    <td class="px-5 py-4 text-center">
                        @php $bs=['hamil'=>'bg-blue-50 text-blue-700','melahirkan'=>'bg-emerald-50
                        text-emerald-700','selesai'=>'bg-gray-100 text-gray-500']; @endphp
                        <span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $bs[$k->status_kehamilan] ?? 'bg-gray-100 text-gray-500' }}">{{
                            ucfirst($k->status_kehamilan) }}</span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $k->pemantauanBumil->count() ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-400' }}">
                            {{ $k->pemantauanBumil->count() }} kali
                        </span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $k->pemantauanAnak->count() ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-400' }}">
                            {{ $k->pemantauanAnak->count() }} kali
                        </span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $k->stuntingScorecard->count() ? 'bg-purple-50 text-purple-700' : 'bg-gray-100 text-gray-400' }}">
                            {{ $k->stuntingScorecard->count() }} triwulan
                        </span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="/admin/kesehatan/stunting/pemantauan-bumil?kia_id={{ $k->id }}"
                                class="px-2.5 py-1 text-xs font-medium rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors"
                                title="Pemantauan Bumil">Bumil</a>
                            @if($k->nama_anak)
                            <a href="/admin/kesehatan/stunting/pemantauan-anak?kia_id={{ $k->id }}"
                                class="px-2.5 py-1 text-xs font-medium rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors"
                                title="Pemantauan Anak">Anak</a>
                            @endif
                            <a href="/admin/kesehatan/stunting/scorecard?kia_id={{ $k->id }}"
                                class="px-2.5 py-1 text-xs font-medium rounded-lg bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors"
                                title="Scorecard">Skor</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center text-sm text-gray-400">Belum ada data KIA.</td>
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
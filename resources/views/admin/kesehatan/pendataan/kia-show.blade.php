@extends('layouts.admin')
@section('title', 'Detail KIA')

@section('content')
{{-- Sub-tab Pendataan --}}
<div class="flex gap-2 mb-6">
    <a href="/admin/kesehatan/pendataan/posyandu"
        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors text-gray-600 hover:bg-gray-100">
        Posyandu
    </a>
    <a href="/admin/kesehatan/pendataan/kia"
        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors bg-emerald-100 text-emerald-700">
        Kesehatan Ibu &amp; Anak (KIA)
    </a>
</div>

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.kesehatan.pendataan.kia') }}"
        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    <div>
        <h3 class="text-base font-semibold text-gray-900">{{ $kia->nama_ibu }}</h3>
        <p class="text-sm text-gray-500">{{ $kia->no_register ?? 'No register belum tersedia' }}</p>
    </div>
    <div class="ml-auto flex gap-2">
        <a href="{{ route('admin.kesehatan.pendataan.kia.edit', $kia) }}"
            class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium bg-amber-100 text-amber-700 rounded-xl hover:bg-amber-200 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- Info Ibu --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h4 class="text-sm font-semibold text-gray-900">Data Ibu</h4>
        </div>
        <dl class="space-y-3">
            @foreach([
            ['NIK','nik_ibu'],['Alamat','alamat_ibu'],['Dusun','dusun'],['No. HP','no_hp'],
            ['Posyandu', null], ['Kehamilan Ke-','kehamilan_ke'],
            ['HPHT', null], ['Taksiran Lahir (HPL)', null],
            ['Tempat Pemeriksaan','tempat_pemeriksaan'],
            ] as $row)
            <div class="flex justify-between gap-4">
                <dt class="text-xs text-gray-500 flex-shrink-0">{{ $row[0] }}</dt>
                <dd class="text-sm font-medium text-gray-800 text-right">
                    @if($row[0] === 'Posyandu')
                    {{ $kia->posyandu->nama_posyandu ?? '-' }}
                    @elseif($row[0] === 'HPHT')
                    {{ $kia->hpht ? $kia->hpht->format('d M Y') : '-' }}
                    @elseif($row[0] === 'Taksiran Lahir (HPL)')
                    {{ $kia->taksiran_lahir ? $kia->taksiran_lahir->format('d M Y') : '-' }}
                    @else
                    {{ $kia->{$row[1]} ?? '-' }}
                    @endif
                </dd>
            </div>
            @endforeach
            <div class="flex justify-between gap-4">
                <dt class="text-xs text-gray-500">Status Risiko</dt>
                <dd>
                    @php $rb=['normal'=>'bg-emerald-50 text-emerald-700','resiko_rendah'=>'bg-amber-50
                    text-amber-700','resiko_tinggi'=>'bg-red-50 text-red-700']; @endphp
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $rb[$kia->status_resiko] ?? 'bg-gray-100 text-gray-600' }}">{{
                        $kia->status_resiko_label }}</span>
                </dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt class="text-xs text-gray-500">Status Kehamilan</dt>
                <dd>
                    @php $bs=['hamil'=>'bg-blue-50 text-blue-700','melahirkan'=>'bg-emerald-50
                    text-emerald-700','selesai'=>'bg-gray-100 text-gray-500']; @endphp
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $bs[$kia->status_kehamilan] ?? 'bg-gray-100 text-gray-500' }}">{{
                        ucfirst($kia->status_kehamilan) }}</span>
                </dd>
            </div>
        </dl>
    </div>

    {{-- Info Anak --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h4 class="text-sm font-semibold text-gray-900">Data Anak</h4>
        </div>
        @if($kia->nama_anak)
        <dl class="space-y-3">
            @foreach([
            ['Nama Anak','nama_anak'],['NIK Anak','nik_anak'],
            ['Jenis Kelamin', null],['Tanggal Lahir', null],
            ['Umur Sekarang', null],
            ['Berat Lahir','berat_lahir'],['Panjang Lahir','panjang_lahir'],
            ] as $row)
            <div class="flex justify-between gap-4">
                <dt class="text-xs text-gray-500">{{ $row[0] }}</dt>
                <dd class="text-sm font-medium text-gray-800 text-right">
                    @if($row[0] === 'Jenis Kelamin')
                    {{ $kia->jenis_kelamin_anak === 'L' ? 'Laki-laki' : ($kia->jenis_kelamin_anak === 'P' ? 'Perempuan'
                    : '-') }}
                    @elseif($row[0] === 'Tanggal Lahir')
                    {{ $kia->tgl_lahir_anak ? $kia->tgl_lahir_anak->format('d M Y') : '-' }}
                    @elseif($row[0] === 'Umur Sekarang')
                    {{ $kia->umur_anak_bulan !== null ? $kia->umur_anak_bulan . ' bulan' : '-' }}
                    @elseif($row[0] === 'Berat Lahir')
                    {{ $kia->berat_lahir ? $kia->berat_lahir . ' kg' : '-' }}
                    @elseif($row[0] === 'Panjang Lahir')
                    {{ $kia->panjang_lahir ? $kia->panjang_lahir . ' cm' : '-' }}
                    @else
                    {{ $kia->{$row[1]} ?? '-' }}
                    @endif
                </dd>
            </div>
            @endforeach
        </dl>
        @else
        <div class="flex flex-col items-center justify-center h-40 text-gray-400">
            <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <p class="text-sm">Data anak belum diisi</p>
        </div>
        @endif
    </div>
</div>

{{-- Tabs riwayat --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden" x-data="{ tab: 'bumil' }">
    <div class="flex border-b border-gray-100 overflow-x-auto">
        <button @click="tab = 'bumil'"
            :class="tab === 'bumil' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500'"
            class="px-5 py-3.5 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">Pemantauan Ibu Hamil
            ({{ $kia->pemantauanBumil->count() }})</button>
        @if($kia->nama_anak)
        <button @click="tab = 'anak'"
            :class="tab === 'anak' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500'"
            class="px-5 py-3.5 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">Pemantauan Anak ({{
            $kia->pemantauanAnak->count() }})</button>
        @endif
        <button @click="tab = 'scorecard'"
            :class="tab === 'scorecard' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500'"
            class="px-5 py-3.5 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">Scorecard ({{
            $kia->stuntingScorecard->count() }})</button>
    </div>

    <div x-show="tab === 'bumil'" class="overflow-x-auto">
        @if($kia->pemantauanBumil->count())
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Usia Hamil</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">BB (kg)</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">LILA</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Pil Fe</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Anemia</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">KEK</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($kia->pemantauanBumil as $pm)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-sm text-gray-700">{{ $pm->tanggal_pemantauan->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-sm text-gray-600 text-center">{{ $pm->usia_kehamilan ?
                        $pm->usia_kehamilan.' mgg' : '-' }}</td>
                    <td class="px-5 py-3 text-sm text-gray-600 text-center">{{ $pm->berat_badan ?? '-' }}</td>
                    <td class="px-5 py-3 text-sm text-gray-600 text-center">{{ $pm->lingkar_lengan ?
                        $pm->lingkar_lengan.' cm' : '-' }}</td>
                    <td class="px-5 py-3 text-center"><span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $pm->dapat_pil_fe==='ya' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">{{
                            strtoupper($pm->dapat_pil_fe) }}</span></td>
                    <td class="px-5 py-3 text-center"><span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $pm->anemia==='ya' ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700' }}">{{
                            strtoupper($pm->anemia) }}</span></td>
                    <td class="px-5 py-3 text-center"><span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $pm->kek==='ya' ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700' }}">{{
                            strtoupper($pm->kek) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="py-12 text-center text-sm text-gray-400">Belum ada riwayat pemantauan ibu hamil.</div>
        @endif
    </div>

    @if($kia->nama_anak)
    <div x-show="tab === 'anak'" class="overflow-x-auto">
        @if($kia->pemantauanAnak->count())
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Umur (bln)</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">BB (kg)</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">TB (cm)</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Status TB/U</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($kia->pemantauanAnak as $pa)
                <tr class="hover:bg-gray-50 {{ $pa->is_stunting ? 'bg-amber-50/50' : '' }}">
                    <td class="px-5 py-3 text-sm text-gray-700">{{ $pa->tanggal_pemantauan->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-sm text-gray-600 text-center">{{ $pa->umur_bulan }}</td>
                    <td class="px-5 py-3 text-sm text-gray-600 text-center">{{ $pa->berat_badan ?? '-' }}</td>
                    <td class="px-5 py-3 text-sm text-gray-600 text-center">{{ $pa->tinggi_badan ?? '-' }}</td>
                    <td class="px-5 py-3 text-center">
                        @php $bt=['sangat_pendek'=>'bg-red-50 text-red-700','pendek'=>'bg-amber-50
                        text-amber-700','normal'=>'bg-emerald-50 text-emerald-700','tinggi'=>'bg-blue-50
                        text-blue-700']; @endphp
                        <span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $bt[$pa->status_tb_u] ?? 'bg-gray-100 text-gray-500' }}">{{
                            $pa->status_tb_u ?? '-' }}</span>
                        @if($pa->is_stunting) <span class="ml-1 text-amber-500 text-xs">⚠</span> @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="py-12 text-center text-sm text-gray-400">Belum ada riwayat pemantauan anak.</div>
        @endif
    </div>
    @endif

    <div x-show="tab === 'scorecard'" class="p-6">
        @if($kia->stuntingScorecard->count())
        @foreach($kia->stuntingScorecard as $sc)
        <div class="mb-4 p-4 bg-gray-50 rounded-xl">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-semibold text-gray-700">{{ $sc->triwulan_label }}</span>
                <span class="text-sm font-bold text-gray-900">{{ $sc->skor_konvergensi }}/14 ({{ $sc->persentase_skor
                    }}%)</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="h-2 rounded-full {{ $sc->persentase_skor >= 80 ? 'bg-emerald-500' : ($sc->persentase_skor >= 60 ? 'bg-blue-500' : ($sc->persentase_skor >= 40 ? 'bg-amber-500' : 'bg-red-500')) }}"
                    style="width: {{ $sc->persentase_skor }}%"></div>
            </div>
            <span class="text-xs text-gray-500 mt-1 block">{{ $sc->kategori_skor }}</span>
        </div>
        @endforeach
        @else
        <div class="py-8 text-center text-sm text-gray-400">Belum ada data scorecard konvergensi.</div>
        @endif
    </div>
</div>
@endsection
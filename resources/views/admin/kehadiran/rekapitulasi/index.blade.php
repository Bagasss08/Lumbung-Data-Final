@extends('layouts.admin')

@section('title', 'Rekapitulasi Kehadiran')

@section('content')
<div class="space-y-6">

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <form method="GET" action="{{ route('admin.kehadiran.rekapitulasi.index') }}"
            class="flex flex-wrap items-end gap-4">

            {{-- Bulan --}}
            @php
            $namaBulanList = [
            1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
            5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
            9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
            ];
            @endphp
            <div class="flex-1 min-w-[140px]">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Bulan</label>
                <select name="bulan"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none bg-white">
                    @foreach($namaBulanList as $num => $namaB)
                    <option value="{{ $num }}" {{ $bulan==$num ? 'selected' : '' }}>{{ $namaB }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tahun --}}
            @php
            $tahunList = range(now()->year - 2, now()->year + 1);
            @endphp
            <div class="flex-1 min-w-[120px]">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tahun</label>
                <select name="tahun"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none bg-white">
                    @foreach($tahunList as $y)
                    <option value="{{ $y }}" {{ $tahun==$y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Perangkat --}}
            <div class="flex-[2] min-w-[200px]">
                <label
                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Perangkat</label>
                <select name="perangkat_id"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none bg-white">
                    <option value="">Semua Perangkat</option>
                    @foreach($perangkats as $p)
                    <option value="{{ $p->id }}" {{ $perangkatId==$p->id ? 'selected' : '' }}>
                      {{ $p->nama }} ({{ $p->jabatan?->nama ?? '-' }})
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all shadow-sm">
                Tampilkan
            </button>
        </form>
    </div>

    {{-- JUDUL PERIODE & EXPORT --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">
                Rekapitulasi {{ $namaBulan }} {{ $tahun }}
            </h3>
            <p class="text-sm text-gray-500 mt-0.5">
                Jumlah hari kerja: <strong>{{ $jumlahHariKerja }} hari</strong>
            </p>
        </div>
        @include('admin.partials.modal-hapus')
        <div class="relative" x-data>
            @include('admin.partials.export-buttons', [
                'routeExcel' => 'admin.kehadiran.rekapitulasi.export-excel',
                'routePdf' => 'admin.kehadiran.rekapitulasi.export-pdf',
            ])
        </div>
    </div>

    {{-- TABEL REKAPITULASI --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if(empty($rekapData))
        <div class="flex flex-col items-center justify-center py-16 text-gray-400">
            <svg class="w-16 h-16 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <p class="font-medium text-gray-500">Belum ada data kehadiran</p>
            <p class="text-sm mt-1">Pilih periode di atas untuk menampilkan data</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            No</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Nama Perangkat</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Jabatan</th>
                        <th
                            class="text-center px-4 py-3.5 text-xs font-semibold text-emerald-600 uppercase tracking-wider">
                            Hadir</th>
                        <th
                            class="text-center px-4 py-3.5 text-xs font-semibold text-amber-600 uppercase tracking-wider">
                            Telat</th>
                        <th
                            class="text-center px-4 py-3.5 text-xs font-semibold text-blue-600 uppercase tracking-wider">
                            Izin</th>
                        <th
                            class="text-center px-4 py-3.5 text-xs font-semibold text-cyan-600 uppercase tracking-wider">
                            Sakit</th>
                        <th class="text-center px-4 py-3.5 text-xs font-semibold text-red-600 uppercase tracking-wider">
                            Alpa</th>
                        <th
                            class="text-center px-4 py-3.5 text-xs font-semibold text-purple-600 uppercase tracking-wider">
                            Dinas</th>
                        <th
                            class="text-center px-4 py-3.5 text-xs font-semibold text-indigo-600 uppercase tracking-wider">
                            Cuti</th>
                        <th
                            class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            %Hadir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($rekapData as $i => $rekap)
                    @php
                    $persen = $jumlahHariKerja > 0
                    ? round(($rekap['hadir'] + $rekap['terlambat']) / $jumlahHariKerja * 100)
                    : 0;
                    $persenColor = $persen >= 80 ? 'emerald' : ($persen >= 60 ? 'amber' : 'red');
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4 text-gray-500 font-medium">{{ $i + 1 }}</td>
                        <td class="px-5 py-4 font-semibold text-gray-800">{{ $rekap['nama'] }}</td>
                        <td class="px-5 py-4 text-gray-600 text-xs">{{ $rekap['jabatan'] }}</td>
                        <td class="px-4 py-4 text-center">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 font-bold text-sm">{{
                                $rekap['hadir'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 text-amber-700 font-bold text-sm">{{
                                $rekap['terlambat'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-700 font-bold text-sm">{{
                                $rekap['izin'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-cyan-50 text-cyan-700 font-bold text-sm">{{
                                $rekap['sakit'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-700 font-bold text-sm">{{
                                $rekap['alpa'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-purple-50 text-purple-700 font-bold text-sm">{{
                                $rekap['dinas_luar'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 font-bold text-sm">{{
                                $rekap['cuti'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-xs font-bold
                                        @if($persen >= 80) text-emerald-600
                                        @elseif($persen >= 60) text-amber-600
                                        @else text-red-600
                                        @endif">
                                    {{ $persen }}%
                                </span>
                                <div class="w-12 bg-gray-100 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full
                                            @if($persen >= 80) bg-emerald-500
                                            @elseif($persen >= 60) bg-amber-500
                                            @else bg-red-500
                                            @endif" style="width: {{ $persen }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50 border-t-2 border-gray-200 font-semibold">
                        <td colspan="3" class="px-5 py-3.5 text-sm text-gray-700">Total</td>
                        <td class="px-4 py-3.5 text-center text-emerald-700">{{ collect($rekapData)->sum('hadir') }}
                        </td>
                        <td class="px-4 py-3.5 text-center text-amber-700">{{ collect($rekapData)->sum('terlambat') }}
                        </td>
                        <td class="px-4 py-3.5 text-center text-blue-700">{{ collect($rekapData)->sum('izin') }}</td>
                        <td class="px-4 py-3.5 text-center text-cyan-700">{{ collect($rekapData)->sum('sakit') }}</td>
                        <td class="px-4 py-3.5 text-center text-red-700">{{ collect($rekapData)->sum('alpa') }}</td>
                        <td class="px-4 py-3.5 text-center text-purple-700">{{ collect($rekapData)->sum('dinas_luar') }}
                        </td>
                        <td class="px-4 py-3.5 text-center text-indigo-700">{{ collect($rekapData)->sum('cuti') }}</td>
                        <td class="px-4 py-3.5 text-center text-gray-500">—</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif
    </div>

</div>
@endsection
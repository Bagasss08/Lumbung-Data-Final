@extends('layouts.admin')
@section('title', 'Scorecard Konvergensi Stunting')

@section('content')

<div class="flex gap-2 mb-6 overflow-x-auto">
    <a href="/admin/kesehatan/stunting/posyandu"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">Posyandu</a>
    <a href="/admin/kesehatan/stunting/kia"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">KIA</a>
    <a href="/admin/kesehatan/stunting/pemantauan-bumil"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">Pemantauan
        Bumil</a>
    <a href="/admin/kesehatan/stunting/pemantauan-anak"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">Pemantauan
        Anak</a>
    <a href="/admin/kesehatan/stunting/scorecard"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap bg-emerald-100 text-emerald-700 transition-colors">Scorecard</a>
</div>

{{-- Filter --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 mb-5">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="triwulan"
            class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
            <option value="">Semua Triwulan</option>
            @foreach(['TW1'=>'Triwulan 1','TW2'=>'Triwulan 2','TW3'=>'Triwulan 3','TW4'=>'Triwulan 4'] as $v=>$l)
            <option value="{{ $v }}" {{ request('triwulan')===$v?'selected':'' }}>{{ $l }}</option>
            @endforeach
        </select>
        <select name="tahun"
            class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
            <option value="">Semua Tahun</option>
            @foreach(range(date('Y'), 2020) as $y)
            <option value="{{ $y }}" {{ request('tahun')==$y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>
        <select name="kia_id"
            class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
            <option value="">Semua KIA</option>
            @foreach($kiaList as $k)
            <option value="{{ $k->id }}" {{ request('kia_id')==$k->id ? 'selected' : '' }}>{{ $k->nama_ibu }}</option>
            @endforeach
        </select>
        <button type="submit"
            class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-xl hover:bg-emerald-700 transition-colors">Filter</button>
        <a href="/admin/kesehatan/stunting/scorecard"
            class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">Reset</a>
    </form>
</div>

{{-- Stats --}}
@if($stats['total'] > 0)
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <p class="text-xs text-gray-500 mb-1">Total Scorecard</p>
        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <p class="text-xs text-gray-500 mb-1">Rata-rata Skor</p>
        <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['rata_rata'], 1) }}/14</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <p class="text-xs text-gray-500 mb-1">Skor Tertinggi</p>
        <p class="text-2xl font-bold text-emerald-600">{{ $stats['max'] }}/14</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <p class="text-xs text-gray-500 mb-1">Skor Terendah</p>
        <p class="text-2xl font-bold text-red-500">{{ $stats['min'] }}/14</p>
    </div>
</div>
@endif

{{-- Form Tambah Scorecard --}}
@if($selectedKia)
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 bg-purple-50 border-b border-purple-100">
        <div>
            <h4 class="text-sm font-semibold text-purple-900">Input Scorecard Konvergensi</h4>
            <p class="text-xs text-purple-700 mt-0.5">{{ $selectedKia->nama_ibu }} — {{ $selectedKia->nama_anak ??
                'Belum melahirkan' }}</p>
        </div>
        <a href="/admin/kesehatan/stunting/kia" class="text-xs text-purple-600 hover:underline">Ganti KIA</a>
    </div>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.kesehatan.stunting.scorecard.store') }}">
            @csrf
            <input type="hidden" name="kia_id" value="{{ $selectedKia->id }}">
            @if($errors->any())
            <div class="p-3 mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs">
                @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
            </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Triwulan <span
                            class="text-red-500">*</span></label>
                    <select name="triwulan" required
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="">-- Pilih --</option>
                        @foreach(['TW1'=>'Triwulan 1 (Jan-Mar)','TW2'=>'Triwulan 2 (Apr-Jun)','TW3'=>'Triwulan 3
                        (Jul-Sep)','TW4'=>'Triwulan 4 (Okt-Des)'] as $v=>$l)
                        <option value="{{ $v }}">{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Tahun <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="tahun" required min="2000" max="2100" value="{{ date('Y') }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
            </div>

            {{-- 14 Indikator --}}
            @php
            $indikators = [
            'Kelompok Ibu Hamil' => [
            ['ifa', 'Mendapat suplemen Fe/IFA (≥90 tablet)'],
            ['pmtbumil', 'Mendapat PMT Ibu Hamil'],
            ['pemeriksaan_kehamilan', 'Pemeriksaan kehamilan (ANC K4)'],
            ['akt_bumil', 'Ikut kelas ibu hamil'],
            ['persalinan_fasyankes', 'Persalinan di fasilitas kesehatan'],
            ],
            'Kelompok Bayi/Anak' => [
            ['imunisasi_dasar', 'Imunisasi dasar lengkap'],
            ['pmtbalita', 'Mendapat PMT Balita'],
            ['vit_a', 'Mendapat Vitamin A (2x/tahun)'],
            ['stimulasi', 'Mendapat stimulasi tumbuh kembang'],
            ['paud', 'Mengikuti PAUD / BKB'],
            ],
            'Kelompok Keluarga' => [
            ['jkn', 'Memiliki jaminan kesehatan (JKN)'],
            ['air_bersih', 'Akses air bersih layak'],
            ['sanitasi', 'Akses sanitasi layak (jamban)'],
            ['perlindungan_sosial', 'Menerima perlindungan sosial'],
            ],
            ];
            @endphp

            <div class="space-y-5">
                @foreach($indikators as $group => $items)
                <div class="rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                        <p class="text-xs font-semibold text-gray-700">{{ $group }}</p>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @foreach($items as [$name, $label])
                        <div class="flex items-center justify-between px-4 py-3">
                            <label for="ind_{{ $name }}" class="text-sm text-gray-700 cursor-pointer flex-1">{{ $label
                                }}</label>
                            <div class="flex items-center gap-3 ml-4">
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="{{ $name }}" id="ind_{{ $name }}" value="ya"
                                        class="w-3.5 h-3.5 text-emerald-600 focus:ring-emerald-500">
                                    <span class="text-xs font-medium text-emerald-700">Ya</span>
                                </label>
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="{{ $name }}" value="tidak" checked
                                        class="w-3.5 h-3.5 text-red-500 focus:ring-red-400">
                                    <span class="text-xs font-medium text-red-600">Tidak</span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-5">
                <button type="submit"
                    class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-br from-purple-500 to-indigo-600 text-white text-sm font-semibold rounded-xl hover:shadow-md transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Hitung & Simpan Scorecard
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Tabel Hasil Scorecard --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="text-base font-semibold text-gray-900">Hasil Scorecard</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Ibu</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Periode</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Skor</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">%</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase"
                        style="min-width:150px">Progress</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Kategori</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($scorecards as $sc)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3">
                        <p class="text-sm font-medium text-gray-800">{{ $sc->kia->nama_ibu }}</p>
                        @if($sc->kia->nama_anak) <p class="text-xs text-gray-400">Anak: {{ $sc->kia->nama_anak }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-sm text-gray-600 text-center">{{ $sc->triwulan_label }}</td>
                    <td class="px-5 py-3 text-center">
                        <span class="text-base font-bold text-gray-900">{{ $sc->skor_konvergensi }}</span>
                        <span class="text-xs text-gray-400">/14</span>
                    </td>
                    <td class="px-5 py-3 text-center font-semibold text-gray-700">{{ $sc->persentase_skor }}%</td>
                    <td class="px-5 py-3">
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="h-2 rounded-full transition-all {{ $sc->persentase_skor >= 80 ? 'bg-emerald-500' : ($sc->persentase_skor >= 60 ? 'bg-blue-500' : ($sc->persentase_skor >= 40 ? 'bg-amber-500' : 'bg-red-500')) }}"
                                style="width: {{ $sc->persentase_skor }}%"></div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-center">
                        @php
                        $kcat = ['Sangat Baik'=>'bg-emerald-50 text-emerald-700','Baik'=>'bg-blue-50
                        text-blue-700','Cukup'=>'bg-amber-50 text-amber-700','Kurang'=>'bg-red-50 text-red-700'];
                        @endphp
                        <span
                            class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $kcat[$sc->kategori_skor] ?? 'bg-gray-100 text-gray-600' }}">{{
                            $sc->kategori_skor }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">Belum ada data scorecard.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@extends('layouts.admin')
@section('title', 'Pemantauan Tumbuh Kembang Anak')

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
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap bg-emerald-100 text-emerald-700 transition-colors">Pemantauan
        Anak</a>
    <a href="/admin/kesehatan/stunting/scorecard"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">Scorecard</a>
</div>

{{-- Statistik Stunting --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
    $statStunting = [
    ['label'=>'Sangat Pendek', 'key'=>'sangat_pendek', 'color'=>'red'],
    ['label'=>'Pendek (Stunting)', 'key'=>'pendek', 'color'=>'amber'],
    ['label'=>'Normal', 'key'=>'normal', 'color'=>'emerald'],
    ['label'=>'Tinggi', 'key'=>'tinggi', 'color'=>'blue'],
    ];
    $colorBg = ['red'=>'bg-red-50 text-red-600','amber'=>'bg-amber-50 text-amber-600','emerald'=>'bg-emerald-50
    text-emerald-600','blue'=>'bg-blue-50 text-blue-600'];
    @endphp
    @foreach($statStunting as $st)
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <p class="text-xs text-gray-500 mb-1">{{ $st['label'] }}</p>
        <p class="text-2xl font-bold {{ explode(' ', $colorBg[$st['color']])[1] }}">{{ $stats[$st['key']] ?? 0 }}</p>
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

{{-- Form Tambah --}}
@if($selectedKia)
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 bg-emerald-50 border-b border-emerald-100">
        <div>
            <h4 class="text-sm font-semibold text-emerald-900">Tambah Pemantauan Tumbuh Kembang</h4>
            <p class="text-xs text-emerald-700 mt-0.5">{{ $selectedKia->nama_anak }} &mdash; {{ $selectedKia->nama_ibu
                }}</p>
        </div>
        <a href="/admin/kesehatan/stunting/kia" class="text-xs text-emerald-600 hover:underline">Ganti KIA</a>
    </div>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.kesehatan.stunting.pemantauan-anak.store') }}">
            @csrf
            <input type="hidden" name="kia_id" value="{{ $selectedKia->id }}">
            @if($errors->any())
            <div class="p-3 mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs">
                @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
            </div>
            @endif
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_pemantauan" required id="tgl-anak"
                        value="{{ old('tanggal_pemantauan', date('Y-m-d')) }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Bulan</label>
                    <input type="number" name="bulan" id="bulan-anak" min="1" max="12"
                        value="{{ old('bulan', date('n')) }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
                    <input type="number" name="tahun" id="tahun-anak" min="2000" max="2100"
                        value="{{ old('tahun', date('Y')) }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Umur (bulan) <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="umur_bulan" required min="0" max="72"
                        value="{{ old('umur_bulan', $selectedKia->umur_anak_bulan ?? '') }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Berat Badan (kg)</label>
                    <input type="number" name="berat_badan" step="0.1" min="0" max="50" value="{{ old('berat_badan') }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Tinggi Badan (cm)</label>
                    <input type="number" name="tinggi_badan" step="0.1" min="0" max="200"
                        value="{{ old('tinggi_badan') }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
            </div>
            {{-- Status WHO --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Status BB/U <span
                            class="text-xs text-gray-400">(Berat Badan / Usia)</span></label>
                    <select name="status_bb_u"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="">-- Pilih --</option>
                        @foreach(['sangat_kurang'=>'Sangat
                        Kurang','kurang'=>'Kurang','normal'=>'Normal','lebih'=>'Lebih'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('status_bb_u')===$v?'selected':'' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Status TB/U <span
                            class="text-xs text-amber-500">(Indikator Stunting)</span></label>
                    <select name="status_tb_u"
                        class="w-full px-3 py-2 text-sm border border-amber-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none bg-white">
                        <option value="">-- Pilih --</option>
                        @foreach(['sangat_pendek'=>'Sangat
                        Pendek','pendek'=>'Pendek','normal'=>'Normal','tinggi'=>'Tinggi'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('status_tb_u')===$v?'selected':'' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-amber-600 mt-1">⚠ Sangat Pendek / Pendek = Stunting</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Status BB/TB</label>
                    <select name="status_bb_tb"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="">-- Pilih --</option>
                        @foreach(['sangat_kurus'=>'Sangat
                        Kurus','kurus'=>'Kurus','normal'=>'Normal','gemuk'=>'Gemuk','obesitas'=>'Obesitas'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('status_bb_tb')===$v?'selected':'' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- Layanan tambahan --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-5">
                @foreach(['dapat_vit_a'=>'Dapat Vit A','asi_eksklusif'=>'ASI Eksklusif'] as $name=>$label)
                <label
                    class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50">
                    <input type="checkbox" name="{{ $name }}" value="ya" {{ old($name)==='ya' ?'checked':'' }}
                        class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                    <span class="text-xs font-medium text-gray-700">{{ $label }}</span>
                </label>
                @endforeach
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Status Imunisasi</label>
                    <select name="status_imunisasi"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="">--</option>
                        @foreach(['lengkap'=>'Lengkap','belum_lengkap'=>'Belum Lengkap','tidak_imunisasi'=>'Tidak
                        Imunisasi'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('status_imunisasi')===$v?'selected':'' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit"
                class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl hover:shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Simpan Pemantauan
            </button>
        </form>
    </div>
</div>
@endif

{{-- Tabel riwayat --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <h3 class="text-base font-semibold text-gray-900">Riwayat Pemantauan Anak</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Anak</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Umur (bln)</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">BB (kg)</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">TB (cm)</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">BB/U</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-amber-600 uppercase">TB/U (Stunting)
                    </th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">BB/TB</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pemantauan as $pa)
                <tr class="hover:bg-gray-50 transition-colors {{ $pa->is_stunting ? 'bg-amber-50/50' : '' }}">
                    <td class="px-5 py-3 text-sm text-gray-700">{{ $pa->tanggal_pemantauan->format('d M Y') }}</td>
                    <td class="px-5 py-3">
                        <p class="text-sm font-medium text-gray-800">{{ $pa->kia->nama_anak ?? '-' }}</p>
                        <p class="text-xs text-gray-400">{{ $pa->kia->nama_ibu }}</p>
                    </td>
                    <td class="px-5 py-3 text-sm text-gray-600 text-center">{{ $pa->umur_bulan }}</td>
                    <td class="px-5 py-3 text-sm text-gray-600 text-center">{{ $pa->berat_badan ?? '-' }}</td>
                    <td class="px-5 py-3 text-sm text-gray-600 text-center">{{ $pa->tinggi_badan ?? '-' }}</td>
                    <td class="px-5 py-3 text-center">
                        @php $bbu=['sangat_kurang'=>'bg-red-50 text-red-700','kurang'=>'bg-amber-50
                        text-amber-700','normal'=>'bg-emerald-50 text-emerald-700','lebih'=>'bg-blue-50 text-blue-700'];
                        @endphp
                        <span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $bbu[$pa->status_bb_u] ?? 'bg-gray-100 text-gray-400' }}">{{
                            $pa->status_bb_u ?? '-' }}</span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        @php $tbu=['sangat_pendek'=>'bg-red-50 text-red-700','pendek'=>'bg-amber-50
                        text-amber-700','normal'=>'bg-emerald-50 text-emerald-700','tinggi'=>'bg-blue-50
                        text-blue-700']; @endphp
                        <span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $tbu[$pa->status_tb_u] ?? 'bg-gray-100 text-gray-400' }}">
                            {{ $pa->status_tb_u ?? '-' }}
                            @if($pa->is_stunting) ⚠ @endif
                        </span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        @php $bbtb=['sangat_kurus'=>'bg-red-50 text-red-700','kurus'=>'bg-amber-50
                        text-amber-700','normal'=>'bg-emerald-50 text-emerald-700','gemuk'=>'bg-blue-50
                        text-blue-700','obesitas'=>'bg-purple-50 text-purple-700']; @endphp
                        <span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $bbtb[$pa->status_bb_tb] ?? 'bg-gray-100 text-gray-400' }}">{{
                            $pa->status_bb_tb ?? '-' }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-sm text-gray-400">Belum ada data pemantauan anak.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('tgl-anak')?.addEventListener('change', function () {
    const d = new Date(this.value);
    if (!isNaN(d)) {
        document.getElementById('bulan-anak').value = d.getMonth() + 1;
        document.getElementById('tahun-anak').value = d.getFullYear();
    }
});
</script>
@endsection
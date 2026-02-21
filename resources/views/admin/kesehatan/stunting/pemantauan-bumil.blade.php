@extends('layouts.admin')
@section('title', 'Pemantauan Ibu Hamil')

@section('content')

<div class="flex gap-2 mb-6 overflow-x-auto">
    <a href="/admin/kesehatan/stunting/posyandu"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">Posyandu</a>
    <a href="/admin/kesehatan/stunting/kia"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap text-gray-600 hover:bg-gray-100 transition-colors">KIA</a>
    <a href="/admin/kesehatan/stunting/pemantauan-bumil"
        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap bg-emerald-100 text-emerald-700 transition-colors">Pemantauan
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

{{-- Form Tambah Pemantauan --}}
@if($selectedKia)
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 bg-blue-50 border-b border-blue-100">
        <div>
            <h4 class="text-sm font-semibold text-blue-900">Tambah Pemantauan Ibu Hamil</h4>
            <p class="text-xs text-blue-700 mt-0.5">{{ $selectedKia->nama_ibu }} &mdash; {{
                $selectedKia->posyandu->nama_posyandu ?? '-' }}</p>
        </div>
        <a href="/admin/kesehatan/stunting/kia" class="text-xs text-blue-600 hover:underline">Ganti KIA</a>
    </div>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.kesehatan.stunting.pemantauan-bumil.store') }}">
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
                    <input type="date" name="tanggal_pemantauan" required id="tgl-bumil"
                        value="{{ old('tanggal_pemantauan', date('Y-m-d')) }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Bulan <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="bulan" required id="bulan-bumil" min="1" max="12"
                        value="{{ old('bulan', date('n')) }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Tahun <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="tahun" required id="tahun-bumil" min="2000" max="2100"
                        value="{{ old('tahun', date('Y')) }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Usia Hamil (mgg)</label>
                    <input type="number" name="usia_kehamilan" min="1" max="45" value="{{ old('usia_kehamilan') }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Berat Badan (kg)</label>
                    <input type="number" name="berat_badan" step="0.1" min="0" max="200"
                        value="{{ old('berat_badan') }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">LILA (cm)</label>
                    <input type="number" name="lingkar_lengan" step="0.1" min="0" max="60"
                        value="{{ old('lingkar_lengan') }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Sistole</label>
                    <input type="number" name="tekanan_darah_sistole" min="0" max="300"
                        value="{{ old('tekanan_darah_sistole') }}" placeholder="120"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Diastole</label>
                    <input type="number" name="tekanan_darah_diastole" min="0" max="200"
                        value="{{ old('tekanan_darah_diastole') }}" placeholder="80"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Posyandu</label>
                    <select name="posyandu_id"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        @foreach($posyanduList as $p)
                        <option value="{{ $p->id }}" {{ $selectedKia->posyandu_id == $p->id ? 'selected' : '' }}>{{
                            $p->nama_posyandu }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- Checklist layanan --}}
            <div class="mb-4">
                <p class="text-xs font-semibold text-gray-600 mb-3">Layanan yang Diterima</p>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                    @foreach([
                    ['dapat_pil_fe','Pil Fe (TTD)'],
                    ['imunisasi_tt','Imunisasi TT'],
                    ['dapat_vit_a','Vitamin A'],
                    ['pemeriksaan_lab','Periksa Lab'],
                    ['konseling_gizi','Konseling Gizi'],
                    ] as [$name, $label])
                    <label
                        class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                        <input type="checkbox" name="{{ $name }}" value="ya" {{ old($name)==='ya' ? 'checked' : '' }}
                            class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                        <span class="text-xs font-medium text-gray-700">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            {{-- Status kesehatan --}}
            <div class="mb-5">
                <p class="text-xs font-semibold text-gray-600 mb-3">Status Kesehatan</p>
                <div class="grid grid-cols-2 gap-3 max-w-sm">
                    @foreach(['anemia'=>'Anemia', 'kek'=>'KEK (Kurang Energi Kronis)'] as $name => $label)
                    <label
                        class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-red-50 transition-colors">
                        <input type="checkbox" name="{{ $name }}" value="ya" {{ old($name)==='ya' ? 'checked' : '' }}
                            class="w-4 h-4 text-red-500 rounded focus:ring-red-500">
                        <span class="text-xs font-medium text-gray-700">{{ $label }}</span>
                    </label>
                    @endforeach
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

{{-- Riwayat --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <h3 class="text-base font-semibold text-gray-900">Riwayat Pemantauan Bumil</h3>
        @if(!$selectedKia)
        <div class="flex gap-3">
            <form method="GET" class="flex gap-2">
                <select name="kia_id"
                    class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                    <option value="">Pilih KIA...</option>
                    @foreach($kiaList as $k)
                    <option value="{{ $k->id }}" {{ request('kia_id')==$k->id ? 'selected' : '' }}>{{ $k->nama_ibu }}
                    </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="px-3 py-2 bg-emerald-600 text-white text-sm rounded-xl hover:bg-emerald-700 transition-colors">Filter</button>
            </form>
        </div>
        @endif
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Ibu</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Usia (mgg)</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">BB (kg)</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">TD</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">LILA</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Fe</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Anemia</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">KEK</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pemantauan as $pm)
                <tr
                    class="hover:bg-gray-50 transition-colors {{ ($pm->anemia==='ya' || $pm->kek==='ya') ? 'bg-red-50/40' : '' }}">
                    <td class="px-5 py-3 text-sm text-gray-700">{{ $pm->tanggal_pemantauan->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-sm font-medium text-gray-800">{{ $pm->kia->nama_ibu }}</td>
                    <td class="px-5 py-3 text-sm text-gray-600 text-center">{{ $pm->usia_kehamilan ?? '-' }}</td>
                    <td class="px-5 py-3 text-sm text-gray-600 text-center">{{ $pm->berat_badan ?? '-' }}</td>
                    <td class="px-5 py-3 text-sm text-gray-600 text-center">{{ $pm->tekanan_darah ?? '-' }}</td>
                    <td class="px-5 py-3 text-sm text-gray-600 text-center">{{ $pm->lingkar_lengan ?
                        $pm->lingkar_lengan.' cm' : '-' }}</td>
                    <td class="px-5 py-3 text-center"><span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $pm->dapat_pil_fe==='ya' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-400' }}">{{
                            $pm->dapat_pil_fe==='ya'?'Ya':'Tidak' }}</span></td>
                    <td class="px-5 py-3 text-center"><span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $pm->anemia==='ya' ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700' }}">{{
                            $pm->anemia==='ya'?'Ya':'Tidak' }}</span></td>
                    <td class="px-5 py-3 text-center"><span
                            class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $pm->kek==='ya' ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700' }}">{{
                            $pm->kek==='ya'?'Ya':'Tidak' }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center text-sm text-gray-400">Belum ada data pemantauan ibu
                        hamil.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('tgl-bumil')?.addEventListener('change', function () {
    const d = new Date(this.value);
    if (!isNaN(d)) {
        document.getElementById('bulan-bumil').value = d.getMonth() + 1;
        document.getElementById('tahun-bumil').value = d.getFullYear();
    }
});
</script>
@endsection
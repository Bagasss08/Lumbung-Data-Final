@extends('layouts.admin')

@section('title', 'Tambah Anggota')

@section('content')

<div class="mb-6">
    <nav class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('admin.kelompok.index') }}" class="hover:text-emerald-600 transition">Data Kelompok</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('admin.kelompok.anggota.index', $kelompok) }}" class="hover:text-emerald-600 transition">{{
            $kelompok->nama }}</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-800 font-medium">Tambah Anggota</span>
    </nav>
</div>

<div class="max-w-xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h3 class="font-semibold text-gray-800">Tambah Anggota Kelompok</h3>
            <p class="text-xs text-gray-500 mt-0.5">{{ $kelompok->nama }}</p>
        </div>

        <form method="POST" action="{{ route('admin.kelompok.anggota.store', $kelompok) }}" class="p-6 space-y-5">
            @csrf

            @if(session('error'))
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm">{{ session('error') }}</span>
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Penduduk (NIK / Nama) <span
                        class="text-red-500">*</span></label>
                <select name="nik" id="nik-select" required
                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">-- Cari NIK atau Nama --</option>
                    @foreach($pendudukList as $p)
                    <option value="{{ $p->nik }}" data-alamat="{{ $p->alamat }}" {{ old('nik')==$p->nik ? 'selected' :
                        '' }}>
                        {{ $p->nik }} - {{ $p->nama }}
                    </option>
                    @endforeach
                </select>
                {{-- Info penduduk terpilih --}}
                <div id="info-penduduk" class="hidden mt-2 px-3 py-2 bg-emerald-50 rounded-xl text-xs text-emerald-700">
                    <span id="info-alamat"></span>
                </div>
                @error('nik')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan</label>
                <select name="jabatan"
                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach(\App\Models\KelompokAnggota::$jabatanOptions as $j)
                    <option value="{{ $j }}" {{ old('jabatan')==$j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Masuk</label>
                <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk', date('Y-m-d')) }}"
                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="2"
                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-1">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:shadow-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan
                </button>
                <a href="{{ route('admin.kelompok.anggota.index', $kelompok) }}"
                    class="px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    const ts = new TomSelect('#nik-select', {
        placeholder: 'Ketik NIK atau Nama...',
        searchField: ['text'],
        maxOptions: 100,
        onChange(value) {
            const opt = ts.options[value];
            const infoBok = document.getElementById('info-penduduk');
            const infoAlamat = document.getElementById('info-alamat');
            if (value && opt) {
                const alamat = document.querySelector(`option[value="${value}"]`)?.dataset?.alamat;
                if (alamat) {
                    infoAlamat.textContent = '📍 ' + alamat;
                    infoBok.classList.remove('hidden');
                } else {
                    infoBok.classList.add('hidden');
                }
            } else {
                infoBok.classList.add('hidden');
            }
        }
    });
</script>
@endsection
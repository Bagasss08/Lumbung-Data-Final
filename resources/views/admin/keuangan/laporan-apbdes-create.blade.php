@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Tambah APBDes</h1>
                <p class="text-slate-600">Tambah data anggaran pendapatan atau belanja desa</p>
            </div>
            <a href="{{ route('admin.keuangan.apbdes') }}"
                class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        <div class="flex items-center mb-2">
            <i class="fas fa-exclamation-triangle mr-3"></i>
            <span class="font-semibold">Terdapat kesalahan:</span>
        </div>
        <ul class="list-disc list-inside ml-6 text-sm">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center">
        <i class="fas fa-exclamation-circle mr-3"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <form action="{{ route('admin.keuangan.apbdes.store') }}" method="POST" class="space-y-6">
            {{-- route: admin.keuangan.apbdes.store ✅ --}}
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tahun Anggaran -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Tahun Anggaran <span class="text-red-500">*</span>
                    </label>
                    <select name="tahun_id"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tahun_id') border-red-500 @enderror"
                        required>
                        <option value="">Pilih Tahun</option>
                        @foreach($tahunAnggaran as $tahun)
                        <option value="{{ $tahun->id }}" {{ old('tahun_id')==$tahun->id ? 'selected' : '' }}>
                            {{ $tahun->tahun }}
                            @if($tahun->status === 'aktif') (Aktif) @endif
                        </option>
                        @endforeach
                    </select>
                    @error('tahun_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kategori') border-red-500 @enderror"
                        required>
                        <option value="">Pilih Kategori</option>
                        <option value="pendapatan" {{ old('kategori')=='pendapatan' ? 'selected' : '' }}>
                            Pendapatan
                        </option>
                        <option value="belanja" {{ old('kategori')=='belanja' ? 'selected' : '' }}>
                            Belanja
                        </option>
                    </select>
                    @error('kategori')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Bidang → Kegiatan (dependent dropdown) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Bidang Anggaran <span class="text-red-500">*</span>
                    </label>
                    <select id="bidangSelect"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Pilih Bidang</option>
                        @foreach($bidang as $b)
                        <option value="{{ $b->id }}">{{ $b->nama_bidang }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <select name="kegiatan_id" id="kegiatanSelect"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kegiatan_id') border-red-500 @enderror"
                        required>
                        <option value="">Pilih Bidang dulu</option>
                    </select>
                    @error('kegiatan_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sumber Dana -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Sumber Dana <span class="text-red-500">*</span>
                </label>
                <select name="sumber_dana_id"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('sumber_dana_id') border-red-500 @enderror"
                    required>
                    <option value="">Pilih Sumber Dana</option>
                    @foreach($sumberDana as $sd)
                    <option value="{{ $sd->id }}" {{ old('sumber_dana_id')==$sd->id ? 'selected' : '' }}>
                        {{ $sd->nama_sumber }}
                    </option>
                    @endforeach
                </select>
                @error('sumber_dana_id')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jumlah Anggaran -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Jumlah Anggaran (Rp) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="anggaran" value="{{ old('anggaran') }}" min="1"
                    placeholder="Contoh: 250000000"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('anggaran') border-red-500 @enderror"
                    required>
                @error('anggaran')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                <button type="reset" class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition">
                    <i class="fas fa-redo mr-2"></i>Reset
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Data kegiatan per bidang dari PHP
const kegiatanData = {
    @foreach($bidang as $b)
    {{ $b->id }}: [
        @foreach($b->kegiatanAnggaran as $k)
        { id: {{ $k->id }}, nama: "{{ addslashes($k->nama_kegiatan) }}" },
        @endforeach
    ],
    @endforeach
};

const oldKegiatanId = "{{ old('kegiatan_id') }}";

document.getElementById('bidangSelect').addEventListener('change', function () {
    const bidangId = this.value;
    const kegiatanSelect = document.getElementById('kegiatanSelect');

    kegiatanSelect.innerHTML = '<option value="">Pilih Kegiatan</option>';

    if (bidangId && kegiatanData[bidangId]) {
        kegiatanData[bidangId].forEach(function (k) {
            const opt = document.createElement('option');
            opt.value = k.id;
            opt.textContent = k.nama;
            if (k.id == oldKegiatanId) opt.selected = true;
            kegiatanSelect.appendChild(opt);
        });
    }
});
</script>
@endsection
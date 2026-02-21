@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Edit APBDes</h1>
                <p class="text-slate-600">Edit data anggaran pendapatan atau belanja desa</p>
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

    <!-- Info Realisasi yang sudah ada -->
    @if($apbdes->realisasi->count() > 0)
    <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
        <div class="flex items-center">
            <i class="fas fa-info-circle mr-3"></i>
            <span>
                Sudah ada <strong>{{ $apbdes->realisasi->count() }} realisasi</strong>
                senilai <strong>Rp {{ number_format($apbdes->total_realisasi, 0, ',', '.') }}</strong>.
                Perubahan anggaran tidak akan mempengaruhi data realisasi yang sudah ada.
            </span>
        </div>
    </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <form action="{{ route('admin.keuangan.apbdes.update', $apbdes->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tahun Anggaran -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Tahun Anggaran <span class="text-red-500">*</span>
                    </label>
                    <select name="tahun_id"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                        @foreach($tahunAnggaran as $tahun)
                        <option value="{{ $tahun->id }}" {{ old('tahun_id', $apbdes->tahun_id) == $tahun->id ?
                            'selected' : '' }}>
                            {{ $tahun->tahun }}
                            @if($tahun->status === 'aktif') (Aktif) @endif
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                        <option value="pendapatan" {{ old('kategori', $apbdes->kategori) == 'pendapatan' ? 'selected' :
                            '' }}>
                            Pendapatan
                        </option>
                        <option value="belanja" {{ old('kategori', $apbdes->kategori) == 'belanja' ? 'selected' : '' }}>
                            Belanja
                        </option>
                    </select>
                </div>
            </div>

            <!-- Bidang → Kegiatan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Bidang Anggaran</label>
                    <select id="bidangSelect"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Pilih Bidang</option>
                        @foreach($bidang as $b)
                        <option value="{{ $b->id }}" {{ $apbdes->kegiatanAnggaran &&
                            $apbdes->kegiatanAnggaran->bidang_id == $b->id ? 'selected' : '' }}>
                            {{ $b->nama_bidang }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <select name="kegiatan_id" id="kegiatanSelect"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                        <!-- Opsi awal: tampilkan kegiatan yang sedang dipilih -->
                        <option value="{{ $apbdes->kegiatan_id }}" selected>
                            {{ $apbdes->kegiatanAnggaran->nama_kegiatan ?? 'Kegiatan Saat Ini' }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- Sumber Dana -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Sumber Dana <span class="text-red-500">*</span>
                </label>
                <select name="sumber_dana_id"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    required>
                    @foreach($sumberDana as $sd)
                    <option value="{{ $sd->id }}" {{ old('sumber_dana_id', $apbdes->sumber_dana_id) == $sd->id ?
                        'selected' : '' }}>
                        {{ $sd->nama_sumber }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Jumlah Anggaran -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Jumlah Anggaran (Rp) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="anggaran" value="{{ old('anggaran', $apbdes->anggaran) }}" min="1"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    required>
                @if($apbdes->total_realisasi > 0)
                <p class="mt-1 text-xs text-amber-600">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Anggaran tidak boleh kurang dari total realisasi
                    (Rp {{ number_format($apbdes->total_realisasi, 0, ',', '.') }})
                </p>
                @endif
            </div>

            <!-- Info Saldo -->
            <div class="bg-slate-50 rounded-lg p-4 text-sm grid grid-cols-3 gap-4">
                <div>
                    <p class="text-slate-500">Anggaran</p>
                    <p class="font-semibold text-slate-800">Rp {{ number_format($apbdes->anggaran, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Terealisasi</p>
                    <p class="font-semibold text-blue-600">Rp {{ number_format($apbdes->total_realisasi, 0, ',', '.') }}
                    </p>
                </div>
                <div>
                    <p class="text-slate-500">Sisa</p>
                    <p class="font-semibold text-emerald-600">
                        Rp {{ number_format($apbdes->anggaran - $apbdes->total_realisasi, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('admin.keuangan.apbdes') }}"
                    class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const kegiatanData = {
    @foreach($bidang as $b)
    {{ $b->id }}: [
        @foreach($b->kegiatanAnggaran as $k)
        { id: {{ $k->id }}, nama: "{{ addslashes($k->nama_kegiatan) }}" },
        @endforeach
    ],
    @endforeach
};

const currentKegiatanId = {{ $apbdes->kegiatan_id }};

document.getElementById('bidangSelect').addEventListener('change', function () {
    const bidangId = this.value;
    const kegiatanSelect = document.getElementById('kegiatanSelect');
    kegiatanSelect.innerHTML = '<option value="">Pilih Kegiatan</option>';

    if (bidangId && kegiatanData[bidangId]) {
        kegiatanData[bidangId].forEach(function (k) {
            const opt = document.createElement('option');
            opt.value = k.id;
            opt.textContent = k.nama;
            if (k.id == currentKegiatanId) opt.selected = true;
            kegiatanSelect.appendChild(opt);
        });
    }
});

// Auto-trigger saat load jika bidang sudah dipilih
const bidangSelect = document.getElementById('bidangSelect');
if (bidangSelect.value) {
    bidangSelect.dispatchEvent(new Event('change'));
}
</script>
@endsection
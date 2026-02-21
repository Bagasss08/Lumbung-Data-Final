@extends('layouts.admin')

@section('title', 'Konfirmasi Hapus Penduduk')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-slate-700">Konfirmasi Hapus Penduduk</h2>
            <p class="text-sm text-slate-500">Apakah Anda yakin ingin menghapus penduduk ini?</p>
        </div>
        <a href="{{ route('admin.penduduk') }}"
           class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
            ← Kembali
        </a>
    </div>

    <!-- Warning Card -->
    <div class="bg-red-50 border border-red-200 rounded-xl p-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-medium text-red-800 mb-2">Peringatan!</h3>
                <p class="text-sm text-red-700 mb-4">
                    Tindakan ini tidak dapat dibatalkan. Data penduduk yang dihapus akan hilang secara permanen.
                </p>
            </div>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Detail Penduduk</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- NIK -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">NIK</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $penduduk->nik }}</p>
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $penduduk->nama }}</p>
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Kelamin</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            </div>

            <!-- Tempat Lahir -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Tempat Lahir</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $penduduk->tempat_lahir }}</p>
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Lahir</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $penduduk->tanggal_lahir->format('d/m/Y') }}</p>
            </div>

            <!-- Agama -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Agama</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $penduduk->agama }}</p>
            </div>

            <!-- Status Kawin -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status Kawin</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $penduduk->status_kawin }}</p>
            </div>

            <!-- Pendidikan -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Pendidikan</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $penduduk->pendidikan ?? '-' }}</p>
            </div>

            <!-- Pekerjaan -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Pekerjaan</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $penduduk->pekerjaan == 'bekerja' ? 'Bekerja' : 'Tidak Bekerja' }}</p>
            </div>

            <!-- Alamat -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $penduduk->alamat ?? '-' }}</p>
            </div>

            <!-- Keluarga -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Keluarga</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">
                    @php
                        $currentKeluarga = $penduduk->keluargas()->withPivot('hubungan_keluarga')->first();
                    @endphp
                    @if($currentKeluarga)
                    {{ $currentKeluarga->no_kk }}
                    <span class="text-slate-500 font-normal">
                        ({{ $currentKeluarga->getKepalaKeluarga()->nama ?? 'N/A' }})
                    </span>
                    <br>
                    <span class="text-xs text-slate-600">
                        Hubungan: {{ ucfirst(str_replace('_', ' ', $currentKeluarga->pivot->hubungan_keluarga)) }}
                    </span>
                    @else
                    <span class="text-slate-400">Belum ada keluarga</span>
                    @endif
                </p>
            </div>

            <!-- Rumah Tangga -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Rumah Tangga</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">
                    @php
                        $currentRumahTangga = $penduduk->rumahTanggas()->withPivot('hubungan_rumah_tangga')->first();
                    @endphp
                    @if($currentRumahTangga)
                    {{ $currentRumahTangga->no_rumah_tangga }}
                    <span class="text-slate-500 font-normal">
                        ({{ $currentRumahTangga->kepalaRumahTangga()->nama ?? 'N/A' }})
                    </span>
                    <br>
                    <span class="text-xs text-slate-600">
                        Hubungan: {{ ucfirst(str_replace('_', ' ', $currentRumahTangga->pivot->hubungan_rumah_tangga)) }}
                    </span>
                    @else
                    <span class="text-slate-400">Belum ada rumah tangga</span>
                    @endif
                </p>
            </div>

            <!-- Wilayah -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Wilayah</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">
                    @if($penduduk->wilayah)
                    RT {{ $penduduk->wilayah->rt }} / RW {{ $penduduk->wilayah->rw }} - {{
                    $penduduk->wilayah->dusun }}
                    @else
                    <span class="text-slate-400">Belum ada wilayah</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-slate-200">
            <a href="{{ route('admin.penduduk') }}"
               class="px-6 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-50 transition duration-200">
                Batal
            </a>
            <form action="{{ route('admin.penduduk.destroy', $penduduk) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition duration-200">
                    Ya, Hapus Penduduk
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

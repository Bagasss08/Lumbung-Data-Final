@extends('layouts.admin')
@section('title', 'Detail Kartu Keluarga')

@section('content')
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.buku-administrasi.penduduk.ktp-kk.kk.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <p class="text-lg font-semibold text-gray-700">Detail Kartu Keluarga</p>
    </div>

    @php $kepala = $kk->getKepalaKeluarga(); @endphp

    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4">
        <div class="flex items-start justify-between mb-5">
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $kepala?->nama ?? 'Kepala KK belum ditetapkan' }}</h2>
                <p class="text-sm font-mono text-gray-500 mt-1">No KK: {{ $kk->no_kk }}</p>
            </div>
            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm font-medium">
                {{ $kk->anggota->count() }} Anggota
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 text-sm">
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Alamat</p>
                <p class="text-gray-800">{{ $kk->alamat }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Wilayah</p>
                <p class="text-gray-800">{{ $kk->wilayah?->nama ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Tanggal Terdaftar</p>
                <p class="text-gray-800">{{ $kk->tgl_terdaftar?->format('d/m/Y') ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Klasifikasi Ekonomi</p>
                <p class="text-gray-800 capitalize">{{ str_replace('_', ' ', $kk->klasifikasi_ekonomi ?? '-') }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Bantuan Aktif</p>
                <p class="text-gray-800">{{ $kk->jenis_bantuan_aktif ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-700 text-sm uppercase tracking-wider">Daftar Anggota Keluarga</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-4 py-3 text-gray-600 font-medium">No</th>
                        <th class="text-left px-4 py-3 text-gray-600 font-medium">NIK</th>
                        <th class="text-left px-4 py-3 text-gray-600 font-medium">Nama</th>
                        <th class="text-left px-4 py-3 text-gray-600 font-medium">Hubungan</th>
                        <th class="text-left px-4 py-3 text-gray-600 font-medium">JK</th>
                        <th class="text-left px-4 py-3 text-gray-600 font-medium">Tgl Lahir</th>
                        <th class="text-left px-4 py-3 text-gray-600 font-medium">Pekerjaan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kk->anggota as $i => $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-gray-700">{{ $p->nik }}</td>
                        <td class="px-4 py-3 text-gray-800 font-medium">{{ $p->nama }}</td>
                        <td class="px-4 py-3">
                            <span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded text-xs capitalize">
                                {{ str_replace('_', ' ', $p->pivot->hubungan_keluarga) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $p->jenis_kelamin === 'L' ? 'L' : 'P' }}</td>
                        <td class="px-4 py-3 text-gray-600 text-xs">{{ $p->tanggal_lahir->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $p->pekerjaan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">Belum ada anggota</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-end gap-3 mt-4">
        <a href="{{ route('admin.buku-administrasi.penduduk.ktp-kk.kk.edit', $kk) }}"
           class="px-5 py-2 text-sm bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-colors">Edit</a>
    </div>
@endsection
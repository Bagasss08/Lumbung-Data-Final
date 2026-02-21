@extends('layouts.admin')

@section('title', 'Anggota Rumah Tangga')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-slate-700">Anggota Rumah Tangga</h2>
            <p class="text-sm text-slate-500">Kelola anggota rumah tangga {{ $rumahTangga->no_rumah_tangga }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.rumah-tangga.show', $rumahTangga) }}"
               class="px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white rounded-lg text-sm font-medium transition duration-200">
                ← Kembali ke Detail
            </a>
            <a href="{{ route('admin.rumah-tangga-anggota.create', $rumahTangga) }}"
               class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition duration-200">
                + Tambah Anggota
            </a>
        </div>
    </div>

    <!-- Stats Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-emerald-600">{{ $anggota->count() }}</div>
                <div class="text-sm text-slate-500">Total Anggota</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $anggota->where('hubungan', 'kepala_rumah_tangga')->count() }}</div>
                <div class="text-sm text-slate-500">Kepala Rumah Tangga</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $anggota->where('hubungan', '!=', 'kepala_rumah_tangga')->count() }}</div>
                <div class="text-sm text-slate-500">Anggota Lain</div>
            </div>
        </div>
    </div>

    <!-- Members Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-800">Daftar Anggota</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">No</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">NIK</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Nama</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Jenis Kelamin</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Hubungan</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($anggota as $index => $member)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $member->penduduk->nik }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $member->penduduk->nama }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700">
                            {{ $member->penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-700">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($member->hubungan == 'kepala_rumah_tangga') bg-emerald-100 text-emerald-800
                                @elseif($member->hubungan == 'istri' || $member->hubungan == 'suami') bg-pink-100 text-pink-800
                                @elseif($member->hubungan == 'anak') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $member->hubungan_formatted }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.rumah-tangga-anggota.edit', [$rumahTangga, $member]) }}"
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Edit
                                </a>
                                @if($member->hubungan != 'kepala_rumah_tangga')
                                <form action="{{ route('admin.rumah-tangga-anggota.destroy', [$rumahTangga, $member]) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                            Belum ada anggota rumah tangga
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

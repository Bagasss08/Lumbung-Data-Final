@extends('layouts.admin')

@section('title', 'Data Kehadiran Harian')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-emerald-50 p-6">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            <div class="relative px-8 py-8 bg-gradient-to-br from-emerald-600 via-teal-600 to-teal-500">
                <!-- Decorative Elements -->
                <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,black)]">
                </div>
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 via-transparent to-transparent"></div>

                <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex items-center gap-5">
                        <div class="relative group">
                            <div
                                class="absolute inset-0 bg-white/30 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300">
                            </div>
                            <div
                                class="relative w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30 shadow-2xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1.5 tracking-tight">Data Kehadiran Harian</h1>
                            <p class="text-teal-100 text-sm font-medium">Kelola kehadiran harian pegawai dengan sistem modern
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('admin.kehadiran-harian.create') }}"
                        class="group relative inline-flex items-center justify-center gap-2 bg-white text-emerald-600 px-6 py-3.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-white to-teal-50 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <svg class="relative w-5 h-5 group-hover:rotate-90 transition-transform duration-500"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span class="relative">Tambah Kehadiran</span>
                    </a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 px-8 py-8 bg-gradient-to-br from-slate-50/50 to-white/50">
                <!-- Total Kehadiran -->
                <div
                    class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative flex items-center gap-4">
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:shadow-xl group-hover:shadow-emerald-500/40 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600 font-semibold mb-1">Total Kehadiran</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $kehadiran->total() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Hadir Hari Ini -->
                <div
                    class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative flex items-center gap-4">
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:shadow-xl group-hover:shadow-emerald-500/40 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600 font-semibold mb-1">Hadir Hari Ini</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $kehadiran->where('tanggal', now()->toDateString())->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Terlambat -->
                <div
                    class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-orange-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative flex items-center gap-4">
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:shadow-xl group-hover:shadow-amber-500/40 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600 font-semibold mb-1">Terlambat</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $kehadiran->where('jam_masuk', '>', '08:00')->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tidak Hadir -->
                <div
                    class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-slate-500/5 to-gray-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative flex items-center gap-4">
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-slate-500 to-gray-600 flex items-center justify-center shadow-lg shadow-slate-500/30 group-hover:shadow-xl group-hover:shadow-slate-500/40 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600 font-semibold mb-1">Tidak Hadir</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $kehadiran->where('id_jenis_kehadiran', 2)->count() }}</p> <!-- Assuming 2 is absent -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
        <div class="bg-white rounded-2xl border-l-4 border-emerald-500 p-5 shadow-lg backdrop-blur-sm animate-slideIn">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-slate-800 font-semibold">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr
                            class="bg-gradient-to-r from-slate-100 via-slate-50 to-slate-100 border-b-2 border-slate-200">
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Pegawai</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Jenis Kehadiran</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Jam Masuk</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Jam Pulang</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Metode</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($kehadiran as $index => $item)
                        <tr
                            class="group hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 transition-all duration-200">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-sm font-bold text-slate-700 group-hover:bg-emerald-100 group-hover:text-emerald-700 transition-colors">
                                    {{ $kehadiran->firstItem() + $index }}
                                </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="text-sm font-semibold text-slate-900">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</span>
                                <p class="text-xs text-slate-500">{{ $item->hari }}</p>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="relative group/avatar">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl blur opacity-50 group-hover/avatar:opacity-75 transition-opacity">
                                        </div>
                                        <div
                                            class="relative w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                            {{ strtoupper(substr($item->pegawai->nama_lengkap, 0, 2)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-sm font-semibold text-slate-900">{{ $item->pegawai->nama_lengkap }}</span>
                                        <p class="text-xs text-slate-500">{{ $item->pegawai->jabatan }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200/50 shadow-sm">
                                    {{ $item->jenisKehadiran->nama_kehadiran }}
                                </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="text-sm text-slate-700">{{ $item->jam_masuk ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="text-sm text-slate-700">{{ $item->jam_pulang ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="text-sm text-slate-700">{{ ucfirst($item->metode_absen) }}</span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.kehadiran-harian.show', $item->id) }}"
                                        class="group/btn relative inline-flex items-center gap-1.5 px-3.5 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-bold rounded-lg shadow-md hover:shadow-xl transition-all duration-200 hover:scale-105 overflow-hidden">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-emerald-700 to-teal-700 opacity-0 group-hover/btn:opacity-100 transition-opacity">
                                        </div>
                                        <svg class="relative w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span class="relative">Detail</span>
                                    </a>
                                    <a href="{{ route('admin.kehadiran-harian.edit', $item->id) }}"
                                        class="group/btn relative inline-flex items-center gap-1.5 px-3.5 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white text-xs font-bold rounded-lg shadow-md hover:shadow-xl transition-all duration-200 hover:scale-105 overflow-hidden">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-amber-600 to-orange-700 opacity-0 group-hover/btn:opacity-100 transition-opacity">
                                        </div>
                                        <svg class="relative w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span class="relative">Edit</span>
                                    </a>
                                    <form action="{{ route('admin.kehadiran-harian.destroy', $item->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="group/btn relative inline-flex items-center gap-1.5 px-3.5 py-2 bg-gradient-to-r from-rose-600 to-red-600 text-white text-xs font-bold rounded-lg shadow-md hover:shadow-xl transition-all duration-200 hover:scale-105 overflow-hidden"
                                            onclick="return confirm('Yakin ingin menghapus kehadiran ini?')">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r from-rose-700 to-red-700 opacity-0 group-hover/btn:opacity-100 transition-opacity">
                                            </div>
                                            <svg class="relative w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span class="relative">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="relative w-28 h-28 mb-6">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-slate-200 to-slate-300 rounded-full blur-2xl opacity-50">
                                        </div>
                                        <div
                                            class="relative w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center shadow-xl">
                                            <svg class="w-14 h-14 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Data Kehadiran</h3>
                                    <p class="text-sm text-slate-500 mb-8 max-w-md">Mulai tambahkan data kehadiran untuk
                                        mengelola absensi pegawai dengan lebih efektif</p>
                                    <a href="{{ route('admin.kehadiran-harian.create') }}"
                                        class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 via-teal-600 to-teal-600 text-white px-8 py-4 rounded-xl font-bold shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 overflow-hidden">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-emerald-700 via-teal-700 to-teal-700 opacity-0 group-hover:opacity-100 transition-opacity">
                                        </div>
                                        <svg class="relative w-6 h-6 group-hover:rotate-90 transition-transform duration-500"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <span class="relative">Tambah Kehadiran Pertama</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($kehadiran->hasPages())
            <div class="px-6 py-5 border-t border-slate-200 bg-gradient-to-r from-slate-50 to-white">
                {{ $kehadiran->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-slideIn {
        animation: slideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .bg-grid-white\/10 {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(255 255 255 / 0.1)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
    }
</style>
@endsection


@extends('superadmin.layout.superadmin')

@section('title', 'Manajemen User')
@section('header', 'Pengguna Sistem')
@section('subheader', 'Kelola hak akses, peran, dan data pengguna.')

@section('content')

{{-- Alpine.js State untuk Bulk Actions --}}
<div class="max-w-7xl mx-auto space-y-6" x-data="{ selectedUsers: [], selectAll: false }" x-init="
    $watch('selectAll', value => {
        if (value) {
            selectedUsers = Array.from(document.querySelectorAll('.user-checkbox')).map(cb => cb.value);
        } else {
            selectedUsers = [];
        }
    })
">

    {{-- ── Header & Statistik Singkat ── --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Manajemen Pengguna</h2>
            <p class="text-sm text-slate-500 mt-1">Total <strong class="text-slate-700">{{ $users->total() }}</strong> pengguna terdaftar.</p>
        </div>
        
        <div class="flex gap-2">
            <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 active:bg-blue-800 shadow-sm transition-colors gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                Tambah User
            </a>
        </div>
    </div>

    {{-- ── Alert Success ── --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-xl flex items-start gap-3 shadow-sm">
            <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h3 class="text-sm font-bold text-emerald-800">Berhasil!</h3>
                <p class="text-sm text-emerald-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- ── Table Container ── --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
        
        {{-- Toolbar: Filter & Search --}}
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            
            {{-- Bagian Kiri: Bulk Action --}}
            <div class="w-full sm:w-auto h-10 flex items-center">
                {{-- Pastikan route hapus massal Anda sudah dibuat, contoh: route('superadmin.users.bulk_delete') --}}
                <form action="#" method="POST" x-show="selectedUsers.length > 0" x-cloak class="flex items-center gap-2" onsubmit="return confirm('Yakin ingin menghapus data terpilih?');">
                    @csrf
                    <template x-for="id in selectedUsers" :key="id">
                        <input type="hidden" name="user_ids[]" x-bind:value="id">
                    </template>
                    
                    <span class="text-sm font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg" x-text="selectedUsers.length + ' dipilih'"></span>
                    
                    <select name="bulk_action" required class="text-sm border-slate-200 rounded-lg text-slate-600 bg-white shadow-sm focus:ring-blue-500 py-2 pl-3 pr-8">
                        <option value="">Pilih Aksi...</option>
                        <option value="delete">Hapus Massal</option>
                    </select>
                    
                    <button type="submit" class="px-3 py-2 bg-slate-800 text-white text-sm font-semibold rounded-lg hover:bg-slate-700 transition-colors">Terapkan</button>
                </form>
            </div>

            {{-- Bagian Kanan: Filter & Search --}}
            <form action="{{ route('superadmin.users.index') }}" method="GET" class="w-full sm:w-auto flex flex-col sm:flex-row gap-3">
                <select name="role" onchange="this.form.submit()" class="text-sm border-slate-200 rounded-lg text-slate-600 bg-white shadow-sm focus:ring-blue-500 py-2 pl-3 pr-8">
                    <option value="">Semua Role</option>
                    <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="operator" {{ request('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                </select>

                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, username..." class="pl-9 pr-4 py-2 w-full border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 transition-all text-slate-700 shadow-sm" />
                </div>
                <button type="submit" class="hidden">Cari</button>
            </form>
        </div>

        {{-- Table Data --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-white border-b border-slate-200 text-slate-500 text-[11px] font-extrabold uppercase tracking-widest">
                        <th scope="col" class="px-5 py-4 w-12 text-center">
                            <input type="checkbox" x-model="selectAll" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer">
                        </th>
                        <th scope="col" class="px-4 py-4">Profil Pengguna</th>
                        <th scope="col" class="px-4 py-4">Hak Akses (Role)</th>
                        <th scope="col" class="px-4 py-4">Tgl Bergabung</th>
                        <th scope="col" class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors duration-150 group">
                        
                        <td class="px-5 py-4 text-center">
                            <input type="checkbox" value="{{ $user->id }}" x-model="selectedUsers" class="user-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer">
                        </td>
                        
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm border border-slate-200 shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800">{{ $user->name }}</div>
                                    <div class="text-[12.5px] text-slate-500 mt-0.5">{{ $user->email ?? 'Tidak ada email' }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-4 py-4">
                            @if($user->role === 'superadmin')
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-purple-50 text-purple-700 border border-purple-200 uppercase tracking-widest">Superadmin</span>
                            @elseif(in_array($user->role, ['admin', 'operator']))
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200 uppercase tracking-widest">{{ $user->role }}</span>
                            @else
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200 uppercase tracking-widest">Warga</span>
                            @endif
                        </td>
                        
                        <td class="px-4 py-4 text-slate-600 text-[13px] font-medium">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        
                        {{-- KOLOM AKSI (Diperjelas dan Diaktifkan Routenya) --}}
                        <td class="px-4 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                
                                {{-- Tombol Detail (Opsional, jika ada route show) --}}
                                {{-- <a href="{{ route('superadmin.users.show', $user->id) }}" class="inline-flex items-center justify-center w-8 h-8 text-emerald-600 bg-emerald-50 hover:bg-emerald-100 hover:text-emerald-700 rounded-md transition-colors" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a> --}}

                                {{-- Tombol Edit (Tersambung ke Route Edit) --}}
                                <a href="{{ route('superadmin.users.edit', $user->id) }}" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 rounded-md transition-colors" title="Edit Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                
                                {{-- Tombol Hapus (Tersambung ke Route Destroy) --}}
                                @if(Auth::id() !== $user->id)
                                <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini secara permanen?');" class="inline-block m-0 p-0">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 rounded-md transition-colors" title="Hapus User">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-50 border border-slate-100 mb-3 text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800 block">Tidak ada data</h3>
                            <p class="text-xs text-slate-500 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- ── Pagination ── --}}
        @if($users->hasPages())
        <div class="px-5 py-4 border-t border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-[13px] text-slate-500 font-medium">
                Menampilkan <span class="font-bold text-slate-800">{{ $users->firstItem() ?? 0 }}</span> - 
                <span class="font-bold text-slate-800">{{ $users->lastItem() ?? 0 }}</span> dari 
                <span class="font-bold text-slate-800">{{ $users->total() }}</span> data
            </div>
            
            <div class="pagination-wrapper">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Menyembunyikan teks info default dari Laravel Tailwind Pagination agar tidak tabrakan dengan tulisan kustom kita */
    .pagination-wrapper nav div.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between p { display: none; }
</style>

@endsection
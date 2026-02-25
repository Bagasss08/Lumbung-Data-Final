@extends('layouts.admin')

@section('title', 'Jenis Kelompok')

@section('content')

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
    class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 shadow-sm">
    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span class="text-sm font-medium">{{ session('success') }}</span>
</div>
@endif
@if(session('error'))
<div x-data="{ show: true }" x-show="show"
    class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 shadow-sm">
    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span class="text-sm font-medium">{{ session('error') }}</span>
</div>
@endif

<div x-data="{
    showAdd: false,
    showEdit: false,
    editData: {},
    openEdit(item) {
        this.editData = item;
        this.showEdit = true;
    }
}">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.kelompok.index') }}"
                class="p-2 rounded-xl bg-white border border-gray-200 text-gray-500 hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <p class="text-sm text-gray-500">Kelola kategori / jenis kelompok yang ada di desa</p>
            </div>
        </div>
        <button @click="showAdd = true"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:shadow-lg transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Jenis
        </button>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">No
                        </th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            Nama Jenis</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            Singkatan</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            Kategori</th>
                        <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            Jumlah Kelompok</th>
                        <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($data as $i => $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4 text-gray-500">{{ $i + 1 }}</td>
                        <td class="px-5 py-4 font-semibold text-gray-800">{{ $item->nama }}</td>
                        <td class="px-5 py-4 text-gray-500">{{ $item->singkatan ?? '-' }}</td>
                        <td class="px-5 py-4">
                            @if($item->jenis)
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-lg bg-purple-50 text-purple-700 text-xs font-medium capitalize">
                                {{ $item->jenis }}
                            </span>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('admin.kelompok.index', ['master' => $item->id]) }}"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold hover:bg-emerald-100 transition">
                                {{ $item->kelompok_count }}
                            </a>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-1">
                                <button @click="openEdit({{ json_encode($item) }})" title="Edit"
                                    class="p-1.5 rounded-lg text-amber-600 hover:bg-amber-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <form method="POST" action="{{ route('admin.kelompok.master.destroy', $item) }}"
                                    onsubmit="return confirm('Hapus jenis kelompok {{ $item->nama }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Hapus"
                                        class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                <svg class="w-10 h-10 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                                <p class="text-sm">Belum ada jenis kelompok</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div x-show="showAdd" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
        style="display:none">
        <div @click.outside="showAdd = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Tambah Jenis Kelompok</h3>
                <button @click="showAdd = false" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.kelompok.master.store') }}" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Jenis <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama" required placeholder="contoh: PKK, Karang Taruna..."
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Singkatan</label>
                    <input type="text" name="singkatan" maxlength="20"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
                    <select name="jenis"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">-- Pilih --</option>
                        @foreach(\App\Models\KelompokMaster::$jenisOptions as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                    <textarea name="keterangan" rows="2"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>
                <div class="flex gap-3 pt-1">
                    <button type="submit"
                        class="flex-1 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:shadow-lg transition">
                        Simpan
                    </button>
                    <button type="button" @click="showAdd = false"
                        class="flex-1 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div x-show="showEdit" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
        style="display:none">
        <div @click.outside="showEdit = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Edit Jenis Kelompok</h3>
                <button @click="showEdit = false" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <template x-if="editData.id">
                <form method="POST" :action="`/admin/kelompok/master/${editData.id}`" class="p-6 space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Jenis <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama" :value="editData.nama" required
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Singkatan</label>
                        <input type="text" name="singkatan" :value="editData.singkatan" maxlength="20"
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
                        <select name="jenis"
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">-- Pilih --</option>
                            @foreach(\App\Models\KelompokMaster::$jenisOptions as $key => $label)
                            <option value="{{ $key }}" x-bind:selected="editData.jenis === '{{ $key }}'">{{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                        <textarea name="keterangan" rows="2" x-text="editData.keterangan"
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                    </div>
                    <div class="flex gap-3 pt-1">
                        <button type="submit"
                            class="flex-1 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:shadow-lg transition">
                            Perbarui
                        </button>
                        <button type="button" @click="showEdit = false"
                            class="flex-1 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition">
                            Batal
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>

</div>

@endsection
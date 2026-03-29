@extends('layouts.admin')

@section('title', 'Tambah Lembaga Desa')

@section('content')
<div>
    {{-- ── Page Header dengan Breadcrumb ── --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800 dark:text-slate-100">Daftar Lembaga Desa</h2>
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="/admin/dashboard"
                class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('admin.lembaga-desa.index') }}"
                class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                Daftar Lembaga Desa
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Tambah Data</span>
        </nav>
    </div>

    {{-- ── Alert Messages ── --}}
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-md text-sm">
            <p class="font-medium mb-2">Terjadi kesalahan:</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ── Form ── --}}
    <form action="{{ route('admin.lembaga-desa.store') }}" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf

        {{-- ── LEFT: Logo Upload ── --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide">Logo Lembaga</h3>
            </div>
            <div class="p-4 space-y-4">
                {{-- Preview --}}
                <div id="logo-preview"
                    class="relative w-full h-48 border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-md flex items-center justify-center overflow-hidden bg-gray-50 dark:bg-slate-700/30">
                    <img src="{{ asset('images/lumbung-data-logo.png') }}" alt="Default Logo"
                        class="w-full h-full object-contain p-4">
                </div>
                <p class="text-xs text-gray-500 dark:text-slate-400">
                    Kosongkan jika menggunakan logo default Lumbung Data.
                </p>
                <input type="file" id="logo" name="logo" accept="image/*"
                    class="w-full text-sm text-gray-500 dark:text-slate-400
                           file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0
                           file:text-sm file:font-medium
                           file:bg-blue-50 dark:file:bg-blue-900/30
                           file:text-blue-700 dark:file:text-blue-400
                           hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50
                           cursor-pointer" />
            </div>
        </div>

        {{-- ── RIGHT: Form Fields ── --}}
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide">Identitas Lembaga</h3>
            </div>
            <div class="p-4 space-y-4">

                {{-- Row 1: Nama & Kode --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                            Nama Lembaga <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                            placeholder="Masukkan nama lembaga" required
                            class="w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-1.5 text-sm bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors">
                        @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="kode" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                            Kode Lembaga <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="kode" name="kode" value="{{ old('kode') }}"
                            placeholder="Masukkan kode lembaga" required
                            class="w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-1.5 text-sm bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors">
                        @error('kode')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        <p class="text-xs text-red-500 font-medium mt-1">* Pastikan kode belum pernah dipakai di data lembaga / kelompok.</p>
                    </div>
                </div>

                {{-- Row 2: No. SK & Kategori --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="no_sk" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                            No. SK Pendirian Lembaga
                        </label>
                        <input type="text" id="no_sk" name="no_sk" value="{{ old('no_sk') }}"
                            placeholder="Masukkan nomor SK"
                            class="w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-1.5 text-sm bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors">
                        @error('no_sk')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                            Kategori Lembaga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative" x-data="{
                            open: false,
                            search: '',
                            selected: { id: '{{ old('kategori_id') }}', label: '{{ old('kategori_id') ? ($kategoris->firstWhere('id', old('kategori_id'))?->nama ?? 'Pilih Kategori') : 'Pilih Kategori' }}' },
                            options: [
                                { id: '', label: 'Pilih Kategori' },
                                @foreach ($kategoris as $kategori)
                                    { id: '{{ $kategori->id }}', label: '{{ addslashes($kategori->nama) }}' },
                                @endforeach
                            ],
                            get filtered() { return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                            choose(opt) { this.selected = opt; this.open = false; this.search = ''; kategoriInput.value = opt.id; }
                        }">
                            <input type="hidden" id="kategoriInput" name="kategori_id" value="{{ old('kategori_id') }}">
                            <div @click="open = !open" @click.outside="open = false; search = ''"
                                class="w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-1.5 text-sm bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 cursor-pointer flex items-center justify-between gap-2 focus-within:ring-2 focus-within:ring-emerald-500 hover:border-emerald-400 transition-colors">
                                <span x-text="selected.label" :class="selected.id === '' ? 'text-gray-400 dark:text-slate-500' : ''"></span>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute left-0 top-full mt-1 z-40 w-full bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-md shadow-lg"
                                style="display:none">
                                <div class="p-2 border-b border-gray-100 dark:border-slate-600">
                                    <input type="text" x-model="search" @click.stop placeholder="Cari kategori..."
                                        class="w-full px-3 py-1.5 text-sm border border-gray-300 dark:border-slate-500 rounded bg-white dark:bg-slate-800 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 outline-none"
                                        @keydown.escape="open = false">
                                </div>
                                <ul class="max-h-48 overflow-y-auto py-1">
                                    <template x-for="opt in filtered" :key="opt.id">
                                        <li @click="choose(opt)"
                                            class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors"
                                            :class="selected.id === opt.id ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium' : 'text-gray-900 dark:text-slate-100'"
                                            x-text="opt.label"></li>
                                    </template>
                                    <li x-show="filtered.length === 0" class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 italic">Tidak ditemukan</li>
                                </ul>
                            </div>
                        </div>
                        @error('kategori_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Row 3: Ketua & Status --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                            Ketua Lembaga
                        </label>
                        <div class="relative" x-data="{
                            open: false,
                            search: '',
                            selected: { id: '{{ old('ketua') }}', label: '{{ old('ketua') ? (explode(' - ', old('ketua'))[1] ?? old('ketua')) : 'Pilih Ketua Lembaga' }}' },
                            options: [
                                { id: '', label: 'Pilih Ketua Lembaga' },
                                @foreach($penduduk as $person)
                                    { id: '{{ $person->nik }}-{{ str_replace(' ', '_', $person->nama) }}', label: '{{ $person->nik }} - {{ $person->nama }}' },
                                @endforeach
                            ],
                            get filtered() { return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                            choose(opt) { this.selected = opt; this.open = false; this.search = ''; ketuaInput.value = opt.id; }
                        }">
                            <input type="hidden" id="ketuaInput" name="ketua" value="{{ old('ketua') }}">
                            <div @click="open = !open" @click.outside="open = false; search = ''"
                                class="w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-1.5 text-sm bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 cursor-pointer flex items-center justify-between gap-2 focus-within:ring-2 focus-within:ring-emerald-500 hover:border-emerald-400 transition-colors">
                                <span x-text="selected.label" :class="selected.id === '' ? 'text-gray-400 dark:text-slate-500' : ''"></span>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute left-0 top-full mt-1 z-40 w-full bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-md shadow-lg"
                                style="display:none">
                                <div class="p-2 border-b border-gray-100 dark:border-slate-600">
                                    <input type="text" x-model="search" @click.stop placeholder="Cari ketua..."
                                        class="w-full px-3 py-1.5 text-sm border border-gray-300 dark:border-slate-500 rounded bg-white dark:bg-slate-800 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 outline-none"
                                        @keydown.escape="open = false">
                                </div>
                                <ul class="max-h-48 overflow-y-auto py-1">
                                    <template x-for="opt in filtered" :key="opt.id">
                                        <li @click="choose(opt)"
                                            class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors"
                                            :class="selected.id === opt.id ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium' : 'text-gray-900 dark:text-slate-100'"
                                            x-text="opt.label"></li>
                                    </template>
                                    <li x-show="filtered.length === 0" class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 italic">Tidak ditemukan</li>
                                </ul>
                            </div>
                        </div>
                        @error('ketua')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <div class="relative" x-data="{
                            open: false,
                            search: '',
                            selected: { id: '{{ old('aktif', '1') }}', label: '{{ old('aktif', '1') == '1' ? 'Aktif' : (old('aktif') == '0' ? 'Nonaktif' : 'Pilih Status') }}' },
                            options: [
                                { id: '', label: 'Pilih Status' },
                                { id: '1', label: 'Aktif' },
                                { id: '0', label: 'Nonaktif' }
                            ],
                            get filtered() { return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                            choose(opt) { this.selected = opt; this.open = false; this.search = ''; aktifInput.value = opt.id; }
                        }">
                            <input type="hidden" id="aktifInput" name="aktif" value="{{ old('aktif', '1') }}">
                            <div @click="open = !open" @click.outside="open = false; search = ''"
                                class="w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-1.5 text-sm bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 cursor-pointer flex items-center justify-between gap-2 focus-within:ring-2 focus-within:ring-emerald-500 hover:border-emerald-400 transition-colors">
                                <span x-text="selected.label" :class="selected.id === '' ? 'text-gray-400 dark:text-slate-500' : ''"></span>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute left-0 top-full mt-1 z-40 w-full bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-md shadow-lg"
                                style="display:none">
                                <div class="p-2 border-b border-gray-100 dark:border-slate-600">
                                    <input type="text" x-model="search" @click.stop placeholder="Cari status..."
                                        class="w-full px-3 py-1.5 text-sm border border-gray-300 dark:border-slate-500 rounded bg-white dark:bg-slate-800 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 outline-none"
                                        @keydown.escape="open = false">
                                </div>
                                <ul class="max-h-40 overflow-y-auto py-1">
                                    <template x-for="opt in filtered" :key="opt.id">
                                        <li @click="choose(opt)"
                                            class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors"
                                            :class="selected.id === opt.id ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium' : 'text-gray-900 dark:text-slate-100'"
                                            x-text="opt.label"></li>
                                    </template>
                                    <li x-show="filtered.length === 0" class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 italic">Tidak ditemukan</li>
                                </ul>
                            </div>
                        </div>
                        @error('aktif')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Row 4: Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                        Deskripsi Lembaga
                    </label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                        placeholder="Masukkan deskripsi lembaga"
                        class="w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-1.5 text-sm bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors resize-none">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- ── Form Actions ── --}}
                <div class="flex items-center justify-between gap-3 pt-4 border-t border-gray-100 dark:border-slate-700">
                    <a href="{{ route('admin.lembaga-desa.index') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('logo')?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                const preview = document.getElementById('logo-preview');
                preview.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-contain p-4" alt="Preview Logo">`;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush

@endsection
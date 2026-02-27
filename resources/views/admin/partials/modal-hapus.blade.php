{{--
PARTIAL: resources/views/admin/partials/modal-hapus.blade.php

CARA PAKAI — taruh sekali di layout ATAU per halaman:
@include('admin.partials.modal-hapus')

CARA TRIGGER dari tombol hapus:
<button type="button" @click="$dispatch('buka-modal-hapus', {
        action: '{{ route('admin.status-desa.destroy', $item) }}',
        nama:   '{{ addslashes($item->nama_status) }} ({{ $item->tahun }})'
    })" class="...">
    Hapus
</button>
--}}

<div x-data="{
        show: false,
        action: '',
        nama: '',
        loading: false,
    }" @buka-modal-hapus.window="
        action  = $event.detail.action;
        nama    = $event.detail.nama;
        show    = true;
        loading = false;
    " x-show="show" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display: none;">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="show = false"></div>

    {{-- Modal --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" @click.stop>
        {{-- Header --}}
        <div class="bg-red-50 px-6 py-5 border-b border-red-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 text-base">Konfirmasi Hapus</h3>
                <p class="text-sm text-gray-500 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
            </div>
        </div>

        {{-- Body --}}
        <div class="px-6 py-5">
            <p class="text-gray-700 text-sm leading-relaxed">
                Apakah Anda yakin ingin menghapus
                <strong class="text-gray-900" x-text="nama"></strong>?
            </p>
            <div class="mt-3 p-3 bg-amber-50 rounded-xl border border-amber-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs text-amber-700">Data yang dihapus tidak dapat dipulihkan kembali.</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
            <button type="button" @click="show = false"
                class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-white text-sm font-medium transition-colors">
                Batal
            </button>

            <form :action="action" method="POST" @submit="loading = true">
                @csrf
                @method('DELETE')
                <button type="submit" :disabled="loading"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 disabled:bg-red-300 text-white rounded-xl text-sm font-semibold transition-all shadow-sm hover:shadow">
                    <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                    <span x-text="loading ? 'Menghapus...' : 'Ya, Hapus'"></span>
                </button>
            </form>
        </div>
    </div>
</div>
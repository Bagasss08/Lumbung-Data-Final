{{--
PARTIAL: resources/views/admin/partials/export-buttons.blade.php

CARA PAKAI:
<div class="relative" x-data>
    @include('admin.partials.export-buttons', [
    'routeExcel' => 'admin.status-desa.export.excel',
    'routePdf' => 'admin.status-desa.export.pdf',
    ])
</div>

CATATAN: parent div harus punya x-data dan position: relative
--}}

<div x-data="{ open: false }" @click.away="open = false" class="relative">
    <button type="button" @click="open = !open"
        class="inline-flex items-center gap-2 border border-gray-200 hover:border-emerald-400 bg-white hover:bg-emerald-50 text-gray-700 hover:text-emerald-700 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Export
        <svg class="w-3 h-3 transition-transform duration-150" :class="open && 'rotate-180'" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-30"
        style="display:none">

        {{-- Excel --}}
        <a href="{{ route($routeExcel) }}"
            class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
            <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="font-semibold text-xs">Excel (.xlsx)</p>
                <p class="text-xs text-gray-400">Semua data</p>
            </div>
        </a>

        <div class="h-px bg-gray-100 mx-3"></div>

        {{-- PDF --}}
        <a href="{{ route($routePdf) }}"
            class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors">
            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="font-semibold text-xs">PDF</p>
                <p class="text-xs text-gray-400">Siap cetak + TTD</p>
            </div>
        </a>
    </div>
</div>
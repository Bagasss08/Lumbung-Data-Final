@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination" class="flex items-center justify-between">

    {{-- Info --}}
    <div class="hidden sm:block">
        <p class="text-sm text-gray-600">
            Menampilkan
            <span class="font-semibold text-gray-900">{{ $paginator->firstItem() }}</span>
            –
            <span class="font-semibold text-gray-900">{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-semibold text-gray-900">{{ $paginator->total() }}</span>
            data
        </p>
    </div>

    {{-- Tombol --}}
    <div class="flex items-center gap-1">

        {{-- Prev --}}
        @if ($paginator->onFirstPage())
        <span
            class="inline-flex items-center px-3 py-2 rounded-xl text-sm text-gray-300 bg-gray-50 cursor-not-allowed border border-gray-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}"
            class="inline-flex items-center px-3 py-2 rounded-xl text-sm text-gray-600 bg-white hover:bg-emerald-50 hover:text-emerald-700 border border-gray-200 hover:border-emerald-300 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        @endif

        {{-- Halaman --}}
        @foreach ($elements as $element)
        @if (is_string($element))
        <span class="inline-flex items-center px-3 py-2 text-sm text-gray-400">{{ $element }}</span>
        @endif

        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <span
            class="inline-flex items-center px-3.5 py-2 rounded-xl text-sm font-semibold text-white bg-gradient-to-br from-emerald-500 to-teal-600 shadow-sm">
            {{ $page }}
        </span>
        @else
        <a href="{{ $url }}"
            class="inline-flex items-center px-3.5 py-2 rounded-xl text-sm text-gray-600 bg-white hover:bg-emerald-50 hover:text-emerald-700 border border-gray-200 hover:border-emerald-300 transition-all">
            {{ $page }}
        </a>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
            class="inline-flex items-center px-3 py-2 rounded-xl text-sm text-gray-600 bg-white hover:bg-emerald-50 hover:text-emerald-700 border border-gray-200 hover:border-emerald-300 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
        @else
        <span
            class="inline-flex items-center px-3 py-2 rounded-xl text-sm text-gray-300 bg-gray-50 cursor-not-allowed border border-gray-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </span>
        @endif

    </div>
</nav>
@endif
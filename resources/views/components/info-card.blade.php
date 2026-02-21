@props(['icon' => null, 'title', 'description', 'link' => null, 'linkText' => 'Lihat', 'type' => 'vertical'])

@if($type === 'horizontal')
    <div class="flex items-start gap-4 p-4 rounded-xl border border-gray-100 bg-gray-50 hover:border-emerald-200 hover:bg-white hover:shadow-md transition-all duration-300 h-full">
        @if($icon)
            <div class="w-12 h-12 flex-shrink-0 rounded-full bg-white border border-emerald-100 flex items-center justify-center text-emerald-600 shadow-sm">
                {!! $icon !!}
            </div>
        @endif
        <div class="flex-1 min-w-0">
            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide mb-1">{{ $title }}</p>
            <div class="text-gray-900 font-medium text-sm leading-snug break-words">
                {!! $description !!}
            </div>
        </div>
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300 h-full">
        @if($icon)
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 h-12 flex items-center justify-center text-white text-2xl">
                {{ $icon }}
            </div>
        @endif
        
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $title }}</h3>
            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $description }}</p>
            
            @if($link)
                <a href="{{ $link }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium text-sm">
                    {{ $linkText }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @endif
        </div>
    </div>
@endif
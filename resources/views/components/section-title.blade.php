@props(['title', 'subtitle' => null, 'centered' => true, 'icon' => null, 'badge' => null])

<div class="{{ $centered ? 'text-center' : '' }} mb-12">
    @if($badge)
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-bold uppercase tracking-wider mb-4">
            {{ $badge }}
        </div>
    @endif

    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight flex items-center {{ $centered ? 'justify-center' : '' }} gap-3">
        @if($icon && !$badge)
            <span class="text-emerald-600 w-8 h-8">
                {!! $icon !!}
            </span>
        @endif
        {{ $title }}
    </h2>
    
    @if($subtitle)
        <p class="text-gray-600 text-lg leading-relaxed max-w-2xl {{ $centered ? 'mx-auto' : '' }}">
            {{ $subtitle }}
        </p>
    @endif
</div>
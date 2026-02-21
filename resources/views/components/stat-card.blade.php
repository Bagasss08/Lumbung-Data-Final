@props(['icon' => null, 'label', 'value', 'unit' => '', 'color' => 'emerald'])

@php
    // Mapping warna untuk border, background ikon, dan teks
    $theme = match($color) {
        'blue' => [
            'border' => 'border-blue-200', 
            'bg_icon' => 'bg-blue-50', 
            'text_icon' => 'text-blue-600',
            'text_unit' => 'text-blue-600',
            'decoration' => 'bg-blue-50'
        ],
        'amber' => [
            'border' => 'border-amber-200', 
            'bg_icon' => 'bg-amber-50', 
            'text_icon' => 'text-amber-600',
            'text_unit' => 'text-amber-600',
            'decoration' => 'bg-amber-50'
        ],
        'rose' => [
            'border' => 'border-rose-200', 
            'bg_icon' => 'bg-rose-50', 
            'text_icon' => 'text-rose-600',
            'text_unit' => 'text-rose-600',
            'decoration' => 'bg-rose-50'
        ],
        'purple' => [
            'border' => 'border-purple-200', 
            'bg_icon' => 'bg-purple-50', 
            'text_icon' => 'text-purple-600',
            'text_unit' => 'text-purple-600',
            'decoration' => 'bg-purple-50'
        ],
        default => [
            'border' => 'border-emerald-200', 
            'bg_icon' => 'bg-emerald-50', 
            'text_icon' => 'text-emerald-600',
            'text_unit' => 'text-emerald-600',
            'decoration' => 'bg-emerald-50'
        ],
    };
@endphp

<div class="relative p-6 bg-white rounded-3xl border {{ $theme['border'] }} shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden group h-full flex flex-col justify-between">
    
    {{-- Dekorasi Lingkaran Abstrak di Pojok Kanan Atas --}}
    <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full {{ $theme['decoration'] }} opacity-50 group-hover:scale-110 transition-transform duration-500"></div>

    {{-- Ikon --}}
    <div class="relative z-10 mb-6">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center {{ $theme['bg_icon'] }} {{ $theme['text_icon'] }}">
            <div class="w-7 h-7">
                {!! $icon ?? '' !!}
            </div>
        </div>
    </div>

    {{-- Konten Angka & Label --}}
    <div class="relative z-10">
        <h3 class="text-4xl font-extrabold text-slate-800 tracking-tight leading-none mb-2">
            {{ $value }}
        </h3>
        <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
        
        @if($unit)
            <p class="text-xs font-bold {{ $theme['text_unit'] }} mt-2 uppercase tracking-wider">{{ $unit }}</p>
        @endif
    </div>
</div>
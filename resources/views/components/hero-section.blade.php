@props(['title', 'subtitle' => null, 'image' => null, 'breadcrumb' => null])

@php
    // LOGIKA OTOMATIS: Ambil gambar kantor jika props image kosong
    if (empty($image)) {
        $identitasHero = \App\Models\IdentitasDesa::first();
        if ($identitasHero && $identitasHero->gambar_kantor && file_exists(storage_path('app/public/gambar-kantor/' . $identitasHero->gambar_kantor))) {
            $image = asset('storage/gambar-kantor/' . $identitasHero->gambar_kantor);
        }
    }
@endphp

<div class="relative bg-emerald-900 text-white py-20 lg:py-32 overflow-hidden isolate group">
    
    {{-- 1. BACKGROUND LAYER --}}
    <div class="absolute inset-0 z-0">
        @if($image)
            {{-- Gambar Background dengan Efek Zoom Halus saat Hover --}}
            <img src="{{ $image }}" 
                alt="Background" 
                class="w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-105 origin-center">
            
            {{-- Overlay Gradient Modern (Emerald Gelap -> Transparan) --}}
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/95 via-emerald-900/80 to-emerald-900/40 mix-blend-multiply"></div>
            
            {{-- Overlay Tambahan untuk Readability --}}
            <div class="absolute inset-0 bg-black/20"></div>
        @else
            {{-- Fallback Gradient jika tidak ada gambar --}}
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-950 via-emerald-900 to-teal-900"></div>
        @endif
        
        {{-- Pattern Texture Halus (Cubes) --}}
        <div class="absolute inset-0 opacity-[0.07] bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-overlay"></div>
    </div>

    {{-- 2. DEKORASI VISUAL (Glow Effect) --}}
    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-emerald-500 rounded-full blur-[100px] opacity-20 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-teal-500 rounded-full blur-[100px] opacity-20 pointer-events-none"></div>

    {{-- 3. CONTENT LAYER --}}
    <div class="relative z-10 container mx-auto px-4">
        <div class="max-w-4xl">
            
            {{-- Breadcrumb Modern --}}
            @if($breadcrumb)
                <nav class="flex flex-wrap items-center gap-2 text-sm font-medium text-emerald-200/90 mb-6 animate-fade-in-down" aria-label="Breadcrumb">
                    @foreach($breadcrumb as $item)
                        @if(!$loop->last)
                            <a href="{{ $item['url'] }}" class="hover:text-white hover:underline decoration-emerald-400 underline-offset-4 transition-all duration-200">
                                {{ $item['label'] }}
                            </a>
                            <span class="text-emerald-500/60 text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </span>
                        @else
                            <span class="text-white px-2 py-0.5 rounded-md bg-white/10 border border-white/10 text-xs tracking-wide uppercase">
                                {{ $item['label'] }}
                            </span>
                        @endif
                    @endforeach
                </nav>
            @endif

            {{-- Judul Utama --}}
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 tracking-tight leading-tight text-white drop-shadow-sm text-balance">
                {{ $title }}
            </h1>
            
            {{-- Subjudul --}}
            @if($subtitle)
                <p class="text-lg md:text-xl text-emerald-100/90 leading-relaxed max-w-3xl font-light text-balance border-l-4 border-emerald-500 pl-4">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>

    {{-- 4. BOTTOM BORDER DECORATION --}}
    <div class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-emerald-400/30 to-transparent z-20"></div>
</div>
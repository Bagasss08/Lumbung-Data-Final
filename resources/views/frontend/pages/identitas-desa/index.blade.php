@extends('layouts.app')

@section('title', 'Identitas Desa')
@section('description', 'Profil lengkap, Visi Misi, dan Identitas Resmi Desa ' . ($profil['nama_desa'] ?? ''))

@section('content')

<x-hero-section 
    title="Profil Desa"
    subtitle="Mengenal lebih dalam sejarah, visi, dan identitas resmi yang dimiliki oleh desa kami."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Identitas Desa', 'url' => '#']
    ]"
/>

<section class="py-20 bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
        <div class="absolute bottom-10 -left-10 w-72 h-72 bg-teal-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
            <div class="flex flex-col lg:flex-row">
                
                <div class="lg:w-1/2 p-8 lg:p-12 order-2 lg:order-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold uppercase tracking-wider mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Identitas Resmi
                    </div>
                    
                    <h2 class="text-3xl font-bold text-slate-800 mb-6 leading-tight">
                        Desa {{ $profil['nama_desa'] ?? 'Nama Desa' }}
                    </h2>

                    <div class="prose prose-emerald text-slate-600 leading-relaxed mb-8">
                        <p>{{ $deskripsi ?? 'Deskripsi desa belum tersedia.' }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-center gap-4 p-4 rounded-2xl border border-slate-100 bg-slate-50 hover:bg-white hover:border-emerald-100 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-0.5">Ponsel / WhatsApp</p>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil['ponsel_desa'] ?? '') }}" target="_blank" class="text-slate-800 font-semibold hover:text-emerald-600 transition text-sm">
                                    {{ $profil['ponsel_desa'] ?? '-' }}
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 p-4 rounded-2xl border border-slate-100 bg-slate-50 hover:bg-white hover:border-emerald-100 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-0.5">Lokasi</p>
                                <p class="text-slate-800 font-semibold text-sm">{{ ($profil['kecamatan'] ?? '-') . ', ' . ($profil['kabupaten'] ?? '-') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 p-4 rounded-2xl border border-slate-100 bg-slate-50 hover:bg-white hover:border-emerald-100 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-0.5">Email Resmi</p>
                                <a href="mailto:{{ $profil['email_desa'] ?? '#' }}" class="text-slate-800 font-semibold hover:text-emerald-600 transition text-sm truncate block max-w-[150px]">{{ $profil['email_desa'] ?? '-' }}</a>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 p-4 rounded-2xl border border-slate-100 bg-slate-50 hover:bg-white hover:border-emerald-100 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-0.5">Telepon</p>
                                <a href="tel:{{ $profil['telepon_desa'] ?? '#' }}" class="text-slate-800 font-semibold hover:text-emerald-600 transition text-sm">{{ $profil['telepon_desa'] ?? '-' }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/2 relative order-1 lg:order-2 h-64 lg:h-auto min-h-[400px]">
                    <img src="{{ $profil['gambar_kantor'] }}" alt="Kantor Desa" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-md rounded-xl text-white border border-white/30">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span class="text-sm font-medium">Kantor Pemerintahan Desa</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4">Visi & Misi</h2>
            <p class="text-slate-600 max-w-2xl mx-auto">Arah dan tujuan pembangunan desa menuju masyarakat yang maju, mandiri, dan sejahtera.</p>
        </div>

        <div class="space-y-8">
            <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl p-8 md:p-12 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 opacity-10 transform translate-x-4 -translate-y-4">
                    <svg class="w-48 h-48 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
                </div>
                
                <div class="relative z-10">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-white text-xs font-bold uppercase tracking-wider mb-6 border border-white/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Visi Desa
                    </div>
                    <h3 class="text-2xl md:text-4xl font-bold text-white leading-tight mb-4 text-center md:text-left">
                        "{{ $visiMisi['visi'] ?? 'Visi belum diatur' }}"
                    </h3>
                </div>
            </div>

            <div class="bg-slate-50 rounded-3xl p-8 md:p-12 border border-slate-100">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase tracking-wider mb-8">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Misi Desa
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($visiMisi['misi'] ?? [] as $index => $item)
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex gap-4 hover:shadow-md transition group">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <p class="text-slate-700 font-medium leading-relaxed pt-2">
                                {{ $item }}
                            </p>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-8 text-slate-500 italic bg-white rounded-2xl border border-dashed border-slate-200">
                            Data misi belum tersedia.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

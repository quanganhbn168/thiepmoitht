@extends('layouts.app')
{{-- Template Name: Royal Fine Art (Sang Trọng Cổ Điển) --}}

@section('title', 'The Wedding of ' . $wedding->groom_name . ' & ' . $wedding->bride_name)
@section('og_image', $shareUrl)

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Great+Vibes&display=swap');
    
    :root {
        --paper-bg: #f9f7f2;
        --ink-color: #4a403a;
        --gold-accent: #c0a062;

        /* Theming for Shared Components */
        --color-primary: #c0a062;
        --color-primary-dark: #8c7355;
        --color-primary-light: #f9f7f2;
        --color-bg-secondary: #f9f7f2;
        --color-text-body: #4a403a;
        --bg-paper: #ffffff;
        --bg-input: #fdfdfc;
        --font-heading: 'Cormorant Garamond', serif;
        --font-body: 'Cormorant Garamond', serif; /* Elegant uses serif everywhere */
        --radius-box: 0px; /* Sharp corners for elegant feel */
        --shadow-box: 0 4px 6px -1px rgba(0, 0, 0, 0.05);    }

    body { font-family: 'Cormorant Garamond', serif; background-color: var(--paper-bg); color: var(--ink-color); }
    h1, h2, h3 { font-weight: 400; }
    .font-script { font-family: 'Great Vibes', cursive; }

    /* Classic Double Border */
    .royal-border {
        border: 1px solid var(--gold-accent);
        padding: 4px;
        position: relative;
    }
    .royal-border::before {
        content: '';
        position: absolute;
        top: -6px; left: -6px; right: -6px; bottom: -6px;
        border: 1px solid var(--gold-accent);
        opacity: 0.5;
        pointer-events: none;
    }

    /* Paper Texture Overlay (Lightweight) */
    .bg-texture {
        background-color: #f9f7f2;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%239C92AC' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    .divider-h {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 2rem 0;
        color: var(--gold-accent);
    }
    .divider-h::before, .divider-h::after {
        content: '';
        flex: 1;
        height: 1px;
        background: currentColor;
        margin: 0 1rem;
        opacity: 0.5;
    }
    .divider-h span {  font-size: 1.5rem; }
    
    /* Premium Animations */
    @keyframes floatOrnament { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-10px) rotate(3deg); } }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes shimmerGold { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
    @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.03); } }
    
    .animate-float { animation: floatOrnament 5s ease-in-out infinite; }
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; }
    .animate-shimmer { background: linear-gradient(90deg, var(--gold-accent), #e8d9a0, var(--gold-accent)); background-size: 200% 100%; animation: shimmerGold 3s infinite; -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .animate-pulse { animation: pulse 2s ease-in-out infinite; }
    
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-500 { animation-delay: 0.5s; }
    
    /* Floating Ornaments */
    .floating-ornament { position: absolute; opacity: 0.3; animation: floatOrnament 6s ease-in-out infinite; pointer-events: none; z-index: 5; font-size: 18px; }
    
    /* Hover Effects */
    .hover-lift { transition: all 0.4s ease; }
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(192,160,98,0.2); }

</style>

<div class="max-w-[480px] mx-auto bg-white min-h-screen shadow-2xl relative text-gray-800">
    
    {{-- Pro Features: Preload Animation & Falling Effects --}}
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'traditional'])
    
    {{-- Invitation Wrapper (Envelope) --}}
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" />
    @endif
    
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    
    {{-- Music Player --}}
    <x-wedding.music-player :wedding="$wedding" />

    {{-- HERO SECTION --}}
    <section class="min-h-screen flex flex-col items-center justify-center p-8 relative overflow-hidden bg-[#f0fdf4]">
        <div class="absolute inset-0 z-0 opacity-50">
             <img src="{{ $heroUrl }}" class="w-full h-full object-cover">
             <div class="absolute inset-0 bg-white/60"></div>
        </div>

        <div class="relative z-10 w-full mt-auto bg-white/80 backdrop-blur-[2px] p-8 shadow-sm royal-border">
            <p class="uppercase tracking-[0.3em] text-xs text-[#c0a062] mb-4">The Wedding Of</p>
            <h1 class="text-5xl mb-2">{{ $wedding->groom_name }}</h1>
            <span class="font-script text-4xl text-[#c0a062] block my-2">&</span>
            <h1 class="text-5xl mb-8">{{ $wedding->bride_name }}</h1>
            
            <div class="w-24 h-[1px] bg-[#c0a062] mx-auto mb-4 opacity-50"></div>
            <p class="text-xl italic">{{ $wedding->event_date?->format('l, F d, Y') }}</p>
            @if($wedding->event_date_lunar)
            <p class="text-sm italic text-gray-500 mt-1">({{ $wedding->event_date_lunar }})</p>
            @endif
        </div>
    </section>

    {{-- QUOTE --}}
    <section class="py-12 px-8 text-center">
        <span class="text-6xl text-[#c0a062] opacity-30 block font-serif">“</span>
        <p class="text-2xl font-script leading-relaxed text-[#5d544f] -mt-4">
             Yêu nhau không phải là nhìn nhau, mà là cùng nhau nhìn về một hướng.
        </p>
        <div class="divider-h"><span>❦</span></div>
    </section>

    {{-- COUPLE --}}
    <section class="py-12 px-6">
        <div class="space-y-12">
            {{-- Groom --}}
            <div class="text-center">
                <div class="w-48 h-64 mx-auto mb-6 p-2 border border-[#c0a062] bg-white shadow-lg rotate-1">
                    {{-- Full Color --}}
                    <img src="{{ $groomPhoto }}" class="w-full h-full object-cover">
                </div>
                <h3 class="text-3xl mb-1">{{ $wedding->groom_name }}</h3>
                <p class="text-[#c0a062] text-xs uppercase tracking-widest mb-4">The Groom</p>
                <div class="text-sm italic text-gray-600">
                    @if($wedding->groom_father)<p>Con ông {{ $wedding->groom_father }}</p>@endif
                    @if($wedding->groom_mother)<p>& bà {{ $wedding->groom_mother }}</p>@endif
                </div>
            </div>

            {{-- Bride --}}
             <div class="text-center">
                <div class="w-48 h-64 mx-auto mb-6 p-2 border border-[#c0a062] bg-white shadow-lg -rotate-1">
                    {{-- Full Color --}}
                    <img src="{{ $bridePhoto }}" class="w-full h-full object-cover">
                </div>
                <h3 class="text-3xl mb-1">{{ $wedding->bride_name }}</h3>
                 <p class="text-[#c0a062] text-xs uppercase tracking-widest mb-4">The Bride</p>
                <div class="text-sm italic text-gray-600">
                    @if($wedding->bride_father)<p>Con ông {{ $wedding->bride_father }}</p>@endif
                    @if($wedding->bride_mother)<p>& bà {{ $wedding->bride_mother }}</p>@endif
                </div>
            </div>
        </div>
    </section>

    {{-- COUNTDOWN --}}
    @if($wedding->event_date && $wedding->event_date->isFuture())
    <section class="py-12 px-6 bg-[#f2ece4] text-center border-y border-[#e6dfd5]">
        <h2 class="text-3xl mb-8 italic">Save the Date</h2>
        <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="flex justify-center gap-8 font-serif">
            <div>
                <span x-text="days" class="text-4xl block"></span>
                <span class="text-xs uppercase tracking-widest text-[#c0a062]">Days</span>
            </div>
            <div>
                <span x-text="hours" class="text-4xl block"></span>
                <span class="text-xs uppercase tracking-widest text-[#c0a062]">Hours</span>
            </div>
            <div>
                <span x-text="minutes" class="text-4xl block"></span>
                <span class="text-xs uppercase tracking-widest text-[#c0a062]">Mins</span>
            </div>
        </div>
    </section>
    @endif

    {{-- EVENTS --}}
    <section class="py-16 px-6">
        <h2 class="text-center text-4xl mb-12 font-script text-[#c0a062]">Trân trọng kính mời</h2>

        <div class="space-y-12">
            {{-- Card Nhà Gái --}}
            <div class="bg-white p-6 shadow-lg border-t-4 border-[#c0a062] relative">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-4">
                     <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#c0a062]">Nhà Gái</span>
                </div>
                
                <div class="text-center space-y-6">
                    @if($wedding->bride_reception_time)
                    <div>
                         <p class="font-bold text-lg mb-1">Tiệc Cưới</p>
                         <p class="text-3xl italic text-[#4a403a]">{{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }}</p>
                         <p class="text-sm text-gray-500 mt-2">{{ $wedding->bride_reception_venue }}</p>
                    </div>
                    <div class="w-12 h-px bg-gray-200 mx-auto"></div>
                    @endif

                    <div>
                        <p class="font-bold text-lg mb-1">Lễ Vu Quy</p>
                         <p class="text-3xl italic text-[#4a403a] mb-2">{{ $wedding->bride_ceremony_time ? \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') : '--' }}</p>
                         <p class="text-sm font-bold uppercase tracking-widest text-gray-400">{{ $wedding->bride_ceremony_date ? \Carbon\Carbon::parse($wedding->bride_ceremony_date)->format('d . m . Y') : '' }}</p>
                         <p class="text-sm text-gray-500 mt-4">{{ $wedding->bride_address }}</p>
                         @if($wedding->bride_map_url)
                         <a href="{{ $wedding->bride_map_url }}" target="_blank" class="inline-block mt-4 text-[#c0a062] border-b border-[#c0a062] text-xs uppercase pb-1 tracking-widest hover:text-[#4a403a] transition">Xem Bản Đồ</a>
                         @endif
                    </div>
                </div>
            </div>

            {{-- Card Nhà Trai --}}
            <div class="bg-white p-6 shadow-lg border-t-4 border-[#c0a062] relative">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-4">
                     <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#c0a062]">Nhà Trai</span>
                </div>
                
                <div class="text-center space-y-6">
                    @if($wedding->groom_reception_time)
                    <div>
                         <p class="font-bold text-lg mb-1">Tiệc Cưới</p>
                         <p class="text-3xl italic text-[#4a403a]">{{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }}</p>
                         <p class="text-sm text-gray-500 mt-2">{{ $wedding->groom_reception_venue }}</p>
                    </div>
                    <div class="w-12 h-px bg-gray-200 mx-auto"></div>
                    @endif

                    <div>
                        <p class="font-bold text-lg mb-1">Lễ Thành Hôn</p>
                         <p class="text-3xl italic text-[#4a403a] mb-2">{{ $wedding->groom_ceremony_time ? \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') : '--' }}</p>
                         <p class="text-sm font-bold uppercase tracking-widest text-gray-400">{{ $wedding->groom_ceremony_date ? \Carbon\Carbon::parse($wedding->groom_ceremony_date)->format('d . m . Y') : '' }}</p>
                         <p class="text-sm text-gray-500 mt-4">{{ $wedding->groom_address }}</p>
                         @if($wedding->groom_map_url)
                         <a href="{{ $wedding->groom_map_url }}" target="_blank" class="inline-block mt-4 text-[#c0a062] border-b border-[#c0a062] text-xs uppercase pb-1 tracking-widest hover:text-[#4a403a] transition">Xem Bản Đồ</a>
                         @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- RSVP & WISHES (Clean standardized components) --}}
    @include('components.wedding.rsvp-form', ['wedding' => $wedding])
    
    @include('components.wedding.guestbook', ['wedding' => $wedding])

    {{-- GIFT BOX (QR Codes) --}}
    <x-wedding.gift-box :wedding="$wedding" class="py-16 px-6 bg-[#eae4dc]">
        <div class="bg-[#f9f7f2] p-8 border border-[#d8d0c5] text-center shadow-2xl relative">
            <div class="absolute top-4 left-4 border-t border-l border-[#c0a062] w-8 h-8"></div>
            <div class="absolute top-4 right-4 border-t border-r border-[#c0a062] w-8 h-8"></div>
            <div class="absolute bottom-4 left-4 border-b border-l border-[#c0a062] w-8 h-8"></div>
            <div class="absolute bottom-4 right-4 border-b border-r border-[#c0a062] w-8 h-8"></div>
            
            <h2 class="text-3xl font-script mb-8 text-[#c0a062]">Hộp Mừng Cưới</h2>
            
            <div class="flex justify-center gap-4 mb-8">
                <button @click="showQr = 'groom'" class="bg-white border border-[#eae4dc] py-3 px-6 text-sm uppercase tracking-widest hover:bg-[#c0a062] hover:text-white transition">Nhà Trai</button>
                <button @click="showQr = 'bride'" class="bg-white border border-[#eae4dc] py-3 px-6 text-sm uppercase tracking-widest hover:bg-[#c0a062] hover:text-white transition">Nhà Gái</button>
            </div>
        </div>
    </x-wedding.gift-box>

    {{-- GALLERY --}}
    <section class="py-16 px-4 bg-white">
        <h2 class="text-center text-4xl font-script mb-12 text-[#c0a062]">Những Khoảnh Khắc Đẹp</h2>
        <div class="columns-2 gap-4 space-y-4">
            @if($wedding->gallery_images->isNotEmpty())
                @foreach($wedding->gallery_images as $media)
                <div class="break-inside-avoid p-2 bg-white border border-[#eae4dc] shadow-md">
                    <img src="{{ $media->getUrl() }}" class="w-full h-auto">
                </div>
                @endforeach
            @else
                {{-- Placeholder gallery for demo --}}
                @foreach(['https://images.unsplash.com/photo-1519741497674-611481863552?w=600', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=600', 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=600', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=600', 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=600', 'https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=600'] as $placeholder)
                <div class="break-inside-avoid p-2 bg-white border border-[#eae4dc] shadow-md">
                    <img src="{{ $placeholder }}" class="w-full h-auto">
                </div>
                @endforeach
            @endif
        </div>
    </section>

    <footer class="py-16 text-center bg-[#f9f7f2] border-t border-[#eae4dc]">
        <h2 class="font-script text-5xl mb-4 text-[#c0a062]">Thank You</h2>
        <p class="uppercase tracking-widest text-xs">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</p>
    </footer>
</div>

@push('scripts')
    <x-wedding.countdown-script />
@endpush
@endsection

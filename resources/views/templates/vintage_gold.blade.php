@extends('layouts.app')
{{-- Template Name: Vintage Gold (Cổ Điển Sang Trọng) --}}
{{-- Tier: pro --}}

@section('title', 'Happy Wedding - ' . $wedding->groom_name . ' & ' . $wedding->bride_name)
@section('og_image', $shareUrl)

@section('content')

@php
    $galleryImages = $wedding->gallery_images;
    $imagesToDisplay = $galleryImages->isNotEmpty() ? $galleryImages->map->getUrl() : [
        'https://images.unsplash.com/photo-1519741497674-611481863552?w=800',
        'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800',
        'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=800'
    ];
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@300;400;600&display=swap');

    :root {
        --vintage-cream: #FDFBF7;
        --vintage-gold: #C5A059;
        --vintage-gold-dark: #8E6E36;
        --vintage-accent: #5D4037;
        --font-script: 'Great Vibes', cursive;
        --font-serif: 'Playfair Display', serif;
        --font-sans: 'Montserrat', sans-serif;
    }

    body {
        background-color: var(--vintage-cream);
        color: var(--vintage-accent);
        font-family: var(--font-sans);
    }

    .vintage-border {
        position: relative;
        border: 2px solid var(--vintage-gold);
        margin: 10px;
        padding: 20px;
    }

    .vintage-border::before {
        content: '';
        position: absolute;
        top: 5px; left: 5px; right: 5px; bottom: 5px;
        border: 1px solid var(--vintage-gold);
        pointer-events: none;
    }

    .font-script { font-family: var(--font-script); }
    .font-serif { font-family: var(--font-serif); }
    .text-gold { color: var(--vintage-gold); }

    .hero-mask {
        mask-image: url('https://www.transparenttextures.com/patterns/aged-paper.png');
    }

    @keyframes slowZoom {
        from { transform: scale(1); }
        to { transform: scale(1.1); }
    }

    .animate-slow-zoom {
        animation: slowZoom 10s ease-in-out infinite alternate;
    }

    .btn-vintage {
        background: var(--vintage-gold);
        color: white !important;
        border: none;
        padding: 12px 30px;
        font-family: var(--font-serif);
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(197, 160, 89, 0.3);
    }

    .btn-vintage:hover {
        background: var(--vintage-gold-dark);
        transform: translateY(-2px);
    }
</style>

<div class="max-w-[480px] mx-auto bg-[#FDFBF7] min-h-screen shadow-2xl relative overflow-hidden border-x-[12px] border-[#C5A059]">
    
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'swirl'])
    
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" />
    @endif
    
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    
    <x-wedding.music-player :wedding="$wedding" />

    {{-- HERO --}}
    <section class="h-screen relative flex flex-col items-center justify-center px-10 text-center">
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img src="{{ $heroUrl }}" class="w-full h-full object-cover animate-slow-zoom grayscale-[20%] sepia-[20%]">
            <div class="absolute inset-0 bg-black/40"></div>
        </div>

        <div class="relative z-10 text-white">
            {{-- Ornament Top --}}
            <div class="mb-8 opacity-60" data-aos="fade-down">
                <svg viewBox="0 0 100 20" class="w-32 mx-auto fill-[#C5A059]">
                    <path d="M0,10 Q25,0 50,10 Q75,20 100,10 L100,11 Q75,21 50,11 Q25,1 0,11 Z" />
                </svg>
            </div>

            <p class="text-sm tracking-[0.5em] uppercase mb-6 font-light opacity-80" data-aos="fade-down">The Wedding Of</p>
            <h1 class="font-script text-7xl mb-4 text-[#C5A059]" data-aos="zoom-in">{{ $wedding->groom_name }}</h1>
            <p class="font-script text-4xl mb-4" data-aos="zoom-in" data-aos-delay="200">&</p>
            <h1 class="font-script text-7xl mb-12 text-[#C5A059]" data-aos="zoom-in" data-aos-delay="400">{{ $wedding->bride_name }}</h1>
            
            <div class="border-y border-white/30 py-4 inline-block px-10" data-aos="fade-up">
                <p class="font-serif text-3xl tracking-widest">{{ $wedding->event_date?->format('d . m . Y') }}</p>
            </div>

            {{-- Ornament Bottom --}}
            <div class="mt-8 opacity-60" data-aos="fade-up">
                <svg viewBox="0 0 100 20" class="w-32 mx-auto fill-[#C5A059] rotate-180">
                    <path d="M0,10 Q25,0 50,10 Q75,20 100,10 L100,11 Q75,21 50,11 Q25,1 0,11 Z" />
                </svg>
            </div>
        </div>
        
        <div class="absolute bottom-10 animate-bounce text-white/50">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
        </div>
    </section>

    {{-- INTRO --}}
    <section class="py-20 px-8 text-center bg-[#FDFBF7]">
        <div class="vintage-border" data-aos="fade-up">
            <p class="font-serif italic text-lg mb-8 leading-relaxed">
                "Hạnh phúc không phải là một điểm đến, mà là một hành trình chúng ta cùng nhau đi."
            </p>
            <div class="w-12 h-0.5 bg-[#C5A059] mx-auto"></div>
        </div>
    </section>

    {{-- COUPLE --}}
    <section class="py-16 px-8 space-y-16">
        <div class="text-center" data-aos="fade-right">
            <div class="relative w-48 h-64 mx-auto mb-6">
                <div class="absolute inset-0 border-2 border-[#C5A059] rotate-3"></div>
                <img src="{{ $groomPhoto }}" class="absolute inset-0 w-full h-full object-cover border-4 border-white shadow-xl">
            </div>
            <h3 class="font-serif text-3xl text-[#5D4037] mb-2 uppercase tracking-widest">{{ $wedding->groom_name }}</h3>
            <div class="text-sm text-[#8E6E36] font-serif italic">
                @if($wedding->groom_father)<p>Con ông: {{ $wedding->groom_father }}</p>@endif
                @if($wedding->groom_mother)<p>Con bà: {{ $wedding->groom_mother }}</p>@endif
            </div>
        </div>

        <div class="text-center" data-aos="fade-left">
            <div class="relative w-48 h-64 mx-auto mb-6">
                <div class="absolute inset-0 border-2 border-[#C5A059] -rotate-3"></div>
                <img src="{{ $bridePhoto }}" class="absolute inset-0 w-full h-full object-cover border-4 border-white shadow-xl">
            </div>
            <h3 class="font-serif text-3xl text-[#5D4037] mb-2 uppercase tracking-widest">{{ $wedding->bride_name }}</h3>
            <div class="text-sm text-[#8E6E36] font-serif italic">
                @if($wedding->bride_father)<p>Con ông: {{ $wedding->bride_father }}</p>@endif
                @if($wedding->bride_mother)<p>Con bà: {{ $wedding->bride_mother }}</p>@endif
            </div>
        </div>
    </section>

    {{-- EVENTS --}}
    <section class="py-20 px-8 bg-[#F4EFE6] relative">
        <h2 class="font-script text-5xl text-center text-[#8E6E36] mb-12">Chương Trình Hôn Lễ</h2>
        
        <div class="space-y-10">
            <div class="text-center p-8 bg-white shadow-sm border border-[#C5A059]/20" data-aos="fade-up">
                <h3 class="font-serif text-xl font-bold mb-4 border-b border-[#C5A059] pb-2 inline-block">Lễ Vu Quy</h3>
                <p class="text-2xl font-serif text-[#C5A059] mb-2">{{ \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') }}</p>
                <p class="text-gray-600 mb-4">{{ $wedding->bride_ceremony_date?->format('d/m/Y') }}</p>
                <p class="text-sm italic">{{ $wedding->bride_address }}</p>
            </div>

            <div class="text-center p-8 bg-white shadow-sm border border-[#C5A059]/20" data-aos="fade-up" data-aos-delay="200">
                <h3 class="font-serif text-xl font-bold mb-4 border-b border-[#C5A059] pb-2 inline-block">Lễ Thành Hôn</h3>
                <p class="text-2xl font-serif text-[#C5A059] mb-2">{{ \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') }}</p>
                <p class="text-gray-600 mb-4">{{ $wedding->groom_ceremony_date?->format('d/m/Y') }}</p>
                <p class="text-sm italic">{{ $wedding->groom_address }}</p>
            </div>
        </div>
    </section>

    {{-- GALLERY --}}
    <section class="py-20 px-4 bg-[#FDFBF7]">
        <h2 class="font-script text-5xl text-center text-[#8E6E36] mb-12">Gallery</h2>
        <div class="columns-2 gap-4 space-y-4">
            @foreach($imagesToDisplay as $img)
            <div class="break-inside-avoid border-4 border-white shadow-lg overflow-hidden" data-aos="zoom-in">
                <img src="{{ $img }}" class="w-full h-auto grayscale-[20%] hover:grayscale-0 transition-all duration-700">
            </div>
            @endforeach
        </div>
    </section>

    {{-- RSVP --}}
    @include('components.wedding.rsvp-form', ['wedding' => $wedding])

    {{-- GIFT BOX --}}
    <x-wedding.gift-box :wedding="$wedding" class="py-20 px-8 bg-[#F4EFE6] text-center">
        <h2 class="font-script text-5xl text-[#8E6E36] mb-8">Hộp Mừng Cưới</h2>
        <div class="space-y-4">
            <button @click="showQr = 'groom'" class="btn-vintage w-full">Mừng Cưới Chú Rể</button>
            <button @click="showQr = 'bride'" class="btn-vintage w-full">Mừng Cưới Cô Gái</button>
        </div>
    </x-wedding.gift-box>

    {{-- GUESTBOOK --}}
    @include('components.wedding.guestbook', ['wedding' => $wedding])

    {{-- FOOTER --}}
    <footer class="py-32 bg-[#5D4037] text-white text-center px-8 relative">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/aged-paper.png')]"></div>
        <h2 class="font-script text-6xl mb-8 text-[#C5A059]">Trân Trọng Cảm Ơn</h2>
        <p class="font-serif italic opacity-80 mb-12">Sự hiện diện của quý khách là niềm hạnh phúc của gia đình chúng tôi</p>
        <div class="font-serif uppercase tracking-[0.3em] text-sm opacity-60">
            {{ $wedding->groom_name }} & {{ $wedding->bride_name }}
        </div>
    </footer>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if(typeof AOS !== 'undefined') {
            AOS.init({ duration: 1000, once: true });
        }
    });
</script>

@endsection

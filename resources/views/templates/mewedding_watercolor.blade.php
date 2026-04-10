@extends('layouts.app')
{{-- Template Name: MeWedding Watercolor (Clone of mewedding.online style) --}}

@section('title', 'The Wedding of ' . $wedding->groom_name . ' & ' . $wedding->bride_name)
@section('og_image', $shareUrl)

@section('content')


<!-- Swiper -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
    @font-face {
        font-family: 'utm-viceroyjf';
        src: url('{{ asset('fonts/utm-viceroyjf.ttf') }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
    @font-face {
        font-family: 'vni-ambiance';
        src: url('{{ asset('fonts/vni-ambiancebtswash.ttf') }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Quicksand:wght@300;400;500;600;700&family=Noto+Serif:ital,wght@0,400;0,700;1,400&display=swap');
    
    :root {
        --color-primary: rgb(187, 106, 7);
        --color-primary-dark: #A88B4A;
        --color-primary-light: #E8D5B5;
        --color-bg-main: #FFFFFF;
        --color-bg-cream: #FDF9F3;
        --color-text-dark: #545353;
        --color-text-body: #6B7280;
        
        --font-viceroy: 'utm-viceroyjf', cursive;
        --font-script: 'Dancing Script', cursive;
        --font-body: 'Quicksand', sans-serif;
        --font-serif: 'Noto Serif', serif;
        
        --radius-box: 16px;
    }

    body { 
        font-family: var(--font-body); 
        background-color: var(--color-bg-main); 
        color: var(--color-text-dark); 
    }
    
    .font-viceroy { font-family: var(--font-viceroy); }
    .font-ambiance { font-family: 'vni-ambiance'; }
    .font-script { font-family: var(--font-script); }
    .font-serif { font-family: var(--font-serif); }
    
    .text-gold { color: var(--color-primary); }
    .bg-gold { background-color: var(--color-primary); }
    .text-brown { color: #8B4513; }
    .bg-brown { background-color: #8B4513; }
    .bg-cream { background-color: var(--color-bg-cream); }
    
    .bg-main-watercolor {
        background-image: url('{{ asset('images/back-ground-1.png') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    /* Watercolor floral overlay */
    .watercolor-overlay {
        position: relative;
    }
    
    .watercolor-overlay::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: url('{{ asset('images/back-ground-1.png') }}');
        background-size: cover;
        opacity: 0.1;
        pointer-events: none;
    }
    
    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }
    
    .animate-fade-in-up { animation: fadeInUp 1s ease-out forwards; }
    .animate-fade-in { animation: fadeIn 1.2s ease-out forwards; }
    .animate-float { animation: float 4s ease-in-out infinite; }
    
    /* Card shadow */
    .card-shadow {
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    
    /* Decorative separator */
    .separator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }
    .separator::before, .separator::after {
        content: '';
        width: 60px;
        height: 1px;
        background: linear-gradient(to right, transparent, var(--color-primary), transparent);
    }
    
    .btn-gold-premium {
        background: linear-gradient(135deg, var(--color-primary) 0%, #A88B4A 100%);
        color: white !important;
        box-shadow: 0 10px 20px -5px rgba(187, 106, 7, 0.4);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .btn-gold-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px -5px rgba(187, 106, 7, 0.5);
        filter: brightness(1.1);
    }
    .btn-brown-premium {
        background: linear-gradient(135deg, #8B4513 0%, #5D2E0A 100%);
        color: white !important;
        box-shadow: 0 10px 20px -5px rgba(139, 69, 19, 0.4);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .btn-brown-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px -5px rgba(139, 69, 19, 0.5);
        filter: brightness(1.1);
    }

    /* Custom Swiper */
    .swiper-button-next, .swiper-button-prev {
        color: var(--color-primary);
        background: rgba(255, 255, 255, 0.8);
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }
    .swiper-button-next:after, .swiper-button-prev:after {
        font-size: 18px;
        font-weight: bold;
    }

    .gallery-thumbs .swiper-slide {
        opacity: 0.4;
        transition: opacity 0.3s;
    }
    .gallery-thumbs .swiper-slide-thumb-active {
        opacity: 1;
        border: 2px solid var(--color-primary);
        border-radius: 8px;
    }
    
    .floral-decoration {
        position: absolute;
        width: 120px;
        z-index: 10;
        pointer-events: none;
    }
    .floral-top-left { top: -20px; left: -20px; transform: rotate(0deg); }
    .floral-bottom-right { bottom: -20px; right: -20px; transform: rotate(180deg); }
    .portrait-hover {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .portrait-hover:hover {
        transform: scale(1.05);
        filter: brightness(1.05);
        box-shadow: 0 15px 30px -5px rgba(0,0,0,0.15);
    }
    .text-shadow-gold {
        text-shadow: 2px 2px 4px rgba(187, 106, 7, 0.15);
    }
</style>

<div class="max-w-[480px] mx-auto bg-white min-h-screen shadow-2xl relative overflow-hidden">
    
    {{-- Pro Features --}}
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'heartbeat'])
    
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" style="envelope" />
    @endif
    
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    
    <x-wedding.music-player :wedding="$wedding" />

    {{-- SECTION 1: HERO / INTRO --}}
    <section class="min-h-screen relative flex flex-col justify-center items-center px-6 py-12 bg-cream watercolor-overlay">
        <div class="text-center" data-aos="fade-up">
            <p class="text-sm tracking-[0.3em] uppercase text-gray-500 mb-6 font-medium">Thân Mời Tới Dự Bữa Tiệc</p>
            
            <div class="mb-8 text-shadow-gold">
                <h1 class="font-viceroy text-6xl text-gold leading-tight mb-2" data-aos="fade-down">{{ $wedding->groom_name }}</h1>
                <p class="font-viceroy text-4xl text-gold" data-aos="zoom-in" data-aos-delay="200">&</p>
                <h1 class="font-viceroy text-6xl text-gold leading-tight mt-2" data-aos="fade-up" data-aos-delay="400">{{ $wedding->bride_name }}</h1>
            </div>
            
            {{-- Western Date --}}
            <div class="mb-8 text-gold font-serif text-lg tracking-widest">
                @if($wedding->event_date)
                    @php
                        $prevDate = $wedding->event_date->copy()->subDay();
                    @endphp
                    @if($prevDate->month == $wedding->event_date->month)
                        {{ $prevDate->format('d') }}-{{ $wedding->event_date->format('d/m/Y') }}
                    @else
                        {{ $prevDate->format('d/m') }}-{{ $wedding->event_date->format('d/m/Y') }}
                    @endif
                @endif
            </div>

            {{-- Couple Hero Image --}}
            <div class="relative mx-auto mb-8 max-w-[320px]">
                <div class="aspect-[3/4] rounded-t-full overflow-hidden border-8 border-white shadow-2xl">
                    <img src="{{ $heroUrl }}" class="w-full h-full object-contain bg-gray-50" alt="Couple Photo">
                </div>
            </div>
            
            <div class="separator">
                <svg class="w-6 h-6 text-gold" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
        </div>
        
        <div class="absolute bottom-12 animate-bounce text-gold opacity-60">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    {{-- SECTION 2: SAVE THE DATE --}}
    <section class="py-24 px-6 text-center relative overflow-hidden bg-main-watercolor" data-aos="fade-up">
        <div class="relative z-10 max-w-sm mx-auto">
            {{-- Date Section First - Cute Typography --}}
            <div class="mb-12" data-aos="zoom-in">
                <div class="inline-block">
                    <div class="font-viceroy text-4xl text-brown border-y-2 border-gold/20 py-4 px-8">
                        {{ $wedding->event_date?->format('d . m . Y') }}
                    </div>
                </div>
            </div>
            
            {{-- Image Section Second - Preserving Aspect Ratio --}}
            <div class="relative px-6" data-aos="fade-up" data-aos-delay="200">
                <div class="relative group">
                    {{-- Soft Glow --}}
                    <div class="absolute -inset-4 bg-gold/5 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition duration-700"></div>
                    
                    {{-- Main Image - Long aspect, no crop --}}
                    <img src="{{ asset('images/save-the-date.png') }}" 
                         class="w-full h-auto rounded-[60px] border-8 border-white shadow-2xl relative z-10 hover:scale-[1.02] transition duration-500" 
                         style="max-height: 80vh; object-fit: contain;"
                         alt="Save the Date">
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 3: GROOM & BRIDE INFO --}}
    <section class="py-20 px-6 bg-cream relative overflow-hidden">
        <div class="text-center mb-12" data-aos="zoom-in">
            <h2 class="font-viceroy text-5xl text-gold mb-4">Chú Rể & Cô Dâu</h2>
            <div class="separator">
                <svg class="w-6 h-6 text-gold" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            {{-- Groom --}}
            <div class="text-center" data-aos="fade-right">
                <div class="w-36 h-36 mx-auto mb-6 rounded-full overflow-hidden border-4 border-white shadow-xl bg-gray-50 aspect-square portrait-hover">
                    <img src="{{ $groomPhoto }}" class="w-full h-full object-cover" style="object-position: top;" alt="{{ $wedding->groom_name }}">
                </div>
                <h3 class="font-viceroy text-3xl text-brown mb-2">{{ $wedding->groom_name }}</h3>
                <div class="text-gray-600 text-[11px] space-y-1 font-medium italic">
                    @if($wedding->groom_father)<p>Con ông: <span class="not-italic font-bold text-gray-800">{{ $wedding->groom_father }}</span></p>@endif
                    @if($wedding->groom_mother)<p>Con bà: <span class="not-italic font-bold text-gray-800">{{ $wedding->groom_mother }}</span></p>@endif
                </div>
            </div>
            
            {{-- Bride --}}
            <div class="text-center" data-aos="fade-left">
                <div class="w-36 h-36 mx-auto mb-6 rounded-full overflow-hidden border-4 border-white shadow-xl bg-gray-50 aspect-square portrait-hover">
                    <img src="{{ $bridePhoto }}" class="w-full h-full object-cover" style="object-position: top;" alt="{{ $wedding->bride_name }}">
                </div>
                <h3 class="font-viceroy text-3xl text-brown mb-2">{{ $wedding->bride_name }}</h3>
                <div class="text-gray-600 text-[11px] space-y-1 font-medium italic">
                    @if($wedding->bride_father)<p>Con ông: <span class="not-italic font-bold text-gray-800">{{ $wedding->bride_father }}</span></p>@endif
                    @if($wedding->bride_mother)<p>Con bà: <span class="not-italic font-bold text-gray-800">{{ $wedding->bride_mother }}</span></p>@endif
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 4: GALLERY --}}
    <section class="py-20 px-6 bg-white relative overflow-hidden" data-aos="fade-up">
        {{-- Floral decorations --}}
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-decoration floral-top-left" alt="decor">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-decoration floral-bottom-right" alt="decor">

        <h2 class="font-viceroy text-5xl text-gold text-center mb-12">Kỷ Niệm Của Chúng Tôi</h2>
        
        <div class="space-y-12">
            {{-- Main Slider 1 --}}
            <div class="relative">
                <div class="swiper mainGallery rounded-2xl overflow-hidden aspect-[4/5] shadow-2xl">
                    <div class="swiper-wrapper">
                        @php
                            $galleryImages = $wedding->gallery_images;
                            $placeholders = [
                                'https://images.unsplash.com/photo-1519741497674-611481863552?w=800',
                                'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800',
                                'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=800',
                                'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=800'
                            ];
                            $imagesToDisplay = $galleryImages->isNotEmpty() ? $galleryImages->map->getUrl() : $placeholders;
                        @endphp
                        @foreach($imagesToDisplay as $imgUrl)
                            <div class="swiper-slide">
                                <img src="{{ $imgUrl }}" class="w-full h-full object-cover object-top">
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                {{-- Thumbs Slider 1 --}}
                <div class="swiper thumbGallery mt-4 h-24">
                    <div class="swiper-wrapper">
                        @foreach($imagesToDisplay as $imgUrl)
                            <div class="swiper-slide rounded-lg overflow-hidden cursor-pointer">
                                <img src="{{ $imgUrl }}" class="w-full h-full object-cover object-top">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Slider 2 (Secondary) --}}
            <div class="swiper secondaryGallery rounded-2xl overflow-hidden aspect-[4/5] shadow-xl" data-aos="fade-up">
                <div class="swiper-wrapper">
                    @foreach($imagesToDisplay->reverse() as $imgUrl)
                            <div class="swiper-slide">
                                <img src="{{ $imgUrl }}" class="w-full h-full object-cover object-top">
                            </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    {{-- SECTION 5: CALENDAR & COUNTDOWN --}}
    @if($wedding->event_date)
    <section class="py-20 px-6 bg-cream relative overflow-hidden bg-main-watercolor" data-aos="fade-up">
        <h2 class="font-viceroy text-5xl text-gold text-center mb-12">Lịch Cưới</h2>
        
        {{-- Calendar Card --}}
        <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 card-shadow max-w-sm mx-auto mb-12 relative">
            <div class="text-center mb-8">
                <p class="font-serif text-2xl font-bold text-gray-800 uppercase tracking-widest">
                    {{ $wedding->event_date->translatedFormat('F') }}
                </p>
                <p class="text-gold font-bold italic">Năm {{ $wedding->event_date->format('Y') }}</p>
            </div>
            
            <div class="grid grid-cols-7 gap-2 text-center">
                @foreach(['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'] as $day)
                    <div class="text-gray-400 font-bold text-xs py-2">{{ $day }}</div>
                @endforeach
                
                @php
                    $eventDay = $wedding->event_date->day;
                    $firstDayOfMonth = $wedding->event_date->copy()->startOfMonth();
                    $daysInMonth = $wedding->event_date->daysInMonth;
                    $startDayOfWeek = $firstDayOfMonth->dayOfWeek;
                @endphp
                
                @for($i = 0; $i < $startDayOfWeek; $i++)
                    <div></div>
                @endfor
                
                @for($d = 1; $d <= $daysInMonth; $d++)
                    <div class="py-3 relative flex items-center justify-center">
                        <span class="z-10 text-sm font-bold {{ $d == $eventDay ? 'text-gray-900' : 'text-gray-700' }}">{{ $d }}</span>
                        @if($d == $eventDay)
                            <div class="absolute inset-0 flex items-center justify-center p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 90" class="w-full h-full" fill="#F06464">
                                    <path d="M83.187,25.7c-0.876-2.142-2.227-3.936-3.734-5.473c-1.512-1.543-3.212-2.838-5.01-3.934  c-1.796-1.099-3.679-2.031-5.646-2.735c-3.906-1.35-8.197-2.167-12.283-1.04l-0.008,0.001c-0.947,0.268-1.895,0.566-2.84,0.918  c-0.931,0.359-1.846,0.757-2.74,1.202c-0.889,0.455-1.752,0.955-2.6,1.481c-0.84,0.542-1.647,1.132-2.423,1.764l-1.124,0.995  l-1.059,1.067l-0.996,1.126l-0.921,1.193c-0.58,0.821-1.111,1.676-1.592,2.562l-0.679,1.352l-0.292,0.681  c-2.903-2.597-6.235-4.866-10.103-6.082c-4.059-1.339-8.719-1.216-12.724,0.124c-2.091,0.676-4.112,1.535-5.939,2.934  c-1.822,1.362-3.375,3.34-4.075,5.648c-0.737,2.295-0.63,4.704-0.187,6.89c0.477,2.194,1.293,4.233,2.257,6.155  c1.947,3.839,4.461,7.246,7.16,10.438c1.345,1.604,2.764,3.131,4.208,4.629c1.437,1.501,2.978,2.938,4.371,4.349  c2.834,2.853,5.561,5.806,7.997,8.91c1.212,1.552,2.361,3.142,3.321,4.768c0.482,0.819,0.9,1.609,1.255,2.439l0.083,0.191  l0.07,0.148l0.067,0.131c0.036,0.061,0.045,0.098,0.201,0.317c0.165-0.593-0.052,2.234,3.981,0.301  c1.01-1.418,0.549-1.152,0.725-1.468c0.027-0.192,0.03-0.271,0.036-0.336l0.015-0.23c0.016-0.229,0.034-0.409,0.06-0.609  c0.052-0.392,0.132-0.793,0.233-1.2c0.85-3.307,2.979-6.579,5.398-9.51c2.456-2.947,5.269-5.682,8.227-8.283  c5.928-5.209,12.436-9.896,19.008-14.584l2.526-1.785c0.962-0.706,1.822-1.429,2.646-2.253c1.638-1.625,3.054-3.707,3.668-6.115  C84.374,30.378,84.063,27.817,83.187,25.7z M41.546,76.046l-0.026-0.053c0.006,0.011,0.011,0.021,0.017,0.03l0.023,0.046  C41.568,76.087,41.553,76.059,41.546,76.046z M80.101,31.647c-0.601,1.508-1.71,2.82-3.083,3.926  c-0.686,0.552-1.456,1.063-2.192,1.492l-0.668,0.375l-0.167,0.094c0.03-0.023-0.091,0.044-0.129,0.062l-0.346,0.177l-1.369,0.731  c-3.656,1.945-7.205,4.11-10.646,6.465c-3.432,2.367-6.761,4.924-9.895,7.755c-3.127,2.836-6.089,5.922-8.657,9.415  c-1.866,2.582-3.614,5.343-4.816,8.489c-0.723-0.96-1.469-1.887-2.236-2.788c-2.74-3.213-5.688-6.15-8.724-8.97  c-3.076-2.784-5.93-5.468-8.599-8.466c-2.651-2.961-5.097-6.115-6.939-9.519c-1.817-3.355-3.075-7.174-2.145-10.468  c0.86-3.297,4.207-5.592,7.759-6.844c1.899-0.681,3.696-1.158,5.627-1.311c1.906-0.155,3.843-0.012,5.736,0.426  c3.796,0.879,7.355,2.907,10.464,5.456l-0.111-0.135c0.045,0.077,0.117,0.15,0.194,0.195l0.462,0.275l0.28-0.467l0.005-0.01  l0.045-0.097l0.007-0.021l0.015-0.043l0.03-0.085l0.061-0.171l0.121-0.341l0.242-0.685L41,25.228  c0.425-0.871,0.901-1.716,1.426-2.533l0.84-1.191l0.919-1.134l1.011-1.057l1.079-0.987c0.746-0.628,1.525-1.217,2.34-1.76  c0.816-0.539,1.672-1.015,2.549-1.446c0.883-0.424,1.785-0.802,2.702-1.141c0.911-0.326,1.85-0.608,2.807-0.864  c1.94-0.457,3.97-0.444,5.941-0.144c1.978,0.293,3.907,0.898,5.726,1.724c3.644,1.62,6.949,4.058,9.36,7.083  c1.197,1.508,2.124,3.199,2.595,4.919C80.766,28.419,80.717,30.148,80.101,31.647z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                @endfor
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="font-serif text-lg font-bold text-gray-800">
                    {{ $wedding->event_date?->translatedFormat('l, d/m/Y') }}
                </p>
                @if($wedding->event_date_lunar)
                <p class="text-sm text-gray-500 italic mt-1">(Tức ngày {{ $wedding->event_date_lunar }} Âm Lịch)</p>
                @endif
            </div>
        </div>
        
        {{-- Countdown --}}
        <h3 class="text-center font-viceroy text-4xl text-gold mb-12">Đếm Ngược Ngày Hạnh Phúc</h3>
        <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d H:i:s') }}')" class="grid grid-cols-4 gap-4 max-w-sm mx-auto">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-4 text-center card-shadow">
                <div class="text-3xl font-bold text-gray-800" x-text="days">00</div>
                <div class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Ngày</div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-4 text-center card-shadow">
                <div class="text-3xl font-bold text-gray-800" x-text="hours">00</div>
                <div class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Giờ</div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-4 text-center card-shadow">
                <div class="text-3xl font-bold text-gray-800" x-text="minutes">00</div>
                <div class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Phút</div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-4 text-center card-shadow">
                <div class="text-3xl font-bold text-gray-800" x-text="seconds">00</div>
                <div class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Giây</div>
            </div>
        </div>
    </section>
    @endif

    {{-- SECTION 6: BLESSING / CHÚC PHÚC --}}
    <section class="py-20 px-6 bg-white relative overflow-hidden bg-main-watercolor" data-aos="fade-up" x-data="{ activeQr: null }">
        <div class="relative z-10">
            <h2 class="font-viceroy text-5xl text-gold text-center mb-6">Mừng Cưới</h2>
            <p class="text-center text-gray-700 italic mb-12 max-w-xs mx-auto font-medium">
                {{ $wedding->getContentValue('blessing_desc', "Cảm ơn tất cả tình cảm của cô dì chú bác, bạn bè và anh chị em đã dành cho " . $wedding->groom_name . " & " . $wedding->bride_name . ".") }}
            </p>

            <div class="grid grid-cols-2 gap-8">
                {{-- Groom QR Button --}}
                <div class="text-center" data-aos="fade-right">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden border-4 border-white shadow-lg flex items-center justify-center bg-gray-50 portrait-hover">
                        <img src="{{ $groomPhoto }}" class="w-full h-full object-cover" style="object-position: top;">
                    </div>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Chú Rể</p>
                    <h3 class="font-viceroy text-2xl text-brown mb-4">{{ $wedding->groom_name }}</h3>
                    
                    <button @click="activeQr = 'groom'" class="inline-flex items-center gap-2 px-8 py-3 btn-gold-premium rounded-full text-[11px] font-bold shadow-lg uppercase tracking-widest active:scale-95 group">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        <span>Mừng Cưới</span>
                    </button>
                </div>

                {{-- Bride QR Button --}}
                <div class="text-center" data-aos="fade-left">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden border-4 border-white shadow-lg flex items-center justify-center bg-gray-50 portrait-hover">
                        <img src="{{ $bridePhoto }}" class="w-full h-full object-cover" style="object-position: top;">
                    </div>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Cô Dâu</p>
                    <h3 class="font-viceroy text-2xl text-brown mb-4">{{ $wedding->bride_name }}</h3>
                    
                    <button @click="activeQr = 'bride'" class="inline-flex items-center gap-2 px-8 py-3 btn-gold-premium rounded-full text-[11px] font-bold shadow-lg uppercase tracking-widest active:scale-95 group">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        <span>Mừng Cưới</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- QR Modal Backdrop --}}
        <div x-show="activeQr" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="activeQr = null"
             class="fixed inset-0 z-[100] bg-black/80 backdrop-blur-md flex items-center justify-center p-6"
             style="display: none;">
            
            {{-- Modal Content --}}
            <div @click.stop 
                 class="bg-white rounded-[40px] p-8 max-w-xs w-full text-center relative overflow-hidden"
                 x-show="activeQr"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="scale-90 translate-y-8"
                 x-transition:enter-end="scale-100 translate-y-0">
                
                {{-- Decorative background --}}
                <div class="absolute inset-0 opacity-5 pointer-events-none">
                    <img src="{{ asset('images/back-ground-1.png') }}" class="w-full h-full object-cover">
                </div>

                {{-- Close Button --}}
                <button @click="activeQr = null" class="absolute top-4 right-4 text-gray-400 hover:text-gold transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div x-show="activeQr === 'groom'">
                    <p class="font-viceroy text-2xl text-brown mb-2">Mừng Cưới Chú Rể</p>
                    <p class="text-gold font-bold text-sm mb-6">{{ $wedding->groom_name }}</p>
                    <div class="bg-gray-50 p-4 rounded-3xl inline-block border-4 border-white shadow-inner mb-6">
                        <img src="{{ $wedding->getGroomQrUrl() }}" class="w-48 h-48 object-contain">
                    </div>
                </div>

                <div x-show="activeQr === 'bride'">
                    <p class="font-viceroy text-2xl text-brown mb-2">Mừng Cưới Cô Dâu</p>
                    <p class="text-gold font-bold text-sm mb-6">{{ $wedding->bride_name }}</p>
                    <div class="bg-gray-50 p-4 rounded-3xl inline-block border-4 border-white shadow-inner mb-6">
                        <img src="{{ $wedding->getBrideQrUrl() }}" class="w-48 h-48 object-contain">
                    </div>
                </div>

                <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest italic">Cảm ơn bạn rất nhiều! ❤️</p>
            </div>
        </div>
    </section>

    {{-- SECTION 7: STORY / LỜI NGỎ --}}
    <section class="relative py-32 px-6 overflow-hidden" data-aos="fade-up">
        <div class="absolute inset-0">
            <img src="{{ $heroUrl }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>
        </div>
        
        <div class="relative z-10 text-center text-white" data-aos="zoom-in">
            <div class="inline-block relative mb-12">
                <h2 class="font-viceroy text-6xl mb-2">Lời Ngỏ</h2>
                <div class="absolute -bottom-4 left-0 w-full h-8">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 356.13 42.62" fill="white">
                        <path d="M353.92,19.33c-33.86-1.58-67.75-2.65-101.62-3.86-34.82-1.24-69.64-2.52-104.46-3.8-33.47-1.24-66.94-2.48-100.41-3.72a4.48,4.48,0,0,0-.46,9l.46-.1c33.47,1.24,66.94,2.48,100.41,3.72,34.82,1.28,69.64,2.56,104.46,3.8,33.87,1.21,67.76,2.28,101.62,3.86a4.48,4.48,0,0,0,.46-9Z"/>
                    </svg>
                </div>
            </div>

            <div class="space-y-6 text-lg leading-relaxed max-w-md mx-auto opacity-95 font-medium">
                @if($prologue_content = $wedding->getContentValue('prologue_desc'))
                    @foreach(explode("\n", $prologue_content) as $line)
                        @if(trim($line)) <p>{{ $line }}</p> @endif
                    @endforeach
                @else
                    <p>Gặp gỡ, yêu và cưới. Điều bạn vừa nghe không nằm trong một câu chuyện cổ tích, mà chính là câu chuyện về cuộc đời hai chúng tôi.</p>
                    <p>Chúng tôi sẽ yêu thương, chăm sóc, trân trọng và nắm tay nhau cùng đi đến hết cuộc đời này.</p>
                    <p>Thật là một niềm vinh hạnh lớn khi ngày hạnh phúc nhất cuộc đời chúng tôi có sự hiện diện và chúc phúc của bạn!</p>
                @endif
                <p class="font-viceroy text-4xl text-gold pt-6">Chân thành cảm ơn bạn ♥ ♥</p>
            </div>
        </div>
    </section>

    {{-- SECTION 8: SỔ LƯU BÚT --}}
    <section id="guestbook" class="relative py-20 px-6 overflow-hidden" data-aos="fade-up">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 card-shadow border border-gold/10 text-center">
                <h2 class="font-viceroy text-4xl md:text-5xl text-brown mb-4 text-shadow-gold">
                    {{ $wedding->getContentValue('guestbook_title', 'Sổ Lưu Bút') }}
                </h2>
                <div class="w-16 h-px bg-gold mx-auto mb-6"></div>
                <p class="text-gray-600 italic mb-8 max-w-lg mx-auto">
                    {{ $wedding->getContentValue('guestbook_desc', 'Hãy để lại những lời chúc phúc tốt đẹp nhất cho chúng tôi nhé!') }}
                </p>

                {{-- Wish List (Editorial Style Swiper) --}}
                @php
                    $wishes = $wedding->approvedWishes()->latest()->take(10)->get();
                @endphp

                @if($wishes->count() > 0)
                <div class="mb-12 relative px-8">
                    <div class="swiper guestbook-slider pb-10">
                        <div class="swiper-wrapper">
                            @foreach($wishes as $wish)
                            <div class="swiper-slide">
                                <div class="text-center px-4">
                                    <div class="text-6xl font-viceroy text-gold/20 mb-4">“</div>
                                    <p class="text-xl md:text-2xl text-gray-700 italic font-serif leading-relaxed mb-6">
                                        {{ $wish->message }}
                                    </p>
                                    <div class="font-bold text-brown uppercase tracking-widest text-sm mb-1">
                                        {{ $wish->name }}
                                    </div>
                                    <div class="text-xs text-gold/80">
                                        {{ $wish->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination !bottom-0"></div>
                    </div>
                </div>
                @else
                <div class="mb-12 text-gray-400 italic">Chưa có lời chúc nào. Hãy là người đầu tiên!</div>
                @endif

                {{-- Submit Button & Form --}}
                <div x-data="{ 
                    open: false,
                    submitting: false,
                    success: false,
                    error: null,
                    formData: { name: '', message: '' },
                    async submitWish() {
                        this.submitting = true;
                        this.error = null;
                        try {
                            const response = await fetch('{{ route('wedding.wish.store', $wedding->slug) }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(this.formData)
                            });
                            if (response.ok) {
                                this.success = true;
                                this.formData = { name: '', message: '' };
                                setTimeout(() => { this.success = false; this.open = false; }, 3000);
                            } else {
                                const data = await response.json();
                                this.error = data.message || 'Có lỗi xảy ra.';
                            }
                        } catch (e) {
                            this.error = 'Lỗi kết nối mạng.';
                        } finally {
                            this.submitting = false;
                        }
                    }
                }">
                    <button @click="open = true" class="btn-gold-premium px-8 py-3 rounded-full font-bold uppercase tracking-widest text-sm shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                        Gửi Lời Chúc
                    </button>

                    {{-- Modal --}}
                    <div x-show="open" style="display: none;" 
                         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-md"
                         x-transition.opacity>
                        
                        <div class="bg-white rounded-3xl p-8 max-w-md w-full relative shadow-2xl border-4 border-gold/20" @click.outside="open = false">
                            <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gold transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            <h3 class="font-viceroy text-3xl text-brown text-center mb-6">Viết Lời Chúc</h3>

                            <div x-show="success" class="text-center py-8">
                                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Đã Gửi Thành Công!</h4>
                                <p class="text-gray-600">Cảm ơn bạn rất nhiều.</p>
                            </div>

                            <form @submit.prevent="submitWish" x-show="!success" class="space-y-4 text-left">
                                <div x-show="error" class="p-3 bg-red-50 text-red-600 text-sm rounded-lg text-center" x-text="error"></div>
                                
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Tên của bạn</label>
                                    <input type="text" x-model="formData.name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-1 focus:ring-gold outline-none transition-colors bg-gray-50/50">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Lời chúc</label>
                                    <textarea x-model="formData.message" required rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-1 focus:ring-gold outline-none transition-colors bg-gray-50/50 resize-none"></textarea>
                                </div>

                                <button type="submit" class="w-full py-4 text-white font-bold uppercase rounded-xl shadow-lg btn-gold-premium transition-all" :disabled="submitting">
                                    <span x-show="!submitting">Gửi Ngay</span>
                                    <span x-show="submitting">Đang Gửi...</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 9: SỰ KIỆN CƯỚI --}}
    <section class="py-20 px-6 bg-white relative overflow-hidden bg-main-watercolor" data-aos="fade-up">
        <h2 class="font-viceroy text-5xl text-gold text-center mb-12">Sự Kiện Cưới</h2>
        
        <div class="space-y-8 max-w-sm mx-auto">
            {{-- 1. House of Groom - Reception (Tiệc Mừng) --}}
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 card-shadow border border-gold/10" data-aos="fade-right">
                <div class="text-center mb-6">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden border-4 border-gold p-1 shadow-lg portrait-hover">
                        <img src="{{ $groomPhoto }}" class="w-full h-full object-cover object-top rounded-full">
                    </div>
                    <h3 class="font-viceroy text-2xl text-brown border-b border-gold/20 pb-2 inline-block">Tiệc Mừng Nhà Trai</h3>
                </div>
                
                <div class="space-y-4 text-gray-700 font-sans">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gold/10 rounded-full flex items-center justify-center text-gold">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase text-gray-400">Thời gian</p>
                            <p class="font-bold">{{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }} - {{ ($wedding->groom_reception_date ?? $wedding->event_date)?->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-gold/10 rounded-full flex items-center justify-center text-gold shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] font-bold uppercase text-gray-400">Địa điểm</p>
                            <p class="font-bold leading-snug">{{ $wedding->groom_reception_venue }}</p>
                            <p class="text-xs italic text-gray-500">{{ $wedding->groom_reception_address }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    @if($wedding->groom_map_url)
                    <a href="{{ $wedding->groom_map_url }}" target="_blank" class="block w-full py-4 bg-gold text-white rounded-2xl text-center font-bold shadow-lg shadow-gold/20 hover:scale-[1.02] transition">XEM BẢN ĐỒ</a>
                    @endif
                </div>
            </div>

            {{-- 2. House of Bride - Reception (Tiệc Mừng) --}}
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 card-shadow border border-gold/10" data-aos="fade-left">
                <div class="text-center mb-6">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden border-4 border-gold p-1 shadow-lg portrait-hover">
                        <img src="{{ $bridePhoto }}" class="w-full h-full object-cover object-top rounded-full">
                    </div>
                    <h3 class="font-viceroy text-2xl text-brown border-b border-gold/20 pb-2 inline-block">Tiệc Cưới Nhà Gái</h3>
                </div>
                
                <div class="space-y-4 text-gray-700 font-sans">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gold/10 rounded-full flex items-center justify-center text-gold">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase text-gray-400">Thời gian</p>
                            <p class="font-bold">{{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }} - {{ ($wedding->bride_reception_date ?? $wedding->event_date)?->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-gold/10 rounded-full flex items-center justify-center text-gold shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] font-bold uppercase text-gray-400">Địa điểm</p>
                            <p class="font-bold leading-snug">{{ $wedding->bride_reception_venue }}</p>
                            <p class="text-xs italic text-gray-500">{{ $wedding->bride_address }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    @if($wedding->bride_map_url)
                    <a href="{{ $wedding->bride_map_url }}" target="_blank" class="block w-full py-4 bg-gold text-white rounded-2xl text-center font-bold shadow-lg shadow-gold/20 hover:scale-[1.02] transition">XEM BẢN ĐỒ</a>
                    @endif
                </div>
            </div>

            {{-- 3. House of Bride - Ceremony (Lễ Vu Quy - Optional) --}}
            @if($wedding->bride_ceremony_date)
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 card-shadow border border-gold/10" data-aos="fade-left">
                <div class="text-center mb-6">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden border-4 border-gold p-1 shadow-lg portrait-hover">
                        <img src="{{ $bridePhoto }}" class="w-full h-full object-cover object-top rounded-full">
                    </div>
                    <h3 class="font-viceroy text-2xl text-brown border-b border-gold/20 pb-2 inline-block">Lễ Vu Quy</h3>
                </div>
                
                <div class="space-y-4 text-gray-700 font-sans">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gold/10 rounded-full flex items-center justify-center text-gold">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase text-gray-400">Thời gian</p>
                            <p class="font-bold">{{ \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($wedding->bride_ceremony_date)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-gold/10 rounded-full flex items-center justify-center text-gold shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] font-bold uppercase text-gray-400">Địa điểm</p>
                            <p class="font-bold leading-snug">{{ $wedding->bride_address }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- 4. House of Groom - Ceremony (Lễ Thành Hôn) --}}
            @if($wedding->groom_ceremony_date)
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 card-shadow border border-gold/10" data-aos="fade-right">
                <div class="text-center mb-6">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden border-4 border-gold p-1 shadow-lg portrait-hover">
                        <img src="{{ $groomPhoto }}" class="w-full h-full object-cover object-top rounded-full">
                    </div>
                    <h3 class="font-viceroy text-2xl text-brown border-b border-gold/20 pb-2 inline-block">Lễ Thành Hôn</h3>
                </div>
                
                <div class="space-y-4 text-gray-700 font-sans">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gold/10 rounded-full flex items-center justify-center text-gold">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase text-gray-400">Thời gian</p>
                            <p class="font-bold">{{ \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($wedding->groom_ceremony_date)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-gold/10 rounded-full flex items-center justify-center text-gold shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] font-bold uppercase text-gray-400">Địa điểm</p>
                            <p class="font-bold leading-snug">{{ $wedding->groom_address }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    {{-- SECTION 10: XÁC NHẬN THAM DỰ --}}
    <section id="rsvp" class="py-20 px-6 bg-white relative overflow-hidden" data-aos="fade-up">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 card-shadow border border-gold/10 text-center relative overflow-hidden">
                {{-- Decorative Background --}}
                <div class="absolute inset-0 opacity-5 pointer-events-none">
                    <img src="{{ asset('images/back-ground-1.png') }}" class="w-full h-full object-cover">
                </div>

                <div class="relative z-10">
                    <h2 class="font-viceroy text-4xl md:text-5xl text-brown mb-4 text-shadow-gold">Xác Nhận Tham Dự</h2>
                    <div class="w-16 h-px bg-gold mx-auto mb-6"></div>
                    <p class="text-gray-600 italic mb-10 max-w-lg mx-auto">
                        {{ $wedding->getContentValue('rsvp_desc', 'Sự hiện diện của bạn là niềm vinh hạnh của chúng tôi.') }}
                    </p>

                    <div x-data="{
                        submitting: false,
                        success: false,
                        error: null,
                        formData: {
                            name: '{{ $wedding->getGuestName() ? urldecode($wedding->getGuestName()) : '' }}',
                            phone: '',
                            attendance: 'yes',
                            guests: '1',
                            side: 'both',
                            note: ''
                        },
                        async submitRsvp() {
                            this.submitting = true;
                            this.error = null;
                            try {
                                const response = await fetch('{{ route('wedding.rsvp.store', $wedding->slug) }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify(this.formData)
                                });
                                if (response.ok) {
                                    this.success = true;
                                    setTimeout(() => { this.success = false; }, 5000);
                                } else {
                                    const data = await response.json();
                                    this.error = data.message || 'Có lỗi xảy ra, vui lòng kiểm tra lại.';
                                }
                            } catch (e) {
                                this.error = 'Lỗi kết nối mạng.';
                            } finally {
                                this.submitting = false;
                            }
                        }
                    }">
                        {{-- Success State --}}
                        <div x-show="success" class="mb-8 p-6 bg-green-50 border border-green-200 rounded-2xl animate-fade-in" style="display: none;">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <h4 class="font-bold text-gray-800 text-lg">Xác nhận thành công!</h4>
                                <p class="text-sm text-gray-600">Cảm ơn bạn, chúng tôi đã nhận được thông tin.</p>
                            </div>
                        </div>
                        
                        {{-- Form --}}
                        <form @submit.prevent="submitRsvp" x-show="!success" class="space-y-6 text-left max-w-2xl mx-auto">
                            <div x-show="error" class="p-4 bg-red-50 text-red-600 text-sm border border-red-100 rounded-xl text-center" style="display: none;" x-text="error"></div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Họ và Tên <span class="text-red-400">*</span></label>
                                    <input type="text" x-model="formData.name" required
                                        class="w-full px-4 py-3 bg-white/50 border border-gray-200 rounded-xl text-gray-900 focus:border-gold focus:ring-1 focus:ring-gold outline-none transition-all"
                                        placeholder="Nhập tên...">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Số Điện Thoại</label>
                                    <input type="tel" x-model="formData.phone"
                                        class="w-full px-4 py-3 bg-white/50 border border-gray-200 rounded-xl text-gray-900 focus:border-gold focus:ring-1 focus:ring-gold outline-none transition-all"
                                        placeholder="Số điện thoại...">
                                </div>
                            </div>
                            
                            {{-- Attendance Radio --}}
                            <div class="text-center py-4">
                                <label class="block text-xs font-bold uppercase text-gray-500 mb-4 opacity-70">Bạn sẽ tham dự chứ?</label>
                                <div class="flex flex-wrap justify-center gap-3">
                                    <label class="cursor-pointer">
                                        <input type="radio" x-model="formData.attendance" value="yes" required class="sr-only">
                                        <div class="px-6 py-2 border border-gray-200 rounded-full text-sm font-bold transition-all hover:scale-105 shadow-sm"
                                             :class="formData.attendance === 'yes' ? 'shadow-md opacity-100' : 'bg-white text-gray-500'"
                                             :style="formData.attendance === 'yes' ? 'background-color: #BB6A07; color: white; border-color: #BB6A07;' : ''">
                                            Sẽ Tham Dự
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" x-model="formData.attendance" value="maybe" class="sr-only">
                                        <div class="px-6 py-2 border border-gray-200 rounded-full text-sm font-bold transition-all hover:scale-105 shadow-sm"
                                             :class="formData.attendance === 'maybe' ? 'shadow-md' : 'bg-white text-gray-500'"
                                             :style="formData.attendance === 'maybe' ? 'background-color: #EAB308; color: white; border-color: #EAB308;' : ''">
                                            Chưa Chắc
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" x-model="formData.attendance" value="no" class="sr-only">
                                        <div class="px-6 py-2 border border-gray-200 rounded-full text-sm font-bold transition-all hover:scale-105 shadow-sm"
                                             :class="formData.attendance === 'no' ? 'shadow-md' : 'bg-white text-gray-500'"
                                             :style="formData.attendance === 'no' ? 'background-color: #57534E; color: white; border-color: #57534E;' : ''">
                                            Rất Tiếc
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                     <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Số Khách</label>
                                     <select x-model="formData.guests"
                                        class="w-full px-4 py-3 bg-white/50 border border-gray-200 rounded-xl text-gray-900 focus:border-gold focus:ring-1 focus:ring-gold outline-none cursor-pointer">
                                        <option value="1">1 Người</option>
                                        <option value="2">2 Người</option>
                                        <option value="3">3 Người</option>
                                        <option value="4">4 Người</option>
                                        <option value="5">5+ Người</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Khách Của</label>
                                    <select x-model="formData.side"
                                        class="w-full px-4 py-3 bg-white/50 border border-gray-200 rounded-xl text-gray-900 focus:border-gold focus:ring-1 focus:ring-gold outline-none cursor-pointer">
                                        <option value="both">Bạn Chung</option>
                                        <option value="groom">Nhà Trai</option>
                                        <option value="bride">Nhà Gái</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="pt-6">
                                <button type="submit"
                                    class="btn-gold-premium w-full py-4 rounded-xl font-bold uppercase tracking-widest text-sm shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 block"
                                    :disabled="submitting">
                                    <span x-show="!submitting">Gửi Xác Nhận</span>
                                    <span x-show="submitting">Đang Gửi...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER & THANK YOU --}}
    <footer class="py-24 bg-cream text-center relative overflow-hidden bg-main-watercolor" data-aos="fade-up">
        <div class="relative z-10">
            <h2 class="font-ambiance text-7xl text-gold mb-8">Thank You!</h2>
            <div class="font-viceroy text-3xl text-brown mb-2">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</div>
            <p class="text-gold font-bold tracking-[0.3em] mb-12">{{ $wedding->event_date?->format('d.m.Y') }}</p>
            
            <div class="separator mb-12">
                <svg class="w-8 h-8 text-gold" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
            
            <p class="text-[10px] text-gray-400 uppercase tracking-widest">Designed with ❤️ by THT Media</p>
        </div>
    </footer>
</div>

<script>
    // Initialize Swipers
    document.addEventListener('DOMContentLoaded', () => {
        const thumbSwiper = new Swiper(".thumbGallery", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });

        const mainSwiper = new Swiper(".mainGallery", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: thumbSwiper,
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
        });

        const secondarySwiper = new Swiper(".secondaryGallery", {
            effect: "cards",
            grabCursor: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
        });
    });
</script>

@push('scripts')
    <x-wedding.countdown-script />
@endpush
@endsection

@extends('layouts.app')
{{-- Template Name: Spring Blossom (Hương Sắc Mùa Xuân) --}}
{{-- Tier: pro --}}

@section('title', 'Happy Wedding - ' . $wedding->groom_name . ' & ' . $wedding->bride_name)
@section('og_image', $shareUrl)

@section('content')

@php
    $galleryImages = $wedding->gallery_images;
    $imagesToDisplay = $galleryImages->isNotEmpty() ? $galleryImages->map->getUrl() : [
        'https://images.unsplash.com/photo-1519741497674-611481863552?w=800',
        'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800'
    ];
@endphp

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --color-primary: #FFB7C5;
        --color-gold: #D4AF37;
        --color-dark: #1a1a1a;
        --color-text: #2d2d2d;
        
        --font-heading: 'Playfair Display', serif;
        --font-body: 'Montserrat', sans-serif;
        --font-script: 'Montserrat', sans-serif; /* Disable script font by mapping it to body */
        
        --radius-box: 24px;
    }

    body {
        background-color: #FFF;
        color: var(--color-text);
        font-family: var(--font-body);
        line-height: 1.8;
        font-size: 18px; /* Increased for readability */
    }

    .font-heading { font-family: var(--font-heading); font-weight: 700; }
    .font-script { font-family: var(--font-body); font-style: italic; }
    .font-viceroy { font-family: var(--font-heading); }

    .bg-main-watercolor {
        background-image: url('{{ asset('images/back-ground-1.png') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    /* Clean Minimalist Utilities */
    .btn-minimal {
        background-color: transparent;
        color: #1a1a1a;
        border: 1px solid #e5e7eb;
        padding: 12px 30px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-minimal:hover {
        border-color: #1a1a1a;
        background-color: #1a1a1a;
        color: #fff;
    }
</style>
@endpush

<div class="max-w-[480px] mx-auto bg-white min-h-screen shadow-2xl relative overflow-hidden">
    
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'heartbeat'])
    
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" />
    @endif
    
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    
    <x-wedding.music-player :wedding="$wedding" />

    {{-- HERO --}}
    <section class="min-h-screen relative flex flex-col items-center justify-center text-center bg-white overflow-hidden">
        {{-- Background Image with Fade --}}
        <div class="absolute inset-0 z-0 select-none">
            <img src="{{ $heroUrl }}" class="w-full h-full object-cover opacity-90">
            <div class="absolute inset-0 bg-white/20"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent"></div>
        </div>

        <div class="relative z-10 px-6 mt-20">
            <p class="font-body text-sm tracking-[0.3em] uppercase text-gray-600 mb-8 font-semibold" data-aos="fade-up">The Wedding Of</p>
            
            <div class="mb-8 space-y-4">
                <h1 class="font-heading text-6xl md:text-8xl text-gray-900 font-bold tracking-tight" data-aos="zoom-in" style="line-height: 1.1;">
                    {{ $wedding->groom_name }}
                </h1>
                <p class="font-heading text-4xl text-gray-400 italic" data-aos="zoom-in" data-aos-delay="100">&</p>
                <h1 class="font-heading text-6xl md:text-8xl text-gray-900 font-bold tracking-tight" data-aos="zoom-in" data-aos-delay="200" style="line-height: 1.1;">
                    {{ $wedding->bride_name }}
                </h1>
            </div>
            
            <div class="inline-block border-t border-b border-gray-300 py-4 px-12 mt-8" data-aos="fade-up" data-aos-delay="400">
                <p class="text-xl font-medium tracking-[0.2em] text-gray-800 font-body">
                    {{ $wedding->event_date?->format('d . m . Y') }}
                </p>
            </div>
        </div>
    </section>

    {{-- INTRO --}}
    <section class="py-32 px-8 text-center bg-white" data-aos="fade-up">
        <div class="max-w-2xl mx-auto">
            <div class="w-px h-24 bg-gray-300 mx-auto mb-12"></div>
            <h2 class="font-heading text-4xl md:text-5xl text-gray-900 mb-10 uppercase tracking-widest font-bold">Hành Trình Hạnh Phúc</h2>
            <p class="text-gray-600 leading-relaxed text-lg font-light italic font-body max-w-lg mx-auto">
                "Hạnh phúc không phải là điểm đến, mà là hành trình chúng ta cùng đi bên nhau."
            </p>
        </div>
    </section>

    {{-- STORY / LỜI NGỎ --}}
    {{-- STORY / LỜI NGỎ --}}
    <section class="py-32 px-6 bg-gray-50 text-center" data-aos="fade-up">
        <div class="max-w-3xl mx-auto">
            <h2 class="font-heading text-5xl font-bold mb-12 text-gray-900 tracking-widest uppercase">Lời Ngỏ</h2>

            <div class="space-y-10 text-xl text-gray-600 leading-relaxed font-body font-light">
                @if($prologue_content = $wedding->getContentValue('prologue_desc'))
                    @foreach(explode("\n", $prologue_content) as $line)
                        @if(trim($line)) <p>{{ $line }}</p> @endif
                    @endforeach
                @else
                    <p>Mọi người nói rằng tình yêu là một món quà, và chúng tôi cảm thấy mình là những người may mắn nhất khi tìm thấy nhau.</p>
                    <p>Sự hiện diện và lời chúc phúc của bạn chính là món quà ý nghĩa nhất trong ngày trọng đại này của chúng tôi.</p>
                @endif
                <div class="pt-16">
                    <p class="font-heading text-3xl text-gray-900 italic">Trân trọng cảm ơn</p>
                    <div class="w-12 h-px bg-gray-300 mx-auto mt-8"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- COUPLE --}}
    {{-- COUPLE --}}
    <section class="py-24 px-4 bg-white" data-aos="fade-up">
        <div class="grid md:grid-cols-2 gap-16 max-w-4xl mx-auto">
            {{-- Groom --}}
            <div class="text-center" data-aos="fade-up">
                <div class="w-64 h-64 mx-auto rounded-full overflow-hidden mb-8 shadow-lg">
                    <img src="{{ $groomPhoto }}" class="w-full h-full object-cover transition-all duration-700">
                </div>
                <h3 class="font-heading text-4xl text-gray-900 mb-2 whitespace-nowrap">{{ $wedding->groom_name }}</h3>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 font-bold mb-6 font-body">The Groom</p>
                <div class="text-sm text-gray-500 space-y-2 italic font-body">
                    @if($wedding->groom_father)<p>Con ông: {{ $wedding->groom_father }}</p>@endif
                    @if($wedding->groom_mother)<p>Con bà: {{ $wedding->groom_mother }}</p>@endif
                </div>
            </div>

            {{-- Bride --}}
            <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="w-64 h-64 mx-auto rounded-full overflow-hidden mb-8 shadow-lg">
                    <img src="{{ $bridePhoto }}" class="w-full h-full object-cover transition-all duration-700">
                </div>
                <h3 class="font-heading text-4xl text-gray-900 mb-2 whitespace-nowrap">{{ $wedding->bride_name }}</h3>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 font-bold mb-6 font-body">The Bride</p>
                <div class="text-sm text-gray-500 space-y-2 italic font-body">
                    @if($wedding->bride_father)<p>Con ông: {{ $wedding->bride_father }}</p>@endif
                    @if($wedding->bride_mother)<p>Con bà: {{ $wedding->bride_mother }}</p>@endif
                </div>
            </div>
        </div>
    </section>

    {{-- EVENTS --}}
    <section class="py-32 px-8 bg-gray-50" data-aos="fade-up">
        <div class="text-center mb-16">
            <h2 class="font-heading text-5xl font-bold text-gray-900 pt-12 uppercase tracking-widest" style="line-height: 1.3;">Trân Trọng Kính Mời</h2>
            <div class="w-12 h-px bg-gray-300 mx-auto mt-6"></div>
        </div>
        
        <div class="grid md:grid-cols-2 gap-12 max-w-5xl mx-auto">
            {{-- Bride Event --}}
            <div class="bg-white p-12 shadow-sm border border-gray-100 text-center" data-aos="fade-up">
                <h4 class="font-heading text-3xl text-gray-900 mb-6 uppercase tracking-wider font-bold">Nhà Gái</h4>
                <div class="w-8 h-px bg-gray-200 mx-auto mb-6"></div>
                <h3 class="font-heading text-4xl text-gray-900 mb-4">{{ \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') }}</h3>
                @if($wedding->bride_ceremony_date)
                    <p class="text-gray-500 mb-8 uppercase tracking-widest font-body">{{ $wedding->bride_ceremony_date->format('l, d/m/Y') }}</p>
                @endif
                <p class="text-lg text-gray-700 leading-relaxed font-body px-8">{{ $wedding->bride_address }}</p>
                
                {{-- Map Button --}}
                @if($wedding->bride_map_url)
                <div class="mt-8">
                    <a href="{{ $wedding->bride_map_url }}" target="_blank" class="inline-block border border-gray-900 text-gray-900 px-8 py-3 uppercase tracking-widest text-xs font-bold hover:bg-gray-900 hover:text-white transition-colors">Xem bản đồ</a>
                </div>
                @endif
            </div>

            {{-- Groom Event --}}
            <div class="bg-white p-12 shadow-sm border border-gray-100 text-center" data-aos="fade-up" data-aos-delay="100">
                <h4 class="font-heading text-3xl text-gray-900 mb-6 uppercase tracking-wider font-bold">Nhà Trai</h4>
                <div class="w-8 h-px bg-gray-200 mx-auto mb-6"></div>
                <h3 class="font-heading text-4xl text-gray-900 mb-4">{{ \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') }}</h3>
                @if($wedding->groom_ceremony_date)
                    <p class="text-gray-500 mb-8 uppercase tracking-widest font-body">{{ $wedding->groom_ceremony_date->format('l, d/m/Y') }}</p>
                @endif
                <p class="text-lg text-gray-700 leading-relaxed font-body px-8">{{ $wedding->groom_address }}</p>

                {{-- Map Button --}}
                @if($wedding->groom_map_url)
                <div class="mt-8">
                    <a href="{{ $wedding->groom_map_url }}" target="_blank" class="inline-block border border-gray-900 text-gray-900 px-8 py-3 uppercase tracking-widest text-xs font-bold hover:bg-gray-900 hover:text-white transition-colors">Xem bản đồ</a>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- GALLERY --}}
    <section class="py-32 px-4 bg-white">
        <h2 class="font-heading text-5xl text-center text-gray-900 mb-20 uppercase tracking-widest font-bold">Khoảnh Khắc</h2>
        <div class="columns-2 md:columns-3 gap-6 space-y-6 max-w-6xl mx-auto">
            @foreach($imagesToDisplay as $img)
            <div class="break-inside-avoid overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500" data-aos="fade-up">
                <img src="{{ $img }}" class="w-full h-auto object-cover grayscale-0 hover:scale-105 transition-transform duration-700">
            </div>
            @endforeach
        </div>
    </section>

    {{-- RSVP --}}
    <div class="bg-gray-50 py-24 border-t border-gray-100">
        @include('components.wedding.rsvp-form', ['wedding' => $wedding])
    </div>

    {{-- GIFT BOX --}}
    <x-wedding.gift-box :wedding="$wedding" class="py-32 px-8 text-center bg-white">
        <h2 class="font-heading text-5xl font-bold text-gray-900 mb-20 uppercase tracking-widest">Mừng Cưới</h2>
        <div class="grid md:grid-cols-2 gap-12 max-w-3xl mx-auto">
            <button @click="showQr = 'groom'" class="bg-white p-10 border border-gray-200 transition-all hover:border-gray-900 hover:shadow-lg duration-500 group">
                <p class="text-xs uppercase tracking-[0.4em] font-bold text-gray-400 mb-6 group-hover:text-gray-900 transition-colors">Nhà Trai</p>
                <span class="font-heading text-3xl font-bold text-gray-900">CHÚ RỂ</span>
            </button>
            <button @click="showQr = 'bride'" class="bg-white p-10 border border-gray-200 transition-all hover:border-gray-900 hover:shadow-lg duration-500 group">
                <p class="text-xs uppercase tracking-[0.4em] font-bold text-gray-400 mb-6 group-hover:text-gray-900 transition-colors">Nhà Gái</p>
                <span class="font-heading text-3xl font-bold text-gray-900">CÔ DÂU</span>
            </button>
        </div>
    </x-wedding.gift-box>

    {{-- GUESTBOOK --}}
    <div class="bg-white border-t border-gray-100 py-12">
        @include('components.wedding.guestbook', ['wedding' => $wedding])
    </div>

    {{-- FOOTER --}}
    <footer class="py-32 bg-white text-center px-10 border-t border-gray-100">
        <h2 class="font-heading text-5xl font-bold mb-8 text-gray-900 uppercase tracking-widest">Cảm Ơn</h2>
        <p class="text-gray-500 italic mb-16 text-lg font-body font-light">Hẹn gặp lại bạn tại buổi tiệc!</p>
        <div class="font-bold text-gray-900 uppercase tracking-[0.5em] text-sm opacity-100 font-heading">
            {{ $wedding->groom_name }} & {{ $wedding->bride_name }}
        </div>
    </footer>
</div>

@endsection

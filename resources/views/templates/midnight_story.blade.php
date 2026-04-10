@extends('layouts.app')
{{-- Template Name: Midnight Story (Huyền Thoại Đêm Trăng) --}}
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

    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Montserrat:wght@200;400;600&family=Playfair+Display:ital@0;1&display=swap&subset=vietnamese');

    :root {
        --midnight-navy: #0F172A;
        --midnight-gold: #E2B13C;
        --midnight-slate: #1E293B;
        --font-heading: 'utm-viceroyjf', 'Cinzel', serif;
        --font-body: 'Montserrat', sans-serif;
    }

    body {
        background-color: var(--midnight-navy);
        color: #F1F5F9;
        font-family: var(--font-body);
    }

    .glass-card {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(226, 177, 60, 0.2);
    }

    .glow-gold {
        text-shadow: 0 0 10px rgba(226, 177, 60, 0.5);
    }

    .star-bg {
        background-image: radial-gradient(white, rgba(255,255,255,.2) 2px, transparent 40px);
        background-size: 550px 550px;
    }

    @keyframes pulse-gold {
        0%, 100% { box-shadow: 0 0 5px rgba(226, 177, 60, 0.3); }
        50% { box-shadow: 0 0 20px rgba(226, 177, 60, 0.6); }
    }

    .btn-midnight {
        background: transparent;
        color: var(--midnight-gold) !important;
        border: 1px solid var(--midnight-gold);
        padding: 12px 30px;
        text-transform: uppercase;
        font-family: var(--font-heading);
        font-weight: bold;
        letter-spacing: 2px;
        transition: all 0.4s;
        animation: pulse-gold 3s infinite;
    }

    .btn-midnight:hover {
        background: var(--midnight-gold);
        color: var(--midnight-navy) !important;
        box-shadow: 0 0 30px rgba(226, 177, 60, 0.5);
    }
</style>

<div class="max-w-[480px] mx-auto bg-[#0F172A] min-h-screen shadow-2xl relative overflow-hidden">
    
    <div class="absolute inset-0 star-bg opacity-20 pointer-events-none"></div>

    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'swirl'])
    
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" />
    @endif
    
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    
    <x-wedding.music-player :wedding="$wedding" />

    {{-- HERO --}}
    <section class="h-screen relative flex flex-col items-center justify-center p-8 text-center">
        <div class="absolute inset-0 z-0">
            <img src="{{ $heroUrl }}" class="w-full h-full object-cover brightness-[0.4] contrast-125">
            <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A] via-transparent to-[#0F172A]/80"></div>
        </div>

        <div class="relative z-10 border border-[#E2B13C]/30 p-10 backdrop-blur-[2px]">
            <p class="font-heading text-xs tracking-[0.6em] text-[#E2B13C]/80 mb-8" data-aos="fade-down">The Grand Premiere Of Our Love</p>
            <h1 class="font-heading text-5xl mb-4 glow-gold" data-aos="zoom-in">{{ $wedding->groom_name }}</h1>
            <span class="text-3xl text-[#E2B13C] block my-2">&</span>
            <h1 class="font-heading text-5xl mb-12 glow-gold" data-aos="zoom-in" data-aos-delay="200">{{ $wedding->bride_name }}</h1>
            
            <p class="font-heading text-3xl tracking-[0.4em]" data-aos="fade-up" data-aos-delay="400">{{ $wedding->event_date?->format('d . m . Y') }}</p>
        </div>
    </section>

    {{-- INTRO --}}
    <section class="py-24 px-10 text-center">
        <div data-aos="fade-up">
            <h2 class="font-heading text-2xl text-[#E2B13C] mb-8">The Story Under The Stars</h2>
            <p class="font-light leading-loose text-slate-300 italic">
                Giống như những vì sao lấp lánh giữa đêm tối, tình yêu của chúng tôi tỏa sáng rạng ngời nhất khi ở bên cạnh nhau.
            </p>
        </div>
    </section>

    {{-- COUPLE --}}
    <section class="py-16 px-8 flex flex-col gap-12">
        <div class="flex items-center gap-6" data-aos="fade-right">
            <div class="w-1/2 aspect-[3/4] rounded-sm overflow-hidden border-2 border-[#E2B13C]/30">
                <img src="{{ $groomPhoto }}" class="w-full h-full object-cover">
            </div>
            <div class="w-1/2">
                <h3 class="font-heading text-xl text-[#E2B13C] mb-2">{{ $wedding->groom_name }}</h3>
                <div class="text-[10px] text-slate-400 font-light">
                    @if($wedding->groom_father)<p>Con ông: {{ $wedding->groom_father }}</p>@endif
                    @if($wedding->groom_mother)<p>Con bà: {{ $wedding->groom_mother }}</p>@endif
                </div>
            </div>
        </div>

        <div class="flex flex-row-reverse items-center gap-6" data-aos="fade-left">
            <div class="w-1/2 aspect-[3/4] rounded-sm overflow-hidden border-2 border-[#E2B13C]/30">
                <img src="{{ $bridePhoto }}" class="w-full h-full object-cover">
            </div>
            <div class="w-1/2 text-right">
                <h3 class="font-heading text-xl text-[#E2B13C] mb-2">{{ $wedding->bride_name }}</h3>
                <div class="text-[10px] text-slate-400 font-light">
                    @if($wedding->bride_father)<p>Con ông: {{ $wedding->bride_father }}</p>@endif
                    @if($wedding->bride_mother)<p>Con bà: {{ $wedding->bride_mother }}</p>@endif
                </div>
            </div>
        </div>
    </section>

    {{-- EVENTS --}}
    <section class="py-24 px-8 bg-[#1E293B]">
        <h2 class="font-heading text-3xl text-center text-[#E2B13C] mb-16">Invitation Details</h2>
        
        <div class="space-y-12 border-l border-[#E2B13C]/20 ml-4">
            <div class="relative pl-10" data-aos="fade-up">
                <div class="absolute left-[-5px] top-0 w-[10px] h-[10px] bg-[#E2B13C] rounded-full shadow-[0_0_10px_#E2B13C]"></div>
                <h4 class="font-heading text-[#E2B13C] mb-2">Lễ Vu Quy</h4>
                <p class="text-2xl font-light mb-2">{{ \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') }} | {{ $wedding->bride_ceremony_date?->format('d/m/Y') }}</p>
                <p class="text-xs text-slate-400">{{ $wedding->bride_address }}</p>
            </div>

            <div class="relative pl-10" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute left-[-5px] top-0 w-[10px] h-[10px] bg-[#E2B13C] rounded-full shadow-[0_0_10px_#E2B13C]"></div>
                <h4 class="font-heading text-[#E2B13C] mb-2">Lễ Thành Hôn</h4>
                <p class="text-2xl font-light mb-2">{{ \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') }} | {{ $wedding->groom_ceremony_date?->format('d/m/Y') }}</p>
                <p class="text-xs text-slate-400">{{ $wedding->groom_address }}</p>
            </div>
        </div>
    </section>

    {{-- GALLERY --}}
    <section class="py-20 px-2 bg-[#0F172A]">
        <h2 class="font-heading text-3xl text-center text-[#E2B13C] mb-12">Visual Memories</h2>
        <div class="columns-2 gap-2 space-y-2">
            @foreach($imagesToDisplay as $img)
            <div class="break-inside-avoid border border-[#E2B13C]/10" data-aos="zoom-in">
                <img src="{{ $img }}" class="w-full h-auto brightness-75 hover:brightness-100 transition-all duration-1000">
            </div>
            @endforeach
        </div>
    </section>

    {{-- RSVP (Injected with dark theme classes if possible, or just standard) --}}
    @include('components.wedding.rsvp-form', ['wedding' => $wedding])

    {{-- GIFT BOX --}}
    <x-wedding.gift-box :wedding="$wedding" class="py-24 px-10 text-center glass-card m-6 rounded-3xl">
        <h2 class="font-heading text-3xl text-[#E2B13C] mb-12">Wedding Gift</h2>
        <div class="flex flex-col gap-6">
            <button @click="showQr = 'groom'" class="btn-midnight">Mừng Cưới Chú Rể</button>
            <button @click="showQr = 'bride'" class="btn-midnight">Mừng Cưới Cô Dâu</button>
        </div>
    </x-wedding.gift-box>

    {{-- GUESTBOOK --}}
    @include('components.wedding.guestbook', ['wedding' => $wedding])

    {{-- STORY / LỜI NGỎ --}}
    <section class="relative py-32 px-6 overflow-hidden" data-aos="fade-up">
        <div class="absolute inset-0">
            <img src="{{ $heroUrl }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-[4px]"></div>
        </div>
        
        <div class="relative z-10 text-center text-white" data-aos="zoom-in">
            <div class="inline-block relative mb-12">
                <h2 class="font-viceroy text-6xl mb-2 text-glow-gold">Lời Ngỏ</h2>
                <div class="absolute -bottom-4 left-0 w-full h-8">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 356.13 42.62" fill="white" class="opacity-20">
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
                <p class="font-viceroy text-4xl text-[#E2B13C] pt-6 glow-gold">Chân thành cảm ơn bạn ♥ ♥</p>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="py-32 bg-[#020617] text-center px-10 border-t border-[#E2B13C]/10" data-aos="fade-up">
        <h2 class="font-heading text-5xl mb-8 glow-gold">Eternity</h2>
        <p class="text-slate-500 font-light mb-16 tracking-[0.2em]">Our life together begins tonight.</p>
        <div class="text-[10px] text-[#E2B13C] uppercase tracking-[0.5em] opacity-40">
            {{ $wedding->groom_name }} & {{ $wedding->bride_name }}
        </div>
    </footer>
</div>

@endsection

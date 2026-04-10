@extends('layouts.app')
{{-- Template Name: Traditional Red (Sắc Đỏ Truyền Thống) --}}

@section('title', 'Lễ Vu Quy ' . $wedding->groom_name . ' & ' . $wedding->bride_name)
@section('og_image', $shareUrl)

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Be+Vietnam+Pro:wght@300;400;500&family=Pinyon+Script&display=swap');

    :root {
        /* Standardized Theme Variables */
        --color-primary: #8a1c1c; /* Deep Red */
        --color-primary-dark: #631212;
        --color-primary-light: #fff5f5; /* Light Red tint */
        --color-bg-secondary: #fffcf5; /* Cream */
        --color-text-body: #4a0404; /* Dark Red/Brown text */
        --bg-paper: #fffcf5;
        --bg-input: #ffffff;
        
        --font-heading: 'Playfair Display', serif;
        --font-body: 'Be Vietnam Pro', sans-serif;
        --radius-box: 8px;
        --shadow-box: 0 10px 30px -5px rgba(138, 28, 28, 0.15);

        /* Custom Theme Colors */
        --red-pri: #8a1c1c;
        --gold-pri: #d4af37;
        --gold-light: #f6e3ba;
        --cream: #fffcf5;
    }

    body { font-family: var(--font-body); background-color: var(--red-pri); color: var(--gold-pri); }
    h1, h2, h3, h4, .font-heading { font-family: var(--font-heading); }
    .font-script { font-family: 'Pinyon Script', cursive; }

    /* Traditional Patterns */
    .bg-pattern {
        background-color: var(--red-pri);
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0c0 16.569-13.431 30-30 30 16.569 0 30 13.431 30 30 0-16.569 13.431-30 30-30C43.431 30 30 16.569 30 0z' fill='%23500a0a' fill-opacity='0.15' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    /* Gradient Text */
    .text-gradient-gold {
        background: linear-gradient(to bottom, #fceeb5, #d4af37, #aa851c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Cloud/Wave Border */
    .cloud-border-y {
        background-image: url("data:image/svg+xml,%3Csvg width='1200' height='60' viewBox='0 0 1200 60' preserveAspectRatio='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0,0V46.29c47,0,47,22.5,94,22.5s47-22.5,94,22.5,47-22.5,94,22.5,47-22.5,94,22.5,47-22.5,94,22.5,47-22.5,94-22.5,47-22.5,94-22.5,47-22.5,94-22.5,47-22.5,94-22.5,47-22.5,94-22.5,47-22.5,94-22.5,47-22.5,94-22.5,47-22.5,94-22.5,47-22.5,94-22.5V0Z' fill='%23fffcf5' fill-opacity='1'/%3E%3C/svg%3E");
        height: 30px;
        width: 100%;
        background-repeat: no-repeat;
        background-size: cover;
    }
    
    /* Animations */
    @keyframes spin-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.4); } 70% { box-shadow: 0 0 0 10px rgba(212, 175, 55, 0); } }
    
    .animate-spin-slow { animation: spin-slow 20s linear infinite; }
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-pulse-glow { animation: pulse-glow 2s infinite; }
    
    .glass-panel {
        background: rgba(138, 28, 28, 0.6);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(212, 175, 55, 0.3);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
    }
    
    /* Scroll Reveal */
    .reveal-on-scroll { opacity: 0; transform: translateY(20px); transition: all 0.8s ease-out; }
    .reveal-on-scroll.revealed { opacity: 1; transform: translateY(0); }

</style>

<div class="max-w-[480px] mx-auto bg-pattern min-h-screen shadow-2xl relative overflow-hidden text-[#f6e3ba]">
    
    {{-- Pro Features --}}
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'traditional'])
    
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" style="gatefold" />
    @endif
    
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    
    <x-wedding.music-player :wedding="$wedding" />

    {{-- HEADER / HERO SECTION --}}
    <section class="relative min-h-screen flex flex-col pt-12">
        <div class="absolute inset-0 z-0">
            <img src="{{ $heroUrl }}" class="w-full h-full object-cover opacity-60 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-b from-[#8a1c1c] via-transparent to-[#8a1c1c]"></div>
        </div>

        <div class="relative z-10 text-center px-6 flex-1 flex flex-col justify-center items-center">
            
            {{-- Song Hỷ Ornament --}}
            <div class="w-24 h-24 mb-8 relative animate-float">
                <div class="absolute inset-0 border-2 border-dashed border-[#d4af37] rounded-full animate-spin-slow opacity-50"></div>
                <div class="absolute inset-2 bg-[#8a1c1c] rounded-full border border-[#d4af37] flex items-center justify-center shadow-lg">
                    <span class="text-5xl text-[#d4af37] font-serif pt-2">囍</span>
                </div>
            </div>

            <p class="text-sm uppercase tracking-[0.3em] text-[#d4af37] mb-6 opacity-90 font-light">Lễ Thành Hôn</p>
            
            <h1 class="text-5xl md:text-6xl font-heading font-bold text-gradient-gold mb-2 leading-tight">
                {{ $wedding->groom_name }}
            </h1>
            
            <div class="flex items-center gap-6 my-2 opacity-80">
                <span class="h-[1px] w-12 bg-gradient-to-r from-transparent to-[#d4af37]"></span>
                <span class="font-script text-4xl text-[#d4af37]">&</span>
                <span class="h-[1px] w-12 bg-gradient-to-l from-transparent to-[#d4af37]"></span>
            </div>
            
            <h1 class="text-5xl md:text-6xl font-heading font-bold text-gradient-gold mb-12 leading-tight">
                {{ $wedding->bride_name }}
            </h1>

            <div class="glass-panel px-8 py-4 rounded-full inline-block animate-pulse-glow">
                <p class="text-2xl font-heading text-[#fffcf5]">
                    {{ $wedding->event_date?->format('d . m . Y') }}
                </p>
            </div>
            
            @if($wedding->event_date_lunar)
            <p class="text-sm mt-4 text-[#d4af37] opacity-80 italic font-light">
                (Tức ngày {{ $wedding->event_date_lunar }} Âm Lịch)
            </p>
            @endif
        </div>
        
        {{-- Cloud Border Bottom --}}
        <div class="relative w-full z-10 mt-auto">
             <div class="cloud-border-y transform rotate-180"></div>
        </div>
    </section>

    {{-- INTRO / COUPLE --}}
    <section class="py-16 px-6 relative bg-[#fffcf5] text-[#4a0404]">
        <div class="text-center mb-16">
            <span class="text-6xl text-[#8a1c1c] opacity-20 font-serif block mb-[-20px]">“</span>
            <p class="text-xl font-script leading-relaxed text-[#8a1c1c]">
                Trăm năm tình viên mãn<br>Bạc đầu nghĩa phu thê
            </p>
            <div class="w-16 h-[1px] bg-[#8a1c1c] mx-auto mt-6 opacity-30"></div>
        </div>

        <div class="grid gap-12 max-w-lg mx-auto">
            {{-- Groom --}}
            <div class="flex flex-col items-center group reveal-on-scroll">
                <div class="relative w-56 aspect-[3/4] mb-6">
                    <div class="absolute inset-0 border-[1px] border-[#8a1c1c] translate-x-3 translate-y-3 transition-transform duration-500 group-hover:translate-x-2 group-hover:translate-y-2"></div>
                    <div class="absolute inset-0 bg-[#8a1c1c] transition-transform duration-500 group-hover:-translate-x-1 group-hover:-translate-y-1 overflow-hidden shadow-xl">
                        <img src="{{ $groomPhoto }}" class="w-full h-full object-cover opacity-90 hover:opacity-100 transition duration-700">
                    </div>
                </div>
                <h3 class="text-3xl font-heading font-bold text-[#8a1c1c] mb-1">{{ $wedding->groom_name }}</h3>
                <p class="text-xs uppercase tracking-widest text-[#d4af37] font-bold mb-3">Chú Rể</p>
                <div class="text-sm text-center leading-relaxed opacity-80">
                    @if($wedding->groom_father)<p>Trưởng nam ông: <strong>{{ $wedding->groom_father }}</strong></p>@endif
                    @if($wedding->groom_mother)<p>Bà: <strong>{{ $wedding->groom_mother }}</strong></p>@endif
                </div>
            </div>

            {{-- Bride --}}
            <div class="flex flex-col items-center group reveal-on-scroll delay-200">
                 <div class="relative w-56 aspect-[3/4] mb-6">
                    <div class="absolute inset-0 border-[1px] border-[#8a1c1c] -translate-x-3 translate-y-3 transition-transform duration-500 group-hover:-translate-x-2 group-hover:translate-y-2"></div>
                    <div class="absolute inset-0 bg-[#8a1c1c] transition-transform duration-500 group-hover:translate-x-1 group-hover:-translate-y-1 overflow-hidden shadow-xl">
                        <img src="{{ $bridePhoto }}" class="w-full h-full object-cover opacity-90 hover:opacity-100 transition duration-700">
                    </div>
                </div>
                <h3 class="text-3xl font-heading font-bold text-[#8a1c1c] mb-1">{{ $wedding->bride_name }}</h3>
                <p class="text-xs uppercase tracking-widest text-[#d4af37] font-bold mb-3">Cô Dâu</p>
                 <div class="text-sm text-center leading-relaxed opacity-80">
                    @if($wedding->bride_father)<p>Trưởng nữ ông: <strong>{{ $wedding->bride_father }}</strong></p>@endif
                    @if($wedding->bride_mother)<p>Bà: <strong>{{ $wedding->bride_mother }}</strong></p>@endif
                </div>
            </div>
        </div>
    </section>

    {{-- INVITATION DETAILS --}}
    <section class="py-20 px-4 relative bg-[#8a1c1c] text-[#f6e3ba]">
        <div class="absolute top-0 left-0 w-full cloud-border-y opacity-20"></div>
        <div class="absolute bottom-0 left-0 w-full cloud-border-y transform rotate-180 opacity-20"></div>
        
        <div class="border border-[#d4af37]/30 p-8 rounded-t-full rounded-b-[100px] relative max-w-md mx-auto bg-[#631212]/50 backdrop-blur-sm">
            <h2 class="text-center font-heading text-3xl text-gradient-gold mb-12 uppercase tracking-wide">Trân trọng kính mời</h2>
            
            <div class="space-y-12">
                {{-- Nhà Gái --}}
                <div class="text-center reveal-on-scroll">
                    <p class="text-[#d4af37] text-xs font-bold uppercase tracking-[0.2em] mb-4 border-b border-[#d4af37]/30 inline-block pb-2">Nhà Gái</p>
                    
                    <div class="mb-6">
                        <h4 class="font-heading text-xl mb-1 text-white">Lễ Vu Quy</h4>
                        <p class="text-4xl font-heading font-bold text-gradient-gold my-2">
                            {{ \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') }}
                        </p>
                        <p class="text-sm opacity-80">{{ $wedding->bride_address }}</p>
                    </div>

                    @if($wedding->bride_reception_time)
                    <div class="bg-black/20 p-4 rounded-lg">
                        <p class="text-xs uppercase tracking-wider text-[#d4af37] mb-1">Tiệc Cưới</p>
                        <p class="font-bold text-lg text-white">{{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }}</p>
                        <p class="text-xs opacity-70">{{ $wedding->bride_reception_venue }}</p>
                    </div>
                    @endif
                    
                    @if($wedding->bride_map_url)
                    <a href="{{ $wedding->bride_map_url }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-[#d4af37] hover:text-white transition text-xs uppercase tracking-widest border border-[#d4af37]/50 px-4 py-2 hover:bg-[#d4af37]/20 rounded">
                        <span>Bản Đồ</span> <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </a>
                    @endif
                </div>

                {{-- Divider --}}
                <div class="opacity-30">
                    <svg class="w-full h-4" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 5 Q50 10 100 5" stroke="#d4af37" fill="none" /></svg>
                </div>

                {{-- Nhà Trai --}}
                 <div class="text-center reveal-on-scroll">
                    <p class="text-[#d4af37] text-xs font-bold uppercase tracking-[0.2em] mb-4 border-b border-[#d4af37]/30 inline-block pb-2">Nhà Trai</p>
                    
                    <div class="mb-6">
                        <h4 class="font-heading text-xl mb-1 text-white">Lễ Thành Hôn</h4>
                        <p class="text-4xl font-heading font-bold text-gradient-gold my-2">
                            {{ \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') }}
                        </p>
                        <p class="text-sm opacity-80">{{ $wedding->groom_address }}</p>
                    </div>

                    @if($wedding->groom_reception_time)
                    <div class="bg-black/20 p-4 rounded-lg">
                        <p class="text-xs uppercase tracking-wider text-[#d4af37] mb-1">Tiệc Cưới</p>
                        <p class="font-bold text-lg text-white">{{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }}</p>
                         <p class="text-xs opacity-70">{{ $wedding->groom_reception_venue }}</p>
                    </div>
                    @endif

                    @if($wedding->groom_map_url)
                    <a href="{{ $wedding->groom_map_url }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-[#d4af37] hover:text-white transition text-xs uppercase tracking-widest border border-[#d4af37]/50 px-4 py-2 hover:bg-[#d4af37]/20 rounded">
                        <span>Bản Đồ</span> <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- COUNTDOWN --}}
    @if($wedding->event_date && $wedding->event_date->isFuture())
    <section class="py-16 px-6 bg-[#fffcf5] text-[#8a1c1c] text-center">
        <h2 class="font-heading text-3xl mb-8">Save The Date</h2>
        <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="flex justify-center gap-4 text-center">
            <div class="w-16">
                <div class="text-4xl font-bold font-heading mb-1" x-text="days">00</div>
                <div class="text-[10px] uppercase tracking-widest opacity-60">Ngày</div>
            </div>
            <div class="text-2xl pt-2 opacity-30">:</div>
            <div class="w-16">
                <div class="text-4xl font-bold font-heading mb-1" x-text="hours">00</div>
                <div class="text-[10px] uppercase tracking-widest opacity-60">Giờ</div>
            </div>
            <div class="text-2xl pt-2 opacity-30">:</div>
            <div class="w-16">
                <div class="text-4xl font-bold font-heading mb-1" x-text="minutes">00</div>
                <div class="text-[10px] uppercase tracking-widest opacity-60">Phút</div>
            </div>
            <div class="text-2xl pt-2 opacity-30">:</div>
            <div class="w-16">
                <div class="text-4xl font-bold font-heading mb-1" x-text="seconds">00</div>
                <div class="text-[10px] uppercase tracking-widest opacity-60">Giây</div>
            </div>
        </div>
    </section>
    @endif

    {{-- GALLERY --}}
    <section class="py-16 px-4 bg-[#8a1c1c]">
        <h2 class="text-center font-heading text-3xl text-gradient-gold mb-10">Khoảnh Khắc Hạnh Phúc</h2>
        <div class="columns-2 md:columns-3 gap-3 space-y-3">
            @if($wedding->gallery_images->isNotEmpty())
                @foreach($wedding->gallery_images as $media)
                <div class="break-inside-avoid p-[2px] bg-gradient-to-br from-[#d4af37] to-[#8a1c1c]">
                    <img src="{{ $media->getUrl() }}" class="w-full grayscale-[50%] hover:grayscale-0 transition duration-500">
                </div>
                @endforeach
            @else
                @foreach(['https://images.unsplash.com/photo-1519741497674-611481863552?w=600', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=600', 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=600', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=600', 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=600', 'https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=600'] as $placeholder)
                <div class="break-inside-avoid p-[2px] bg-gradient-to-br from-[#d4af37] to-[#8a1c1c]">
                    <img src="{{ $placeholder }}" class="w-full grayscale-[50%] hover:grayscale-0 transition duration-500">
                </div>
                @endforeach
            @endif
        </div>
    </section>

    {{-- RSVP & GUESTBOOK (Shared Components) --}}
    <div class="py-16 bg-[#fffcf5] space-y-16">
        
        {{-- Custom wrapper for Gift Box to inject Theme Colors --}}
        <div class="px-6">
            <x-wedding.gift-box :wedding="$wedding">
                <div class="text-center border-y-2 border-[#8a1c1c]/10 py-12">
                    <h2 class="font-heading text-3xl text-[#8a1c1c] mb-6">Hộp Mừng Cưới</h2>
                    <div class="flex justify-center gap-6">
                        <button @click="showQr = 'groom'" class="bg-[#8a1c1c] text-[#f6e3ba] px-6 py-3 uppercase tracking-widest text-xs hover:bg-[#631212] transition shadow-lg">Nhà Trai</button>
                        <button @click="showQr = 'bride'" class="bg-[#8a1c1c] text-[#f6e3ba] px-6 py-3 uppercase tracking-widest text-xs hover:bg-[#631212] transition shadow-lg">Nhà Gái</button>
                    </div>
                </div>
            </x-wedding.gift-box>
        </div>

        @include('components.wedding.rsvp-form', ['wedding' => $wedding])
        @include('components.wedding.guestbook', ['wedding' => $wedding])

    </div>

    {{-- FOOTER --}}
    <footer class="py-16 bg-[#500a0a] text-center border-t border-[#d4af37]/20">
        <h2 class="font-heading text-4xl text-gradient-gold mb-4">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</h2>
        <p class="text-[#d4af37] opacity-60 text-xs tracking-[0.3em] uppercase">Thank You</p>
        <div class="mt-8">
            <span class="text-4xl text-[#d4af37] opacity-20">囍</span>
        </div>
    </footer>
</div>

<script>
    // Intersection Observer for scroll animations
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        });
        document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));
    });
</script>

@push('scripts')
    <x-wedding.countdown-script />
@endpush
@endsection

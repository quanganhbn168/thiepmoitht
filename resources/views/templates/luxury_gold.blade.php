@extends('layouts.app')
{{-- Template Name: Luxury Gold (Vàng Hoàng Gia) --}}

@section('title', 'The Wedding of ' . $wedding->groom_name . ' & ' . $wedding->bride_name)
@section('og_image', $shareUrl)

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap');
    
    :root {
        /* Standardized Theme Variables */
        --color-primary: #d4af37; /* Metallic Gold */
        --color-primary-dark: #b59024;
        --color-primary-light: #fcf6ba;
        --color-bg-secondary: #0f172a; /* Slate 900 */
        --color-text-body: #e2e8f0; /* Slate 200 */
        --bg-paper: #1e293b; /* Slate 800 */
        --bg-input: #ffffff; /* Contrast input */
        
        --font-heading: 'Cinzel', serif;
        --font-body: 'Montserrat', sans-serif;
        --radius-box: 2px; /* Sharp luxury corners */
        --shadow-box: 0 20px 50px -12px rgba(0, 0, 0, 0.7);

        /* Custom Theme Colors */
        --lux-gold: #d4af37;
        --lux-bg: #0f172a;
    }

    body { font-family: var(--font-body); background-color: var(--lux-bg); color: var(--color-text-body); }
    h1, h2, h3, h4, .font-heading { font-family: var(--font-heading); }
    
    /* Gold Gradient Text */
    .text-gradient-gold {
        background: linear-gradient(to bottom, #fcf6ba, #d4af37, #aa771c, #d4af37, #fcf6ba);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 200% auto;
        animation: shine 4s linear infinite;
    }

    /* Gradient Border */
    .border-gold-gradient {
        border-image: linear-gradient(to bottom right, #fcf6ba, #d4af37, #aa771c) 1;
    }

    /* Pattern Background */
    .bg-luxury-pattern {
        background-color: #0f172a;
        opacity: 1;
        background-image:  linear-gradient(#1e293b 1px, transparent 1px), linear-gradient(to right, #1e293b 1px, transparent 1px);
        background-size: 40px 40px;
    }

    /* Animations */
    @keyframes shine { to { background-position: 200% center; } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    @keyframes pulse-gold { 0%, 100% { box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.4); } 70% { box-shadow: 0 0 0 15px rgba(212, 175, 55, 0); } }
    
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-pulse-gold { animation: pulse-gold 3s infinite; }

    /* Scroll Reveal */
    .reveal-on-scroll { opacity: 0; transform: translateY(30px); transition: all 1s ease-out; }
    .reveal-on-scroll.revealed { opacity: 1; transform: translateY(0); }

    /* Glass Effect (Dark) */
    .glass-dark {
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(212, 175, 55, 0.2);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.5);
    }
</style>

<div class="max-w-[480px] mx-auto bg-luxury-pattern min-h-screen shadow-2xl relative overflow-hidden text-slate-200">
    
    {{-- Pro Features --}}
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'rings'])
    
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" style="gatefold" />
    @endif
    
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    
    <x-wedding.music-player :wedding="$wedding" />

    {{-- HERO SECTION --}}
    <section class="h-screen relative flex flex-col justify-center items-center overflow-hidden">
        {{-- Background Image with Parallax-like feel --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ $heroUrl }}" class="w-full h-full object-cover opacity-50 scale-105 animate-float" style="animation-duration: 20s">
            <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/60 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-[#0f172a] via-transparent to-transparent opacity-80"></div>
        </div>

        {{-- Frame Content --}}
        <div class="relative z-10 p-8 w-full max-w-sm mx-auto">
            <div class="border border-[#d4af37] p-8 relative backdrop-blur-[2px]">
                {{-- Corner Ornaments --}}
                <div class="absolute -top-3 -left-3 w-16 h-16 border-t-2 border-l-2 border-[#d4af37]"></div>
                <div class="absolute -top-3 -right-3 w-16 h-16 border-t-2 border-r-2 border-[#d4af37]"></div>
                <div class="absolute -bottom-3 -left-3 w-16 h-16 border-b-2 border-l-2 border-[#d4af37]"></div>
                <div class="absolute -bottom-3 -right-3 w-16 h-16 border-b-2 border-r-2 border-[#d4af37]"></div>

                <div class="text-center space-y-6">
                    <p class="uppercase tracking-[0.4em] text-[10px] text-[#d4af37] font-bold">The Wedding Of</p>
                    
                    <div>
                        <h1 class="text-5xl font-heading font-bold text-gradient-gold leading-tight">{{ $wedding->groom_name }}</h1>
                        <span class="font-heading text-4xl text-[#d4af37] my-2 block">&</span>
                        <h1 class="text-5xl font-heading font-bold text-gradient-gold leading-tight">{{ $wedding->bride_name }}</h1>
                    </div>

                    <div class="h-px w-24 bg-gradient-to-r from-transparent via-[#d4af37] to-transparent mx-auto"></div>

                    <p class="font-heading text-xl text-white tracking-widest">
                        {{ $wedding->event_date?->format('d . m . Y') }}
                    </p>
                    @if($wedding->event_date_lunar)
                        <p class="text-[10px] uppercase text-[#d4af37]/70 tracking-wider">({{ $wedding->event_date_lunar }} Âm Lịch)</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="absolute bottom-8 animate-bounce text-[#d4af37] opacity-60">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
        </div>
    </section>

    {{-- COUPLE SECTION --}}
    <section class="py-20 px-6 relative bg-[#0f172a]">
        <div class="text-center mb-16 reveal-on-scroll">
            <h2 class="font-heading text-4xl text-[#d4af37] mb-4">Cô Dâu & Chú Rể</h2>
            <p class="text-slate-400 text-sm max-w-xs mx-auto italic">"Tình yêu không phải là nhìn nhau, mà là cùng nhau nhìn về một hướng."</p>
        </div>

        <div class="grid gap-16 relative">
            {{-- Vertical Line --}}
            <div class="absolute left-1/2 top-0 bottom-0 w-px bg-gradient-to-b from-transparent via-[#d4af37]/30 to-transparent -translate-x-1/2 hidden md:block"></div>

            {{-- Groom --}}
            <div class="reveal-on-scroll group">
                <div class="relative max-w-xs mx-auto">
                    <div class="absolute -inset-1 bg-gradient-to-br from-[#d4af37] to-transparent opacity-30 rounded-lg blur-sm group-hover:opacity-60 transition duration-700"></div>
                    <div class="aspect-[3/4] relative rounded-lg overflow-hidden border border-[#d4af37]/30 bg-black">
                        <img src="{{ $groomPhoto }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 w-full p-6 text-center">
                            <h3 class="font-heading text-2xl text-gradient-gold font-bold mb-1">{{ $wedding->groom_name }}</h3>
                            <p class="text-[10px] uppercase tracking-widest text-slate-300 mb-2">Chú Rể</p>
                            <p class="text-xs text-[#d4af37]/80">
                                @if($wedding->groom_father) Con Ông: {{ $wedding->groom_father }} @endif
                                @if($wedding->groom_father && $wedding->groom_mother) <br> @endif
                                @if($wedding->groom_mother) Con Bà: {{ $wedding->groom_mother }} @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bride --}}
            <div class="reveal-on-scroll group delay-200">
                 <div class="relative max-w-xs mx-auto">
                    <div class="absolute -inset-1 bg-gradient-to-bl from-[#d4af37] to-transparent opacity-30 rounded-lg blur-sm group-hover:opacity-60 transition duration-700"></div>
                    <div class="aspect-[3/4] relative rounded-lg overflow-hidden border border-[#d4af37]/30 bg-black">
                        <img src="{{ $bridePhoto }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 w-full p-6 text-center">
                            <h3 class="font-heading text-2xl text-gradient-gold font-bold mb-1">{{ $wedding->bride_name }}</h3>
                            <p class="text-[10px] uppercase tracking-widest text-slate-300 mb-2">Cô Dâu</p>
                            <p class="text-xs text-[#d4af37]/80">
                                @if($wedding->bride_father) Con Ông: {{ $wedding->bride_father }} @endif
                                @if($wedding->bride_father && $wedding->bride_mother) <br> @endif
                                @if($wedding->bride_mother) Con Bà: {{ $wedding->bride_mother }} @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- EVENTS TIMELINE --}}
    <section class="py-20 px-4 bg-[#0B1120] relative overflow-hidden">
        {{-- Decoration --}}
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[#d4af37]/40 to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[#d4af37]/40 to-transparent"></div>

        <h2 class="text-center font-heading text-3xl text-gradient-gold mb-16 reveal-on-scroll">Sự Kiện Trọng Đại</h2>

        <div class="space-y-12 max-w-md mx-auto">
            {{-- Groom Event --}}
            <div class="glass-dark p-8 rounded-sm relative reveal-on-scroll border-l-2 border-[#d4af37]">
                <div class="absolute -left-[9px] top-8 w-4 h-4 bg-[#0f172a] border-2 border-[#d4af37] rounded-full"></div>
                <h3 class="font-heading text-xl text-white mb-2 uppercase tracking-wide">Tiệc Nhà Trai</h3>
                <div class="text-[#d4af37] text-3xl font-heading font-bold mb-4">
                     {{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }}
                </div>
                <p class="text-slate-300 text-sm mb-4">{{ $wedding->groom_reception_venue }}</p>
                <p class="text-slate-500 text-xs border-t border-[#d4af37]/20 pt-4 mt-4">
                    {{ $wedding->groom_address }}
                </p>
                @if($wedding->groom_map_url)
                <a href="{{ $wedding->groom_map_url }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-[#d4af37] text-xs uppercase tracking-wider hover:text-white transition">
                    Xem bản đồ <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
                @endif
            </div>

            {{-- Bride Event --}}
            <div class="glass-dark p-8 rounded-sm relative reveal-on-scroll border-r-2 border-[#d4af37] text-right">
                <div class="absolute -right-[9px] top-8 w-4 h-4 bg-[#0f172a] border-2 border-[#d4af37] rounded-full"></div>
                <h3 class="font-heading text-xl text-white mb-2 uppercase tracking-wide">Tiệc Nhà Gái</h3>
                <div class="text-[#d4af37] text-3xl font-heading font-bold mb-4">
                     {{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }}
                </div>
                <p class="text-slate-300 text-sm mb-4">{{ $wedding->bride_reception_venue }}</p>
                <p class="text-slate-500 text-xs border-t border-[#d4af37]/20 pt-4 mt-4">
                    {{ $wedding->bride_address }}
                </p>
                 @if($wedding->bride_map_url)
                <a href="{{ $wedding->bride_map_url }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-[#d4af37] text-xs uppercase tracking-wider hover:text-white transition justify-end">
                    Xem bản đồ <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
                @endif
            </div>
        </div>
    </section>

    {{-- COUNTDOWN --}}
    @if($wedding->event_date && $wedding->event_date->isFuture())
    <section class="py-20 px-6 text-center bg-luxury-pattern">
        <h2 class="font-heading text-2xl text-[#d4af37] mb-8 uppercase tracking-widest">Countdown</h2>
        <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="flex justify-center gap-4 md:gap-8">
            <div class="glass-dark w-20 h-24 flex flex-col justify-center items-center rounded border border-[#d4af37]/30">
                <div class="text-3xl font-heading font-bold text-white mb-1" x-text="days">00</div>
                <div class="text-[10px] uppercase text-[#d4af37]">Ngày</div>
            </div>
            <div class="glass-dark w-20 h-24 flex flex-col justify-center items-center rounded border border-[#d4af37]/30">
                <div class="text-3xl font-heading font-bold text-white mb-1" x-text="hours">00</div>
                <div class="text-[10px] uppercase text-[#d4af37]">Giờ</div>
            </div>
            <div class="glass-dark w-20 h-24 flex flex-col justify-center items-center rounded border border-[#d4af37]/30">
                <div class="text-3xl font-heading font-bold text-white mb-1" x-text="minutes">00</div>
                <div class="text-[10px] uppercase text-[#d4af37]">Phút</div>
            </div>
            <div class="glass-dark w-20 h-24 flex flex-col justify-center items-center rounded border border-[#d4af37]/30">
                <div class="text-3xl font-heading font-bold text-white mb-1" x-text="seconds">00</div>
                <div class="text-[10px] uppercase text-[#d4af37]">Giây</div>
            </div>
        </div>
    </section>
    @endif

    {{-- GALLERY --}}
    <section class="py-16 px-4 bg-[#0f172a]">
        <h2 class="text-center font-heading text-4xl text-gradient-gold mb-12">Khoảnh Khắc</h2>
        <div class="columns-2 gap-4 space-y-4">
            @if($wedding->gallery_images->isNotEmpty())
                @foreach($wedding->gallery_images as $media)
                <div class="break-inside-avoid relative group overflow-hidden rounded-sm border border-[#d4af37]/20">
                    <img src="{{ $media->getUrl() }}" class="w-full transition duration-700 group-hover:scale-110 grayscale-[30%] group-hover:grayscale-0">
                    <div class="absolute inset-0 bg-[#d4af37]/10 opacity-0 group-hover:opacity-100 transition duration-500"></div>
                </div>
                @endforeach
            @else
                @foreach(['https://images.unsplash.com/photo-1519741497674-611481863552?w=600', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=600', 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=600', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=600'] as $placeholder)
               <div class="break-inside-avoid relative group overflow-hidden rounded-sm border border-[#d4af37]/20">
                    <img src="{{ $placeholder }}" class="w-full transition duration-700 group-hover:scale-110 grayscale-[30%] group-hover:grayscale-0">
                    <div class="absolute inset-0 bg-[#d4af37]/10 opacity-0 group-hover:opacity-100 transition duration-500"></div>
                </div>
                @endforeach
            @endif
        </div>
    </section>

    {{-- GIFT BOX & RSVP & GUESTBOOK --}}
    <div class="py-20 bg-[#1e293b] space-y-20 relative">
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[#d4af37]/30 to-transparent"></div>

        {{-- Gift Box --}}
        <div class="px-6">
            <x-wedding.gift-box :wedding="$wedding">
                <div class="text-center py-8 px-4 border border-[#d4af37]/30 bg-[#0f172a]">
                    <h2 class="font-heading text-2xl text-[#d4af37] mb-6">Hộp Mừng Cưới</h2>
                    <div class="flex flex-wrap justify-center gap-4">
                        <button @click="showQr = 'groom'" class="bg-[#d4af37] text-black font-bold px-6 py-3 uppercase tracking-widest text-xs hover:bg-[#fcf6ba] transition shadow-lg shadow-[#d4af37]/20">Nhà Trai</button>
                        <button @click="showQr = 'bride'" class="bg-[#d4af37] text-black font-bold px-6 py-3 uppercase tracking-widest text-xs hover:bg-[#fcf6ba] transition shadow-lg shadow-[#d4af37]/20">Nhà Gái</button>
                    </div>
                </div>
            </x-wedding.gift-box>
        </div>

        {{-- Wrappers for standard components to force them into the theme if needed, 
           or relying on :root variables which we set nicely --}}
        
        <div class="px-4">
             @include('components.wedding.rsvp-form', ['wedding' => $wedding])
        </div>

        <div class="px-4">
             @include('components.wedding.guestbook', ['wedding' => $wedding])
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="py-16 bg-[#0f172a] text-center border-t border-[#d4af37]/20">
        <h2 class="font-heading text-3xl text-gradient-gold mb-4">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</h2>
        <p class="text-slate-500 text-xs tracking-[0.3em] uppercase">Built with Love</p>
    </footer>
</div>

<script>
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

@extends('layouts.app')
{{-- Template Name: Cherry Blossom (Mùa Valentine) - PREMIUM --}}

@section('title', 'Lễ Cưới ' . $wedding->groom_name . ' & ' . $wedding->bride_name)
@section('og_image', $shareUrl)

@section('content')

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

    @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Nunito:wght@300;400;600;700&display=swap&subset=vietnamese');
    
    :root {
        /* Standardized Theme Variables */
        --color-primary: #f43f5e; /* Rose 500 */
        --color-primary-dark: #be123c; /* Rose 700 */
        --color-primary-light: #ffe4e6; /* Rose 100 */
        --color-bg-secondary: #fff1f2; /* Rose 50 */
        --color-text-body: #881337; /* Rose 900 */
        --bg-paper: #ffffff;
        --bg-input: #fff1f2;
        
        --font-heading: 'utm-viceroyjf', 'Dancing Script', cursive;
        --font-body: 'Nunito', sans-serif;
        --radius-box: 24px; /* Soft rounded corners */
        --shadow-box: 0 15px 35px -5px rgba(244, 63, 94, 0.15);

        /* Custom Theme Colors */
        --pink-soft: #ffe4e6;
        --pink-accent: #f43f5e;
        --pink-deep: #881337;
    }

    body { font-family: var(--font-body); background-color: #fff0f5; color: var(--color-text-body); overflow-x: hidden; }
    h1, h2, h3, h4, .font-heading { font-family: var(--font-heading); }
    
    /* Soft Gradient Text */
    .text-gradient-pink {
        background: linear-gradient(135deg, #f43f5e, #be123c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Floating Petals Pattern */
    .bg-petals {
        background-color: #fff0f5;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23f43f5e' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    /* Animations */
    @keyframes sway { 0%, 100% { transform: rotate(-5deg); } 50% { transform: rotate(5deg); } }
    @keyframes float-soft { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
    @keyframes heartbeat-soft { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
    
    .animate-sway { animation: sway 4s ease-in-out infinite; }
    .animate-float-soft { animation: float-soft 6s ease-in-out infinite; }
    .animate-heartbeat { animation: heartbeat-soft 3s ease-in-out infinite; }

    /* Scroll Reveal */
    .reveal-on-scroll { opacity: 0; transform: translateY(30px) scale(0.95); transition: all 1s cubic-bezier(0.4, 0, 0.2, 1); }
    .reveal-on-scroll.revealed { opacity: 1; transform: translateY(0) scale(1); }

    /* Glass Effect (Light Pink) */
    .glass-pink {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 8px 32px 0 rgba(244, 63, 94, 0.1);
    }
    
    /* Image Frame */
    .blob-frame {
        border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
        overflow: hidden;
        transition: border-radius 8s ease-in-out;
        animation: morph 8s ease-in-out infinite;
    }
    @keyframes morph {
        0% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
        50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
        100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
    }
</style>

<div class="max-w-[480px] mx-auto bg-petals min-h-screen shadow-2xl relative overflow-hidden text-[#881337]">
    
    {{-- Pro Features --}}
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'heartbeat'])
    
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" />
    @endif
    
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    
    <x-wedding.music-player :wedding="$wedding" />

    {{-- HERO SECTION --}}
    <section class="min-h-screen relative flex flex-col justify-between pt-12 pb-8 overflow-hidden">
        {{-- Floating Background Blobs --}}
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-pink-200 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-float-soft"></div>
        <div class="absolute top-40 -right-20 w-72 h-72 bg-red-100 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-float-soft" style="animation-delay: -2s"></div>

        {{-- Main Image Frame --}}
        <div class="relative z-10 mx-6 mb-8 mt-4">
            <div class="blob-frame shadow-xl border-4 border-white aspect-[3/4] relative">
                <img src="{{ $heroUrl }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#f43f5e]/30 to-transparent"></div>
            </div>
            
            {{-- Floating Badge --}}
            <div class="absolute -bottom-6 -right-2 glass-pink p-4 rounded-full shadow-lg animate-sway origin-top-left">
                <div class="flex flex-col items-center">
                    <span class="text-3xl font-heading text-[#f43f5e]">{{ $wedding->event_date?->format('d') }}</span>
                    <span class="text-xs uppercase font-bold text-[#881337]">{{ $wedding->event_date?->format('M') }}</span>
                </div>
            </div>
        </div>

        {{-- Text Content --}}
        <div class="relative z-10 text-center px-6">
            <p class="text-sm uppercase tracking-[0.3em] text-[#f43f5e] mb-4 font-bold bg-white/50 inline-block px-4 py-1 rounded-full backdrop-blur-sm">Save The Date</p>
            
            <h1 class="text-5xl font-heading text-gradient-pink mb-2 drop-shadow-sm leading-tight">
                {{ $wedding->groom_name }}
            </h1>
            <div class="text-3xl font-heading text-[#f43f5e]/60 my-[-5px]">&</div>
            <h1 class="text-5xl font-heading text-gradient-pink mb-6 drop-shadow-sm leading-tight">
                {{ $wedding->bride_name }}
            </h1>

            <p class="text-[#881337] opacity-80 italic font-medium">
                "Hạnh phúc là khi được cùng người mình yêu đi đến cuối con đường."
            </p>
            
            <div class="mt-8 animate-bounce text-[#f43f5e]">
                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </div>
        </div>
    </section>

    {{-- COUPLE SECTION --}}
    <section class="py-20 px-6 relative bg-white/50 backdrop-blur-sm">
        <div class="text-center mb-16 reveal-on-scroll">
            <span class="text-4xl text-[#f43f5e] block mb-2">❤</span>
            <h2 class="font-heading text-4xl text-[#881337] mb-4">Cô Dâu & Chú Rể</h2>
        </div>

        <div class="space-y-20">
            {{-- Groom --}}
            <div class="reveal-on-scroll group">
                <div class="bg-white p-4 rounded-[2rem] shadow-lg transform group-hover:-rotate-2 transition duration-500 border border-pink-100">
                    <div class="aspect-square rounded-[1.5rem] overflow-hidden mb-6 relative">
                        <img src="{{ $groomPhoto }}" class="w-full h-full object-cover">
                        <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur px-4 py-2 rounded-lg shadow-sm">
                            <span class="text-xs font-bold uppercase text-[#f43f5e] tracking-widest">Chú Rể</span>
                        </div>
                    </div>
                    <div class="text-center px-4 pb-4">
                        <h3 class="font-heading text-3xl text-[#881337] mb-2">{{ $wedding->groom_name }}</h3>
                        <div class="text-sm text-gray-600 leading-relaxed">
                            @if($wedding->groom_father)<p>Con ông: <strong class="text-[#f43f5e]">{{ $wedding->groom_father }}</strong></p>@endif
                            @if($wedding->groom_mother)<p>Con bà: <strong class="text-[#f43f5e]">{{ $wedding->groom_mother }}</strong></p>@endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bride --}}
             <div class="reveal-on-scroll group">
                <div class="bg-white p-4 rounded-[2rem] shadow-lg transform group-hover:rotate-2 transition duration-500 border border-pink-100">
                    <div class="aspect-square rounded-[1.5rem] overflow-hidden mb-6 relative">
                        <img src="{{ $bridePhoto }}" class="w-full h-full object-cover">
                        <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur px-4 py-2 rounded-lg shadow-sm">
                            <span class="text-xs font-bold uppercase text-[#f43f5e] tracking-widest">Cô Dâu</span>
                        </div>
                    </div>
                    <div class="text-center px-4 pb-4">
                        <h3 class="font-heading text-3xl text-[#881337] mb-2">{{ $wedding->bride_name }}</h3>
                        <div class="text-sm text-gray-600 leading-relaxed">
                            @if($wedding->bride_father)<p>Con ông: <strong class="text-[#f43f5e]">{{ $wedding->bride_father }}</strong></p>@endif
                            @if($wedding->bride_mother)<p>Con bà: <strong class="text-[#f43f5e]">{{ $wedding->bride_mother }}</strong></p>@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- EVENTS --}}
    <section class="py-20 px-4 bg-[#fff1f2] relative overflow-hidden">
        {{-- Background Decoration --}}
         <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full mix-blend-overlay filter blur-3xl opacity-50"></div>
         
        <h2 class="text-center font-heading text-4xl text-[#f43f5e] mb-12 reveal-on-scroll">Sự Kiện Trọng Đại</h2>

        <div class="space-y-8 max-w-sm mx-auto z-10 relative">
            {{-- Groom Event --}}
            <div class="bg-white p-6 rounded-3xl shadow-md reveal-on-scroll border-l-8 border-[#f43f5e]">
                <h3 class="font-heading text-2xl text-[#881337] mb-4">Tiệc Nhà Trai</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-[#f43f5e]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-gray-400 font-bold">Thời gian</p>
                            <p class="font-bold text-lg">{{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-[#f43f5e] shrink-0">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-gray-400 font-bold">Địa điểm</p>
                            <p class="font-medium text-gray-700 text-sm">{{ $wedding->groom_reception_venue }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $wedding->groom_address }}</p>
                        </div>
                    </div>
                </div>
                 @if($wedding->groom_map_url)
                <a href="{{ $wedding->groom_map_url }}" target="_blank" class="block w-full text-center mt-6 py-3 bg-[#f43f5e] text-white rounded-xl font-bold text-sm hover:bg-[#be123c] transition shadow-lg shadow-pink-300/50">
                    Xem Bản Đồ
                </a>
                @endif
            </div>

            {{-- Bride Event --}}
            <div class="bg-white p-6 rounded-3xl shadow-md reveal-on-scroll border-r-8 border-[#f43f5e]">
                <h3 class="font-heading text-2xl text-[#881337] mb-4 text-right">Tiệc Nhà Gái</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 flex-row-reverse text-right">
                        <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-[#f43f5e]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-gray-400 font-bold">Thời gian</p>
                            <p class="font-bold text-lg">{{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 flex-row-reverse text-right">
                        <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-[#f43f5e] shrink-0">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-gray-400 font-bold">Địa điểm</p>
                            <p class="font-medium text-gray-700 text-sm">{{ $wedding->bride_reception_venue }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $wedding->bride_address }}</p>
                        </div>
                    </div>
                </div>
                 @if($wedding->bride_map_url)
                <a href="{{ $wedding->bride_map_url }}" target="_blank" class="block w-full text-center mt-6 py-3 bg-[#f43f5e] text-white rounded-xl font-bold text-sm hover:bg-[#be123c] transition shadow-lg shadow-pink-300/50">
                    Xem Bản Đồ
                </a>
                @endif
            </div>
        </div>
    </section>

    {{-- COUNTDOWN --}}
    @if($wedding->event_date && $wedding->event_date->isFuture())
    <section class="py-20 px-6 text-center bg-white">
        <h2 class="font-heading text-3xl text-[#f43f5e] mb-8">Cùng Đếm Ngược Nhé!</h2>
        <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="flex justify-center flex-wrap gap-4">
            <div class="bg-[#fff1f2] w-20 h-24 flex flex-col justify-center items-center rounded-2xl shadow-sm border border-pink-100 animate-heartbeat">
                <div class="text-3xl font-heading font-bold text-[#f43f5e] mb-1" x-text="days">00</div>
                <div class="text-[10px] uppercase text-gray-500 font-bold">Ngày</div>
            </div>
            <div class="bg-[#fff1f2] w-20 h-24 flex flex-col justify-center items-center rounded-2xl shadow-sm border border-pink-100">
                <div class="text-3xl font-heading font-bold text-[#f43f5e] mb-1" x-text="hours">00</div>
                <div class="text-[10px] uppercase text-gray-500 font-bold">Giờ</div>
            </div>
            <div class="bg-[#fff1f2] w-20 h-24 flex flex-col justify-center items-center rounded-2xl shadow-sm border border-pink-100">
                <div class="text-3xl font-heading font-bold text-[#f43f5e] mb-1" x-text="minutes">00</div>
                <div class="text-[10px] uppercase text-gray-500 font-bold">Phút</div>
            </div>
            <div class="bg-[#fff1f2] w-20 h-24 flex flex-col justify-center items-center rounded-2xl shadow-sm border border-pink-100">
                <div class="text-3xl font-heading font-bold text-[#f43f5e] mb-1" x-text="seconds">00</div>
                <div class="text-[10px] uppercase text-gray-500 font-bold">Giây</div>
            </div>
        </div>
    </section>
    @endif

    {{-- STORY / LỜI NGỎ --}}
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
                <p class="font-viceroy text-4xl text-[#f43f5e] pt-6">Chân thành cảm ơn bạn ♥ ♥</p>
            </div>
        </div>
    </section>

    {{-- GALLERY --}}
    <section class="py-16 px-4 bg-[#fff1f2]" data-aos="fade-up">
        <h2 class="text-center font-heading text-4xl text-[#f43f5e] mb-10">Khoảnh Khắc Ngọt Ngào</h2>
        <div class="columns-2 gap-3 space-y-3">
            @if($wedding->gallery_images->isNotEmpty())
                @foreach($wedding->gallery_images as $media)
                <div class="break-inside-avoid relative rounded-xl overflow-hidden shadow-md group">
                    <img src="{{ $media->getUrl() }}" class="w-full transition duration-700 group-hover:scale-105">
                     <div class="absolute inset-0 bg-[#f43f5e]/20 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                </div>
                @endforeach
            @else
                @foreach(['https://images.unsplash.com/photo-1519741497674-611481863552?w=600', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=600', 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=600', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=600'] as $placeholder)
               <div class="break-inside-avoid relative rounded-xl overflow-hidden shadow-md group">
                    <img src="{{ $placeholder }}" class="w-full transition duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-[#f43f5e]/20 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                </div>
                @endforeach
            @endif
        </div>
    </section>

    {{-- GIFT BOX & RSVP & GUESTBOOK --}}
    <div class="py-20 bg-white space-y-16">
        
        {{-- Gift Box --}}
        <div class="px-6">
            <x-wedding.gift-box :wedding="$wedding">
                <div class="text-center py-8 px-4 bg-[#fff1f2] rounded-2xl border border-pink-200">
                    <h2 class="font-heading text-3xl text-[#f43f5e] mb-6">Hộp Mừng Cưới</h2>
                    <div class="flex flex-wrap justify-center gap-4">
                        <button @click="showQr = 'groom'" class="bg-white text-[#f43f5e] font-bold px-8 py-3 rounded-full text-xs uppercase tracking-widest hover:bg-pink-50 transition shadow-md border border-pink-100">Nhà Trai</button>
                        <button @click="showQr = 'bride'" class="bg-white text-[#f43f5e] font-bold px-8 py-3 rounded-full text-xs uppercase tracking-widest hover:bg-pink-50 transition shadow-md border border-pink-100">Nhà Gái</button>
                    </div>
                </div>
            </x-wedding.gift-box>
        </div>

        <div class="px-4">
             @include('components.wedding.rsvp-form', ['wedding' => $wedding])
        </div>

        <div class="px-4">
             @include('components.wedding.guestbook', ['wedding' => $wedding])
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="py-16 bg-[#fff1f2] text-center border-t border-pink-200">
        <h2 class="font-heading text-4xl text-[#f43f5e] mb-4">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</h2>
        <div class="animate-heartbeat text-2xl">❤</div>
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

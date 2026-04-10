@extends('layouts.app')
{{-- Template Name: Galaxy Dreams (Ngân Hà Lung Linh) - PREMIUM --}}

@section('title', 'Galaxy Wedding | ' . $wedding->groom_name . ' & ' . $wedding->bride_name)
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

    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Exo+2:ital,wght@0,300;0,400;0,600;1,400&display=swap&subset=vietnamese');
    
    :root {
        /* Standardized Theme Variables */
        --color-primary: #ec4899; /* Pink 500 */
        --color-primary-dark: #be185d;
        --color-primary-light: #fbcfe8;
        --color-bg-secondary: #0f0f23;
        --color-text-body: #e0e7ff; /* Indigo 100 */
        --bg-paper: #0f0f23; 
        --bg-input: #ffffff;
        
        --font-heading: 'utm-viceroyjf', 'Orbitron', sans-serif;
        --font-body: 'Exo 2', sans-serif;
        --radius-box: 16px; 
        --shadow-box: 0 0 30px rgba(0, 243, 255, 0.2);

        /* Custom Theme Colors */
        --neon-cyan: #00f3ff;
        --neon-pink: #ec4899;
        --deep-space: #050510;
        --space-blue: #0c0c1e;
    }

    body { 
        font-family: var(--font-body); 
        background-color: var(--deep-space); 
        color: var(--color-text-body); 
        overflow-x: hidden; 
        background: radial-gradient(circle at 50% 0%, #1a1a40 0%, #050510 60%);
    }

    h1, h2, h3, h4, .font-heading { font-family: var(--font-heading); letter-spacing: 1px; }

    /* Neon Glow Text */
    .text-glow-cyan { text-shadow: 0 0 10px rgba(0, 243, 255, 0.7), 0 0 20px rgba(0, 243, 255, 0.4); }
    .text-glow-pink { text-shadow: 0 0 10px rgba(236, 72, 153, 0.7), 0 0 20px rgba(236, 72, 153, 0.4); }
    
    /* Neon Borders */
    .border-glow-cyan { box-shadow: 0 0 15px rgba(0, 243, 255, 0.3); border: 1px solid rgba(0, 243, 255, 0.5); }
    .border-glow-pink { box-shadow: 0 0 15px rgba(236, 72, 153, 0.3); border: 1px solid rgba(236, 72, 153, 0.5); }

    /* Glass Neon Card */
    .glass-neon {
        background: rgba(15, 15, 35, 0.7);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(0, 243, 255, 0.1);
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.5), inset 0 0 20px rgba(0, 243, 255, 0.05);
    }

    /* Animations */
    @keyframes float-space { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-20px) rotate(2deg); } }
    @keyframes pulse-neon { 0%, 100% { opacity: 0.8; filter: brightness(100%); } 50% { opacity: 1; filter: brightness(130%); } }
    
    .animate-float-space { animation: float-space 8s ease-in-out infinite; }
    .animate-pulse-neon { animation: pulse-neon 2s infinite; }

    /* Stars */
    .star-bg { position: absolute; background: white; border-radius: 50%; animation: twinkle linear infinite; }
    @keyframes twinkle { 0%, 100% { opacity: 0.3; transform: scale(0.8); } 50% { opacity: 1; transform: scale(1.2); box-shadow: 0 0 4px white; } }

    /* Scroll Reveal */
    .reveal-on-scroll { opacity: 0; transform: translateY(30px) scale(0.95); filter: blur(10px); transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
    .reveal-on-scroll.revealed { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
</style>

<div class="max-w-[480px] mx-auto bg-[#0c0c1e] min-h-screen shadow-2xl relative overflow-hidden text-[#e0e7ff]">

    {{-- Background Stars --}}
    <div id="stars-container" class="absolute inset-0 pointer-events-none z-0 h-full overflow-hidden"></div>
    
    {{-- Pro Features --}}
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'heartbeat'])
    
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" />
    @endif
    
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    
    <x-wedding.music-player :wedding="$wedding" />

    {{-- STORY / LỜI NGỎ --}}
    <section class="relative py-32 px-6 overflow-hidden" data-aos="fade-up">
        {{-- Cosmic Background for Story --}}
        <div class="absolute inset-0 z-0">
             <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-gradient-to-b from-purple-900/40 to-transparent blur-[100px]"></div>
        </div>

        <div class="relative z-10 text-center text-white" data-aos="zoom-in">
            <div class="inline-block relative mb-12">
                <h2 class="font-viceroy text-6xl mb-2 text-glow-cyan">Lời Ngỏ</h2>
                <div class="absolute -bottom-4 left-0 w-full h-8">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 356.13 42.62" fill="white" class="opacity-50">
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
                <p class="font-viceroy text-4xl text-[#00f3ff] pt-6 text-glow-cyan">Chân thành cảm ơn bạn ♥ ♥</p>
            </div>
        </div>
    </section>

    {{-- HERO SECTION --}}
    <section class="min-h-screen relative flex flex-col justify-center items-center overflow-hidden py-12" data-aos="fade">
        {{-- Background Gradients --}}
        <div class="absolute inset-0 z-0">
             <div class="absolute top-[10%] left-[20%] w-80 h-80 bg-purple-600/30 rounded-full blur-[100px] animate-pulse-neon"></div>
             <div class="absolute bottom-[20%] right-[10%] w-64 h-64 bg-cyan-600/30 rounded-full blur-[100px] animate-pulse-neon" style="animation-delay: 1s"></div>
        </div>

        {{-- Main Frame --}}
        <div class="relative z-10 w-full px-8 mb-8">
            <div class="relative aspect-[3/4] rounded-2xl p-1 bg-gradient-to-br from-[#00f3ff] to-[#ec4899] animate-float-space">
                <div class="absolute -inset-4 bg-gradient-to-br from-[#00f3ff] to-[#ec4899] opacity-30 blur-xl rounded-[2rem]"></div>
                <div class="w-full h-full rounded-xl overflow-hidden relative">
                    <img src="{{ $heroUrl }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#050510] via-transparent to-transparent"></div>
                    
                    {{-- Date Badge --}}
                    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 glass-neon px-6 py-3 rounded-full flex gap-3 items-center whitespace-nowrap">
                        <span class="text-[#00f3ff] font-bold font-heading text-lg drop-shadow-[0_0_5px_rgba(0,243,255,0.8)]">{{ $wedding->event_date?->format('d . m') }}</span>
                        <span class="w-px h-4 bg-white/30"></span>
                        <span class="text-[#ec4899] font-bold font-heading text-lg drop-shadow-[0_0_5px_rgba(236,72,153,0.8)]">{{ $wedding->event_date?->format('Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Text Content --}}
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl md:text-5xl font-heading font-bold mb-2 leading-tight tracking-wider">
                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-white to-[#00f3ff] text-glow-cyan">{{ $wedding->groom_name }}</span>
                <span class="text-2xl text-white/50 block my-1">&</span>
                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-[#ec4899] to-white text-glow-pink">{{ $wedding->bride_name }}</span>
            </h1>
            
            <p class="text-sm uppercase tracking-[0.4em] text-white/60 mt-6 font-bold">The Wedding</p>
            
            <div class="mt-12 animate-bounce text-[#00f3ff]">
                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </div>
        </div>
    </section>

    {{-- COUPLE SECTION --}}
    <section class="py-20 px-6 relative bg-[#0f0f23]/50 backdrop-blur-sm" data-aos="fade-up">
        <div class="text-center mb-16 reveal-on-scroll">
            <h2 class="font-heading text-3xl text-white mb-2 text-glow-cyan">Star-Crossed Lovers</h2>
            <div class="w-32 h-1 bg-gradient-to-r from-transparent via-[#ec4899] to-transparent mx-auto"></div>
        </div>

        <div class="space-y-16">
            {{-- Groom --}}
            <div class="reveal-on-scroll group relative">
                <div class="absolute -left-4 -top-4 w-20 h-20 border-t-2 border-l-2 border-[#00f3ff] rounded-tl-3xl opacity-50 group-hover:opacity-100 transition duration-500"></div>
                <div class="glass-neon p-4 rounded-2xl relative z-10">
                    <div class="aspect-[3/4] rounded-xl overflow-hidden mb-4 border border-white/10">
                        <img src="{{ $groomPhoto }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                    </div>
                    <div class="text-center">
                        <h3 class="font-heading text-2xl text-[#00f3ff] mb-1 text-glow-cyan">{{ $wedding->groom_name }}</h3>
                        <p class="text-[10px] uppercase font-bold tracking-widest text-[#ec4899] mb-3">The Groom</p>
                        <p class="text-sm text-gray-400">
                            Con ông <span class="text-white">{{ $wedding->groom_father }}</span><br>
                            & bà <span class="text-white">{{ $wedding->groom_mother }}</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Bride --}}
            <div class="reveal-on-scroll group relative">
                <div class="absolute -right-4 -bottom-4 w-20 h-20 border-b-2 border-r-2 border-[#ec4899] rounded-br-3xl opacity-50 group-hover:opacity-100 transition duration-500"></div>
                <div class="glass-neon p-4 rounded-2xl relative z-10">
                    <div class="aspect-[3/4] rounded-xl overflow-hidden mb-4 border border-white/10">
                        <img src="{{ $bridePhoto }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                    </div>
                    <div class="text-center">
                        <h3 class="font-heading text-2xl text-[#ec4899] mb-1 text-glow-pink">{{ $wedding->bride_name }}</h3>
                        <p class="text-[10px] uppercase font-bold tracking-widest text-[#00f3ff] mb-3">The Bride</p>
                        <p class="text-sm text-gray-400">
                            Con ông <span class="text-white">{{ $wedding->bride_father }}</span><br>
                            & bà <span class="text-white">{{ $wedding->bride_mother }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- EVENTS --}}
    <section class="py-24 px-4 relative overflow-hidden" data-aos="fade-up">
        {{-- Planet Decoration --}}
        <div class="absolute top-[20%] right-[-100px] w-[300px] h-[300px] rounded-full bg-gradient-to-b from-[#ec4899]/10 to-transparent blur-[3px] border border-white/5 opacity-50"></div>

        <h2 class="text-center font-heading text-3xl text-white mb-16 reveal-on-scroll text-glow-cyan">Mission Control</h2>

        <div class="space-y-12 max-w-sm mx-auto z-10 relative">
            {{-- Groom Event --}}
            <div class="glass-neon p-6 rounded-3xl reveal-on-scroll hover:border-[#00f3ff]/50 transition duration-500">
                <div class="flex flex-col items-center text-center">
                    <div class="w-12 h-12 rounded-full border border-[#00f3ff] flex items-center justify-center text-[#00f3ff] mb-4 shadow-[0_0_15px_rgba(0,243,255,0.3)] bg-[#00f3ff]/10">
                        <span class="font-heading font-bold text-lg">G</span>
                    </div>
                    <h3 class="font-heading text-xl text-white mb-2 uppercase tracking-wider">Nhà Trai</h3>
                    
                    <div class="text-3xl font-heading font-bold text-[#00f3ff] mb-1 text-glow-cyan">
                        {{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }}
                    </div>
                    <p class="text-xs uppercase text-gray-500 font-bold mb-4 tracking-widest">Tiệc Cưới</p>
                    
                    <p class="text-gray-300 text-sm mb-2">{{ $wedding->groom_reception_venue }}</p>
                    <div class="w-full h-px bg-white/10 my-4"></div>
                    <p class="text-gray-400 text-xs">{{ $wedding->groom_address }}</p>

                     @if($wedding->groom_map_url)
                    <a href="{{ $wedding->groom_map_url }}" target="_blank" class="mt-6 px-6 py-2 border border-[#00f3ff] text-[#00f3ff] rounded-full text-xs font-bold uppercase hover:bg-[#00f3ff] hover:text-black transition shadow-[0_0_10px_rgba(0,243,255,0.2)]">
                        Locate
                    </a>
                    @endif
                </div>
            </div>

            {{-- Bride Event --}}
             <div class="glass-neon p-6 rounded-3xl reveal-on-scroll hover:border-[#ec4899]/50 transition duration-500">
                <div class="flex flex-col items-center text-center">
                    <div class="w-12 h-12 rounded-full border border-[#ec4899] flex items-center justify-center text-[#ec4899] mb-4 shadow-[0_0_15px_rgba(236,72,153,0.3)] bg-[#ec4899]/10">
                        <span class="font-heading font-bold text-lg">B</span>
                    </div>
                    <h3 class="font-heading text-xl text-white mb-2 uppercase tracking-wider">Nhà Gái</h3>
                     
                    <div class="text-3xl font-heading font-bold text-[#ec4899] mb-1 text-glow-pink">
                        {{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }}
                    </div>
                    <p class="text-xs uppercase text-gray-500 font-bold mb-4 tracking-widest">Tiệc Cưới</p>
                    
                    <p class="text-gray-300 text-sm mb-2">{{ $wedding->bride_reception_venue }}</p>
                     <div class="w-full h-px bg-white/10 my-4"></div>
                    <p class="text-gray-400 text-xs">{{ $wedding->bride_address }}</p>

                    @if($wedding->bride_map_url)
                    <a href="{{ $wedding->bride_map_url }}" target="_blank" class="mt-6 px-6 py-2 border border-[#ec4899] text-[#ec4899] rounded-full text-xs font-bold uppercase hover:bg-[#ec4899] hover:text-black transition shadow-[0_0_10px_rgba(236,72,153,0.2)]">
                        Locate
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- COUNTDOWN --}}
    @if($wedding->event_date && $wedding->event_date->isFuture())
    <section class="py-24 px-6 text-center bg-[#050510]" data-aos="zoom-in">
        <h2 class="font-heading text-3xl text-white mb-8 text-glow-cyan">Launch Sequence</h2>
        <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="flex justify-center flex-wrap gap-4">
            <div class="glass-neon w-20 h-24 flex flex-col justify-center items-center rounded-xl p-2 animate-pulse-neon">
                <div class="text-3xl font-heading font-bold text-[#ec4899] mb-1" x-text="days">00</div>
                <div class="text-[10px] uppercase text-white/50 font-bold">Days</div>
            </div>
            <div class="glass-neon w-20 h-24 flex flex-col justify-center items-center rounded-xl p-2">
                <div class="text-3xl font-heading font-bold text-[#00f3ff] mb-1" x-text="hours">00</div>
                <div class="text-[10px] uppercase text-white/50 font-bold">Hrs</div>
            </div>
            <div class="glass-neon w-20 h-24 flex flex-col justify-center items-center rounded-xl p-2">
                <div class="text-3xl font-heading font-bold text-[#ec4899] mb-1" x-text="minutes">00</div>
                <div class="text-[10px] uppercase text-white/50 font-bold">Mins</div>
            </div>
            <div class="glass-neon w-20 h-24 flex flex-col justify-center items-center rounded-xl p-2">
                <div class="text-3xl font-heading font-bold text-[#00f3ff] mb-1" x-text="seconds">00</div>
                <div class="text-[10px] uppercase text-white/50 font-bold">Secs</div>
            </div>
        </div>
    </section>
    @endif

    {{-- GALLERY --}}
    <section class="py-20 px-4" data-aos="fade-up">
        <h2 class="text-center font-heading text-4xl text-white mb-10 text-glow-pink">Nebula Memories</h2>
        <div class="columns-2 gap-3 space-y-3">
            @if($wedding->gallery_images->isNotEmpty())
                @foreach($wedding->gallery_images as $media)
                <div class="break-inside-avoid relative rounded-xl overflow-hidden shadow-lg border border-white/10 group">
                    <img src="{{ $media->getUrl() }}" class="w-full transition duration-700 group-hover:scale-110 opacity-80 group-hover:opacity-100">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#ec4899]/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                </div>
                @endforeach
            @else
                @foreach(['https://images.unsplash.com/photo-1519741497674-611481863552?w=600', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=600', 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=600', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=600'] as $placeholder)
                <div class="break-inside-avoid relative rounded-xl overflow-hidden shadow-lg border border-white/10 group">
                    <img src="{{ $placeholder }}" class="w-full transition duration-700 group-hover:scale-110 opacity-80 group-hover:opacity-100">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#ec4899]/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                </div>
                @endforeach
            @endif
        </div>
    </section>

    {{-- GIFT BOX & RSVP & GUESTBOOK --}}
    <div class="py-20 bg-[#0f0f23] space-y-16 relative">
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[#00f3ff]/30 to-transparent"></div>

        {{-- Gift Box --}}
        <div class="px-6">
            <x-wedding.gift-box :wedding="$wedding">
                <div class="text-center py-8 px-4 glass-neon rounded-2xl">
                    <h2 class="font-heading text-3xl text-[#00f3ff] mb-6 text-glow-cyan">Sending Love</h2>
                    <div class="flex flex-wrap justify-center gap-4">
                        <button @click="showQr = 'groom'" class="bg-[#00f3ff]/10 border border-[#00f3ff] text-[#00f3ff] font-bold px-8 py-3 rounded-xl text-xs uppercase tracking-widest hover:bg-[#00f3ff] hover:text-black transition shadow-[0_0_10px_rgba(0,243,255,0.2)]">Nhà Trai</button>
                        <button @click="showQr = 'bride'" class="bg-[#ec4899]/10 border border-[#ec4899] text-[#ec4899] font-bold px-8 py-3 rounded-xl text-xs uppercase tracking-widest hover:bg-[#ec4899] hover:text-black transition shadow-[0_0_10px_rgba(236,72,153,0.2)]">Nhà Gái</button>
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
    <footer class="py-20 bg-[#050510] text-center border-t border-white/10 relative">
        <h2 class="font-heading text-3xl text-white mb-2">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</h2>
        <p class="text-[10px] uppercase text-gray-600 tracking-[0.5em]">Infinite Love</p>
    </footer>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Intersection Observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        });
        document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));

        // Create Static Stars
        const container = document.getElementById('stars-container');
        if (container) {
            for (let i = 0; i < 80; i++) {
                const star = document.createElement('div');
                star.className = 'star-bg';
                star.style.width = Math.random() * 2 + 'px';
                star.style.height = star.style.width;
                star.style.left = Math.random() * 100 + '%';
                star.style.top = Math.random() * 100 + '%';
                star.style.animationDuration = (Math.random() * 3 + 2) + 's'; 
                container.appendChild(star);
            }
        }
    });
</script>

@push('scripts')
    <x-wedding.countdown-script />
@endpush
@endsection

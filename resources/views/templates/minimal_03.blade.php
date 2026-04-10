@extends('layouts.app')
{{-- Template Name: Editorial Magazine (Tạp Chí Thời Trang) --}}

@section('title', 'The Union | ' . $wedding->groom_name . ' & ' . $wedding->bride_name)

@section('content')
@section('og_image', $shareUrl)

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
    
    @import url('https://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400;500&family=Dancing+Script:wght@400;700&display=swap&subset=vietnamese');
    
    :root {
        --bg-color: #f4f4f0;
        --text-color: #1a1a1a;
        --accent-color: #8c8c88;

        /* Theming for Shared Components */
        --color-primary: #111827; /* gray-900 */
        --color-primary-dark: #000000;
        --color-primary-light: #f3f4f6; /* gray-100 */
        --color-bg-secondary: #f9fafb; /* gray-50 */
        --color-text-body: #1a1a1a;
        --bg-paper: #ffffff;
        --bg-input: #fdfdfd;
        --font-heading: 'utm-viceroyjf', 'Italiana', serif;
        --font-body: 'Jost', sans-serif;
        --radius-box: 0px; /* Editorial Magazine style = squares */
        --shadow-box: none; /* Flat design */    }

    body { font-family: 'Jost', sans-serif; background-color: var(--bg-color); color: var(--text-color); }
    h1, h2, h3, .font-display { font-family: 'utm-viceroyjf', serif; }

    .tracking-widest-xl { letter-spacing: 0.3em; }
    
    /* Editorial Grid Layout */
    .editorial-grid {
        display: grid;
        grid-template-columns: 1fr 11fr;
        gap: 1rem;
    }
    .vertical-text {
        writing-mode: vertical-rl;
        transform: rotate(180deg);
        text-transform: uppercase;
        letter-spacing: 0.2em;
        font-size: 10px;
        color: var(--accent-color);
        border-left: 1px solid #e0e0e0;
        padding-left: 10px;
        height: 100%;
        display: flex;
        align-items: center;
    }
    
    /* Premium Subtle Animations */
    @keyframes fadeSlideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes gentleFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
    @keyframes lineReveal { from { width: 0; } to { width: 100%; } }
    
    .animate-fade-slide { animation: fadeSlideUp 0.8s ease-out forwards; opacity: 0; }
    .animate-gentle-float { animation: gentleFloat 4s ease-in-out infinite; }
    .animate-line-reveal { animation: lineReveal 1s ease-out forwards; }
    
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-500 { animation-delay: 0.5s; }
    
    /* Clean Hover Effects */
    .hover-subtle { transition: all 0.3s ease; }
    .hover-subtle:hover { transform: translateY(-3px); }
</style>

<div class="max-w-[480px] mx-auto bg-[#fdfdfd] min-h-screen shadow-xl relative text-[#1a1a1a]">

    {{-- Pro Features: Preload Animation & Falling Effects --}}
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'heartbeat'])
    {{-- Invitation Wrapper (Envelope) --}}
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" />
    @endif
    
    @include('components.wedding.falling-effects', ['wedding' => $wedding])

    {{-- Music Player (Global Premium Vinyl) --}}
    <x-wedding.music-player :wedding="$wedding" />

    {{-- MAGAZINE COVER HERO --}}
    <section class="h-screen relative flex flex-col justify-between p-6 bg-[#f4f4f0]" data-aos="fade">
        <div class="flex justify-between items-start pt-4 border-b border-black/10 pb-4">
            <span class="text-[10px] uppercase tracking-widest font-bold">Volume. 01</span>
            <span class="text-[10px] uppercase tracking-widest font-bold">The Wedding Edition</span>
            <span class="text-[10px] uppercase tracking-widest font-bold">{{ now()->year }}</span>
        </div>

        <div class="absolute inset-0 top-32 bottom-24 mx-6 z-0">
             <img src="{{ $heroUrl }}" class="w-full h-full object-cover">
        </div>

        <div class="relative z-10 text-center mt-auto mb-12 bg-white/95 backdrop-blur-sm p-8 mx-4 shadow-sm border border-black/5">
            <h1 class="text-5xl md:text-6xl uppercase tracking-tighter leading-[0.9] mb-4 text-black">
                {{ $wedding->groom_name }} <br> 
                <span class="text-4xl italic lowercase font-serif text-[#666]">&</span> <br>
                {{ $wedding->bride_name }}
            </h1>
            <p class="text-xs uppercase tracking-[0.4em] font-medium mt-6 text-black">Save The Date</p>
            <p class="text-lg font-display mt-2 text-black">{{ $wedding->event_date?->format('F d, Y') }}</p>
        </div>
    </section>

    {{-- EDITORIAL COUPLE --}}
    <section class="py-16 px-6" data-aos="fade-up">
        <div class="mb-12">
            <h2 class="text-8xl font-display opacity-5 absolute -left-4 pointer-events-none">Love</h2>
            <p class="text-[10px] uppercase tracking-[0.3em] font-bold border-l-2 border-black pl-3 ml-2">The Protagonists</p>
        </div>

        <div class="space-y-12">
            {{-- GROOM --}}
            <div class="editorial-grid">
                <div class="vertical-text">The Groom</div>
                <div>
                    <div class="w-full aspect-[3/4] overflow-hidden mb-4 relative">
                        {{-- No Grayscale, No contrast filter --}}
                        <img src="{{ $groomPhoto }}" class="w-full h-full object-cover">
                        <div class="absolute bottom-0 right-0 bg-white px-4 py-2 border border-gray-100">
                             <h3 class="text-2xl font-display text-black">{{ $wedding->groom_name }}</h3>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed pl-4 border-l border-gray-200">
                        "Là một người đàn ông của gia đình, anh luôn tâm niệm rằng hạnh phúc không phải là những điều to lớn, mà là những khoảnh khắc bình yên bên người mình yêu."
                    </p>
                    <div class="text-[10px] text-gray-400 mt-4 pl-4 space-y-1">
                        @if($wedding->groom_father)<p>Con ông: {{ $wedding->groom_father }}</p>@endif
                        @if($wedding->groom_mother)<p>Con bà: {{ $wedding->groom_mother }}</p>@endif
                    </div>
                </div>
            </div>

            {{-- BRIDE --}}
            <div class="editorial-grid" style="grid-template-columns: 11fr 1fr;">
                <div class="text-right">
                    <div class="w-full aspect-[3/4] overflow-hidden mb-4 relative">
                         {{-- No Grayscale, No contrast filter --}}
                        <img src="{{ $bridePhoto }}" class="w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 bg-white px-4 py-2 border border-gray-100">
                             <h3 class="text-2xl font-display text-black">{{ $wedding->bride_name }}</h3>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed pr-4 border-r border-gray-200 inline-block text-right">
                        "Em không cần một câu chuyện cổ tích, em chỉ cần một hiện thực mà ở đó có anh cùng em đi qua những tháng năm."
                    </p>
                    <div class="text-[10px] text-gray-400 mt-4 pr-4 space-y-1 text-right">
                        @if($wedding->bride_father)<p>Con ông: {{ $wedding->bride_father }}</p>@endif
                        @if($wedding->bride_mother)<p>Con bà: {{ $wedding->bride_mother }}</p>@endif
                    </div>
                </div>
                <div class="vertical-text" style="writing-mode: vertical-lr; transform: none; border-left: none; border-right: 1px solid #e0e0e0; padding-left: 0; padding-right: 10px;">The Bride</div>
            </div>
        </div>
    </section>

    {{-- COUNTDOWN TYPOGRAPHY --}}
    @if($wedding->event_date && $wedding->event_date->isFuture())
    <section class="py-16 px-6 bg-[#1a1a1a] text-[#f4f4f0] overflow-hidden relative">
        <h2 class="text-[120px] leading-none font-display opacity-10 absolute -top-10 -right-20 pointer-events-none whitespace-nowrap">Forever</h2>
        
        <div class="relative z-10">
            <p class="text-xs uppercase tracking-[0.4em] mb-12 border-b border-gray-700 pb-4 inline-block">Countdown To Eternity</p>
            <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="flex flex-col gap-8">
                <div class="flex items-baseline justify-between border-b border-gray-800 pb-2">
                    <span class="text-xs uppercase tracking-widest text-gray-500">Days Remaining</span>
                    <span x-text="days" class="text-6xl font-display"></span>
                </div>
                <div class="flex items-baseline justify-between border-b border-gray-800 pb-2">
                    <span class="text-xs uppercase tracking-widest text-gray-500">Hours</span>
                    <span x-text="hours" class="text-6xl font-display"></span>
                </div>
                <div class="flex items-baseline justify-between border-b border-gray-800 pb-2">
                    <span class="text-xs uppercase tracking-widest text-gray-500">Minutes</span>
                    <span x-text="minutes" class="text-6xl font-display"></span>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- EVENTS MINIMAL LIST --}}
    <section class="py-16 px-6 bg-[#fdfdfd]" data-aos="fade-up">
        <div class="mb-16 text-center">
            <h2 class="text-4xl font-display mb-2 text-black">The Timeline</h2>
            <p class="text-[10px] uppercase tracking-widest text-gray-400">Save these moments</p>
        </div>

        <div class="space-y-12 max-w-sm mx-auto">
            {{-- NHÀ GÁI --}}
            <div class="block"> {{-- Removed group/hover --}}
                <div class="flex items-center gap-4 mb-4">
                    <span class="text-4xl font-display text-black">01.</span>
                    <h3 class="text-xl uppercase tracking-widest border-b border-gray-200 flex-1 pb-1 text-black">Nhà Gái</h3>
                </div>
                
                <div class="pl-12 space-y-8">
                    @if($wedding->bride_reception_time)
                    <div>
                        <p class="font-bold text-xs uppercase tracking-wider mb-1 text-gray-500">Tiệc Cưới</p>
                        <p class="text-2xl font-display italic text-black">{{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $wedding->bride_reception_venue }}</p>
                    </div>
                    @endif

                    <div>
                        <p class="font-bold text-xs uppercase tracking-wider mb-1 text-gray-500">Lễ Vu Quy</p>
                         <div class="flex items-baseline gap-3 mb-1">
                            <span class="text-2xl font-display italic text-black">{{ $wedding->bride_ceremony_time ? \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') : '--' }}</span>
                            <span class="text-xs text-black uppercase">{{ $wedding->bride_ceremony_date ? \Carbon\Carbon::parse($wedding->bride_ceremony_date)->format('M d') : '' }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">{{ $wedding->bride_address }}</p>
                        @if($wedding->bride_map_url)
                        <a href="{{ $wedding->bride_map_url }}" target="_blank" class="text-[10px] uppercase font-bold border border-black px-4 py-2 bg-white text-black hover:bg-black hover:text-white transition">Google Maps</a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- NHÀ TRAI --}}
             <div class="block">
                <div class="flex items-center gap-4 mb-4">
                    <span class="text-4xl font-display text-black">02.</span>
                    <h3 class="text-xl uppercase tracking-widest border-b border-gray-200 flex-1 pb-1 text-black">Nhà Trai</h3>
                </div>
                
                <div class="pl-12 space-y-8">
                    @if($wedding->groom_reception_time)
                    <div>
                        <p class="font-bold text-xs uppercase tracking-wider mb-1 text-gray-500">Tiệc Cưới</p>
                        <p class="text-2xl font-display italic text-black">{{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $wedding->groom_reception_venue }}</p>
                    </div>
                    @endif

                    <div>
                        <p class="font-bold text-xs uppercase tracking-wider mb-1 text-gray-500">Lễ Thành Hôn</p>
                         <div class="flex items-baseline gap-3 mb-1">
                            <span class="text-2xl font-display italic text-black">{{ $wedding->groom_ceremony_time ? \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') : '--' }}</span>
                            <span class="text-xs text-black uppercase">{{ $wedding->groom_ceremony_date ? \Carbon\Carbon::parse($wedding->groom_ceremony_date)->format('M d') : '' }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">{{ $wedding->groom_address }}</p>
                        @if($wedding->groom_map_url)
                        <a href="{{ $wedding->groom_map_url }}" target="_blank" class="text-[10px] uppercase font-bold border border-black px-4 py-2 bg-white text-black hover:bg-black hover:text-white transition">Google Maps</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- RSVP & WISHES --}}
    <x-wedding.gift-box :wedding="$wedding" class="py-16 px-6 bg-[#f4f4f0]">
        <h2 class="text-center font-display text-4xl mb-12">Box of Wishes</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-0 border border-black/10 max-w-md mx-auto mb-10 bg-white">
            <button @click="showQr = 'groom'" class="p-8 border-b md:border-b-0 md:border-r border-black/10 hover:bg-gray-50 transition text-left">
                <span class="block text-[10px] uppercase tracking-widest text-gray-500 mb-2">For The</span>
                <span class="text-2xl font-display block text-black">Groom's Family</span>
            </button>
            <button @click="showQr = 'bride'" class="p-8 hover:bg-gray-50 transition text-right">
                 <span class="block text-[10px] uppercase tracking-widest text-gray-500 mb-2">For The</span>
                <span class="text-2xl font-display block text-black">Bride's Family</span>
            </button>
        </div>


    </x-wedding.gift-box>

    {{-- RSVP Section --}}
    @include('components.wedding.rsvp-form', ['wedding' => $wedding])

    {{-- Guestbook Section --}}
    @include('components.wedding.guestbook', ['wedding' => $wedding])

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
                <p class="font-viceroy text-4xl text-[#D4AF37] pt-6">Chân thành cảm ơn bạn ♥ ♥</p>
            </div>
        </div>
    </section>

    {{-- GALLERY EDITORIAL --}}
    <section class="py-16 px-4 bg-white" data-aos="fade-up">
        <h2 class="text-[10vw] font-display text-center leading-none opacity-5 mb-[-5vw] relative z-0 text-black">Memories</h2>
        <div class="columns-1 md:columns-2 gap-8 space-y-8 relative z-10 px-4">
            @if($wedding->gallery_images->isNotEmpty())
                @foreach($wedding->gallery_images as $media)
                <div class="break-inside-avoid">
                    <img src="{{ $media->getUrl() }}" class="w-full h-auto">
                </div>
                @endforeach
            @else
                {{-- Placeholder gallery for demo --}}
                @foreach(['https://images.unsplash.com/photo-1519741497674-611481863552?w=600', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=600', 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=600', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=600', 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=600', 'https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=600'] as $placeholder)
                <div class="break-inside-avoid">
                    <img src="{{ $placeholder }}" class="w-full h-auto">
                </div>
                @endforeach
            @endif
        </div>
    </section>

    <footer class="py-12 bg-[#f4f4f0] text-center border-t border-black/5">
        <p class="font-display text-2xl mb-4">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</p>
        <p class="text-[10px] uppercase tracking-widest text-gray-400">Thank you for being part of our story.</p>
    </footer>
</div>

@push('scripts')
    <x-wedding.countdown-script />
@endpush
@endsection

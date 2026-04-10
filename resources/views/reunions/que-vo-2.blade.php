@extends('layouts.reunion')

@section('title', "Thư Mời Họp Lớp | {$schoolInfo['name']}")

@section('meta')
    <meta name="description"
        content="Thư mời họp lớp kỷ niệm {{ mb_strtolower($schoolInfo['anniversary']) }} ngày ra trường - {{ $schoolInfo['course'] }} - {{ $schoolInfo['name'] }}. {{ $eventInfo['time'] }} {{ $eventInfo['day'] }} {{ $eventInfo['date'] }}.">
    <meta property="og:title" content="Thư Mời Họp Lớp - {{ $schoolInfo['anniversary'] }} {{ $schoolInfo['slogan'] }}">
    <meta property="og:image" content="{{ $reunion->getCoverUrl() }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/' . $reunion->slug) }}">
    <meta property="og:locale" content="vi_VN">
@endsection

@push('styles')
    <style>
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .font-accent {
            font-family: 'Dancing Script', cursive;
        }

        /* Gradient utilities */
        .gradient-blue {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }

        .gradient-gold {
            background: linear-gradient(135deg, #fde047 0%, #eab308 50%, #ca8a04 100%);
        }

        .text-gradient-blue {
            background: linear-gradient(135deg, #60a5fa 0%, #2563eb 50%, #1e3a8a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-gradient-gold {
            background: linear-gradient(135deg, #fde047 0%, #eab308 50%, #ca8a04 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 15px rgba(190, 18, 60, 0.3);
            }

            50% {
                box-shadow: 0 0 30px rgba(190, 18, 60, 0.5);
            }
        }

        @keyframes leaf-fall {
            0% {
                transform: translateY(-10%) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 0.8;
            }

            90% {
                opacity: 0.8;
            }

            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }

        @keyframes countdown-pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .animate-float {
            animation: float 5s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        /* Falling petals */
        .petal {
            position: fixed;
            pointer-events: none;
            z-index: 5;
            opacity: 0;
        }

        /* Hero overlay */
        .hero-overlay {
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.5) 50%, rgba(0, 0, 0, 0.7) 100%);
        }

        /* Glass panel */
        .glass {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-white {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        /* Card hover */
        .card-lift {
            transition: all 0.3s ease;
        }

        .card-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }

        /* Music button */
        .music-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 50;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .music-btn.playing {
            animation: pulse-glow 2s infinite;
        }

        .music-btn .bars {
            display: flex;
            gap: 2px;
            align-items: flex-end;
            height: 16px;
        }

        .music-btn .bar {
            width: 3px;
            background: white;
            border-radius: 2px;
        }

        .music-btn.playing .bar {
            animation: bar-dance 0.8s ease-in-out infinite;
        }

        .music-btn.playing .bar:nth-child(2) {
            animation-delay: 0.2s;
        }

        .music-btn.playing .bar:nth-child(3) {
            animation-delay: 0.4s;
        }

        .music-btn.playing .bar:nth-child(4) {
            animation-delay: 0.1s;
        }

        @keyframes bar-dance {

            0%,
            100% {
                height: 4px;
            }

            50% {
                height: 16px;
            }
        }

        /* Timeline */
        .timeline-line {
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #fbbf24, #e11d48);
        }

        @media(min-width:640px) {
            .timeline-line {
                left: 50%;
                transform: translateX(-50%);
            }
        }

        /* Countdown */
        .countdown-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 12px;
            padding: 8px 6px;
            min-width: 60px;
            text-align: center;
        }

        @media(min-width:640px) {
            .countdown-box {
                padding: 12px 16px;
                min-width: 80px;
            }
        }

        /* Video play btn */
        .play-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.3s;
        }

        .play-circle:hover {
            transform: scale(1.1);
            background: white;
        }

        @media(min-width:640px) {
            .play-circle {
                width: 80px;
                height: 80px;
            }
        }
    </style>
@endpush

@section('body_class', "bg-blue-50 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] text-gray-900 antialiased overflow-x-hidden")

@section('content')
    <!-- Falling Petals Container -->
    <div id="petalsContainer" class="fixed inset-0 pointer-events-none z-[5] overflow-hidden"></div>

    <!-- Music Toggle -->
    <button id="musicBtn" class="music-btn gradient-blue text-white shadow-xl" onclick="toggleMusic()"
        aria-label="Bật/tắt nhạc">
        <div class="bars">
            <div class="bar" style="height:6px"></div>
            <div class="bar" style="height:10px"></div>
            <div class="bar" style="height:4px"></div>
            <div class="bar" style="height:8px"></div>
        </div>
    </button>
    <audio id="bgMusic" loop preload="auto">
        <source src="{{ $reunion->music_url ?: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3' }}"
            type="audio/mp3">
    </audio>

    <!-- ============================================ -->
    <!-- HERO SECTION -->
    <!-- ============================================ -->
    <!-- ============================================ -->
    <!-- HERO SECTION QUẾ VÕ 2 -->
    <!-- ============================================ -->
    <section
        class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden bg-white mb-0 pb-16 pt-16">

        <!-- Vẩy vàng góc vuông (Top-Left & Bottom-Right) -->
        <!-- Top Left: Góc vuông viền -->
        <div
            class="absolute top-0 left-0 w-32 h-32 border-t-[8px] border-l-[8px] border-yellow-500 rounded-br-[40px] opacity-80 z-0">
        </div>
        <div class="absolute top-2 left-2 w-28 h-28 border-t-2 border-l-2 border-yellow-400 opacity-60 z-0"></div>

        <!-- Bottom Right: Góc vuông viền -->
        <div
            class="absolute bottom-0 right-0 w-32 h-32 border-b-[8px] border-r-[8px] border-yellow-500 rounded-tl-[40px] opacity-80 z-0">
        </div>
        <div class="absolute bottom-2 right-2 w-28 h-28 border-b-2 border-r-2 border-yellow-400 opacity-60 z-0"></div>

        <!-- Sóng góc uốn lượn (Top-Right & Bottom-Left bằng SVG xịn) -->
        <!-- SVG Defs Chung Thả Rời Trên Cùng Để Không Bị Ẩn -->
        <svg style="width:0;height:0;position:absolute;" aria-hidden="true" focusable="false">
            <defs>
                <linearGradient id="waveGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#1e3a8a" stop-opacity="0.8" />
                    <stop offset="100%" stop-color="#172554" stop-opacity="1" />
                </linearGradient>
                <linearGradient id="waveGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#3b82f6" stop-opacity="0.4" />
                    <stop offset="100%" stop-color="#1d4ed8" stop-opacity="0.8" />
                </linearGradient>
                <linearGradient id="goldStarGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#fef08a" />
                    <stop offset="50%" stop-color="#eab308" />
                    <stop offset="100%" stop-color="#a16207" />
                </linearGradient>
            </defs>
        </svg>

        <!-- Top Right SVG Wave -->
        <div
            class="absolute top-0 right-0 w-[55vw] h-[55vw] max-w-[350px] max-h-[350px] z-0 opacity-100 pointer-events-none">
            <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-lg" preserveAspectRatio="none">
                <!-- Sóng lớn -->
                <path d="M 100,0 L 100,100 C 65,85 30,50 0,0 Z" fill="url(#waveGrad1)" />
                <!-- Sóng nhỏ -->
                <path d="M 100,0 L 100,80 C 60,70 30,40 20,0 Z" fill="url(#waveGrad2)" />
            </svg>
        </div>

        <!-- Bottom Left SVG Wave -->
        <div
            class="absolute bottom-0 left-0 w-[55vw] h-[55vw] max-w-[350px] max-h-[350px] z-0 opacity-100 pointer-events-none">
            <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-lg" preserveAspectRatio="none">
                <!-- Sóng lớn -->
                <path d="M 0,100 L 100,100 C 85,65 50,30 0,0 Z" fill="url(#waveGrad1)" />
                <!-- Sóng nhỏ -->
                <path d="M 0,100 L 80,100 C 70,60 40,30 0,20 Z" fill="url(#waveGrad2)" />
            </svg>
        </div>

        <!-- Floating SVG (Những vẩn sóng/vẩy nhỏ lơ lửng)  -->
        <div class="absolute top-[15%] right-[12%] w-16 h-16 animate-float opacity-70 drop-shadow-md">
            <svg viewBox="0 0 100 100" class="w-full h-full transform -rotate-12">
                <path d="M50,10 C60,40 90,50 90,50 C90,50 60,60 50,90 C40,60 10,50 10,50 C10,50 40,40 50,10 Z"
                    fill="url(#goldStarGrad)" />
            </svg>
        </div>
        <div class="absolute bottom-[25%] left-[8%] w-12 h-12 animate-float opacity-60 drop-shadow-md"
            style="animation-delay: 1.5s;">
            <svg viewBox="0 0 100 100" class="w-full h-full transform rotate-45">
                <path d="M50,10 C60,40 90,50 90,50 C90,50 60,60 50,90 C40,60 10,50 10,50 C10,50 40,40 50,10 Z"
                    fill="url(#goldStarGrad)" />
            </svg>
        </div>
        <div class="absolute top-[40%] left-[15%] w-6 h-6 animate-float opacity-50 drop-shadow-sm"
            style="animation-delay: 2.2s;">
            <svg viewBox="0 0 100 100" class="w-full h-full">
                <path d="M50,10 C60,40 90,50 90,50 C90,50 60,60 50,90 C40,60 10,50 10,50 C10,50 40,40 50,10 Z"
                    fill="url(#goldStarGrad)" />
            </svg>
        </div>

        <!-- NỘI DUNG CHÍNH (Content) -->
        <div class="relative z-10 w-full max-w-xl mx-auto px-5 text-center flex flex-col items-center">

            <!-- Logo Chính -->
            <img src="{{ $reunion->getHeroUrl() }}" alt="{{ $schoolInfo['anniversary'] }} {{ $schoolInfo['slogan'] }}"
                class="w-full max-w-[280px] sm:max-w-[340px] mx-auto mb-2 transform hover:scale-105 transition duration-700 rounded-xl mix-blend-multiply"
                data-aos="zoom-in" data-aos-duration="1200">

            <h1 class="text-blue-900 font-accent text-2xl sm:text-3xl font-bold uppercase tracking-widest drop-shadow-lg mb-6"
                data-aos="fade-up" data-aos-delay="200">
                {{ $schoolInfo['slogan'] }}
            </h1>

            <!-- School name badge -->
            <div class="inline-flex flex-col items-center gap-1 px-5 py-2.5 rounded-xl bg-blue-50/80 text-gray-800 text-sm sm:text-base font-medium mb-5 border border-blue-100 shadow-sm"
                data-aos="fade-up" data-aos-delay="100">
                <span class="font-bold tracking-wide text-blue-900">{{ mb_strtoupper($schoolInfo['name']) }}</span>
                <span
                    class="text-yellow-600 text-xs sm:text-sm font-bold uppercase">{{ mb_strtoupper($schoolInfo['course']) }}</span>
            </div>

            <p class="font-serif text-3xl sm:text-4xl font-bold text-yellow-600 mb-2 drop-shadow-sm" data-aos="fade-up"
                data-aos-delay="150">
                THƯ MỜI
            </p>
            <p class="uppercase tracking-widest text-xs sm:text-sm text-gray-500 font-bold mb-8" data-aos="fade-up"
                data-aos-delay="200">
                KỶ NIỆM {{ mb_strtoupper($schoolInfo['anniversary']) }} NGÀY RA TRƯỜNG
            </p>

            <div class="max-w-xs mx-auto mb-8 border-l-2 border-r-2 border-yellow-300 px-4" data-aos="fade-up"
                data-aos-delay="250">
                <p class="text-gray-600 text-sm sm:text-base italic font-serif mb-1">
                    Trân trọng kính mời:
                </p>
                <p class="text-blue-950 text-lg sm:text-xl font-bold border-b border-gray-200 pb-2 inline-block">
                    {{ $greeting }}
                </p>
            </div>

            <div class="bg-gray-50/80 rounded-2xl p-4 sm:p-6 shadow-xs border border-gray-100 w-full mb-8"
                data-aos="zoom-in" data-aos-delay="300">
                <p class="text-gray-700 text-sm sm:text-base mb-1">Vui lòng về dự buổi họp hội khóa</p>
                <p class="text-blue-900 text-base sm:text-lg font-bold mb-2">
                    Lúc: <span class="text-yellow-600">{{ $eventInfo['time_short'] }} {{ $eventInfo['day'] }},
                        {{ $eventInfo['date'] }}</span>
                </p>
                <p class="text-gray-800 text-sm sm:text-base">
                    Tại: <strong>{{ $schoolInfo['name'] }}</strong>
                </p>
            </div>

            <!-- Countdown -->
            <div class="flex justify-center gap-2 sm:gap-4 mb-8" data-aos="fade-up" data-aos-delay="400">
                <div
                    class="bg-white border-2 border-yellow-200/50 shadow-md py-3 px-3 sm:px-4 rounded-xl text-center min-w-[70px] sm:min-w-[85px]">
                    <div id="cd-days" class="text-2xl sm:text-3xl font-bold text-yellow-600 font-serif">--</div>
                    <div class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-widest mt-1">Ngày</div>
                </div>
                <div
                    class="bg-white border-2 border-yellow-200/50 shadow-md py-3 px-3 sm:px-4 rounded-xl text-center min-w-[70px] sm:min-w-[85px]">
                    <div id="cd-hours" class="text-2xl sm:text-3xl font-bold text-yellow-600 font-serif">--</div>
                    <div class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-widest mt-1">Giờ</div>
                </div>
                <div
                    class="bg-white border-2 border-yellow-200/50 shadow-md py-3 px-3 sm:px-4 rounded-xl text-center min-w-[70px] sm:min-w-[85px]">
                    <div id="cd-mins" class="text-2xl sm:text-3xl font-bold text-yellow-600 font-serif">--</div>
                    <div class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-widest mt-1">Phút</div>
                </div>
                <div
                    class="bg-white border-2 border-yellow-200/50 shadow-md py-3 px-3 sm:px-4 rounded-xl text-center min-w-[70px] sm:min-w-[85px]">
                    <div id="cd-secs" class="text-2xl sm:text-3xl font-bold text-yellow-600 font-serif">--</div>
                    <div class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-widest mt-1">Giây</div>
                </div>
            </div>

            <!-- CTA Mở Thư -->
            <a href="#rsvp"
                class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-gradient-to-r from-yellow-500 to-yellow-400 text-white font-bold text-sm shadow-[0_5px_15px_rgba(234,179,8,0.4)] animate-pulse-glow hover:-translate-y-1 transition-all"
                data-aos="fade-up" data-aos-delay="450">
                <i class="fas fa-paper-plane"></i>
                <span>Gửi Xác Nhận</span>
            </a>

        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                </path>
            </svg>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- VIDEO TRAILER SECTION -->
    <!-- ============================================ -->
    <section id="trailer" class="py-16 sm:py-20 bg-slate-900 text-white">
        <div class="max-w-4xl mx-auto px-5">
            <div class="text-center mb-10" data-aos="fade-up">
                <span class="text-yellow-400 font-semibold uppercase tracking-widest text-xs">Video kỷ niệm</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-serif font-bold mt-3">Trailer <span
                        class="text-yellow-400">{{ $schoolInfo['anniversary'] }}</span></h2>
                <p class="font-accent text-lg sm:text-xl text-gray-400 mt-2">"Một thời để nhớ, một đời để thương..."</p>
            </div>

            <div class="relative rounded-2xl overflow-hidden shadow-2xl group cursor-pointer" data-aos="zoom-in">
                @php
                    $videoUrl = $reunion->getMediaUrlFallback('video');
                @endphp

                @if($videoUrl)
                    <a href="{{ $videoUrl }}" class="glightbox-video block">
                        <img src="{{ $reunion->getVideoCoverUrl() }}" alt="Video trailer họp lớp"
                            class="w-full aspect-video object-cover group-hover:scale-105 transition duration-700">
                        <div
                            class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition flex items-center justify-center">
                            <div class="play-circle">
                                <i class="fas fa-play text-blue-600 text-xl sm:text-2xl ml-1"></i>
                            </div>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 sm:bottom-6 sm:left-6">
                            <p class="font-accent text-lg sm:text-xl text-white">Xem lại kỷ niệm xưa...</p>
                        </div>
                    </a>
                @else
                    <div class="block overflow-hidden relative">
                        <img src="{{ $reunion->getVideoCoverUrl() }}" alt="Kỷ niệm họp lớp"
                            class="w-full aspect-video object-cover group-hover:scale-105 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent pointer-events-none"></div>
                        <div class="absolute bottom-4 left-4 right-4 sm:bottom-6 sm:left-6 pointer-events-none">
                            <p class="font-accent text-lg sm:text-xl text-white">Chút kỷ niệm lưu giữ...</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- MỤC TIÊU - Ý NGHĨA -->
    <!-- ============================================ -->
    <section class="relative py-16 sm:py-24 px-5">
        <!-- Wave top -->
        <div class="absolute top-0 left-0 w-full overflow-hidden leading-none rotate-180 text-blue-50">
            <svg class="relative block w-full h-12 sm:h-20" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                    fill="currentColor"></path>
            </svg>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-10" data-aos="fade-up">
                <span class="text-blue-700 font-semibold uppercase tracking-widest text-xs">Thư Ngỏ</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-serif font-bold mt-3 text-gray-900">Lời Mời <span
                        class="text-gradient-blue">Thân Thương</span></h2>
                <div
                    class="mt-6 text-gray-700 leading-relaxed max-w-3xl mx-auto text-left space-y-4 bg-white/70 p-6 rounded-2xl shadow-sm border border-blue-100 prose prose-blue sm:prose-lg max-w-none">
                    {!! $openLetter !!}
                </div>
            </div>


        </div>
    </section>

    <!-- ============================================ -->
    <!-- THỜI GIAN, ĐỊA ĐIỂM, DRESSCODE -->
    <!-- ============================================ -->
    <section class="py-16 sm:py-20 relative bg-gradient-to-br from-blue-50 to-yellow-50 px-5 pt-24 pb-20">
        <!-- Wave top -->
        <div class="absolute top-0 left-0 w-full overflow-hidden leading-none rotate-180 text-blue-50">
            <svg class="relative block w-full h-12 sm:h-20" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                    fill="currentColor"></path>
            </svg>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-10" data-aos="fade-up">
                <span class="text-yellow-700 font-semibold uppercase tracking-widest text-xs">Chi tiết</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-serif font-bold mt-3 text-gray-900">Thời Gian & <span
                        class="text-gradient-gold">Địa Điểm</span></h2>
            </div>

            <div class="space-y-4">
                <!-- Thời gian -->
                <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm card-lift" data-aos="fade-up">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-11 h-11 rounded-xl bg-yellow-100 flex items-center justify-center text-yellow-600 flex-shrink-0">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-base sm:text-lg text-gray-900 mb-1">Thời gian</h3>
                            <p class="text-gray-700">Chủ nhật, ngày <strong>{{ $eventInfo['date_full_tail'] }}</strong>
                            </p>
                            <p class="text-gray-500 text-sm mt-1">Bắt đầu từ 07h00 sáng</p>
                        </div>
                    </div>
                </div>

                <!-- Địa điểm -->
                <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm card-lift" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-base sm:text-lg text-gray-900 mb-1">Địa điểm</h3>
                            <p class="text-gray-700"><strong>Trường THPT Quế Võ 2</strong></p>
                            <p class="text-gray-500 text-sm mt-1">{{ $eventInfo['location_address'] }}</p>
                        </div>
                    </div>
                </div>




            </div>
        </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- TIMELINE CHƯƠNG TRÌNH -->
    <!-- ============================================ -->
    <section class="py-16 sm:py-20 px-5 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12" data-aos="fade-up">
                <span class="text-blue-700 font-semibold uppercase tracking-widest text-xs">TRƯỜNG THPT Quế Võ 2</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-serif font-bold mt-3 text-gray-900">
                    CHƯƠNG TRÌNH HỘI KHÓA <br class="sm:hidden">
                    <span class="text-blue-600">{{ $schoolInfo['years'] }}</span>
                </h2>
                <p class="font-accent text-xl text-gray-600 mt-2 italic">
                    "{{ mb_strtolower($schoolInfo['anniversary']) }} - Hội ngộ và Tri ân"</p>
            </div>

            <div class="space-y-4 relative">
                <div class="absolute left-[92px] sm:left-[110px] top-5 bottom-5 w-0.5 bg-gray-200 hidden sm:block">
                </div>

                <div class="flex gap-4 items-start" data-aos="fade-up">
                    <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1"><span
                            class="text-sm sm:text-base font-bold font-mono text-yellow-600">7h00-8h00</span></div>
                    <div class="flex-shrink-0 flex flex-col items-center z-10">
                        <div class="w-4 h-4 rounded-full border-[3px] border-yellow-400 bg-white"></div>
                    </div>
                    <div class="flex-1 bg-white rounded-xl p-4 shadow-sm border border-gray-100 pb-5">
                        <h3 class="font-bold text-gray-800">Đón tiếp thầy cô và các bạn</h3>
                        <p class="text-gray-500 text-sm mt-1">Giao lưu, nhận áo đồng phục và chụp ảnh lưu niệm tại
                            backdrop.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start" data-aos="fade-up">
                    <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1"><span
                            class="text-sm sm:text-base font-bold font-mono text-yellow-600">8h00-8h30</span></div>
                    <div class="flex-shrink-0 flex flex-col items-center z-10">
                        <div class="w-4 h-4 rounded-full border-[3px] border-yellow-400 bg-white"></div>
                    </div>
                    <div class="flex-1 bg-white rounded-xl p-4 shadow-sm border border-gray-100 pb-5">
                        <h3 class="font-bold text-gray-800">Văn nghệ chào mừng</h3>
                        <p class="text-gray-500 text-sm mt-1">Các tiết mục văn nghệ đặc sắc do cựu học sinh biểu diễn.
                        </p>
                    </div>
                </div>

                <div class="flex gap-4 items-start" data-aos="fade-up">
                    <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1"><span
                            class="text-sm sm:text-base font-bold font-mono text-blue-600">8h30-8h45</span></div>
                    <div class="flex-shrink-0 flex flex-col items-center z-10">
                        <div class="w-4 h-4 rounded-full border-[3px] border-blue-500 bg-white"></div>
                    </div>
                    <div class="flex-1 bg-blue-50 rounded-xl p-4 shadow-sm border border-blue-100 pb-5">
                        <h3 class="font-bold text-blue-800">Phát biểu khai mạc</h3>
                        <p class="text-gray-600 text-sm mt-1">Tuyên bố lý do, giới thiệu đại biểu và khai mạc chương
                            trình.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start" data-aos="fade-up">
                    <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1"><span
                            class="text-sm sm:text-base font-bold font-mono text-yellow-600">8h45-9h00</span></div>
                    <div class="flex-shrink-0 flex flex-col items-center z-10">
                        <div class="w-4 h-4 rounded-full border-[3px] border-yellow-400 bg-white"></div>
                    </div>
                    <div class="flex-1 bg-white rounded-xl p-4 shadow-sm border border-gray-100 pb-5">
                        <h3 class="font-bold text-gray-800">Phát biểu của Thầy Hiệu trưởng cũ</h3>
                        <p class="text-gray-500 text-sm mt-1">Lắng nghe những chia sẻ đầy kỷ niệm từ Thầy hiệu trưởng
                            nhiệm kỳ 2003-2006.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start" data-aos="fade-up">
                    <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1"><span
                            class="text-sm sm:text-base font-bold font-mono text-yellow-600">9h00-9h15</span></div>
                    <div class="flex-shrink-0 flex flex-col items-center z-10">
                        <div class="w-4 h-4 rounded-full border-[3px] border-yellow-400 bg-white"></div>
                    </div>
                    <div class="flex-1 bg-white rounded-xl p-4 shadow-sm border border-gray-100 pb-5">
                        <h3 class="font-bold text-gray-800">Phát biểu của Thầy Hiệu trưởng đương nhiệm</h3>
                        <p class="text-gray-500 text-sm mt-1">Thầy hiệu trưởng hiện tại phát biểu về sự phát triển của
                            nhà trường.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start" data-aos="fade-up">
                    <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1"><span
                            class="text-sm sm:text-base font-bold font-mono text-yellow-600">9h15-9h30</span></div>
                    <div class="flex-shrink-0 flex flex-col items-center z-10">
                        <div class="w-4 h-4 rounded-full border-[3px] border-yellow-400 bg-white"></div>
                    </div>
                    <div class="flex-1 bg-white rounded-xl p-4 shadow-sm border border-gray-100 pb-5">
                        <h3 class="font-bold text-gray-800">Phát biểu của Học sinh</h3>
                        <p class="text-gray-500 text-sm mt-1">Đại diện cựu học sinh gửi lời tri ân sâu sắc tới mái
                            trường và thầy cô.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start" data-aos="fade-up">
                    <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1"><span
                            class="text-sm sm:text-base font-bold font-mono text-blue-600">9h30-10h00</span></div>
                    <div class="flex-shrink-0 flex flex-col items-center z-10">
                        <div class="w-4 h-4 rounded-full border-[3px] border-blue-500 bg-white"></div>
                    </div>
                    <div class="flex-1 bg-blue-50 rounded-xl p-4 shadow-sm border border-blue-100 pb-5">
                        <h3 class="font-bold text-blue-800">Tặng quà tri ân Thầy cô giáo</h3>
                        <p class="text-gray-600 text-sm mt-1">Gửi tặng những món quà ý nghĩa đến các thầy cô nguyên là
                            giáo viên giảng dạy khóa 2003-2006.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start" data-aos="fade-up">
                    <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1"><span
                            class="text-sm sm:text-base font-bold font-mono text-yellow-600">10h00-10h15</span></div>
                    <div class="flex-shrink-0 flex flex-col items-center z-10">
                        <div class="w-4 h-4 rounded-full border-[3px] border-yellow-400 bg-white"></div>
                    </div>
                    <div class="flex-1 bg-white rounded-xl p-4 shadow-sm border border-gray-100 pb-5">
                        <h3 class="font-bold text-gray-800">Tặng quà Nhà trường</h3>
                        <p class="text-gray-500 text-sm mt-1">Tập thể khóa tiến hành trao tặng kỷ niệm chương và quỹ hỗ
                            trợ cho trường.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start" data-aos="fade-up">
                    <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1"><span
                            class="text-sm sm:text-base font-bold font-mono text-yellow-600">10h15-10h30</span></div>
                    <div class="flex-shrink-0 flex flex-col items-center z-10">
                        <div class="w-4 h-4 rounded-full border-[3px] border-yellow-400 bg-white"></div>
                    </div>
                    <div class="flex-1 bg-white rounded-xl p-4 shadow-sm border border-gray-100 pb-5">
                        <h3 class="font-bold text-gray-800">Tặng hoa Mạnh thường quân</h3>
                        <p class="text-gray-500 text-sm mt-1">Vinh danh và cảm ơn các bạn cựu học sinh đã đóng góp lớn
                            cho chương trình.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start" data-aos="fade-up">
                    <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1"><span
                            class="text-sm sm:text-base font-bold font-mono text-blue-600">10h30-11h00</span></div>
                    <div class="flex-shrink-0 flex flex-col items-center z-10">
                        <div class="w-5 h-5 rounded-full bg-blue-600 border-[3px] border-blue-200"></div>
                    </div>
                    <div class="flex-1 bg-gradient-to-r from-blue-600 to-blue-500 rounded-xl p-4 shadow-lg text-white pb-5">
                        <h3 class="font-bold text-lg text-white">Chụp ảnh tập thể khóa</h3>
                        <p class="text-blue-100 text-sm mt-1">Tất cả chụp ảnh lưu niệm toàn khóa bằng flycam và kết thúc
                            chương trình Lễ.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start" data-aos="fade-up">
                    <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1"><span
                            class="text-sm sm:text-base font-bold font-mono text-yellow-600">11h00</span></div>
                    <div class="flex-shrink-0 flex flex-col items-center z-10">
                        <div class="w-5 h-5 rounded-full bg-yellow-500 border-[3px] border-yellow-200"></div>
                    </div>
                    <div
                        class="flex-1 bg-gradient-to-r from-yellow-500 to-yellow-400 rounded-xl p-4 shadow-lg text-white pb-5">
                        <h3 class="font-bold text-lg text-white">Tiệc liên hoan</h3>
                        <p class="text-yellow-100 text-sm mt-1">Dùng tiệc mặn giao lưu, hát hò tự do thắt chặt tình cảm.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- ALBUM KỶ NIỆM -->
    <!-- ============================================ -->

    <section id="album" class="py-16 sm:py-20 bg-white px-5">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-10" data-aos="fade-up">
                <span class="text-blue-700 font-semibold uppercase tracking-widest text-xs">Album</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-serif font-bold mt-3 text-gray-900">Ảnh Kỷ Niệm <span
                        class="text-gradient-blue">Ngày Ấy</span></h2>
                <p class="font-accent text-lg text-gray-500 mt-2">"Một thời để nhớ, một đời để thương..."</p>
            </div>

            <!-- Tabs Navigation -->
            <div class="flex flex-wrap items-center justify-center gap-2 mb-8" data-aos="fade-up">
                @foreach($classDirs as $className => $photos)
                    <button type="button"
                        class="album-tab-btn px-5 py-2 rounded-full font-bold text-sm transition shadow-sm border border-transparent 
                                        {{ $loop->first ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 border-gray-200' }}"
                        data-target="album-tab-{{ Str::slug($className) }}"
                        onclick="showAlbumTab(this, 'album-tab-{{ Str::slug($className) }}')">
                        {{ $className }}
                        <span class="ml-1 opacity-70 text-xs font-normal">({{ count($photos) }})</span>
                    </button>
                @endforeach
            </div>

            <!-- Tabs Content -->
            <div class="relative min-h-[300px]">
                @foreach($classDirs as $className => $photos)
                    <div id="album-tab-{{ Str::slug($className) }}"
                        class="album-tab-content {{ $loop->first ? 'block' : 'hidden' }} animate-fade-in">
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-2 sm:gap-3">
                            @foreach($photos as $index => $photo)
                                <a href="{{ $photo }}"
                                    class="glightbox-gallery rounded-xl overflow-hidden shadow-sm group aspect-square relative"
                                    data-gallery="album-{{ Str::slug($className) }}"
                                    data-glightbox="title: Lớp {{ $className }} - Ảnh {{ $index + 1 }}">
                                    <img src="{{ $photo }}" alt="Ảnh lớp {{ $className }}"
                                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition duration-700"
                                        loading="lazy">
                                    <div
                                        class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition duration-300 flex items-center justify-center">
                                        <i
                                            class="fas fa-search-plus text-white text-lg opacity-0 group-hover:opacity-100 transition duration-300 scale-50 group-hover:scale-100"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <script>
                function showAlbumTab(btn, targetId) {
                    // Hide all contents
                    document.querySelectorAll('.album-tab-content').forEach(el => {
                        el.classList.add('hidden');
                        el.classList.remove('block');
                    });

                    // Reset all buttons
                    document.querySelectorAll('.album-tab-btn').forEach(el => {
                        el.classList.remove('bg-gradient-to-r', 'from-blue-600', 'to-blue-500', 'text-white', 'border-transparent');
                        el.classList.add('bg-gray-100', 'text-gray-600', 'border-gray-200');
                    });

                    // Show target content
                    const targetEl = document.getElementById(targetId);
                    if (targetEl) {
                        targetEl.classList.remove('hidden');
                        targetEl.classList.add('block');
                    }

                    // Activate button
                    btn.classList.remove('bg-gray-100', 'text-gray-600', 'border-gray-200');
                    btn.classList.add('bg-gradient-to-r', 'from-blue-600', 'to-blue-500', 'text-white', 'border-transparent');
                }
            </script>

            <p class="text-center font-accent text-base text-gray-400 mt-8">Ảnh sẽ được cập nhật từ BTC các lớp 🌸</p>
        </div>
    </section>

    <x-reunions.rsvp :classDirs="$classDirs" />

    <!-- ============================================ -->
    <!-- GOOGLE MAPS -->
    <!-- ============================================ -->
    <section id="map" class="py-16 sm:py-20 bg-gradient-to-br from-slate-50 to-gray-100 px-5">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-8" data-aos="fade-up">
                <span class="text-sky-700 font-semibold uppercase tracking-widest text-xs">Bản đồ</span>
                <h2 class="text-2xl sm:text-3xl font-serif font-bold mt-3 text-gray-900">Địa Điểm <span
                        class="text-gradient-blue">Họp Mặt</span></h2>
            </div>

            <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-200" data-aos="fade-up"
                data-aos-delay="100">
                <iframe src="{{ $eventInfo['map_iframe'] }}" width="100%" height="300" style="border:0;" allowfullscreen=""
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-full"></iframe>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-6" data-aos="fade-up"
                data-aos-delay="200">
                <a href="https://maps.google.com/?q={{ $eventInfo['map_query'] }}" target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white border border-gray-200 text-sm font-semibold text-gray-700 hover:border-blue-300 hover:text-blue-700 transition shadow-sm">
                    <i class="fas fa-directions text-blue-500"></i>
                    <span>Chỉ đường</span>
                </a>
                <a href="tel:{{ $organizers[0]['phone'] ?? '' }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full gradient-blue text-white text-sm font-semibold shadow-sm hover:opacity-90 transition">
                    <i class="fas fa-phone"></i>
                    <span>Liên hệ BTC</span>
                </a>
            </div>
        </div>
    </section>

    <x-reunions.guestbook :messages="$messages" />

    <!-- ============================================ -->
    <!-- FOOTER -->
    <!-- ============================================ -->
    <footer class="bg-slate-900 text-white py-12 sm:py-16 px-5">
        <div class="max-w-4xl mx-auto text-center">
            <h3 class="font-serif text-xl sm:text-2xl font-bold mb-2" data-aos="fade-up">{{ $schoolInfo['name'] }}</h3>
            <p class="text-yellow-400 font-accent text-lg mb-4" data-aos="fade-up" data-aos-delay="50">
                {{ $schoolInfo['course'] }}
            </p>

            <div class="flex flex-col items-center justify-center gap-2 mb-8" data-aos="fade-up" data-aos-delay="100">
                @foreach($organizers as $org)
                    <div
                        class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-gray-400 text-sm py-1">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user text-blue-400"></i>
                            <span>{{ $org['role'] }}: <strong class="text-white">{{ $org['name'] }}</strong></span>
                        </div>
                        @if(!empty($org['phone']))
                            <div class="hidden sm:block w-1 h-1 bg-gray-600 rounded-full"></div>
                            <a href="tel:{{ $org['phone'] }}" class="flex items-center gap-2 hover:text-white transition">
                                <i class="fas fa-phone text-green-400"></i>
                                <span>{{ $org['phone'] }}</span>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Share buttons -->
            <div class="mb-8" data-aos="fade-up" data-aos-delay="150">
                <p class="text-gray-500 text-xs uppercase tracking-wider mb-3">Chia sẻ thiệp mời</p>
                <div class="flex justify-center gap-3">
                    <a href="https://zalo.me/share?u={{ urlencode(url('/' . $reunion->slug)) }}" target="_blank"
                        class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold hover:scale-110 transition shadow-lg">Zalo</a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/' . $reunion->slug)) }}"
                        target="_blank"
                        class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white hover:scale-110 transition shadow-lg"><i
                            class="fab fa-facebook-f"></i></a>
                    <button onclick="copyLink()"
                        class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-white hover:scale-110 transition shadow-lg"><i
                            class="fas fa-link"></i></button>
                </div>
            </div>

            <div class="border-t border-white/10 pt-6">
                <p class="text-gray-500 text-xs">Thiết kế bởi <a href="/"
                        class="text-blue-400 hover:text-blue-300 transition font-semibold">THT Media</a> • Nền tảng
                    Thiệp Mời Online</p>
            </div>
        </div>
    </footer>

    <!-- ============================================ -->
    <!-- SCRIPTS -->
    <!-- ============================================ -->



@endsection

@push('scripts')
    <script>
        // ---- Countdown ----
        const eventDate = new Date('{{ $eventInfo['datetime_iso'] }}').getTime();
        function updateCountdown() {
            const now = Date.now();
            const diff = eventDate - now;
            if (diff <= 0) {
                document.getElementById('cd-days').textContent = '🎉';
                document.getElementById('cd-hours').textContent = '🎓';
                document.getElementById('cd-mins').textContent = '🎊';
                document.getElementById('cd-secs').textContent = '💐';
                return;
            }
            const d = Math.floor(diff / 86400000);
            const h = Math.floor((diff % 86400000) / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);
            document.getElementById('cd-days').textContent = String(d).padStart(2, '0');
            document.getElementById('cd-hours').textContent = String(h).padStart(2, '0');
            document.getElementById('cd-mins').textContent = String(m).padStart(2, '0');
            document.getElementById('cd-secs').textContent = String(s).padStart(2, '0');
        }
        updateCountdown();
        setInterval(updateCountdown, 1000);

        // ---- Falling Petals ----
        const petalsContainer = document.getElementById('petalsContainer');
        const petalColors = ['#fbbf24', '#f59e0b', '#d97706', '#fcd34d', '#fef3c7', '#eab308'];
        function createPetal() {
            const p = document.createElement('div');
            p.className = 'petal';
            const c = petalColors[Math.floor(Math.random() * petalColors.length)];
            const s = 8 + Math.random() * 12;
            p.innerHTML = `<svg width="${s}" height="${s}" viewBox="0 0 20 20"><ellipse cx="10" cy="10" rx="8" ry="5" fill="${c}" opacity="0.7" transform="rotate(${Math.random() * 360} 10 10)"/></svg>`;
            p.style.left = Math.random() * 100 + '%';
            p.style.animation = `leaf-fall ${8 + Math.random() * 10}s linear forwards`;
            petalsContainer.appendChild(p);
            setTimeout(() => p.remove(), 18000);
        }
        setInterval(createPetal, 2000);
        for (let i = 0; i < 5; i++) setTimeout(createPetal, i * 400);

        // ---- Music ----
        const music = document.getElementById('bgMusic');
        const musicBtn = document.getElementById('musicBtn');
        let isPlaying = false;
        function toggleMusic() {
            if (isPlaying) {
                music.pause();
                musicBtn.classList.remove('playing');
            } else {
                music.play().catch(() => { });
                musicBtn.classList.add('playing');
            }
            isPlaying = !isPlaying;
        }
    </script>
@endpush
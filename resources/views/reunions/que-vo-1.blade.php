@extends('layouts.reunion')

@section('title', 'Thư Mời Họp Lớp - 25 Năm Trở Về Khung Trời Kỷ Niệm | THPT Quế Võ Số 1')

@section('meta')
    <meta name="description" content="Thư mời họp lớp kỷ niệm 25 năm ngày ra trường - Niên khóa 1998-2001 - Trường THPT Quế Võ Số 1. 07h00 Chủ nhật 19/04/2026.">
    <meta property="og:title" content="Thư Mời Họp Lớp - 25 Năm Trở Về Khung Trời Kỷ Niệm">
    <meta property="og:description" content="Kỷ niệm 25 năm ngày ra trường - Niên khóa 1998-2001 - THPT Quế Võ Số 1. 07h00 Chủ nhật 19/04/2026. Rất mong sự có mặt của Quý thầy cô và các bạn!">
    <meta property="og:image" content="{{ url('/images/anh-bia.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/demo-hop-lop-que-vo-1') }}">
    <meta property="og:locale" content="vi_VN">
@endsection

@push('styles')
<style>
body { font-family: 'Be Vietnam Pro', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-accent { font-family: 'Dancing Script', cursive; }

        /* Gradient utilities */
        .gradient-rose { background: linear-gradient(135deg, #be123c 0%, #9f1239 100%); }
        .gradient-warm { background: linear-gradient(135deg, #b45309 0%, #92400e 50%, #78350f 100%); }
        .text-gradient-rose {
            background: linear-gradient(135deg, #fb7185 0%, #e11d48 50%, #be123c 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .text-gradient-warm {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }

        /* Animations */
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
        @keyframes pulse-glow { 0%,100% { box-shadow: 0 0 15px rgba(190,18,60,0.3); } 50% { box-shadow: 0 0 30px rgba(190,18,60,0.5); } }
        @keyframes leaf-fall {
            0% { transform: translateY(-10%) rotate(0deg); opacity: 0; }
            10% { opacity: 0.8; }
            90% { opacity: 0.8; }
            100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
        }
        @keyframes countdown-pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.05); } }

        .animate-float { animation: float 5s ease-in-out infinite; }
        .animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }

        /* Falling petals */
        .petal { position: fixed; pointer-events: none; z-index: 5; opacity: 0; }

        /* Hero overlay */
        .hero-overlay {
            background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.7) 100%);
        }

        /* Glass panel */
        .glass { background: rgba(255,255,255,0.12); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.2); }
        .glass-white { background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); }

        /* Card hover */
        .card-lift { transition: all 0.3s ease; }
        .card-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.12); }

        /* Music button */
        .music-btn { position: fixed; bottom: 20px; right: 20px; z-index: 50; width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s; }
        .music-btn.playing { animation: pulse-glow 2s infinite; }
        .music-btn .bars { display: flex; gap: 2px; align-items: flex-end; height: 16px; }
        .music-btn .bar { width: 3px; background: white; border-radius: 2px; }
        .music-btn.playing .bar { animation: bar-dance 0.8s ease-in-out infinite; }
        .music-btn.playing .bar:nth-child(2) { animation-delay: 0.2s; }
        .music-btn.playing .bar:nth-child(3) { animation-delay: 0.4s; }
        .music-btn.playing .bar:nth-child(4) { animation-delay: 0.1s; }
        @keyframes bar-dance { 0%,100% { height: 4px; } 50% { height: 16px; } }

        /* Timeline */
        .timeline-line { position: absolute; left: 20px; top: 0; bottom: 0; width: 2px; background: linear-gradient(to bottom, #fbbf24, #e11d48); }
        @media(min-width:640px) { .timeline-line { left: 50%; transform: translateX(-50%); } }

        /* Countdown */
        .countdown-box {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 12px;
            padding: 8px 6px;
            min-width: 60px;
            text-align: center;
        }
        @media(min-width:640px) { .countdown-box { padding: 12px 16px; min-width: 80px; } }

        /* Video play btn */
        .play-circle { width: 64px; height: 64px; border-radius: 50%; background: rgba(255,255,255,0.9); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 30px rgba(0,0,0,0.3); transition: all 0.3s; }
        .play-circle:hover { transform: scale(1.1); background: white; }
        @media(min-width:640px) { .play-circle { width: 80px; height: 80px; } }
</style>
@endpush

@section('body_class', "bg-[#faf7f0] text-gray-900 antialiased overflow-x-hidden")

@section('content')
<!-- Falling Petals Container -->
    <div id="petalsContainer" class="fixed inset-0 pointer-events-none z-[5] overflow-hidden"></div>

    <!-- Music Toggle -->
    <button id="musicBtn" class="music-btn gradient-rose text-white shadow-xl" onclick="toggleMusic()" aria-label="Bật/tắt nhạc">
        <div class="bars">
            <div class="bar" style="height:6px"></div>
            <div class="bar" style="height:10px"></div>
            <div class="bar" style="height:4px"></div>
            <div class="bar" style="height:8px"></div>
        </div>
    </button>
    <audio id="bgMusic" loop preload="auto">
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mp3">
    </audio>

    <!-- ============================================ -->
    <!-- HERO SECTION -->
    <!-- ============================================ -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Background image -->
        <div class="absolute inset-0">
            <img src="/images/hero-bg.jpg"
                 alt="Trường THPT Quế Võ 1" class="w-full h-full object-cover">
            <div class="hero-overlay absolute inset-0"></div>
        </div>

        <!-- Decorative blobs -->
        <div class="absolute top-20 right-0 w-48 h-48 sm:w-72 sm:h-72 bg-amber-400 rounded-full blur-3xl opacity-20 animate-float"></div>
        <div class="absolute bottom-20 left-0 w-48 h-48 sm:w-64 sm:h-64 bg-rose-400 rounded-full blur-3xl opacity-20 animate-float" style="animation-delay:2s"></div>

        <div class="relative z-10 text-center text-white px-5 py-10 max-w-xl mx-auto w-full">
            <!-- School name badge -->
            <div class="inline-flex flex-col items-center gap-1 px-5 py-2.5 rounded-2xl glass text-white text-xs sm:text-sm font-medium mb-6" data-aos="fade-down">
                <span class="font-bold tracking-wide">TRƯỜNG THPT QUẾ VÕ SỐ 1</span>
                <span class="text-white/70 text-xs">NIÊN KHÓA 1998-2001</span>
            </div>

            <!-- Heading -->
            <h1 class="font-accent text-3xl sm:text-4xl md:text-5xl font-bold leading-tight mb-2" data-aos="fade-up" data-aos-delay="100">
                25 Năm Ngày Trở Về<br>
                <span class="text-amber-400">Khung Trời Kỷ Niệm</span>
            </h1>

            <p class="font-serif text-2xl sm:text-3xl font-bold text-rose-300 mb-3" data-aos="fade-up" data-aos-delay="150">
                THƯ MỜI
            </p>
            <p class="uppercase tracking-wider text-sm sm:text-base text-white font-semibold mb-2" data-aos="fade-up" data-aos-delay="200">
                KỶ NIỆM 25 NĂM NGÀY RA TRƯỜNG
            </p>
            <p class="text-white/80 text-sm sm:text-base mb-2" data-aos="fade-up" data-aos-delay="220">
                Trân trọng kính mời:
            </p>
            <p class="text-white/90 text-sm sm:text-base mb-1" data-aos="fade-up" data-aos-delay="250">
                Vui lòng về dự buổi họp hội khóa
            </p>
            <p class="text-white text-base sm:text-lg font-bold mb-1" data-aos="fade-up" data-aos-delay="260">
                Vào lúc: <span class="text-amber-300">07h Chủ nhật ngày 19/04/2026</span>
            </p>
            <p class="text-amber-200 text-sm sm:text-base mb-4" data-aos="fade-up" data-aos-delay="270">
                Địa điểm: <strong>Trường THPT Quế Võ Số 1</strong>
            </p>
            <p class="font-accent text-lg sm:text-6xl text-rose-300 italic mb-6" data-aos="fade-up" data-aos-delay="280">
                Rất mong sự có mặt của Quý thầy cô và các bạn!
            </p>

            <!-- Date card -->
            <div class="glass rounded-2xl p-6 sm:p-8 max-w-sm mx-auto mb-8 text-center" data-aos="zoom-in" data-aos-delay="300">
    <div class="text-amber-300 uppercase tracking-widest text-xs font-bold mb-3">Save the date</div>
    
    <div class="text-3xl sm:text-4xl md:text-5xl font-serif font-bold text-white border-y border-white/30 py-4 my-3 tracking-tighter">
        19 . 04 . 2026
    </div>
    
    <div class="text-white/90 text-sm sm:text-base font-medium mt-3">
        07h Chủ nhật • Trường THPT Quế Võ Số 1
    </div>
</div>

            <!-- Countdown -->
            <div class="flex justify-center gap-3 sm:gap-4 mb-8" data-aos="fade-up" data-aos-delay="400">
                <div class="countdown-box">
                    <div id="cd-days" class="text-2xl sm:text-3xl font-bold text-white">--</div>
                    <div class="text-[10px] sm:text-xs text-white/60 uppercase tracking-wider mt-1">Ngày</div>
                </div>
                <div class="countdown-box">
                    <div id="cd-hours" class="text-2xl sm:text-3xl font-bold text-white">--</div>
                    <div class="text-[10px] sm:text-xs text-white/60 uppercase tracking-wider mt-1">Giờ</div>
                </div>
                <div class="countdown-box">
                    <div id="cd-mins" class="text-2xl sm:text-3xl font-bold text-white">--</div>
                    <div class="text-[10px] sm:text-xs text-white/60 uppercase tracking-wider mt-1">Phút</div>
                </div>
                <div class="countdown-box">
                    <div id="cd-secs" class="text-2xl sm:text-3xl font-bold text-white">--</div>
                    <div class="text-[10px] sm:text-xs text-white/60 uppercase tracking-wider mt-1">Giây</div>
                </div>
            </div>

            <!-- Signature -->
            <div class="text-white/80 text-sm mb-6" data-aos="fade-up" data-aos-delay="450">
                <p>T/M Ban liên lạc – Trưởng Ban tổ chức</p>
                <p class="font-bold text-white mt-1">Nguyễn Đức Mạnh</p>
            </div>

            <!-- CTA -->
            <a href="#rsvp" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full gradient-rose text-white font-bold text-sm sm:text-base shadow-xl animate-pulse-glow" data-aos="fade-up" data-aos-delay="500">
                <i class="fas fa-hand-point-up"></i>
                <span>Xác nhận tham dự</span>
            </a>

            <!-- Scroll indicator -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 animate-bounce">
                <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- VIDEO TRAILER SECTION -->
    <!-- ============================================ -->
    <section id="trailer" class="py-16 sm:py-20 bg-slate-900 text-white">
        <div class="max-w-4xl mx-auto px-5">
            <div class="text-center mb-10" data-aos="fade-up">
                <span class="text-amber-400 font-semibold uppercase tracking-widest text-xs">Video kỷ niệm</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-serif font-bold mt-3">Trailer <span class="text-amber-400">25 Năm</span></h2>
                <p class="font-accent text-lg sm:text-xl text-gray-400 mt-2">"Một thời để nhớ, một đời để thương..."</p>
            </div>

            <div class="relative rounded-2xl overflow-hidden shadow-2xl group cursor-pointer" data-aos="zoom-in">
                <a href="/video/trailer-hop-lop.mp4" class="glightbox-video">
                    <img src="/images/anh-bia.jpg"
                         alt="Video trailer họp lớp" class="w-full aspect-video object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition flex items-center justify-center">
                        <div class="play-circle">
                            <i class="fas fa-play text-rose-600 text-xl sm:text-2xl ml-1"></i>
                        </div>
                    </div>
                    <div class="absolute bottom-4 left-4 right-4 sm:bottom-6 sm:left-6">
                        <p class="font-accent text-lg sm:text-xl text-white">Xem lại kỷ niệm xưa...</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- MỤC TIÊU - Ý NGHĨA -->
    <!-- ============================================ -->
    <section class="py-16 sm:py-20 px-5">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-10" data-aos="fade-up">
                <span class="text-rose-700 font-semibold uppercase tracking-widest text-xs">Ý nghĩa</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-serif font-bold mt-3 text-gray-900">Mục Tiêu – <span class="text-gradient-rose">Ý Nghĩa</span></h2>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white rounded-2xl p-5 sm:p-6 border border-rose-100 card-lift" data-aos="fade-up">
                    <div class="w-11 h-11 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 text-lg mb-4"><i class="fas fa-heart"></i></div>
                    <h3 class="font-bold text-base mb-2">Gặp gỡ, thắt chặt tình cảm</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Thầy trò, bạn bè sau 25 năm xa cách</p>
                </div>
                <div class="bg-white rounded-2xl p-5 sm:p-6 border border-amber-100 card-lift" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 text-lg mb-4"><i class="fas fa-book-open"></i></div>
                    <h3 class="font-bold text-base mb-2">Ôn lại kỷ niệm</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Thời học sinh dưới mái trường cấp 3 thân yêu</p>
                </div>
                <div class="bg-white rounded-2xl p-5 sm:p-6 border border-emerald-100 card-lift" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-11 h-11 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 text-lg mb-4"><i class="fas fa-hands-helping"></i></div>
                    <h3 class="font-bold text-base mb-2">Tri ân & Sẻ chia</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Tri ân thầy cô, hỗ trợ bạn bè khó khăn</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- THỜI GIAN, ĐỊA ĐIỂM, DRESSCODE -->
    <!-- ============================================ -->
    <section class="py-16 sm:py-20 bg-gradient-to-br from-rose-50 to-amber-50 px-5">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-10" data-aos="fade-up">
                <span class="text-amber-700 font-semibold uppercase tracking-widest text-xs">Chi tiết</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-serif font-bold mt-3 text-gray-900">Thời Gian & <span class="text-gradient-warm">Địa Điểm</span></h2>
            </div>

            <div class="space-y-4">
                <!-- Thời gian -->
                <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm card-lift" data-aos="fade-up">
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0"><i class="fas fa-clock"></i></div>
                        <div>
                            <h3 class="font-bold text-base sm:text-lg text-gray-900 mb-1">Thời gian</h3>
                            <p class="text-gray-700">Chủ nhật, ngày <strong>19 tháng 04 năm 2026</strong></p>
                            <p class="text-gray-500 text-sm mt-1">Bắt đầu từ 07h00 sáng</p>
                        </div>
                    </div>
                </div>

                <!-- Địa điểm -->
                <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm card-lift" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <h3 class="font-bold text-base sm:text-lg text-gray-900 mb-1">Địa điểm</h3>
                            <p class="text-gray-700"><strong>Trường THPT Quế Võ Số 1</strong></p>
                            <p class="text-gray-500 text-sm mt-1">Phố Mới, Quế Võ, Bắc Ninh</p>
                        </div>
                    </div>
                </div>

                <!-- Thành phần -->
                <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm card-lift" data-aos="fade-up" data-aos-delay="150">
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-xl bg-sky-100 flex items-center justify-center text-sky-600 flex-shrink-0"><i class="fas fa-users"></i></div>
                        <div>
                            <h3 class="font-bold text-base sm:text-lg text-gray-900 mb-2">Thành phần (Dự kiến 500 người)</h3>
                            <ul class="text-gray-600 text-sm space-y-1.5">
                                <li class="flex items-start gap-2"><i class="fas fa-check text-green-500 mt-0.5 text-xs"></i>Cựu HS 13 lớp niên khóa 1998-2001 (~400 người)</li>
                                <li class="flex items-start gap-2"><i class="fas fa-check text-green-500 mt-0.5 text-xs"></i>Ban Giám hiệu cũ, thầy cô chủ nhiệm & bộ môn (~90 người)</li>
                                <li class="flex items-start gap-2"><i class="fas fa-check text-green-500 mt-0.5 text-xs"></i>Ban Giám hiệu hiện tại & Tổ trưởng bộ môn (~10 người)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Dresscode -->
                <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm card-lift" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0"><i class="fas fa-tshirt"></i></div>
                        <div class="w-full">
                            <h3 class="font-bold text-base sm:text-lg text-gray-900 mb-3">Dresscode</h3>
                            <div class="space-y-2">
                                <div class="bg-rose-50 rounded-lg p-3 text-sm">
                                    <span class="inline-block px-2 py-0.5 bg-rose-200 text-rose-800 rounded text-xs font-bold mr-2 mb-1">Phần Lễ</span>
                                    <span class="text-gray-700">Nam: Đồng phục hội khóa, quần tối màu. Nữ: Áo dài trắng.</span>
                                </div>
                                <div class="bg-amber-50 rounded-lg p-3 text-sm">
                                    <span class="inline-block px-2 py-0.5 bg-amber-200 text-amber-800 rounded text-xs font-bold mr-2 mb-1">Liên hoan</span>
                                    <span class="text-gray-700">Áo phông hội khóa, quần/chân váy tối màu.</span>
                                </div>
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
            <span class="text-rose-700 font-semibold uppercase tracking-widest text-xs">TRƯỜNG THPT QUẾ VÕ 1</span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-serif font-bold mt-3 text-gray-900">
                CHƯƠNG TRÌNH HỘI KHÓA <br class="sm:hidden"> 
                <span class="text-rose-600">1998 - 2001</span>
            </h2>
            <p class="font-accent text-xl text-gray-600 mt-2 italic">"25 năm - Hội ngộ và Tri ân"</p>
        </div>

        <div class="space-y-4 relative">
            <div class="absolute left-[92px] sm:left-[110px] top-5 bottom-5 w-0.5 bg-gray-200 hidden sm:block"></div>

            <div class="flex gap-4 items-start" data-aos="fade-up">
                <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1">
                    <span class="text-sm sm:text-base font-bold font-mono text-amber-600">7h00-8h00</span>
                </div>
                <div class="flex-shrink-0 flex flex-col items-center z-10">
                    <div class="w-4 h-4 rounded-full border-[3px] border-amber-400 bg-white"></div>
                </div>
                <div class="flex-1 bg-white rounded-xl p-4 shadow-sm border border-gray-100 pb-5">
                    <h3 class="font-bold text-gray-800">Đón khách, hướng dẫn ổn định</h3>
                    <p class="text-gray-500 text-sm mt-1">Đón bạn bè, thầy cô. Nhạc sôi động.</p>
                </div>
            </div>

            <div class="flex gap-4 items-start" data-aos="fade-up">
                <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1">
                    <span class="text-sm sm:text-base font-bold font-mono text-amber-600">8h00-8h25</span>
                </div>
                <div class="flex-shrink-0 flex flex-col items-center z-10">
                    <div class="w-4 h-4 rounded-full border-[3px] border-amber-400 bg-white"></div>
                </div>
                <div class="flex-1 bg-white rounded-xl p-4 shadow-sm border border-gray-100 pb-5">
                    <h3 class="font-bold text-gray-800">Văn nghệ chào mừng</h3>
                    <p class="text-gray-500 text-sm mt-1">Đội Văn nghệ xung kích của khóa biểu diễn.</p>
                </div>
            </div>

            <div class="flex gap-4 items-start" data-aos="fade-up">
                <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1">
                    <span class="text-sm sm:text-base font-bold font-mono text-amber-600">8h25-8h50</span>
                </div>
                <div class="flex-shrink-0 flex flex-col items-center z-10">
                    <div class="w-4 h-4 rounded-full border-[3px] border-amber-400 bg-white"></div>
                </div>
                <div class="flex-1 bg-white rounded-xl p-4 shadow-sm border border-gray-100 pb-5">
                    <h3 class="font-bold text-gray-800">Tuyên bố lý do, giới thiệu</h3>
                    <p class="text-gray-500 text-sm mt-1">Ổn định tổ chức, giới thiệu đại biểu & khách mời.</p>
                </div>
            </div>

            <div class="flex gap-4 items-start" data-aos="fade-up">
                <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1">
                    <span class="text-sm sm:text-base font-bold font-mono text-rose-600">8h50-9h00</span>
                </div>
                <div class="flex-shrink-0 flex flex-col items-center z-10">
                    <div class="w-4 h-4 rounded-full border-[3px] border-rose-500 bg-white"></div>
                </div>
                <div class="flex-1 bg-rose-50 rounded-xl p-4 shadow-sm border border-rose-100 pb-5">
                    <h3 class="font-bold text-rose-800">Khai mạc Hội khóa</h3>
                    <p class="text-gray-600 text-sm mt-1">Đại diện Ban tổ chức phát biểu khai mạc chương trình.</p>
                </div>
            </div>

            <div class="flex gap-4 items-start" data-aos="fade-up">
                <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1">
                    <span class="text-sm sm:text-base font-bold font-mono text-amber-600">9h00-9h30</span>
                </div>
                <div class="flex-shrink-0 flex flex-col items-center z-10">
                    <div class="w-4 h-4 rounded-full border-[3px] border-amber-400 bg-white"></div>
                </div>
                <div class="flex-1 bg-white rounded-xl p-4 shadow-sm border border-gray-100 pb-5">
                    <h3 class="font-bold text-gray-800">Giới thiệu lớp & Chụp ảnh</h3>
                    <p class="text-gray-500 text-sm mt-1">Giới thiệu các lớp tham gia và chụp ảnh lưu niệm.</p>
                </div>
            </div>

            <div class="flex gap-4 items-start" data-aos="fade-up">
                <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1">
                    <span class="text-sm sm:text-base font-bold font-mono text-amber-600">9h30-9h45</span>
                </div>
                <div class="flex-shrink-0 flex flex-col items-center z-10">
                    <div class="w-4 h-4 rounded-full border-[3px] border-amber-400 bg-white"></div>
                </div>
                <div class="flex-1 bg-white rounded-xl p-4 shadow-sm border border-gray-100 pb-5">
                    <h3 class="font-bold text-gray-800">Tặng quà & Phát biểu</h3>
                    <p class="text-gray-500 text-sm mt-1">Tặng quà Nhà trường. Đại diện BGH và Cựu học sinh phát biểu.</p>
                </div>
            </div>

            <div class="flex gap-4 items-start" data-aos="fade-up">
                <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1">
                    <span class="text-sm sm:text-base font-bold font-mono text-rose-600">9h45-10h15</span>
                </div>
                <div class="flex-shrink-0 flex flex-col items-center z-10">
                    <div class="w-4 h-4 rounded-full border-[3px] border-rose-500 bg-white"></div>
                </div>
                <div class="flex-1 bg-rose-50 rounded-xl p-4 shadow-sm border border-rose-100 pb-5">
                    <h3 class="font-bold text-rose-800">Tri ân Thầy Cô</h3>
                    <p class="text-gray-600 text-sm mt-1">Tặng quà tri ân các Thầy cô nguyên giáo viên của khóa.</p>
                </div>
            </div>

            <div class="flex gap-4 items-start" data-aos="fade-up">
                <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1">
                    <span class="text-sm sm:text-base font-bold font-mono text-amber-600">10h15-10h35</span>
                </div>
                <div class="flex-shrink-0 flex flex-col items-center z-10">
                    <div class="w-4 h-4 rounded-full border-[3px] border-amber-400 bg-white"></div>
                </div>
                <div class="flex-1 bg-white rounded-xl p-4 shadow-sm border border-gray-100 pb-5">
                    <h3 class="font-bold text-gray-800">Giao lưu Thầy Cô</h3>
                    <p class="text-gray-500 text-sm mt-1">Đại diện Thầy cô phát biểu và giao lưu cùng các học trò.</p>
                </div>
            </div>

            <div class="flex gap-4 items-start" data-aos="fade-up">
                <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1">
                    <span class="text-sm sm:text-base font-bold font-mono text-amber-600">10h35-10h55</span>
                </div>
                <div class="flex-shrink-0 flex flex-col items-center z-10">
                    <div class="w-4 h-4 rounded-full border-[3px] border-amber-400 bg-white"></div>
                </div>
                <div class="flex-1 bg-white rounded-xl p-4 shadow-sm border border-gray-100 pb-5">
                    <h3 class="font-bold text-gray-800">Vinh danh BTC & Nhà tài trợ</h3>
                    <p class="text-gray-500 text-sm mt-1">Vinh danh, tặng quà Ban tổ chức và các nhà tài trợ.</p>
                </div>
            </div>

            <div class="flex gap-4 items-start" data-aos="fade-up">
                <div class="flex-shrink-0 w-20 sm:w-28 text-right pt-1">
                    <span class="text-sm sm:text-base font-bold font-mono text-rose-600">10h55-11h00</span>
                </div>
                <div class="flex-shrink-0 flex flex-col items-center z-10">
                    <div class="w-5 h-5 rounded-full bg-rose-600 border-[3px] border-rose-200"></div>
                </div>
                <div class="flex-1 bg-gradient-to-r from-rose-600 to-rose-500 rounded-xl p-4 shadow-lg text-white pb-5">
                    <h3 class="font-bold text-lg text-white">Kết thúc chương trình lễ</h3>
                    <p class="text-rose-100 text-sm mt-1">Chuyển sang phần tiệc liên hoan và giao lưu tự do.</p>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- ============================================ -->
    <!-- ALBUM KỶ NIỆM -->
    <!-- ============================================ -->
    @php
        $basePath = public_path('images/anh-cac-lop');
        $classDirs = [];
        if (is_dir($basePath)) {
            $dirs = array_filter(glob($basePath . '/*'), 'is_dir');
            sort($dirs);
            foreach ($dirs as $dir) {
                $className = basename($dir);
                $photos = glob($dir . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
                if (!empty($photos)) {
                    sort($photos);
                    $classDirs[$className] = array_map(function($p) {
                        return '/images/anh-cac-lop/' . basename(dirname($p)) . '/' . basename($p);
                    }, $photos);
                }
            }
        }
    @endphp
    <section id="album" class="py-16 sm:py-20 bg-white px-5">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-10" data-aos="fade-up">
                <span class="text-rose-700 font-semibold uppercase tracking-widest text-xs">Album</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-serif font-bold mt-3 text-gray-900">Ảnh Kỷ Niệm <span class="text-gradient-rose">Ngày Ấy</span></h2>
                <p class="font-accent text-lg text-gray-500 mt-2">"Một thời để nhớ, một đời để thương..."</p>
            </div>

            @foreach($classDirs as $className => $photos)
            <div class="mb-10" data-aos="fade-up">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full gradient-rose flex items-center justify-center text-white font-bold text-sm shadow">{{ $className }}</div>
                    <h3 class="font-serif text-xl font-bold text-gray-800">Lớp {{ $className }}</h3>
                    <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ count($photos) }} ảnh</span>
                </div>
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-1.5 sm:gap-2">
                    @foreach($photos as $index => $photo)
                    <a href="{{ $photo }}" class="glightbox-gallery rounded-lg overflow-hidden shadow-sm group aspect-square" data-gallery="album-{{ $className }}" data-glightbox="title: Lớp {{ $className }} - Ảnh {{ $index + 1 }}">
                        <div class="relative w-full h-full">
                            <img src="{{ $photo }}" alt="Ảnh lớp {{ $className }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" loading="lazy">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition flex items-center justify-center">
                                <i class="fas fa-search-plus text-white text-sm opacity-0 group-hover:opacity-100 transition"></i>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endforeach

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
                <h2 class="text-2xl sm:text-3xl font-serif font-bold mt-3 text-gray-900">Địa Điểm <span class="text-gradient-rose">Họp Mặt</span></h2>
            </div>

            <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-200" data-aos="fade-up" data-aos-delay="100">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3726.5!2d106.1614!3d21.1234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDA3JzI0LjQiTiAxMDbCsDA5JzQxLjAiRQ!5e0!3m2!1svi!2s!4v1234567890"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-full"></iframe>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-6" data-aos="fade-up" data-aos-delay="200">
                <a href="https://maps.google.com/?q=Truong+THPT+Que+Vo+1+Bac+Ninh" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white border border-gray-200 text-sm font-semibold text-gray-700 hover:border-rose-300 hover:text-rose-700 transition shadow-sm">
                    <i class="fas fa-directions text-rose-500"></i>
                    <span>Chỉ đường</span>
                </a>
                <a href="tel:0943859166" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full gradient-rose text-white text-sm font-semibold shadow-sm hover:opacity-90 transition">
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
            <h3 class="font-serif text-xl sm:text-2xl font-bold mb-2" data-aos="fade-up">Trường THPT Quế Võ Số 1</h3>
            <p class="text-amber-400 font-accent text-lg mb-4" data-aos="fade-up" data-aos-delay="50">Niên Khóa 1998 – 2001</p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 text-gray-400 text-sm mb-8" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center gap-2">
                    <i class="fas fa-user text-rose-400"></i>
                    <span>T/M Ban liên lạc – Trưởng Ban tổ chức: <strong class="text-white">Nguyễn Đức Mạnh</strong></span>
                </div>
                <div class="hidden sm:block w-1 h-1 bg-gray-600 rounded-full"></div>
                <a href="tel:0943859166" class="flex items-center gap-2 hover:text-white transition">
                    <i class="fas fa-phone text-green-400"></i>
                    <span>0943 859 166</span>
                </a>
            </div>

            <!-- Share buttons -->
            <div class="mb-8" data-aos="fade-up" data-aos-delay="150">
                <p class="text-gray-500 text-xs uppercase tracking-wider mb-3">Chia sẻ thiệp mời</p>
                <div class="flex justify-center gap-3">
                    <a href="https://zalo.me/share?u={{ urlencode(url('/demo-hop-lop-que-vo-1')) }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold hover:scale-110 transition shadow-lg">Zalo</a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/demo-hop-lop-que-vo-1')) }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white hover:scale-110 transition shadow-lg"><i class="fab fa-facebook-f"></i></a>
                    <button onclick="copyLink()" class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-white hover:scale-110 transition shadow-lg"><i class="fas fa-link"></i></button>
                </div>
            </div>

            <div class="border-t border-white/10 pt-6">
                <p class="text-gray-500 text-xs">Thiết kế bởi <a href="/" class="text-rose-400 hover:text-rose-300 transition font-semibold">THT Media</a> • Nền tảng Thiệp Mời Online</p>
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
        const eventDate = new Date('2026-04-19T07:00:00+07:00').getTime();
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
        const petalColors = ['#ef4444','#f87171','#a855f7','#c084fc','#fca5a5','#d8b4fe'];
        function createPetal() {
            const p = document.createElement('div');
            p.className = 'petal';
            const c = petalColors[Math.floor(Math.random() * petalColors.length)];
            const s = 8 + Math.random() * 12;
            p.innerHTML = `<svg width="${s}" height="${s}" viewBox="0 0 20 20"><ellipse cx="10" cy="10" rx="8" ry="5" fill="${c}" opacity="0.7" transform="rotate(${Math.random()*360} 10 10)"/></svg>`;
            p.style.left = Math.random() * 100 + '%';
            p.style.animation = `leaf-fall ${8+Math.random()*10}s linear forwards`;
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
                music.play().catch(() => {});
                musicBtn.classList.add('playing');
            }
            isPlaying = !isPlaying;
        }
</script>
@endpush

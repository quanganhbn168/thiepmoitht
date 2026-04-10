<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THT Media - Thiệp Mời Họp Lớp Online | Thiết kế chuyên nghiệp</title>
    <meta name="description" content="Dịch vụ thiết kế thiệp mời họp lớp online chuyên nghiệp bởi THT Media. Gửi lời mời đến bạn bè, thầy cô dễ dàng qua Zalo/Facebook.">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Be+Vietnam+Pro:wght@300;400;500;600;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- GLightbox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" href="/favicon.png" type="image/png">
    
    <style>
        body { font-family: 'Be Vietnam Pro', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-accent { font-family: 'Dancing Script', cursive; }
        
        /* Color System - Nostalgic warm tones */
        .gradient-warm { background: linear-gradient(135deg, #b45309 0%, #92400e 50%, #78350f 100%); }
        .gradient-rose { background: linear-gradient(135deg, #be123c 0%, #9f1239 100%); }
        .text-warm { color: #b45309; }
        .text-rose-dark { color: #9f1239; }
        
        .text-gradient-warm {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .text-gradient-rose {
            background: linear-gradient(135deg, #fb7185 0%, #e11d48 50%, #be123c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Animations */
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        @keyframes float-delay { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-15px); } }
        @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 20px rgba(190,18,60,0.3); } 50% { box-shadow: 0 0 40px rgba(190,18,60,0.6); } }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes count-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes leaf-fall {
            0% { transform: translateY(-10%) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
        }
        
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delay { animation: float-delay 6s ease-in-out infinite 2s; }
        .animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
        
        /* Cards */
        .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px) scale(1.02); }
        
        /* Sticky Mobile CTA */
        .sticky-cta { position: fixed; bottom: 0; left: 0; right: 0; z-index: 40; transform: translateY(100%); transition: transform 0.3s ease; }
        .sticky-cta.visible { transform: translateY(0); }
        
        /* Falling leaves */
        .leaf {
            position: absolute;
            width: 20px;
            height: 20px;
            opacity: 0;
            pointer-events: none;
        }
        
        /* Decorative flowers */
        .flower-phuong {
            position: absolute;
            pointer-events: none;
            z-index: 1;
        }
        .flower-phuong svg { filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1)); }
        .flower-banglang svg { filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1)); }
        
        /* Video play button */
        .play-btn {
            width: 80px; height: 80px;
            background: rgba(255,255,255,0.9);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.3s;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }
        .play-btn:hover { transform: scale(1.1); background: white; }
        .play-btn i { color: #be123c; font-size: 28px; margin-left: 4px; }
        
        /* Gallery tabs */
        .gallery-tab {
            padding: 8px 20px;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid transparent;
        }
        .gallery-tab.active {
            background: linear-gradient(135deg, #be123c, #9f1239);
            color: white;
            border-color: transparent;
        }
        .gallery-tab:not(.active) {
            background: white;
            color: #6b7280;
            border-color: #e5e7eb;
        }
        .gallery-tab:not(.active):hover {
            border-color: #f43f5e;
            color: #be123c;
        }
        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px; }
        @media(min-width: 768px) { .gallery-grid { grid-template-columns: repeat(4, 1fr); } }
    </style>
</head>
<body class="bg-[#fcf9f2] text-gray-900 antialiased">

    <!-- Falling Leaves Background (hero only) -->
    <div id="leavesContainer" class="fixed inset-0 pointer-events-none z-0 overflow-hidden" style="height: 100vh;"></div>

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 bg-[#fcf9f2]/95 backdrop-blur-md border-b border-amber-100 shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-3 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <img src="https://thtmedia.com.vn/wp-content/uploads/2023/01/THT-media-logo-2023-261x300.png" alt="THT Media" class="h-12 w-auto">
                <span class="hidden sm:block font-serif font-bold text-lg text-gray-800">THT Media</span>
            </a>
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="#features" class="hover:text-rose-700 transition">Tính năng</a>
                <a href="#demo" class="hover:text-rose-700 transition">Xem Demo</a>
                <a href="#pricing" class="hover:text-rose-700 transition">Bảng giá</a>
                <a href="#contact" class="hover:text-rose-700 transition">Liên hệ</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-rose-700 font-semibold">Tài khoản</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-900 font-semibold hover:text-rose-700 transition">Đăng nhập</a>
                @endauth
            </div>
            <a href="tel:0375433678" class="hidden md:inline-flex items-center gap-2 px-5 py-2.5 rounded-full gradient-rose text-white font-semibold text-sm hover:opacity-90 transition shadow-lg shadow-rose-200">
                <i class="fas fa-phone"></i>
                <span>0375 433 678</span>
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center relative overflow-hidden pt-24 pb-16">
        <!-- Decorative blobs -->
        <div class="absolute top-20 right-10 w-72 h-72 bg-amber-200 rounded-full blur-3xl opacity-40 animate-float"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-rose-200 rounded-full blur-3xl opacity-40 animate-float-delay"></div>
        
        <!-- Decorative Phượng (phoenix flower) branches -->
        <div class="flower-phuong absolute -top-4 -right-8 opacity-60 animate-float" style="width:200px">
            <svg viewBox="0 0 200 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M180 80 Q160 60 140 70 Q120 40 100 55 Q80 30 60 50 Q40 20 20 40" stroke="#15803d" stroke-width="2" fill="none"/>
                <circle cx="140" cy="65" r="8" fill="#ef4444" opacity="0.9"/><circle cx="135" cy="58" r="6" fill="#f87171" opacity="0.8"/><circle cx="148" cy="60" r="5" fill="#dc2626" opacity="0.7"/>
                <circle cx="100" cy="50" r="9" fill="#ef4444" opacity="0.9"/><circle cx="93" cy="43" r="6" fill="#f87171" opacity="0.8"/><circle cx="108" cy="45" r="5" fill="#dc2626" opacity="0.7"/><circle cx="95" cy="55" r="4" fill="#fca5a5"/>
                <circle cx="60" cy="45" r="7" fill="#ef4444" opacity="0.85"/><circle cx="54" cy="39" r="5" fill="#f87171" opacity="0.7"/><circle cx="67" cy="40" r="4" fill="#dc2626" opacity="0.6"/>
                <ellipse cx="160" cy="75" rx="12" ry="4" fill="#15803d" opacity="0.6" transform="rotate(-20 160 75)"/>
                <ellipse cx="120" cy="55" rx="14" ry="4" fill="#16a34a" opacity="0.5" transform="rotate(-30 120 55)"/>
                <ellipse cx="80" cy="42" rx="10" ry="3" fill="#15803d" opacity="0.5" transform="rotate(-15 80 42)"/>
            </svg>
        </div>
        
        <!-- Decorative Bằng Lăng (lagerstroemia) -->
        <div class="flower-phuong absolute bottom-24 -left-4 opacity-50 animate-float-delay" style="width:160px">
            <svg viewBox="0 0 160 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 80 Q40 50 60 60 Q80 35 100 50 Q120 30 140 45" stroke="#15803d" stroke-width="2" fill="none"/>
                <circle cx="60" cy="55" r="10" fill="#a855f7" opacity="0.8"/><circle cx="53" cy="48" r="7" fill="#c084fc" opacity="0.7"/><circle cx="68" cy="49" r="6" fill="#9333ea" opacity="0.6"/><circle cx="57" cy="60" r="5" fill="#d8b4fe"/>
                <circle cx="100" cy="45" r="8" fill="#a855f7" opacity="0.8"/><circle cx="94" cy="39" r="6" fill="#c084fc" opacity="0.7"/><circle cx="107" cy="40" r="5" fill="#9333ea" opacity="0.6"/>
                <circle cx="140" cy="40" r="7" fill="#a855f7" opacity="0.75"/><circle cx="135" cy="34" r="5" fill="#c084fc" opacity="0.65"/>
                <ellipse cx="80" cy="50" rx="12" ry="4" fill="#16a34a" opacity="0.5" transform="rotate(15 80 50)"/>
                <ellipse cx="120" cy="42" rx="10" ry="3" fill="#15803d" opacity="0.5" transform="rotate(-10 120 42)"/>
            </svg>
        </div>
        
        <div class="max-w-6xl mx-auto px-6 relative z-10 w-full">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-rose-600 to-pink-600 text-white font-semibold text-sm mb-4" data-aos="fade-up">
                        🎓 Thiệp Mời Họp Lớp Online - Xu hướng mới 2026
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif font-bold leading-tight mb-4" data-aos="fade-up" data-aos-delay="100">
                        Gửi Lời Mời<br>
                        <span class="text-gradient-rose">Họp Lớp</span><br>
                        <span class="text-gradient-warm">Thật Đẹp</span>
                    </h1>
                    <p class="font-accent text-2xl md:text-3xl text-rose-700 mb-6" data-aos="fade-up" data-aos-delay="150">
                        "Nhớ mãi một thời áo trắng..." 🌸
                    </p>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-lg" data-aos="fade-up" data-aos-delay="200">
                        THT Media thiết kế thiệp mời họp lớp online <strong>sang trọng, đầy kỷ niệm</strong>. Chia sẻ dễ dàng qua Zalo, Facebook. RSVP thông minh, QR Code quỹ hội.
                    </p>
                    
                    <div class="flex flex-wrap gap-4 mb-10" data-aos="fade-up" data-aos-delay="300">
                        <a href="#demo" class="inline-flex items-center gap-2 px-8 py-4 rounded-full gradient-rose text-white font-bold hover:opacity-90 transition shadow-xl shadow-rose-200 animate-pulse-glow">
                            <span>Xem Demo</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#trailer" class="glightbox-trailer inline-flex items-center gap-2 px-8 py-4 rounded-full bg-white border-2 border-gray-200 font-bold hover:border-rose-300 hover:text-rose-700 transition group">
                            <i class="fas fa-play-circle text-rose-500 group-hover:scale-110 transition"></i>
                            <span>Xem Video Trailer</span>
                        </a>
                    </div>
                    
                    <!-- Trust badges -->
                    <div class="flex items-center gap-6 text-sm text-gray-500" data-aos="fade-up" data-aos-delay="400">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Thiết kế A-Z</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Giao nhanh 24h</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Hỗ trợ 1-1</span>
                        </div>
                    </div>
                </div>
                
                <div class="relative" data-aos="fade-left" data-aos-duration="1000">
                    <div class="absolute inset-0 gradient-rose rounded-3xl blur-3xl opacity-20 animate-float"></div>
                    <div class="relative rounded-3xl shadow-2xl w-full overflow-hidden aspect-[4/5] card-hover group cursor-pointer" onclick="document.querySelector('.glightbox-trailer')?.click()">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800&auto=format&fit=crop" 
                             alt="Kỷ niệm họp lớp" 
                             class="w-full h-full object-cover">
                        <!-- Play overlay -->
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-all duration-300 flex items-center justify-center">
                            <div class="play-btn">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <div class="absolute bottom-6 left-6 right-6 text-white">
                            <p class="font-accent text-xl">Video Trailer</p>
                            <p class="text-sm text-white/80">Xem trước không khí buổi họp lớp</p>
                        </div>
                    </div>
                    
                    <!-- Floating card overlay -->
                    <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl shadow-xl p-4 border border-amber-100 animate-float-delay">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-800">500+ Người</div>
                                <div class="text-xs text-gray-500">Đã được kết nối</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-rose-700 font-semibold uppercase tracking-widest text-sm" data-aos="fade-up">Tính năng</span>
                <h2 class="text-3xl md:text-4xl font-serif font-bold mt-4" data-aos="fade-up" data-aos-delay="100">Tại Sao Chọn <span class="text-gradient-rose">Thiệp Mời Online</span>?</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="150">
                    Thay vì gọi điện từng người, hãy gửi một thiệp mời đẹp mắt đến hàng trăm bạn bè chỉ với vài cú nhấp chuột.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gradient-to-br from-rose-50 to-pink-50 p-8 rounded-2xl border border-rose-100 card-hover" data-aos="fade-up">
                    <div class="w-14 h-14 rounded-2xl bg-rose-100 flex items-center justify-center text-rose-600 text-2xl mb-6">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Chia Sẻ Dễ Dàng</h3>
                    <p class="text-gray-600 leading-relaxed">Gửi qua Zalo, Facebook, SMS chỉ bằng 1 link. Bạn bè mở trên điện thoại là xem được ngay.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-gradient-to-br from-amber-50 to-yellow-50 p-8 rounded-2xl border border-amber-100 card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center text-amber-600 text-2xl mb-6">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">RSVP Thông Minh</h3>
                    <p class="text-gray-600 leading-relaxed">Bạn bè xác nhận tham dự trực tiếp trên thiệp. BTC nắm được danh sách ngay lập tức.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-gradient-to-br from-emerald-50 to-green-50 p-8 rounded-2xl border border-emerald-100 card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600 text-2xl mb-6">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">QR Code Quỹ Hội</h3>
                    <p class="text-gray-600 leading-relaxed">Tích hợp QR chuyển khoản trực tiếp trên thiệp. Thu quỹ lớp minh bạch, tiện lợi.</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 p-8 rounded-2xl border border-purple-100 card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600 text-2xl mb-6">
                        <i class="fas fa-images"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Album Kỷ Niệm</h3>
                    <p class="text-gray-600 leading-relaxed">Gắn ảnh lớp ngày xưa, ảnh trường cũ. Gợi nhớ kỷ niệm đẹp thời đi học.</p>
                </div>
                
                <!-- Feature 5 -->
                <div class="bg-gradient-to-br from-sky-50 to-blue-50 p-8 rounded-2xl border border-sky-100 card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 rounded-2xl bg-sky-100 flex items-center justify-center text-sky-600 text-2xl mb-6">
                        <i class="fas fa-comment-dots"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Sổ Lưu Bút Online</h3>
                    <p class="text-gray-600 leading-relaxed">Bạn bè gửi lời nhắn, chia sẻ kỷ niệm. Lưu giữ mãi những tình cảm đẹp.</p>
                </div>
                
                <!-- Feature 6 -->
                <div class="bg-gradient-to-br from-orange-50 to-red-50 p-8 rounded-2xl border border-orange-100 card-hover" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-orange-600 text-2xl mb-6">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Bản Đồ & Lịch Trình</h3>
                    <p class="text-gray-600 leading-relaxed">Tích hợp Google Maps, timeline chương trình chi tiết. Bạn bè không bao giờ lạc đường.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section id="demo" class="py-24 bg-gradient-to-br from-amber-50 via-[#fcf9f2] to-rose-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-warm font-semibold uppercase tracking-widest text-sm" data-aos="fade-up">Demo</span>
                <h2 class="text-3xl md:text-4xl font-serif font-bold mt-4" data-aos="fade-up" data-aos-delay="100">Xem Mẫu Thiệp <span class="text-gradient-warm">Họp Lớp</span></h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="150">
                    Thiệp mời được thiết kế riêng cho từng khóa, với đầy đủ thông tin, chương trình, QR Code, RSVP.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-10 items-center max-w-5xl mx-auto">
                <!-- Demo card -->
                <a href="{{ route('reunion.demo.que-vo') }}" target="_blank" class="group relative bg-slate-900 rounded-3xl overflow-hidden shadow-2xl hover:shadow-rose-500/30 transition duration-500 border border-rose-500/30" data-aos="fade-up">
                    <div class="absolute top-4 right-4 z-20 px-3 py-1 rounded-full gradient-rose text-white text-xs font-bold shadow-lg">DEMO</div>
                    
                    <div class="aspect-[3/4] relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800&auto=format&fit=crop" 
                             class="w-full h-full object-cover opacity-80 transition duration-1000 group-hover:scale-105" 
                             alt="Demo thiệp mời họp lớp Quế Võ 1">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80"></div>
                        
                        <div class="absolute bottom-0 left-0 right-0 p-6 translate-y-2 group-hover:translate-y-0 transition duration-500">
                            <h4 class="font-serif text-2xl font-bold text-white mb-1">THPT Quế Võ 1</h4>
                            <div class="text-amber-400 text-sm font-medium mb-2 uppercase tracking-wider">Niên khóa 1998-2001 • 25 năm</div>
                            <p class="text-gray-300 text-sm mb-3">Thiệp mời kỷ niệm 25 năm ra trường với timeline, dresscode, QR quỹ hội.</p>
                            <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition duration-500 delay-100">
                                <span class="text-white text-sm font-bold border-b border-rose-400 pb-0.5">Xem Demo ngay</span>
                                <i class="fas fa-arrow-right text-rose-400 text-xs"></i>
                            </div>
                        </div>
                    </div>
                </a>
                
                <!-- Info side -->
                <div class="space-y-6" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-2xl font-bold text-gray-800">Một thiệp mời – Trọn vẹn kỷ niệm</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Mỗi thiệp mời họp lớp được THT Media thiết kế riêng, phù hợp với phong cách và kỷ niệm của từng khóa. Không cần lo lắng về thiết kế – chỉ cần gửi thông tin, THT Media sẽ hoàn chỉnh từ A đến Z.
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-4 p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                            <div class="w-10 h-10 rounded-lg bg-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0">
                                <i class="fas fa-paint-brush"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">Thiết kế theo yêu cầu</div>
                                <div class="text-sm text-gray-500">Tùy chỉnh màu sắc, ảnh, nội dung theo ý BTC</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                            <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">Thống kê RSVP</div>
                                <div class="text-sm text-gray-500">Biết chính xác ai tham dự, ai chưa xác nhận</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                                <i class="fas fa-infinity"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">Lưu trữ lâu dài</div>
                                <div class="text-sm text-gray-500">Thiệp online, mở lại bất cứ lúc nào</div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('reunion.demo.que-vo') }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 rounded-full gradient-rose text-white font-bold hover:opacity-90 transition shadow-lg">
                        <i class="fas fa-eye"></i>
                        <span>Xem Demo Thiệp Quế Võ 1</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Class Photos Gallery Section -->
    <section id="gallery" class="py-24 bg-white relative overflow-hidden">
        <!-- Decorative phượng top-right -->
        <div class="flower-phuong absolute -top-2 right-10 opacity-40" style="width:180px">
            <svg viewBox="0 0 180 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M160 70 Q140 45 120 55 Q100 30 80 45 Q60 25 40 40" stroke="#15803d" stroke-width="2" fill="none"/>
                <circle cx="120" cy="50" r="8" fill="#ef4444" opacity="0.8"/><circle cx="113" cy="43" r="6" fill="#f87171" opacity="0.7"/>
                <circle cx="80" cy="40" r="7" fill="#ef4444" opacity="0.75"/><circle cx="74" cy="34" r="5" fill="#fca5a5" opacity="0.6"/>
                <circle cx="40" cy="35" r="6" fill="#ef4444" opacity="0.7"/>
            </svg>
        </div>
        <!-- Decorative bằng lăng bottom-left -->
        <div class="flower-phuong absolute bottom-8 -left-4 opacity-40" style="width:140px">
            <svg viewBox="0 0 140 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 60 Q40 35 60 45 Q80 25 100 35 Q110 28 120 32" stroke="#15803d" stroke-width="2" fill="none"/>
                <circle cx="60" cy="40" r="8" fill="#a855f7" opacity="0.7"/><circle cx="54" cy="34" r="5" fill="#c084fc" opacity="0.6"/>
                <circle cx="100" cy="30" r="7" fill="#a855f7" opacity="0.7"/><circle cx="95" cy="24" r="4" fill="#d8b4fe" opacity="0.6"/>
            </svg>
        </div>
        
        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <div class="text-center mb-12">
                <span class="text-rose-700 font-semibold uppercase tracking-widest text-sm" data-aos="fade-up">Album</span>
                <h2 class="text-3xl md:text-4xl font-serif font-bold mt-4" data-aos="fade-up" data-aos-delay="100">Ảnh Các Lớp <span class="text-gradient-rose">Ngày Ấy</span></h2>
                <p class="font-accent text-xl text-gray-500 mt-3" data-aos="fade-up" data-aos-delay="150">"Một thời để nhớ, một đời để thương..."</p>
            </div>
            
            {{-- Tab chọn lớp --}}
            <div class="flex flex-wrap justify-center gap-3 mb-10" id="galleryTabs" data-aos="fade-up" data-aos-delay="200">
                <button class="gallery-tab active" data-class="all">Tất cả</button>
                <button class="gallery-tab" data-class="12a1">12A1</button>
                <button class="gallery-tab" data-class="12a2">12A2</button>
                <button class="gallery-tab" data-class="12a3">12A3</button>
                <button class="gallery-tab" data-class="12a4">12A4</button>
                <button class="gallery-tab" data-class="12a5">12A5</button>
                <button class="gallery-tab" data-class="12a6">12A6</button>
                <button class="gallery-tab" data-class="12a7">12A7</button>
            </div>
            
            {{-- Grid ảnh placeholder - sẽ thay bằng ảnh thật --}}
            <div class="gallery-grid" id="galleryGrid" data-aos="fade-up" data-aos-delay="300">
                @php
                    $demoPhotos = [
                        ['class' => '12a1', 'label' => 'Lớp 12A1', 'img' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=400&h=400&fit=crop'],
                        ['class' => '12a1', 'label' => 'Lớp 12A1', 'img' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?w=400&h=400&fit=crop'],
                        ['class' => '12a2', 'label' => 'Lớp 12A2', 'img' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=400&h=400&fit=crop'],
                        ['class' => '12a2', 'label' => 'Lớp 12A2', 'img' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=400&h=400&fit=crop'],
                        ['class' => '12a3', 'label' => 'Lớp 12A3', 'img' => 'https://images.unsplash.com/photo-1544531586-fde5298cdd40?w=400&h=400&fit=crop'],
                        ['class' => '12a3', 'label' => 'Lớp 12A3', 'img' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=400&h=400&fit=crop'],
                        ['class' => '12a4', 'label' => 'Lớp 12A4', 'img' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=400&h=400&fit=crop'],
                        ['class' => '12a5', 'label' => 'Lớp 12A5', 'img' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=400&h=400&fit=crop'],
                    ];
                @endphp
                @foreach($demoPhotos as $photo)
                    <a href="{{ $photo['img'] }}" class="glightbox gallery-item rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group" 
                       data-gallery="gallery-{{ $photo['class'] }}" 
                       data-glightbox="title: {{ $photo['label'] }}"
                       data-class="{{ $photo['class'] }}">
                        <div class="aspect-square relative overflow-hidden">
                            <img src="{{ $photo['img'] }}" alt="{{ $photo['label'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-search-plus text-white text-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                <span class="text-white text-sm font-semibold">{{ $photo['label'] }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="text-center mt-10">
                <p class="font-accent text-lg text-gray-400">Ảnh sẽ được cập nhật từ BTC các lớp 🌸</p>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-rose-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <span class="text-amber-400 font-semibold uppercase tracking-widest text-sm" data-aos="fade-up">Bảng giá</span>
                <h2 class="text-3xl md:text-4xl font-serif font-bold mt-4" data-aos="fade-up" data-aos-delay="100">
                    Gói Dịch Vụ <span class="text-amber-400">Thiệp Mời Họp Lớp</span>
                </h2>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="150">
                    THT Media thiết kế và cài đặt hoàn chỉnh từ A-Z. BTC chỉ cần cung cấp thông tin!
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Standard Package -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 card-hover" data-aos="fade-up">
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 rounded-2xl bg-slate-700 flex items-center justify-center text-white text-3xl mx-auto mb-4">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">TIÊU CHUẨN</h3>
                        <div class="text-4xl font-bold text-white mb-1">1.500.000đ</div>
                        <div class="text-gray-400 text-sm">VNĐ / trọn gói</div>
                    </div>
                    <ul class="space-y-3 mb-8 text-gray-300 text-sm">
                        <li class="flex items-start gap-2"><i class="fas fa-check text-green-400 mt-1"></i><span>Thiệp mời online chuẩn responsive</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-green-400 mt-1"></i><span>Timeline chương trình chi tiết</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-green-400 mt-1"></i><span>RSVP xác nhận tham dự</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-green-400 mt-1"></i><span>QR Code quỹ hội</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-green-400 mt-1"></i><span>Google Maps địa điểm</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-green-400 mt-1"></i><span>5 ảnh kỷ niệm</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-green-400 mt-1"></i><span>Nhạc nền</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-green-400 mt-1"></i><span>Lưu trữ 6 tháng</span></li>
                        <li class="flex items-start gap-2 text-gray-500"><i class="fas fa-times mt-1"></i><span class="line-through">Sổ lưu bút online</span></li>
                        <li class="flex items-start gap-2 text-gray-500"><i class="fas fa-times mt-1"></i><span class="line-through">Hiệu ứng đặc biệt</span></li>
                    </ul>
                    <a href="#contact" class="block w-full py-3 text-center rounded-full border border-white/30 font-bold hover:bg-white/10 transition text-sm">Liên hệ đăng ký</a>
                </div>
                
                <!-- Premium Package -->
                <div class="bg-gradient-to-br from-rose-500/20 to-pink-500/20 border-2 border-rose-400 rounded-3xl p-8 relative card-hover md:scale-105" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full gradient-rose text-white text-xs font-bold animate-pulse-glow">
                        ⭐ Được chọn nhiều nhất
                    </div>
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 rounded-2xl gradient-rose flex items-center justify-center text-white text-3xl mx-auto mb-4">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">PREMIUM</h3>
                        <div class="text-4xl font-bold text-rose-400 mb-1">2.500.000đ</div>
                        <div class="text-gray-400 text-sm">VNĐ / trọn gói</div>
                    </div>
                    <ul class="space-y-3 mb-8 text-gray-300 text-sm">
                        <li class="flex items-start gap-2"><i class="fas fa-check text-rose-400 mt-1"></i><span><strong>Tất cả tính năng Tiêu Chuẩn</strong></span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-rose-400 mt-1"></i><span><strong>Thiết kế Premium riêng</strong></span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-rose-400 mt-1"></i><span><strong>Ảnh không giới hạn</strong></span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-rose-400 mt-1"></i><span><strong>Video trailer kỷ niệm</strong></span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-rose-400 mt-1"></i><span><strong>Sổ lưu bút online</strong></span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-rose-400 mt-1"></i><span><strong>Hiệu ứng lá rơi / hoa rơi</strong></span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-rose-400 mt-1"></i><span><strong>Màn mở thiệp 3D</strong></span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-rose-400 mt-1"></i><span><strong>Lưu trữ vĩnh viễn</strong></span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-rose-400 mt-1"></i><span>Tùy chỉnh font, màu sắc</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-rose-400 mt-1"></i><span>Hỗ trợ ưu tiên 1-1</span></li>
                    </ul>
                    <a href="#contact" class="block w-full py-3 text-center rounded-full gradient-rose text-white font-bold hover:opacity-90 transition text-sm animate-pulse-glow">Đăng ký ngay</a>
                </div>
            </div>
            
            <div class="text-center mt-12 text-gray-400 text-sm">
                <p>💡 Tất cả các gói đều được THT Media thiết kế hoàn chỉnh từ A-Z. BTC chỉ cần gửi ảnh và thông tin!</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <span class="text-rose-700 font-semibold uppercase tracking-widest text-sm" data-aos="fade-up">Liên hệ tư vấn</span>
            <h2 class="text-3xl md:text-5xl font-serif font-bold mt-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                THT Media
            </h2>
            <p class="text-gray-600 mb-12" data-aos="fade-up" data-aos-delay="150">Liên hệ ngay để được tư vấn và thiết kế thiệp mời họp lớp cho BTC của bạn!</p>
            
            <div class="grid md:grid-cols-3 gap-8 mt-12 text-left">
                <div class="p-6 rounded-2xl bg-gray-50 text-center card-hover" data-aos="fade-up">
                    <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 text-xl"><i class="fas fa-phone"></i></div>
                    <div class="font-bold text-gray-900 mb-1">Hotline / Zalo</div>
                    <a href="tel:0375433678" class="text-lg font-bold text-rose-700 hover:text-rose-600 transition">0375 433 678</a>
                </div>
                
                <div class="p-6 rounded-2xl bg-gray-50 text-center card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-4 text-xl"><i class="fas fa-envelope"></i></div>
                    <div class="font-bold text-gray-900 mb-1">Email</div>
                    <a href="mailto:thtmediaqvm@gmail.com" class="text-gray-600 hover:text-rose-600 transition">thtmediaqvm@gmail.com</a>
                </div>
                
                <div class="p-6 rounded-2xl bg-gray-50 text-center card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center mx-auto mb-4 text-xl"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="font-bold text-gray-900 mb-1">Trụ sở chính</div>
                    <p class="text-gray-600 text-sm">Số 263 đường Bình Than, phường Đại Phúc, TP. Bắc Ninh</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 bg-slate-950 border-t border-white/5 text-gray-500">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <p class="text-sm">
                © {{ date('Y') }} <strong>THT Media</strong>. Nền tảng Thiệp Mời Họp Lớp Online. Số 263 đường Bình Than, phường Đại Phúc, TP. Bắc Ninh.
            </p>
        </div>
    </footer>

    <!-- Zalo Widget -->
    <a href="https://zalo.me/0375433678" target="_blank" 
       class="fixed bottom-24 right-6 md:bottom-8 w-14 h-14 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-xl hover:scale-110 transition z-50 animate-float border-2 border-white">
        <span class="font-bold text-xs">Zalo</span>
    </a>
    
    <!-- Sticky Mobile CTA -->
    <div id="stickyCta" class="sticky-cta md:hidden bg-white border-t border-gray-100 shadow-2xl px-4 py-3 safe-area-bottom">
        <div class="flex gap-3">
            <a href="tel:0375433678" class="flex-1 py-3 text-center rounded-full bg-gray-100 font-bold text-gray-700">
                <i class="fas fa-phone mr-2"></i>Gọi ngay
            </a>
            <a href="#demo" class="flex-1 py-3 text-center rounded-full gradient-rose text-white font-bold animate-pulse-glow">
                Xem Demo 🎓
            </a>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, offset: 50 });
        
        // GLightbox - Photo gallery
        const lightbox = GLightbox({ selector: '.glightbox', touchNavigation: true, loop: true });
        
        // GLightbox - Video trailer
        // TODO: Replace with actual YouTube URL when video is uploaded
        const trailerLightbox = GLightbox({
            selector: '.glightbox-trailer',
            elements: [{
                href: 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                type: 'video',
                source: 'youtube',
                title: 'Video Trailer - 25 Năm Trở Về Thanh Xuân'
            }]
        });
        
        // Gallery tab filtering
        document.querySelectorAll('.gallery-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.gallery-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                const cls = this.dataset.class;
                document.querySelectorAll('.gallery-item').forEach(item => {
                    if (cls === 'all' || item.dataset.class === cls) {
                        item.style.display = '';
                        item.style.animation = 'count-up 0.4s ease forwards';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // Sticky CTA visibility
        const stickyCta = document.getElementById('stickyCta');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 500) {
                stickyCta.classList.add('visible');
            } else {
                stickyCta.classList.remove('visible');
            }
        });
        
        // Falling petals (phượng + bằng lăng colors)
        const container = document.getElementById('leavesContainer');
        const petalColors = ['#ef4444', '#f87171', '#a855f7', '#c084fc', '#fca5a5', '#d8b4fe'];
        function createPetal() {
            const petal = document.createElement('div');
            petal.className = 'leaf';
            const color = petalColors[Math.floor(Math.random() * petalColors.length)];
            const size = 8 + Math.random() * 14;
            petal.innerHTML = `<svg width="${size}" height="${size}" viewBox="0 0 20 20"><ellipse cx="10" cy="10" rx="8" ry="5" fill="${color}" opacity="0.7" transform="rotate(${Math.random()*360} 10 10)"/></svg>`;
            petal.style.left = Math.random() * 100 + '%';
            petal.style.animation = `leaf-fall ${8 + Math.random() * 10}s linear forwards`;
            container.appendChild(petal);
            setTimeout(() => petal.remove(), 18000);
        }
        setInterval(createPetal, 1500);
        for (let i = 0; i < 8; i++) setTimeout(createPetal, i * 300);
    </script>
</body>
</html>

@extends('layouts.reunion')

@section('title', 'Thư Kính Mời Quý Thầy Cô - 25 Năm Trở Về Khung Trời Kỷ Niệm')

@section('meta')
    <meta name="description" content="Kỷ niệm 25 năm ngày ra trường - Niên khóa 1998-2001 - THPT Quế Võ Số 1. 07h Chủ nhật 19/04/2026. Kính mong sự hiện diện của Quý Thầy Cô!">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Thư Kính Mời Quý Thầy Cô - 25 Năm Trở Về Khung Trời Kỷ Niệm">
    <meta property="og:description" content="Kỷ niệm 25 năm ngày ra trường - Niên khóa 1998-2001 - THPT Quế Võ Số 1. 07h Chủ nhật 19/04/2026. Kính mong sự hiện diện của Quý Thầy Cô!">
    <meta property="og:image" content="{{ asset('images/anh-bia.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
@endsection

@push('styles')
<style>
.text-gold { color: #d4af37; }
        .bg-gold { background-color: #d4af37; }
        .border-gold { border-color: #d4af37; }
        .gradient-luxury { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); }
</style>
@endpush

@section('body_class', "bg-slate-50 text-slate-800 antialiased overflow-x-hidden")

@section('content')
<!-- HERO SECTION -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden gradient-luxury">
        <div class="absolute inset-0">
            <img src="/images/hero-bg.jpg" alt="Trường THPT Quế Võ 1" class="w-full h-full object-cover opacity-20">
        </div>
        
        <!-- Luxury border -->
        <div class="absolute inset-4 sm:inset-6 border-2 border-gold/40 rounded-3xl z-10 pointer-events-none"></div>
        <div class="absolute inset-5 sm:inset-7 border border-gold/20 rounded-3xl z-10 pointer-events-none"></div>

        <div class="relative z-20 text-center text-white px-5 py-10 max-w-xl mx-auto w-full">
            <div data-aos="fade-down" class="mb-4">
                <i class="fas fa-graduation-cap text-4xl text-gold mb-3"></i>
                <p class="uppercase tracking-[0.2em] text-xs sm:text-sm text-gold font-semibold">Trường THPT Quế Võ Số 1</p>
                <p class="uppercase tracking-widest text-xs text-slate-300 mt-1">Niên khóa 1998 - 2001</p>
            </div>

            <h1 class="font-accent text-5xl sm:text-6xl md:text-7xl text-gold mb-4 mt-2" data-aos="zoom-in" data-aos-delay="100">
                Thư Kính Mời
            </h1>

            <div class="w-24 h-[1px] bg-gold mx-auto mb-6 mt-4" data-aos="fade-up" data-aos-delay="200"></div>

            <p class="text-lg sm:text-2xl font-serif text-slate-200 mb-6 leading-relaxed" data-aos="fade-up" data-aos-delay="300">
                Lễ kỷ niệm 25 năm ngày ra trường<br>
                <span class="text-gold font-bold text-3xl sm:text-4xl mt-3 block italic">"Trở Về Khung Trời Kỷ Niệm"</span>
            </p>

            <div class="bg-white/5 backdrop-blur-md border border-gold/30 rounded-xl p-6 sm:p-8 mb-8 mt-6 inline-block w-full max-w-sm" data-aos="fade-up" data-aos-delay="400">
                <p class="text-slate-300 text-sm sm:text-base mb-3 font-serif">Trân trọng kính mời Quý Thầy/Cô:</p>
                <p class="text-gold border-b border-gold/50 pb-1 mb-5 text-lg mx-auto w-full font-serif italic">................................................</p>
                
                <p class="text-sm sm:text-base text-slate-200 mb-3 font-serif">Đến dự buổi họp mặt cùng tập thể cựu học sinh</p>
                <div class="bg-navy/50 rounded-lg p-4 border border-gold/20">
                    <p class="font-bold text-xl text-white mb-2">Vào lúc <span class="text-gold text-2xl">07h00</span> Chủ nhật</p>
                    <p class="text-2xl text-gold font-serif font-bold mb-2">Ngày 19 . 04 . 2026</p>
                    <p class="text-sm text-slate-300">Tại Trường THPT Quế Võ Số 1</p>
                </div>
            </div>

            <p class="font-serif italic text-xl text-gold" data-aos="fade-up" data-aos-delay="500">
                Sự hiện diện của Quý Thầy/Cô là niềm vinh hạnh to lớn đối với chúng em!
            </p>
        </div>
    </section>

    <!-- CHI TIẾT SECTION -->
    <section class="py-16 sm:py-24 bg-white px-5 relative">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-px h-16 bg-gradient-to-b from-gold to-transparent"></div>
        <div class="max-w-4xl mx-auto mt-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-navy">Thông Tin <span class="text-gold">Sự Kiện</span></h2>
                <div class="w-16 h-[2px] bg-gold mx-auto mt-4"></div>
            </div>

            <div class="grid sm:grid-cols-2 gap-8 max-w-4xl mx-auto mb-8">
                <!-- Thời gian -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-8 text-center hover:border-gold/50 transition duration-300 shadow-sm hover:shadow-md" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-navy rounded-full flex items-center justify-center text-gold text-2xl mx-auto mb-5">
                        <i class="far fa-clock"></i>
                    </div>
                    <h3 class="font-bold font-serif text-2xl text-navy mb-3">Thời Gian</h3>
                    <p class="text-slate-600 mb-2 font-medium">Chủ nhật, ngày 19 tháng 04 năm 2026</p>
                    <p class="text-xl font-bold text-gold">07h00 Sáng</p>
                </div>

                <!-- Địa điểm -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-8 text-center hover:border-gold/50 transition duration-300 shadow-sm hover:shadow-md" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-navy rounded-full flex items-center justify-center text-gold text-2xl mx-auto mb-5">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3 class="font-bold font-serif text-2xl text-navy mb-3">Địa Điểm</h3>
                    <p class="text-slate-600 mb-2 font-medium">Trường THPT Quế Võ Số 1</p>
                    <p class="text-sm text-slate-500">Phố Mới, Quế Võ, Bắc Ninh</p>
                </div>
                
                <!-- Thành phần -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-8 text-center hover:border-gold/50 transition duration-300 shadow-sm hover:shadow-md" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-navy rounded-full flex items-center justify-center text-gold text-2xl mx-auto mb-5">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="font-bold font-serif text-2xl text-navy mb-3">Thành Phần (Dự kiến 500 người)</h3>
                    <ul class="text-slate-600 text-sm space-y-2 text-left w-fit mx-auto">
                        <li class="flex items-start gap-2"><i class="fas fa-check text-gold mt-1 text-xs"></i>Cựu HS 13 lớp khóa 1998-2001 (~400 người)</li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-gold mt-1 text-xs"></i>Ban Giám hiệu, thầy/cô cũ (~90 người)</li>
                        <li class="flex items-start gap-2"><i class="fas fa-check text-gold mt-1 text-xs"></i>BGH hiện tại & Tổ trưởng bộ môn (~10 người)</li>
                    </ul>
                </div>
                
                <!-- Dress code -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-8 text-center hover:border-gold/50 transition duration-300 shadow-sm hover:shadow-md" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-16 h-16 bg-navy rounded-full flex items-center justify-center text-gold text-2xl mx-auto mb-5">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <h3 class="font-bold font-serif text-2xl text-navy mb-3">Dresscode</h3>
                    <div class="space-y-3 text-left w-fit mx-auto">
                        <div class="bg-white border border-slate-200 rounded-lg p-3 text-sm flex gap-3 items-center">
                            <span class="px-2 py-1 bg-navy text-gold rounded text-xs font-bold whitespace-nowrap">Phần Lễ</span>
                            <span class="text-slate-600">Đồng phục hội khóa (Nam), Áo dài (Nữ).</span>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-lg p-3 text-sm flex gap-3 items-center">
                            <span class="px-2 py-1 bg-gold text-navy rounded text-xs font-bold whitespace-nowrap">Tiệc</span>
                            <span class="text-slate-600">Áo phông kỷ niệm hội khóa.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TIMELINE SECTION (Navy/Gold style) -->
    <section class="py-16 sm:py-20 bg-slate-100 px-5">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-navy">Lịch Trình <span class="text-gold">Giao Lưu</span></h2>
                <div class="w-16 h-[2px] bg-gold mx-auto mt-4 mb-4"></div>
                <p class="font-serif italic text-lg text-slate-500">"25 năm - Hội ngộ và Tri ân"</p>
            </div>

            <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gold/50 before:to-transparent">
                <!-- 1. 7h00 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active" data-aos="fade-up">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-navy text-gold shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-clock text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-5 rounded-xl shadow-md border border-slate-100 group-hover:border-gold/50 transition">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-navy text-base sm:text-lg pr-2">Đón khách, hướng dẫn ổn định</h3>
                            <span class="font-mono text-gold font-bold bg-gold/10 px-2 py-1 rounded text-xs sm:text-sm whitespace-nowrap">7h00 - 8h00</span>
                        </div>
                        <p class="text-slate-600 text-sm">Đón bạn bè, thầy cô. Nhạc sôi động.</p>
                    </div>
                </div>
                
                <!-- 2. 8h00 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active" data-aos="fade-up">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-navy text-gold shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-music text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-5 rounded-xl shadow-md border border-slate-100 group-hover:border-gold/50 transition">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-navy text-base sm:text-lg pr-2">Văn nghệ chào mừng</h3>
                            <span class="font-mono text-gold font-bold bg-gold/10 px-2 py-1 rounded text-xs sm:text-sm whitespace-nowrap">8h00 - 8h25</span>
                        </div>
                        <p class="text-slate-600 text-sm">Đội Văn nghệ xung kích của khóa biểu diễn.</p>
                    </div>
                </div>

                <!-- 3. 8h25 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active" data-aos="fade-up">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-navy text-gold shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-microphone-alt text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-5 rounded-xl shadow-md border border-slate-100 group-hover:border-gold/50 transition">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-navy text-base sm:text-lg pr-2">Tuyên bố lý do, giới thiệu</h3>
                            <span class="font-mono text-gold font-bold bg-gold/10 px-2 py-1 rounded text-xs sm:text-sm whitespace-nowrap">8h25 - 8h50</span>
                        </div>
                        <p class="text-slate-600 text-sm">Ổn định tổ chức, giới thiệu đại biểu & khách mời.</p>
                    </div>
                </div>

                <!-- 4. 8h50 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active" data-aos="fade-up">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-gold text-navy shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-star text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-navy p-5 rounded-xl shadow-md border border-gold/30">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-gold text-base sm:text-lg pr-2">Khai mạc Hội khóa</h3>
                            <span class="font-mono text-navy font-bold bg-gold px-2 py-1 rounded text-xs sm:text-sm whitespace-nowrap">8h50 - 9h00</span>
                        </div>
                        <p class="text-slate-300 text-sm">Đại diện Ban tổ chức phát biểu khai mạc chương trình.</p>
                    </div>
                </div>

                <!-- 5. 9h00 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active" data-aos="fade-up">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-navy text-gold shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-camera text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-5 rounded-xl shadow-md border border-slate-100 group-hover:border-gold/50 transition">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-navy text-base sm:text-lg pr-2">Giới thiệu lớp & Chụp ảnh</h3>
                            <span class="font-mono text-gold font-bold bg-gold/10 px-2 py-1 rounded text-xs sm:text-sm whitespace-nowrap">9h00 - 9h30</span>
                        </div>
                        <p class="text-slate-600 text-sm">Giới thiệu các lớp tham gia và chụp ảnh lưu niệm.</p>
                    </div>
                </div>

                <!-- 6. 9h30 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active" data-aos="fade-up">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-navy text-gold shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-gift text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-5 rounded-xl shadow-md border border-slate-100 group-hover:border-gold/50 transition">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-navy text-base sm:text-lg pr-2">Tặng quà & Phát biểu</h3>
                            <span class="font-mono text-gold font-bold bg-gold/10 px-2 py-1 rounded text-xs sm:text-sm whitespace-nowrap">9h30 - 9h45</span>
                        </div>
                        <p class="text-slate-600 text-sm">Tặng quà Nhà trường. Đại diện BGH và Cựu học sinh phát biểu.</p>
                    </div>
                </div>

                <!-- 7. 9h45 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active" data-aos="fade-up">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-navy text-gold shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-heart text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-5 rounded-xl shadow-md border border-slate-100 group-hover:border-gold/50 transition">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-navy text-base sm:text-lg pr-2">Tri ân Thầy Cô</h3>
                            <span class="font-mono text-gold font-bold bg-gold/10 px-2 py-1 rounded text-xs sm:text-sm whitespace-nowrap">9h45 - 10h15</span>
                        </div>
                        <p class="text-slate-600 text-sm">Tặng quà tri ân các Thầy cô nguyên giáo viên của khóa.</p>
                    </div>
                </div>

                <!-- 8. 10h15 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active" data-aos="fade-up">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-navy text-gold shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-comments text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-5 rounded-xl shadow-md border border-slate-100 group-hover:border-gold/50 transition">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-navy text-base sm:text-lg pr-2">Giao lưu Thầy Cô</h3>
                            <span class="font-mono text-gold font-bold bg-gold/10 px-2 py-1 rounded text-xs sm:text-sm whitespace-nowrap">10h15 - 10h35</span>
                        </div>
                        <p class="text-slate-600 text-sm">Đại diện Thầy cô phát biểu và giao lưu cùng các học trò.</p>
                    </div>
                </div>

                <!-- 9. 10h35 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active" data-aos="fade-up">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-navy text-gold shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-award text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-5 rounded-xl shadow-md border border-slate-100 group-hover:border-gold/50 transition">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-navy text-base sm:text-lg pr-2">Vinh danh BTC & Nhà tài trợ</h3>
                            <span class="font-mono text-gold font-bold bg-gold/10 px-2 py-1 rounded text-xs sm:text-sm whitespace-nowrap">10h35 - 10h55</span>
                        </div>
                        <p class="text-slate-600 text-sm">Vinh danh, tặng quà Ban tổ chức và các nhà tài trợ.</p>
                    </div>
                </div>

                <!-- 10. 10h55 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active" data-aos="fade-up">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-gold text-navy shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-glass-cheers text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-navy p-5 rounded-xl shadow-md border border-gold/30">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-gold text-base sm:text-lg pr-2">Kết thúc chương trình lễ</h3>
                            <span class="font-mono text-navy font-bold bg-gold px-2 py-1 rounded text-xs sm:text-sm whitespace-nowrap">10h55 - 11h00</span>
                        </div>
                        <p class="text-slate-300 text-sm">Chuyển sang phần tiệc liên hoan và giao lưu tự do.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-reunions.rsvp :classDirs="$classDirs" />

    <!-- MAP SECTION -->
    <section class="py-16 sm:py-20 bg-slate-50 px-5 border-t border-slate-200">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-10" data-aos="fade-up">
                <h2 class="text-3xl font-serif font-bold text-navy">Bản Đồ <span class="text-gold">Chỉ Đường</span></h2>
                <div class="w-16 h-[2px] bg-gold mx-auto mt-4"></div>
            </div>

            <div class="rounded-xl overflow-hidden shadow-xl border-4 border-white bg-white" data-aos="fade-up" data-aos-delay="100">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3726.5!2d106.1614!3d21.1234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDA3JzI0LjQiTiAxMDbCsDA5JzQxLjAiRQ!5e0!3m2!1svi!2s!4v1234567890"
                    width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" class="w-full"></iframe>
            </div>
            
            <div class="text-center mt-10" data-aos="fade-up" data-aos-delay="200">
                <p class="text-sm text-slate-500 mb-4">Để được hỗ trợ chi tiết, Quý Thầy/Cô vui lòng liên hệ Ban Tổ Chức:</p>
                <a href="tel:0943859166" class="inline-flex items-center gap-2 px-8 py-3.5 bg-navy text-gold font-semibold rounded-full hover:bg-slate-800 transition shadow-lg text-lg">
                    <i class="fas fa-phone-alt"></i> 0943 859 166
                </a>
            </div>
        </div>
    </section>

    <x-reunions.guestbook :messages="$messages" />

    <!-- FOOTER -->
    <footer class="gradient-luxury text-slate-300 py-12 px-5 border-t-4 border-gold">
        <div class="max-w-4xl mx-auto text-center">
            <h3 class="font-serif text-2xl text-gold font-bold mb-3">Trường THPT Quế Võ Số 1</h3>
            <p class="uppercase tracking-[0.2em] text-xs font-semibold mb-6">Niên Khóa 1998 - 2001</p>
            
            <p class="text-sm mb-2">Trưởng Ban tổ chức: <strong class="text-white text-base">Nguyễn Đức Mạnh</strong></p>
            
            <div class="border-t border-white/10 mt-10 pt-6">
                <p class="text-xs text-slate-500">Thiết kế bởi <span class="text-gold font-semibold tracking-wider">THT Media</span></p>
            </div>
        </div>
    </footer>

    
    
@endsection

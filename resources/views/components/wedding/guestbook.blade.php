{{-- 
Guestbook Inline Component - Display wishes + submit form
Usage: @include('components.wedding.guestbook-inline', ['wedding' => $wedding])
--}}

@php
    $wishes = $wedding->approvedWishes()->latest()->take(20)->get();
@endphp

{{-- Guestbook Component (Readable & AJAX) --}}
@php
    $wishes = $wedding->approvedWishes()->latest()->take(20)->get();
@endphp

<section id="guestbook" class="py-24 px-6 relative overflow-hidden" 
    style="background-color: var(--bg-paper, #ffffff); color: var(--color-text-body, #374151);">
    
    <div class="max-w-5xl mx-auto relative z-10">
        {{-- Header --}}
        <div class="text-center mb-16">
            <span class="text-xs font-bold uppercase tracking-[0.3em] opacity-60 mb-3 block" style="font-family: var(--font-body); color: var(--color-text-body);">Guestbook</span>
            <h2 class="text-4xl md:text-5xl mb-6 text-shadow-gold" style="font-family: var(--font-heading); color: var(--color-primary-dark);">
                {{ $wedding->getContentValue('guestbook_title', 'Lời Chúc Phúc') }}
            </h2>
            <div class="w-16 h-px mx-auto" style="background-color: var(--color-primary);"></div>
            @if($guestbook_desc = $wedding->getContentValue('guestbook_desc'))
                <p class="mt-4 text-gray-500 italic max-w-md mx-auto">{{ $guestbook_desc }}</p>
            @endif
        </div>
        
        {{-- Submit Form (AJAX & Readable) --}}
        <div class="max-w-2xl mx-auto mb-20" x-data="{ 
            open: false,
            submitting: false,
            success: false,
            error: null,
            formData: { name: '', message: '' },
            async submitWish() {
                this.submitting = true;
                this.error = null;
                
                try {
                    const response = await fetch('{{ route('wedding.wish.store', $wedding->slug) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.formData)
                    });
                    
                    if (response.ok) {
                        this.success = true;
                        this.formData = { name: '', message: '' };
                        setTimeout(() => { this.success = false; this.open = false; }, 3000);
                    } else {
                        const data = await response.json();
                        this.error = data.message || 'Có lỗi xảy ra, vui lòng thử lại.';
                    }
                } catch (e) {
                    this.error = 'Lỗi kết nối mạng.';
                } finally {
                    this.submitting = false;
                }
            }
        }">
            <div class="text-center mb-8">
                 <button @click="open = true" class="group inline-flex items-center gap-2 px-8 py-3 bg-[var(--color-primary)] text-white text-xs uppercase tracking-widest hover:opacity-90 transition-all duration-300 shadow-md rounded-sm">
                    <span style="font-family: var(--font-body);">Gửi Lời Chúc</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>

            {{-- Modal Form --}}
            <div x-show="open" x-transition.opacity 
                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" 
                 style="display: none;">
                
                <div class="bg-white w-full max-w-lg p-8 relative shadow-2xl rounded-lg" @click.outside="open = false">
                    <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-900 z-10 p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    
                    <h3 class="text-2xl text-center mb-6 text-gray-800" style="font-family: var(--font-heading);">Viết Lời Chúc</h3>

                    {{-- Success State --}}
                    <div x-show="success" class="text-center py-8">
                        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800 mb-2">Đã Gửi Thành Công!</h4>
                        <p class="text-gray-600">Cảm ơn bạn đã gửi lời chúc phúc.</p>
                    </div>

                    {{-- Form State --}}
                    <form @submit.prevent="submitWish" x-show="!success" class="space-y-6">
                        @csrf
                        <div x-show="error" class="p-3 bg-red-50 text-red-600 text-sm rounded border border-red-100 text-center" x-text="error"></div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Tên của bạn</label>
                            <input type="text" x-model="formData.name" required 
                                   class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded transition-colors outline-none"
                                   style="font-family: var(--font-body);"
                                   onfocus="this.style.borderColor='var(--color-primary)'; this.style.boxShadow='0 0 0 1px var(--color-primary)';"
                                   onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                                   placeholder="Nhập tên của bạn...">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Lời nhắn gửi</label>
                            <textarea x-model="formData.message" required rows="4" 
                                      class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded transition-colors resize-none outline-none"
                                      style="font-family: var(--font-body);"
                                      onfocus="this.style.borderColor='var(--color-primary)'; this.style.boxShadow='0 0 0 1px var(--color-primary)';"
                                      onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                                      placeholder="Viết lời chúc tốt đẹp nhất..."></textarea>
                        </div>
                        
                        <button type="submit" 
                                class="w-full py-4 text-white font-bold uppercase tracking-widest hover:opacity-90 transition-opacity shadow-lg rounded"
                                style="background-color: var(--color-primary);"
                                :disabled="submitting"
                                :class="{ 'opacity-75 cursor-not-allowed': submitting }">
                            <span x-show="!submitting">Gửi Lời Chúc</span>
                            <span x-show="submitting">Đang Gửi...</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        @php
            // Get style from wedding settings or default to 'editorial'
            $guestbookStyle = $wedding->content['guestbook_style'] ?? 'editorial';
        @endphp

        {{-- Styles Container --}}
        @switch($guestbookStyle)

            {{-- STYLE 1: EDITORIAL (Default) --}}
            @case('editorial')
                @if($wishes->count() > 0)
                <!-- Swiper CSS -->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
                <style>
                    .swiper-pagination-bullet { width: 8px; height: 8px; background: #ddd; opacity: 1; transition: all 0.3s; }
                    .swiper-pagination-bullet-active { width: 24px; border-radius: 4px; background-color: var(--color-primary) !important; }
                    .guestbook-swiper { opacity: 0; transition: opacity 0.5s ease-in-out; }
                    .guestbook-swiper.swiper-initialized { opacity: 1; }
                </style>

                <div class="relative max-w-4xl mx-auto px-4">
                    <div class="swiper guestbook-swiper !pb-16">
                        <div class="swiper-wrapper items-center">
                            @foreach($wishes as $wish)
                            <div class="swiper-slide h-auto">
                                <div class="bg-transparent px-4 md:px-12 py-6 text-center">
                                    <div class="text-4xl md:text-5xl opacity-30 font-serif mb-6" style="color: var(--color-primary);">“</div>
                                    <div class="relative z-10 mb-8">
                                        <p class="text-xl md:text-2xl leading-relaxed font-serif text-gray-700 italic" 
                                           style="font-family: 'Playfair Display', serif; line-height: 1.8;">
                                            {{ $wish->message }}
                                        </p>
                                    </div>
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <div class="w-12 h-px bg-gray-300 mb-2"></div>
                                        <h4 class="font-bold text-sm tracking-[0.2em] uppercase text-gray-900" style="font-family: var(--font-heading);">
                                            {{ $wish->name }}
                                        </h4>
                                        <span class="text-[11px] text-gray-400 font-sans tracking-wide uppercase">
                                            {{ $wish->created_at->format('d.m.Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination !bottom-0"></div>
                    </div>
                
                {{-- Custom Navigation Arrows --}}
                <div class="hidden md:flex swiper-button-prev !w-12 !h-12 !top-1/2 !-translate-y-1/2 z-20 rounded-full border border-gray-200 text-gray-400 hover:border-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-white transition-all duration-300 items-center justify-center after:!hidden group !left-0">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"></path></svg>
                </div>
                <div class="hidden md:flex swiper-button-next !w-12 !h-12 !top-1/2 !-translate-y-1/2 z-20 rounded-full border border-gray-200 text-gray-400 hover:border-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-white transition-all duration-300 items-center justify-center after:!hidden group !right-0">
                    <svg class="w-5 h-5 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </div>

                <!-- Swiper JS -->
                <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
                <script>
                    new Swiper(".guestbook-swiper", {
                        slidesPerView: 1,
                        spaceBetween: 40,
                        loop: true,
                        autoHeight: true,
                        speed: 800,
                        autoplay: { delay: 6000, disableOnInteraction: true },
                        pagination: { el: ".swiper-pagination", clickable: true },
                        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
                        effect: 'fade',
                        fadeEffect: { crossFade: true },
                    });
                </script>
                @else
                <div class="text-center py-16"><p class="text-gray-400 italic font-serif">Chưa có lời chúc nào.</p></div>
                @endif
                @break

            {{-- STYLE 2: MASONRY (Classic Grid) --}}
            @case('masonry')
                @if($wishes->count() > 0)
                <div class="columns-1 md:columns-2 lg:columns-3 gap-6 space-y-6">
                    @foreach($wishes as $wish)
                    <div class="break-inside-avoid relative group hover:-translate-y-1 transition-transform duration-500">
                        <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-100 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-1" style="background-color: var(--color-primary);"></div>
                            <div class="relative z-10">
                                <p class="text-gray-600 leading-relaxed mb-6 text-base text-justify break-words whitespace-pre-wrap" style="font-family: var(--font-body);">
                                    {!! nl2br(e($wish->message)) !!}
                                </p>
                                <div class="pt-4 border-t border-dashed border-gray-200 flex flex-col items-end">
                                    <h4 class="font-bold uppercase tracking-wider text-sm mb-1" style="color: var(--color-primary); font-family: var(--font-heading);">{{ $wish->name }}</h4>
                                    <span class="text-[11px] text-gray-400 italic">{{ $wish->created_at->format('H:i - d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-16"><p class="text-gray-500">Chưa có lời chúc nào.</p></div>
                @endif
                @break

            {{-- STYLE 3: CAROUSEL (Standard Slider) --}}
            @case('carousel')
                @if($wishes->count() > 0)
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
                <style>
                    .wish-scroll::-webkit-scrollbar { width: 3px; }
                    .wish-scroll::-webkit-scrollbar-thumb { background-color: rgba(0,0,0,0.1); border-radius: 3px; }
                    .swiper-pagination-bullet-active { background-color: var(--color-primary) !important; }
                </style>
                <div class="relative px-0 md:px-12">
                    <div class="swiper carousel-swiper !pb-14 !px-4 md:!px-0">
                        <div class="swiper-wrapper">
                            @foreach($wishes as $wish)
                            <div class="swiper-slide h-auto">
                                <div class="bg-white h-[320px] p-6 rounded-xl border border-gray-100 shadow-lg flex flex-col">
                                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-50">
                                        <div class="w-10 h-10 rounded-full text-white flex items-center justify-center font-bold uppercase" style="background-color: var(--color-primary);">{{ substr($wish->name, 0, 1) }}</div>
                                        <div>
                                            <h4 class="font-bold text-sm uppercase">{{ $wish->name }}</h4>
                                            <span class="text-xs text-gray-400">{{ $wish->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="wish-scroll flex-1 overflow-y-auto pr-2">
                                        <p class="text-gray-600 text-[15px] leading-relaxed break-words">{{ $wish->message }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination !bottom-0"></div>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
                <script>
                    new Swiper(".carousel-swiper", {
                        slidesPerView: 1, spaceBetween: 24, loop: true,
                        pagination: { el: ".swiper-pagination", clickable: true },
                        breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
                    });
                </script>
                @else
                <div class="text-center py-16"><p class="text-gray-500">Chưa có lời chúc nào.</p></div>
                @endif
                @break

            {{-- STYLE 4: CHAT (Conversation Bubbles) --}}
            @case('chat')
                @if($wishes->count() > 0)
                <div class="max-w-3xl mx-auto space-y-8 bg-gray-50/50 p-6 rounded-2xl border border-dashed border-gray-200">
                    @foreach($wishes as $wish)
                    <div class="flex gap-4 items-end {{ $loop->even ? 'flex-row-reverse' : '' }}">
                        <div class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center text-white text-xs font-bold uppercase shadow-sm" style="background-color: var(--color-primary);">
                            {{ substr($wish->name, 0, 1) }}
                        </div>
                        <div class="max-w-[80%]">
                            <div class="px-5 py-3 rounded-2xl shadow-sm text-sm leading-relaxed break-words {{ $loop->even ? 'bg-[var(--color-primary)] text-white' : 'bg-white text-gray-800' }}">
                                {{ $wish->message }}
                            </div>
                            <span class="text-[10px] text-gray-400 mt-1 block {{ $loop->even ? 'text-right' : 'text-left' }}">
                                {{ $wish->name }} • {{ $wish->created_at->format('H:i') }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-16"><p class="text-gray-500">Chưa có tin nhắn nào.</p></div>
                @endif
                @break

            {{-- STYLE 5: POLAROID (Scattered Cards) --}}
            @case('polaroid')
                @if($wishes->count() > 0)
                <div class="flex flex-wrap justify-center gap-8 py-8">
                    @foreach($wishes as $index => $wish)
                    @php $rotate = ($index % 2 == 0) ? 'rotate-2' : '-rotate-1'; @endphp
                    <div class="w-64 bg-white p-3 pb-8 shadow-xl transform {{ $rotate }} hover:scale-110 hover:rotate-0 hover:z-10 transition-all duration-300 border border-gray-100">
                        <div class="bg-gray-50 h-32 flex items-center justify-center mb-4 overflow-hidden relative">
                             <div class="text-4xl opacity-10 font-serif">“</div>
                             <p class="absolute inset-0 p-4 text-xs text-center flex items-center justify-center text-gray-600 italic line-clamp-4">{{ $wish->message }}</p>
                        </div>
                        <div class="text-center">
                            <h4 class="font-handwriting text-lg text-gray-800 font-bold" style="font-family: 'Dancing Script', cursive;">{{ $wish->name }}</h4>
                            <span class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $wish->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-16"><p class="text-gray-500">Chưa có tấm ảnh nào.</p></div>
                @endif
                @break

            @default
                {{-- Fallback needed? No, editorial is default above --}}
        @endswitch
    </div>
</section>

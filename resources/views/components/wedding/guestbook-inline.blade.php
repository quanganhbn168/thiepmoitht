{{-- 
Guestbook Inline Component - Display wishes + submit form
Usage: @include('components.wedding.guestbook-inline', ['wedding' => $wedding])
--}}

@php
    $wishes = $wedding->approvedWishes()->latest()->take(20)->get();
@endphp

<section id="guestbook" class="py-16 px-4 bg-gradient-to-b from-pink-50 to-white relative overflow-hidden">
    {{-- Decorative elements --}}
    <div class="absolute top-0 left-0 w-32 h-32 bg-pink-100 rounded-full opacity-30 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-48 h-48 bg-pink-100 rounded-full opacity-30 translate-x-1/2 translate-y-1/2"></div>
    
    <div class="max-w-4xl mx-auto relative">
        {{-- Header --}}
        <div class="text-center mb-12">
            <span class="text-pink-500 text-sm font-medium tracking-widest uppercase">Sổ Lưu Bút</span>
            <h2 class="text-3xl md:text-4xl font-serif text-gray-800 mt-2 mb-4">Lời Chúc Mừng</h2>
            <div class="w-20 h-0.5 bg-gradient-to-r from-pink-300 via-pink-500 to-pink-300 mx-auto"></div>
        </div>
        
        {{-- Wishes Display --}}
        @if($wishes->count() > 0)
        <div class="mb-12 space-y-4" id="wishesContainer">
            @foreach($wishes as $wish)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-pink-100 transform transition hover:shadow-md hover:-translate-y-0.5">
                <div class="flex items-start gap-4">
                    {{-- Avatar --}}
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-400 to-rose-400 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                        {{ strtoupper(substr($wish->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-semibold text-gray-800">{{ $wish->name }}</h4>
                            <span class="text-xs text-gray-400">{{ $wish->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-600 leading-relaxed">{{ $wish->message }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 mb-8">
            <div class="w-16 h-16 mx-auto mb-4 bg-pink-100 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <p class="text-gray-500">Hãy là người đầu tiên gửi lời chúc!</p>
        </div>
        @endif
        
        {{-- Submit Form --}}
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-pink-100">
            <h3 class="text-xl font-serif text-gray-800 mb-6 text-center">Gửi Lời Chúc</h3>
            
            {{-- Success/Error Messages --}}
            @if(session('wish_success'))
            <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl text-center border border-green-200">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('wish_success') }}
            </div>
            @endif
            
            @if(session('wish_error'))
            <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl text-center border border-red-200">
                {{ session('wish_error') }}
            </div>
            @endif
            
            <form action="{{ route('wedding.wish.store', $wedding->slug) }}" method="POST" class="space-y-5">
                @csrf
                
                {{-- Name --}}
                <div>
                    <label for="wish_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Tên của bạn <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="wish_name" name="name" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition"
                        placeholder="Nguyễn Văn A">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                {{-- Message --}}
                <div>
                    <label for="wish_message" class="block text-sm font-medium text-gray-700 mb-2">
                        Lời chúc <span class="text-red-500">*</span>
                    </label>
                    <textarea id="wish_message" name="message" required rows="4"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition resize-none"
                        placeholder="Chúc hai bạn trăm năm hạnh phúc..."></textarea>
                    @error('message') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                {{-- Submit Button --}}
                <button type="submit"
                    class="w-full py-4 bg-gradient-to-r from-pink-500 to-rose-500 text-white font-medium rounded-xl hover:from-pink-600 hover:to-rose-600 transition shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Gửi Lời Chúc
                </button>
            </form>
            
            @if(!($wedding->is_auto_approve_wishes ?? false))
            <p class="text-xs text-gray-400 text-center mt-4">
                * Lời chúc sẽ được hiển thị sau khi được duyệt
            </p>
            @endif
        </div>
    </div>
</section>

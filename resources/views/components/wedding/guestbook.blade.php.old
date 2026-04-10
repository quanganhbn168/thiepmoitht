{{-- Guestbook / Wishes Component --}}
{{-- Usage: @include('components.wedding.guestbook', ['wedding' => $wedding]) --}}

<section id="guestbook" class="py-16 px-4 bg-gradient-to-b from-pink-50 to-white">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-serif text-gray-800 mb-2">Sổ Lưu Bút</h2>
            <p class="text-gray-600">Gửi lời chúc tới cặp đôi</p>
        </div>
        
        {{-- Wish Form --}}
        <form action="{{ route('wedding.wish.store', $wedding->slug) }}" method="POST" 
              class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            @csrf
            
            <div class="mb-4">
                <input type="text" name="name" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                    placeholder="Tên của bạn">
            </div>
            
            <div class="mb-4">
                <textarea name="message" rows="3" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 resize-none"
                    placeholder="Viết lời chúc của bạn..."></textarea>
            </div>
            
            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-pink-500 to-rose-500 text-white font-medium rounded-xl hover:from-pink-600 hover:to-rose-600 transition">
                Gửi Lời Chúc 💝
            </button>
        </form>
        
        {{-- Wishes List --}}
        <div id="wishes-container" class="space-y-4">
            @forelse($wedding->approvedWishes()->latest()->take(20)->get() as $wish)
            <div class="bg-white rounded-xl p-5 shadow-sm border border-pink-100">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-rose-400 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                        {{ strtoupper(substr($wish->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-medium text-gray-800">{{ $wish->name }}</span>
                            <span class="text-xs text-gray-400">{{ $wish->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-600 leading-relaxed">{{ $wish->message }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-500 py-8">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <p>Hãy là người đầu tiên gửi lời chúc!</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Success/Error Toast --}}
@if(session('success') || session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const message = "{{ session('success') ?: session('error') }}";
        const type = "{{ session('success') ? 'success' : 'error' }}";
        
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-xl shadow-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => toast.remove(), 4000);
    });
</script>
@endif

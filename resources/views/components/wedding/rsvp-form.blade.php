{{-- RSVP Form Component (Premium Global Design) --}}
{{-- RSVP Form Component (Readable & AJAX) --}}
<section id="rsvp" class="py-24 px-6 relative overflow-hidden" x-data="{
    submitting: false,
    success: false,
    error: null,
    formData: {
        name: '{{ $wedding->getGuestName() ? urldecode($wedding->getGuestName()) : '' }}',
        phone: '',
        attendance: 'yes',
        guests: '1',
        side: 'both',
        note: ''
    },
    async submitRsvp() {
        this.submitting = true;
        this.error = null;
        
        try {
            const response = await fetch('{{ route('wedding.rsvp.store', $wedding->slug) }}', {
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
                setTimeout(() => { this.success = false; }, 5000);
            } else {
                const data = await response.json();
                this.error = data.message || 'Có lỗi xảy ra, vui lòng kiểm tra lại.';
            }
        } catch (e) {
            this.error = 'Lỗi kết nối mạng.';
        } finally {
            this.submitting = false;
        }
    }
}">
    {{-- Decorative Background --}}
    <div class="absolute inset-0 pointer-events-none opacity-50" style="background-color: var(--bg-paper, #ffffff);"></div>

    <div class="max-w-xl mx-auto relative z-10 text-center">
        {{-- Header --}}
        <div class="mb-12">
            <span class="text-xs font-bold uppercase tracking-[0.3em] opacity-60 mb-3 block" style="font-family: var(--font-body); color: var(--color-text-body);">R.S.V.P</span>
            <h2 class="text-4xl md:text-5xl mb-6 text-shadow-gold" style="font-family: var(--font-heading); color: var(--color-primary-dark);">
                Xác Nhận Tham Dự
            </h2>
            <p class="text-lg opacity-80 leading-relaxed max-w-md mx-auto py-2" style="font-family: var(--font-body); color: var(--color-text-body);">
                {{ $wedding->getContentValue('rsvp_desc', 'Sự hiện diện của bạn là niềm vinh hạnh của chúng tôi.') }}
            </p>
        </div>
        
        {{-- Success State --}}
        <div x-show="success" class="mb-8 p-6 bg-white shadow-xl border-l-4 border-green-500 text-left animate-fade-in" 
             style="display: none; border-radius: var(--radius-box, 0.5rem);">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-green-100 flex items-center justify-center text-green-600" style="border-radius: var(--radius-box, 50%);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                     <h4 class="font-bold text-gray-800">Xác nhận thành công!</h4>
                     <p class="text-sm text-gray-600">Cảm ơn bạn, chúng tôi đã nhận được thông tin.</p>
                </div>
            </div>
        </div>
        
        {{-- Form --}}
        <form @submit.prevent="submitRsvp" x-show="!success" class="space-y-8 text-left bg-white/50 backdrop-blur-sm p-8 shadow-sm border border-white/60"
              style="border-radius: var(--radius-box, 1rem);">
            @csrf
            
            {{-- Error Message --}}
            <div x-show="error" class="p-3 bg-red-50 text-red-600 text-sm border border-red-100 text-center" 
                 style="display: none; border-radius: var(--radius-box, 0.25rem);" x-text="error"></div>
            
            {{-- Name & Phone --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Họ và Tên <span class="text-red-400">*</span></label>
                    <input type="text" x-model="formData.name" required
                        class="block w-full px-4 py-3 bg-white border border-gray-200 text-gray-900 outline-none transition-all shadow-sm"
                        style="font-family: var(--font-body); border-radius: var(--radius-box, 0.5rem);"
                        onfocus="this.style.borderColor='var(--color-primary)'; this.style.boxShadow='0 0 0 1px var(--color-primary)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                        placeholder="Nhập tên...">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Số Điện Thoại</label>
                    <input type="tel" x-model="formData.phone"
                        class="block w-full px-4 py-3 bg-white border border-gray-200 text-gray-900 outline-none transition-all shadow-sm"
                        style="font-family: var(--font-body); border-radius: var(--radius-box, 0.5rem);"
                        onfocus="this.style.borderColor='var(--color-primary)'; this.style.boxShadow='0 0 0 1px var(--color-primary)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                        placeholder="Số điện thoại...">
                </div>
            </div>
            
            {{-- Attendance Radio --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-4 text-center">Bạn sẽ tham dự chứ?</label>
                <div class="flex flex-wrap justify-center gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" x-model="formData.attendance" value="yes" required class="peer sr-only">
                        <div class="px-5 py-3 bg-white border border-gray-200 text-sm font-medium text-gray-600 transition-all peer-checked:bg-[var(--color-primary)] peer-checked:text-white peer-checked:border-[var(--color-primary)] peer-checked:shadow-md hover:bg-gray-50"
                             style="border-radius: var(--radius-box, 2rem);">
                            Sẽ Tham Dự
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" x-model="formData.attendance" value="maybe" class="peer sr-only">
                        <div class="px-5 py-3 bg-white border border-gray-200 text-sm font-medium text-gray-600 transition-all peer-checked:bg-yellow-500 peer-checked:text-white peer-checked:border-yellow-500 peer-checked:shadow-md hover:bg-gray-50"
                             style="border-radius: var(--radius-box, 2rem);">
                            Chưa Chắc
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" x-model="formData.attendance" value="no" class="peer sr-only">
                        <div class="px-5 py-3 bg-white border border-gray-200 text-sm font-medium text-gray-600 transition-all peer-checked:bg-gray-500 peer-checked:text-white peer-checked:border-gray-500 peer-checked:shadow-md hover:bg-gray-50"
                             style="border-radius: var(--radius-box, 2rem);">
                            Rất Tiếc
                        </div>
                    </label>
                </div>
            </div>
            
            {{-- Guests & Side --}}
            <div class="grid grid-cols-2 gap-6">
                <div>
                     <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Số Khách</label>
                     <select x-model="formData.guests"
                        class="block w-full px-4 py-3 bg-white border border-gray-200 text-gray-900 outline-none cursor-pointer shadow-sm appearance-none"
                        style="font-family: var(--font-body); border-radius: var(--radius-box, 0.5rem);"
                        onfocus="this.style.borderColor='var(--color-primary)'; this.style.boxShadow='0 0 0 1px var(--color-primary)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <option value="1">1 Người</option>
                        <option value="2">2 Người</option>
                        <option value="3">3 Người</option>
                        <option value="4">4 Người</option>
                        <option value="5">5+ Người</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Khách Của</label>
                    <select x-model="formData.side"
                        class="block w-full px-4 py-3 bg-white border border-gray-200 text-gray-900 outline-none cursor-pointer shadow-sm appearance-none"
                        style="font-family: var(--font-body); border-radius: var(--radius-box, 0.5rem);"
                        onfocus="this.style.borderColor='var(--color-primary)'; this.style.boxShadow='0 0 0 1px var(--color-primary)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <option value="both">Bạn Chung</option>
                        <option value="groom">Nhà Trai</option>
                        <option value="bride">Nhà Gái</option>
                    </select>
                </div>
            </div>
            
            {{-- Submit --}}
            <div class="pt-4">
                <button type="submit"
                    class="block w-full py-4 text-white font-bold uppercase tracking-[0.15em] hover:opacity-90 transition-all shadow-lg text-sm transform hover:-translate-y-0.5"
                    style="background-color: var(--color-primary); border-radius: var(--radius-box, 0.5rem);"
                    :disabled="submitting"
                    :class="{ 'opacity-75 cursor-not-allowed': submitting }">
                    <span x-show="!submitting">Gửi Xác Nhận</span>
                    <span x-show="submitting">Đang Gửi...</span>
                </button>
            </div>
        </form>
    </div>
</section>

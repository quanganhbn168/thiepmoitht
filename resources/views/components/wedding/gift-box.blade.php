@props(['wedding', 'class' => '', 'style' => 'regular'])
{{-- 
    style: 'regular' (default), 'circle' (for modern), 'card' (for galaxy/cinematic)
    class: Custom Tailwind classes for the container
--}}

<div x-data="{ showQr: null, showWishes: false }" class="{{ $class }}">
    
    {{-- Trigger Buttons Area --}}
    {{ $slot }}

    {{-- Gift Box / QR Modal --}}
    <div x-show="showQr" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" 
         style="display: none;" 
         x-transition.opacity>
        
        <div class="bg-white w-full max-w-sm relative shadow-2xl overflow-hidden" 
             style="border-radius: var(--radius-box, 0.5rem);"
             @click.outside="showQr = null">
            {{-- Close Button --}}
            <button @click="showQr = null" class="absolute top-2 right-2 text-gray-400 hover:text-gray-900 z-10 p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            {{-- Header --}}
            <div class="bg-gray-50 p-4 border-b border-gray-100 text-center">
                <h3 class="text-lg font-bold uppercase tracking-wider text-gray-800" 
                    x-text="showQr === 'groom' ? 'Nhà Trai' : 'Nhà Gái'"></h3>
                <p class="text-xs text-gray-500 mt-1">Hộp Mừng Cưới</p>
            </div>
            
            {{-- Content --}}
            <div class="p-8 text-center">
                <template x-if="showQr === 'groom'">
                    <div>
                        <img src="{{ $wedding->getGroomQrUrl() }}" class="w-full h-auto object-contain mx-auto mb-4 border border-gray-100 p-1 rounded-lg">
                        
                        <div class="space-y-2 text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">
                            <p class="whitespace-pre-line">{{ $wedding->groom_qr_info }}</p>
                        </div>
                    </div>
                </template>
                
                <template x-if="showQr === 'bride'">
                    <div>
                        <img src="{{ $wedding->getBrideQrUrl() }}" class="w-full h-auto object-contain mx-auto mb-4 border border-gray-100 p-1 rounded-lg">

                         <div class="space-y-2 text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">
                            <p class="whitespace-pre-line">{{ $wedding->bride_qr_info }}</p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

</div>

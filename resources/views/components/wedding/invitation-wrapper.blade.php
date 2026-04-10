{{-- 
    Invitation Wrapper Component - PREMIUM ENVELOPE
    A realistic 3D envelope that opens and "flies out" the invitation card.
--}}
@props(['wedding', 'style' => 'envelope'])

<div x-data="{ 
        isOpen: false, 
        isFinished: false,
        isReady: false,
        openInvitation() {
            if (this.isOpen) return;
            this.isOpen = true;
            
            // Dispatch event for auto-play immediately
            window.dispatchEvent(new CustomEvent('wedding-opened'));

            // Delay for 'Entry' animation (Envelope Open + Card Fly Out)
            // Then trigger 'Exit' animation (Zoom & Fade)
            setTimeout(() => {
                this.isFinished = true;
            }, 1200); // FASTER: 1.2s allows card to fly out partially then zoom
        }
    }" 
    x-init="setTimeout(() => isReady = true, 500)"
    class="fixed inset-0 z-[100] flex items-center justify-center transition-all duration-700 ease-in-out"
    :class="{ 'pointer-events-none': isFinished, 'pointer-events-auto': !isFinished }"
    style="font-family: 'Dancing Script', cursive;"
>
    <!-- Load Font -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noticia+Text:wght@700&display=swap" rel="stylesheet">
    
    {{-- Background Overlay --}}
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-700"
         x-show="!isFinished"
         x-transition:leave="transition ease-in duration-700"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"></div>

    {{-- 3D Scene --}}
    <div class="relative w-full max-w-[550px] aspect-[1.6/1] perspective-1000 z-50 p-4"
         x-show="!isFinished"
         x-transition:leave="transition ease-in duration-1000"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-[5] translate-y-[-10%]">

        {{-- THE ENVELOPE --}}
        <div class="relative w-full h-full transform-style-3d transition-all duration-700 ease-in-out"
             :class="{ 'translate-y-[200px]': isOpen }">
            
            {{-- Back Face (Inside Background) --}}
            <div class="absolute inset-0 bg-[#f4f1ea] rounded md:rounded-lg shadow-2xl z-0 border border-[#e8e4db]"></div>

            {{-- The Invitation Card (Hidden Initially, Slides Up) --}}
            <div class="absolute inset-x-2 inset-y-2 bg-white shadow-lg z-10 flex flex-col items-center justify-center text-center p-4 transition-all duration-1000 ease-in-out origin-bottom"
                 :class="{ '-translate-y-[80%] scale-100 shadow-2xl z-[60] rotate-1': isOpen }">
                 
                 <div class="w-full h-full border border-[#d4af37] p-4 flex flex-col items-center justify-center bg-[url('https://www.transparenttextures.com/patterns/cream-paper.png')] relative overflow-hidden">
                    {{-- Decorative Corners --}}
                    <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-[#d4af37]"></div>
                    <div class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 border-[#d4af37]"></div>
                    <div class="absolute bottom-0 left-0 w-8 h-8 border-b-2 border-l-2 border-[#d4af37]"></div>
                    <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-[#d4af37]"></div>

                    <p class="text-[#8c8c88] text-[10px] md:text-xs font-sans uppercase tracking-[0.2em] mb-3">Wedding Invitation</p>
                    <h2 class="text-2xl md:text-4xl text-[#1a1a1a] mb-2 font-serif text-nowrap">{{ $wedding->groom_name }} <span class="text-[#d4af37] mx-1">&</span> {{ $wedding->bride_name }}</h2>
                    <div class="w-12 h-[1px] bg-[#d4af37] my-3"></div>
                    <p class="text-[#8c8c88] text-xs font-sans tracking-widest">{{ $wedding->event_date?->format('d . m . Y') ?? 'Save The Date' }}</p>
                 </div>
            </div>

            {{-- Bottom Flap (Pocket) --}}
            <div class="absolute bottom-0 left-0 right-0 h-3/5 bg-[#fdfbf7] z-30 transform-style-3d rounded-b md:rounded-b-lg shadow-[0_-2px_10px_rgba(0,0,0,0.05)] border-t border-white/50"
                 style="background-image: url('https://www.transparenttextures.com/patterns/cream-paper.png'); clip-path: polygon(0 0, 50% 20%, 100% 0, 100% 100%, 0 100%);">
            </div>
            
            {{-- Left & Right Flaps --}}
            <div class="absolute inset-0 z-20 pointer-events-none">
                <div class="absolute top-0 bottom-0 left-0 w-2/5 bg-[#f8f5f0] shadow-sm" 
                     style="background-image: url('https://www.transparenttextures.com/patterns/cream-paper.png'); clip-path: polygon(0 0, 100% 50%, 0 100%);"></div>
                <div class="absolute top-0 bottom-0 right-0 w-2/5 bg-[#f8f5f0] shadow-sm transform" 
                     style="background-image: url('https://www.transparenttextures.com/patterns/cream-paper.png'); clip-path: polygon(100% 0, 0 50%, 100% 100%);"></div>
            </div>

            {{-- Top Flap (The Opener) --}}
            <div class="absolute top-0 left-0 right-0 h-[55%] bg-[#f4f1ea] z-40 transform origin-top transition-all duration-700 ease-[cubic-bezier(0.4,0,0.2,1)] shadow-md rounded-t md:rounded-t-lg border-b border-[#e8e4db]"
                 style="background-image: url('https://www.transparenttextures.com/patterns/cream-paper.png'); clip-path: polygon(0 0, 100% 0, 50% 100%);"
                 :class="{ '-rotate-x-180 z-10 opacity-90': isOpen }">
            </div>

            {{-- WAX SEAL (Trigger) --}}
            <div class="absolute top-[50%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 cursor-pointer group transition-all duration-500"
                 :class="{ 'opacity-0 scale-150 -translate-y-[200%] pointer-events-none': isOpen }"
                 @click="openInvitation()">
                 
                 <div class="relative w-20 h-20 md:w-24 md:h-24 flex items-center justify-center drop-shadow-2xl">
                    {{-- Seal Body --}}
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-[#8b1c1c] rounded-full shadow-[inset_0_-4px_6px_rgba(0,0,0,0.3),0_4px_10px_rgba(0,0,0,0.4)] flex items-center justify-center relative border border-[#761515] group-hover:scale-105 transition-transform duration-300">
                        {{-- Uneven edges visualization (CSS trick or just round) --}}
                        <div class="absolute inset-0 rounded-full border-[3px] border-[#a52a2a] border-dashed opacity-50"></div>
                        
                        <span class="text-[#e2b7b7] text-2xl md:text-3xl font-serif font-bold drop-shadow-md" style="font-family: 'Noticia Text', serif;">囍</span>
                        <div class="absolute top-2 left-3 w-4 h-4 bg-white opacity-20 rounded-full blur-[2px]"></div>
                        <div class="absolute -inset-1 rounded-full border border-[#8b1c1c] opacity-30 animate-ping"></div>
                    </div>
                </div>
            </div>

            {{-- PERSONALIZATION (Scanner / Address) --}}
            <div class="absolute bottom-4 md:bottom-8 left-0 right-0 z-50 text-center transition-all duration-500 delay-100"
                 :class="{ 'opacity-0 translate-y-10': isOpen }">
                @if($guestName = $wedding->getGuestName())
                <div class="inline-block bg-[#fffefc]/90 backdrop-blur-sm px-6 py-3 rounded shadow-[0_2px_8px_rgba(0,0,0,0.1)] border border-[#e8e4db] transform -rotate-1 min-w-[200px]">
                    <p class="text-[#8c8c88] text-[10px] uppercase tracking-widest mb-1 font-sans">Kính gửi</p>
                    <p class="text-xl md:text-2xl text-[#5c4033] font-handwriting">{{ urldecode($guestName) }}</p>
                </div>
                @else
                <div class="inline-block px-6 py-2">
                     <p class="text-xl md:text-2xl text-[#8b1c1c]/40 font-handwriting transform -rotate-2">Wedding Invitation</p>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<style>
    .perspective-1000 { perspective: 1000px; }
    .transform-style-3d { transform-style: preserve-3d; }
    .-rotate-x-180 { transform: rotateX(-180deg); }
    /* Enhance shadow/lighting for 3D realism */
    .shadow-inner-lg { box-shadow: inset 0 4px 6px -1px rgba(0, 0, 0, 0.1), inset 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
</style>

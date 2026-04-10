{{-- 
    Preload Animation Component
    Supports variants: 'traditional' (Song Hy), 'heartbeat' (Modern), 'rings' (Elegant)
    Usage: @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'heartbeat'])
--}}

@php
    $tierValue = is_object($wedding->tier) ? $wedding->tier->value : (string)($wedding->tier ?? 'basic');
    $tierEnum = \App\Enums\WeddingTier::tryFrom($tierValue) ?? \App\Enums\WeddingTier::BASIC;
@endphp

@if($wedding->show_preload && $tierEnum->hasPreload())
@php
    // Determine variant based on input or default to 'heartbeat' for modern feel if not specified
    // Ideally this could come from $wedding->preload_style if added to DB
    // Determine variant based on DB setting, then input, then default
    $variant = $wedding->preload_variant ?? $variant ?? 'heartbeat'; 
@endphp

<div class="preload-container" id="preloadContainer">
    
    {{-- VARIANT: TRADITIONAL (Sliding Doors) --}}
    @if($variant === 'traditional')
        <!-- Decorative Ornaments -->
        <div class="preload-ornament preload-tl">❀</div>
        <div class="preload-ornament preload-tr">❀</div>
        <div class="preload-ornament preload-bl">❀</div>
        <div class="preload-ornament preload-br">❀</div>
        
        <!-- Left Door -->
        <div class="preload-door-left">
            <span class="song-hy song-hy-left">囍</span>
        </div>
        
        <!-- Right Door -->
        <div class="preload-door-right">
            <span class="song-hy song-hy-right">囍</span>
        </div>
    @endif

    {{-- VARIANT: HEARTBEAT (Modern/Minimal) --}}
    @if($variant === 'heartbeat')
        <div class="absolute inset-0 bg-white flex flex-col items-center justify-center z-50">
            <div class="relative w-24 h-24 mb-8">
                <div class="absolute inset-0 rounded-full opacity-20 animate-ping" style="background-color: var(--color-primary);"></div>
                <div class="absolute inset-4 rounded-full opacity-40 animate-pulse" style="background-color: var(--color-primary);"></div>
                <svg class="absolute inset-0 w-full h-full animate-heartbeat p-6" style="color: var(--color-primary);" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
            <p class="uppercase tracking-[0.3em] font-light text-sm animate-pulse" style="color: var(--color-primary);">Loading Love...</p>
        </div>
    @endif

    {{-- VARIANT: RINGS (Elegant/Luxury) --}}
    @if($variant === 'rings')
        <div class="absolute inset-0 bg-[#fdfbf7] flex flex-col items-center justify-center z-50">
            <div class="relative w-32 h-32 mb-6">
                <!-- Ring 1 -->
                <div class="absolute inset-0 border-[6px] border-[#d4af37] rounded-full shadow-[0_4px_10px_rgba(212,175,55,0.4)] animate-[spin_3s_linear_infinite]"
                     style="border-right-color: transparent; transform: rotate(-45deg);"></div>
                
                <!-- Ring 2 (Interlocked) -->
                <div class="absolute inset-0 border-[6px] border-[#f3e5ab] rounded-full shadow-[0_4px_10px_rgba(212,175,55,0.2)] animate-[spin_4s_reverse_infinite]"
                     style="border-left-color: transparent; width: 80%; height: 80%; top: 10%; left: 10%;"></div>
                
                <!-- Diamond Shine -->
                <div class="absolute top-0 right-0 w-4 h-4 bg-white rotate-45 animate-ping opacity-75 shadow-[0_0_15px_#d4af37]"></div>
            </div>
            
            <div class="text-center space-y-2">
                <p class="text-[#d4af37] font-serif text-2xl tracking-widest uppercase">Wedding</p>
                <div class="w-12 h-[1px] bg-[#d4af37]/50 mx-auto"></div>
                <p class="text-[#8c8c88] text-xs font-sans tracking-[0.3em] animate-pulse">LOADING...</p>
            </div>
        </div>
    @endif

    {{-- COMMON: Couple Names & Guest (Overlay on top of animations if needed, or specific to traditional) --}}
    @if($variant === 'traditional')
    <div class="preload-names">
        @php $guestName = $wedding->getGuestName(); @endphp
        @if($guestName)
        <div class="preload-envelope">
            <div class="envelope-label">Kính mời</div>
            <div class="envelope-name">{{ urldecode($guestName) }}</div>
        </div>
        @endif
        <h1>{{ $wedding->groom_name }}</h1>
        <div class="ampersand">&</div>
        <h1>{{ $wedding->bride_name }}</h1>
    </div>
    @endif

</div>

<style>
    /* Base Container */
    .preload-container {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Animations */
    @keyframes slideLeft { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }
    @keyframes slideRight { 0% { transform: translateX(0); } 100% { transform: translateX(100%); } }
    @keyframes heartbeat { 0% { transform: scale(1); } 50% { transform: scale(1.1); } 100% { transform: scale(1); } }
    @keyframes spin-reverse { from { transform: rotate(360deg); } to { transform: rotate(0deg); } }
    
    .animate-heartbeat { animation: heartbeat 1.5s ease-in-out infinite; }
    .animate-spin-reverse { animation: spin-reverse 3s linear infinite; }

    /* Traditional Styles (Scoped) */
    .preload-door-left { width: 50%; height: 100%; position: absolute; left:0; background: linear-gradient(135deg, #8b0000 0%, #cc0033 50%, #8b0000 100%); display: flex; justify-content: flex-end; align-items: center; animation: slideLeft 1.5s ease-in-out 2.5s forwards; z-index: 10; }
    .preload-door-right { width: 50%; height: 100%; position: absolute; right:0; background: linear-gradient(225deg, #8b0000 0%, #cc0033 50%, #8b0000 100%); display: flex; justify-content: flex-start; align-items: center; animation: slideRight 1.5s ease-in-out 2.5s forwards; z-index: 10; }
    .song-hy { font-size: 100px; color: #ffd700; opacity: 1; animation: fadeHy 0.5s ease-out 2s forwards; }
    .song-hy-left { padding-right: 10px; }
    .song-hy-right { padding-left: 10px; }
    .preload-names { position: relative; z-index: 20; text-align: center; color: #ffd700; opacity: 0; animation: fadeNamesIn 1s ease-out 0.5s forwards, fadeNamesOut 0.5s ease-out 2s forwards; }
    
    @keyframes fadeNamesIn { to { opacity: 1; } }
    @keyframes fadeNamesOut { to { opacity: 0; } }
    @keyframes fadeHy { to { opacity: 0; } }

    /* Hide Helper */
    .preload-container.hidden { display: none !important; }
</style>

<script>
    setTimeout(function() {
        const container = document.getElementById('preloadContainer');
        if (container) {
            container.classList.add('hidden');
        }
    }, 4000); // Adjust timing based on animation
</script>
@endif

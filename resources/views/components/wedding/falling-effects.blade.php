{{-- 
Premium Falling Effects - Multiple Variations
Variety of shapes, sizes, colors for each effect type
--}}

@php
    $effectRaw = $wedding->falling_effect ?? 'hearts';
    $effect = is_object($effectRaw) ? $effectRaw->value : (string)$effectRaw;
    
    // Get tier enum and check if effects are enabled for this tier
    $tierValue = is_object($wedding->tier) ? $wedding->tier->value : (string)($wedding->tier ?? 'basic');
    $tierEnum = \App\Enums\WeddingTier::tryFrom($tierValue) ?? \App\Enums\WeddingTier::BASIC;
    $hasEffects = $tierEnum->hasEffects(); // Standard & Pro have effects, Basic does not
    
    $showEffect = $hasEffects && $effect !== 'none';
@endphp

@if($showEffect)
<style>
.falling-canvas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 100;
    overflow: hidden;
}

.fall-item {
    position: absolute;
    top: -80px;
    opacity: 0;
    animation: fallDown linear infinite, swaySmooth ease-in-out infinite alternate;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
}

@keyframes fallDown {
    0% { transform: translateY(0) rotate(0deg); opacity: 0; }
    5% { opacity: 1; }
    95% { opacity: 0.7; }
    100% { transform: translateY(calc(100vh + 100px)) rotate(360deg); opacity: 0; }
}

@keyframes swaySmooth {
    0% { margin-left: -25px; }
    100% { margin-left: 25px; }
}

/* Size variations */
.size-xs { transform: scale(0.5); }
.size-sm { transform: scale(0.7); }
.size-md { transform: scale(1); }
.size-lg { transform: scale(1.3); }
.size-xl { transform: scale(1.6); }

@media (prefers-reduced-motion: reduce) {
    .fall-item { display: none; }
}

    /* Stars */
    .star {
        position: absolute;
        width: 2px;
        height: 2px;
        background: white;
        border-radius: 50%;
        animation: twinkle linear infinite;
        opacity: 0.8;
    }
    @keyframes twinkle { 0%, 100% { opacity: 0.2; transform: scale(1); } 50% { opacity: 1; transform: scale(1.5); } }

    /* Shooting Star */
    .shooting-star {
        position: fixed;
        width: 4px;
        height: 4px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1), 0 0 0 8px rgba(255, 255, 255, 0.1), 0 0 20px rgba(255, 255, 255, 1);
        animation: shoot 3s linear infinite;
        opacity: 0;
        z-index: 9999;
        pointer-events: none;
    }
    .shooting-star::before {
        content: '';
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 300px;
        height: 1px;
        background: linear-gradient(90deg, rgba(255, 255, 255, 1), transparent);
    }
    @keyframes shoot {
        0% { transform: rotate(315deg) translateX(0); opacity: 1; }
        70% { opacity: 1; }
        100% { transform: rotate(315deg) translateX(-1000px); opacity: 0; }
    }
</style>

<!-- SVG Definitions with Multiple Gradients -->
<svg style="position:absolute;width:0;height:0;">
    <defs>
        <!-- Heart Gradients -->
        <linearGradient id="heart1" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#ff6b8a"/>
            <stop offset="100%" style="stop-color:#e91e63"/>
        </linearGradient>
        <linearGradient id="heart2" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#ff8a9b"/>
            <stop offset="100%" style="stop-color:#ff4d6d"/>
        </linearGradient>
        <linearGradient id="heart3" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#ffb6c1"/>
            <stop offset="100%" style="stop-color:#ff69b4"/>
        </linearGradient>
        <linearGradient id="heart4" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#dc143c"/>
            <stop offset="100%" style="stop-color:#b22222"/>
        </linearGradient>
        
        <!-- Petal Gradients -->
        <linearGradient id="petal1" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" style="stop-color:#ffc0cb"/>
            <stop offset="100%" style="stop-color:#ff91a4"/>
        </linearGradient>
        <linearGradient id="petal2" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" style="stop-color:#fff0f5"/>
            <stop offset="100%" style="stop-color:#ffb6c1"/>
        </linearGradient>
        <linearGradient id="petal3" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" style="stop-color:#ffe4e9"/>
            <stop offset="100%" style="stop-color:#ffa6c1"/>
        </linearGradient>
        
        <!-- Leaf Gradients -->
        <linearGradient id="leaf1" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#d4a574"/>
            <stop offset="100%" style="stop-color:#a67c52"/>
        </linearGradient>
        <linearGradient id="leaf2" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#c9956c"/>
            <stop offset="100%" style="stop-color:#8b6914"/>
        </linearGradient>
        <linearGradient id="leaf3" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#e8c170"/>
            <stop offset="100%" style="stop-color:#b8860b"/>
        </linearGradient>
        <linearGradient id="leaf4" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#cd853f"/>
            <stop offset="100%" style="stop-color:#8b4513"/>
        </linearGradient>
        
        <!-- Star Gradients -->
        <linearGradient id="star1" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#ffd700"/>
            <stop offset="100%" style="stop-color:#ffb700"/>
        </linearGradient>
        <linearGradient id="star2" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#fff8dc"/>
            <stop offset="100%" style="stop-color:#ffd700"/>
        </linearGradient>
    </defs>
</svg>

<div class="falling-canvas" id="fallingCanvas"></div>

<script>
(function() {
    'use strict';
    
    const effect = '{{ $effect }}';
    const isPro = {{ $tierEnum->value === 'pro' ? 'true' : 'false' }};
    const canvas = document.getElementById('fallingCanvas');
    if (!canvas) return;

    // Handle Shooting Stars Logic (Separate from falling logic)
    if (effect === 'shooting_stars') {
        function createShootingStar() {
            const shootingStar = document.createElement('div');
            shootingStar.className = 'shooting-star';
            shootingStar.style.left = Math.random() * 100 + '%';
            shootingStar.style.top = Math.random() * 40 + '%'; // Upper sky
            shootingStar.style.animationDuration = (Math.random() * 1 + 1.5) + 's';
            
            canvas.appendChild(shootingStar);
            
            // Remove after animation
            setTimeout(() => {
                shootingStar.remove();
            }, 3000);
        }

        // Interval loop for shooting stars
        const frequency = isPro ? 3000 : 6000; // 3s for Pro, 6s for Standard
        setInterval(() => createShootingStar(), frequency);
        createShootingStar(); // Create one immediately
        return; // Exit normal flow
    }
    
    // Normal Falling Logic (Hearts, Petals, Snow, Leaves, Standard Stars)
    const count = isPro ? 12 : 6;
    const sizes = ['size-xs', 'size-sm', 'size-md', 'size-lg', 'size-xl'];
    
    // Multiple SVG variations for each effect
    const svgVariations = {
        hearts: [
            // Classic heart
            '<svg viewBox="0 0 32 32" width="24" height="24"><path fill="url(#heart1)" d="M16 28s-11-7.5-11-14c0-4 3-7 7-7 2.5 0 4.5 1.5 4.5 1.5S18.5 7 21 7c4 0 7 3 7 7 0 6.5-11 14-11 14z"/></svg>',
            // Rounded heart
            '<svg viewBox="0 0 32 32" width="22" height="22"><path fill="url(#heart2)" d="M16 28C9 22 5 17 5 12c0-3.5 2.5-6 6-6 2 0 3.5 1 5 2.5C17.5 7 19 6 21 6c3.5 0 6 2.5 6 6 0 5-4 10-11 16z"/></svg>',
            // Small double heart
            '<svg viewBox="0 0 32 32" width="20" height="20"><path fill="url(#heart3)" d="M10 20s-6-4-6-9c0-2.5 2-4.5 4.5-4.5 1.5 0 2.5 1 3 1.5.5-.5 1.5-1.5 3-1.5 2.5 0 4.5 2 4.5 4.5 0 5-6 9-9 9zm12-2s-4-3-4-6c0-1.8 1.4-3.2 3.2-3.2 1 0 2 .7 2.3 1 .3-.3 1.3-1 2.3-1 1.8 0 3.2 1.4 3.2 3.2 0 3-4 6-7 6z"/></svg>',
            // Bold heart
            '<svg viewBox="0 0 32 32" width="26" height="26"><path fill="url(#heart4)" d="M16 29L14 27C6 20 2 15 2 10c0-4 3-7 7-7 2.5 0 5 1.5 7 4 2-2.5 4.5-4 7-4 4 0 7 3 7 7 0 5-4 10-12 17l-2 2z"/></svg>',
        ],
        
        petals: [
            // Sakura petal
            '<svg viewBox="0 0 24 32" width="18" height="24"><ellipse fill="url(#petal1)" cx="12" cy="16" rx="10" ry="14" transform="rotate(-15 12 16)"/></svg>',
            // Round petal
            '<svg viewBox="0 0 24 32" width="16" height="22"><ellipse fill="url(#petal2)" cx="12" cy="16" rx="8" ry="12"/></svg>',
            // Pointed petal
            '<svg viewBox="0 0 20 30" width="14" height="20"><path fill="url(#petal3)" d="M10 2c-6 8-8 16-8 22 0 3 8 4 8 4s8-1 8-4c0-6-2-14-8-22z"/></svg>',
            // Curled petal
            '<svg viewBox="0 0 24 32" width="20" height="26"><ellipse fill="url(#petal1)" cx="12" cy="16" rx="9" ry="13" transform="rotate(20 12 16)"/></svg>',
        ],
        
        snow: [
            // Detailed Snowflake 1 (Delicate)
            '<svg viewBox="0 0 24 24" width="20" height="20"><path fill="#fff" d="M12 0L9 5h6l-3-5zm0 24l3-5H9l3 5zM0 12l5 3V9L0 12zm24 0l-5-3v6l5-3zM3.5 3.5l4 4-1.5 1.5-4-4 1.5-1.5zm17 17l-4-4 1.5-1.5 4 4-1.5 1.5zM3.5 20.5l4-4 1.5 1.5-4 4-1.5-1.5zm17-17l-4 4 1.5 1.5 4-4-1.5-1.5z" style="filter:drop-shadow(0 0 2px rgba(255,255,255,0.9)) opacity(0.9)"/></svg>',
            // Soft Hexagon Snow
            '<svg viewBox="0 0 24 24" width="16" height="16"><path fill="#fff" d="M12 2L6 5v6l6 3 6-3V5l-6-3zm0 20l6-3v-6l-6-3-6 3v6l6 3z" style="filter:drop-shadow(0 0 4px rgba(255,255,255,0.8)) opacity(0.8)"/></svg>',
            // Star Snow
            '<svg viewBox="0 0 24 24" width="18" height="18"><circle cx="12" cy="12" r="4" fill="#fff" style="filter:blur(1px); opacity:0.9"/><path stroke="#fff" stroke-width="1.5" stroke-linecap="round" d="M12 2v20M2 12h20M5 5l14 14M5 19L19 5" style="opacity:0.8"/></svg>',
            // Glitter Dot
            '<svg viewBox="0 0 16 16" width="8" height="8"><circle fill="#fff" cx="8" cy="8" r="3" style="filter:drop-shadow(0 0 4px #fff)"/></svg>',
        ],
        
        leaves: [
            // Realistic Maple Leaf (Detailed)
            '<svg viewBox="0 0 24 24" width="22" height="26"><path fill="url(#leaf1)" d="M21.5 10.5c-1-1-2.5-.5-3-1 .5-2-1-3.5-3-3.5 0-1.5-2-2-3.5-1-.5-1.5-2.5-1.5-3 0-1.5-.5-3 .5-3 2-.5-.5-2 0-2.5 1.5-.5.5-2 0-3 1 .5 1.5 0 3 .5 3.5-1 .5-1.5 2-1 3.5 0 1.5 1.5 2 2 3 .5 0 1 .5 1.5 1 0 1.5.5 3 2 4 .5.5 1.5 0 2-1v4c.5.5 1.5.5 2 0v-4c.5 1 1.5 1.5 2 1 1.5-1 2-2.5 2-4 .5-.5 1-1 1.5-1 .5-1 2-1 3-2.5.5-1.5 0-3-.5-3.5 1-.5 1.5-2 1-3.5z" style="filter:drop-shadow(0 2px 3px rgba(0,0,0,0.1))"/></svg>',
            // Delicate Fern Leaf
            '<svg viewBox="0 0 24 32" width="18" height="28"><path fill="url(#leaf2)" d="M12 2c0 0-2 5-2 8s-3 4-3 7c0 2 2 4 5 4s5-2 5-4c0-3-3-4-3-7s-2-8-2-8zM12 8c0 0 3 4 3 7M12 12c-2 3-2 6-2 6" stroke="rgba(255,255,255,0.3)" stroke-width="0.5" style="filter:drop-shadow(0 1px 2px rgba(0,0,0,0.1))"/></svg>',
            // Elegant Elm Leaf
            '<svg viewBox="0 0 24 28" width="20" height="24"><path fill="url(#leaf3)" d="M12 24c-1 2-1.5 4-1.5 4h3s-.5-2-1.5-4c4-1 9-6 9-13C21 5 15 2 12 2S3 5 3 11c0 7 5 12 9 13z" style="filter:drop-shadow(0 2px 3px rgba(0,0,0,0.1))"/><line x1="12" y1="4" x2="12" y2="22" stroke="rgba(0,0,0,0.1)" stroke-width="1"/></svg>',
            // Flying Small Leaf
            '<svg viewBox="0 0 20 20" width="14" height="14"><path fill="url(#leaf4)" d="M2 18s5-1 9-5c4-4 5-9 5-13 0 0-5 1-9 5-4 4-5 9-5 13z" style="filter:drop-shadow(0 1px 2px rgba(0,0,0,0.1))"/></svg>',
        ],
        
        stars: [
            // 5-point star
            '<svg viewBox="0 0 24 24" width="20" height="20"><polygon fill="url(#star1)" points="12,2 15,9 22,9 16,14 18,22 12,17 6,22 8,14 2,9 9,9" style="filter:drop-shadow(0 0 6px rgba(255,215,0,0.7))"/></svg>',
            // 4-point star
            '<svg viewBox="0 0 24 24" width="16" height="16"><polygon fill="url(#star2)" points="12,0 14,10 24,12 14,14 12,24 10,14 0,12 10,10" style="filter:drop-shadow(0 0 5px rgba(255,215,0,0.6))"/></svg>',
            // Sparkle
            '<svg viewBox="0 0 20 20" width="14" height="14"><circle fill="#ffd700" cx="10" cy="10" r="3" style="filter:drop-shadow(0 0 8px rgba(255,215,0,0.9))"/></svg>',
            // 6-point star
            '<svg viewBox="0 0 24 24" width="22" height="22"><polygon fill="url(#star1)" points="12,0 14,8 22,8 16,12 18,20 12,15 6,20 8,12 2,8 10,8" style="filter:drop-shadow(0 0 8px rgba(255,215,0,0.8))"/></svg>',
        ]
    };
    
    const variations = svgVariations[effect] || svgVariations.hearts;
    
    function createParticle() {
        const item = document.createElement('div');
        item.className = 'fall-item ' + sizes[Math.floor(Math.random() * sizes.length)];
        
        // Pick random variation
        item.innerHTML = variations[Math.floor(Math.random() * variations.length)];
        
        const left = Math.random() * 95 + 2.5;
        // Make it much slower and more gentle
        const duration = 15 + Math.random() * 10; // 15s to 25s
        const delay = Math.random() * 20; // Spread out start times more
        const swayDuration = 3 + Math.random() * 4; // Slower sway
        
        item.style.cssText = `
            left: ${left}%;
            animation-duration: ${duration}s, ${swayDuration}s;
            animation-delay: ${delay}s, 0s;
        `;
        
        canvas.appendChild(item);
    }
    
    for (let i = 0; i < count; i++) {
        setTimeout(() => createParticle(), i * 800); // Add slowly one by one
    }
    
    document.addEventListener('visibilitychange', function() {
        canvas.style.animationPlayState = document.hidden ? 'paused' : 'running';
    });
})();
</script>

@endif

@if($wedding->is_demo ?? false)
<div style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%) rotate(-30deg);font-size:80px;font-weight:bold;color:rgba(255,0,0,0.12);pointer-events:none;z-index:1000;">DEMO</div>
@endif

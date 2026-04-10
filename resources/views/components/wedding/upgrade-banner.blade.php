{{-- Upgrade Banner for Standard tier weddings --}}
{{-- Usage: @include('components.wedding.upgrade-banner', ['wedding' => $wedding]) --}}

@if(isset($showUpgradeBanner) && $showUpgradeBanner)
<div x-data="{ show: true }" x-show="show" x-transition
     class="fixed bottom-0 left-0 right-0 z-50 bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-lg">
    <div class="max-w-4xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <span class="text-2xl">⭐</span>
            <div>
                <p class="font-semibold">Nâng cấp lên Pro để chia sẻ thiệp!</p>
                <p class="text-sm opacity-90">Hiện tại chỉ có bạn xem được thiệp này. Nâng cấp Pro để share link cho khách mời.</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard.pricing') }}" 
               class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition whitespace-nowrap">
                Nâng cấp Pro
            </a>
            <button @click="show = false" class="p-2 hover:bg-white/20 rounded-full transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
@endif

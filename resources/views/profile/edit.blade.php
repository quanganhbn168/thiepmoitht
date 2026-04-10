<x-dashboard-layout>
    <x-slot:header>Tài khoản của tôi</x-slot:header>

    <div class="max-w-4xl mx-auto space-y-8">
        
        <!-- Account Overview -->
        <div class="bg-white shadow-sm rounded-xl overflow-hidden">
            <div class="bg-gradient-to-r from-pink-500 to-purple-600 px-6 py-8 text-white">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center text-3xl font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">{{ Auth::user()->name }}</h2>
                        <p class="text-pink-100">{{ Auth::user()->email }}</p>
                        <div class="mt-2">
                            @php
                                $plan = Auth::user()->subscription?->plan ?? 'free';
                                $planEnum = \App\Enums\SubscriptionPlan::tryFrom($plan) ?? \App\Enums\SubscriptionPlan::FREE;
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20">
                                {{ $planEnum->label() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-3 divide-x divide-gray-100">
                <div class="p-6 text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ Auth::user()->weddings()->count() }}</div>
                    <div class="text-sm text-gray-500">Thiệp cưới</div>
                </div>
                <div class="p-6 text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ Auth::user()->businessCards()->count() }}</div>
                    <div class="text-sm text-gray-500">Name Card</div>
                </div>
                <div class="p-6 text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ Auth::user()->created_at->format('d/m/Y') }}</div>
                    <div class="text-sm text-gray-500">Tham gia</div>
                </div>
            </div>
        </div>
        
        <!-- Subscription Info -->
        @php $subscription = Auth::user()->subscription; @endphp
        <div class="bg-white shadow-sm rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">📦 Gói đăng ký</h3>
                <a href="{{ route('dashboard.pricing') }}" class="text-pink-600 hover:text-pink-800 text-sm font-medium">Nâng cấp →</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-500">Gói hiện tại</div>
                    <div class="text-xl font-bold text-gray-900 capitalize">{{ $planEnum->label() }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-500">Hết hạn</div>
                    <div class="text-xl font-bold text-gray-900">
                        {{ $subscription?->expires_at?->format('d/m/Y') ?? 'Không giới hạn' }}
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-500">Thiệp cưới còn lại</div>
                    <div class="text-xl font-bold text-gray-900">{{ Auth::user()->getRemainingWeddings() }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-500">Name Card còn lại</div>
                    <div class="text-xl font-bold text-gray-900">{{ Auth::user()->getRemainingBusinessCards() }}</div>
                </div>
            </div>
        </div>

        <!-- Profile Information -->
        <div class="bg-white shadow-sm rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">👤 Thông tin cá nhân</h3>
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Update Password -->
        <div class="bg-white shadow-sm rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">🔐 Đổi mật khẩu</h3>
            @include('profile.partials.update-password-form')
        </div>

        <!-- Danger Zone -->
        <div class="bg-white shadow-sm rounded-xl p-6 border-2 border-red-100">
            <h3 class="text-lg font-semibold text-red-600 mb-6">⚠️ Vùng nguy hiểm</h3>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-dashboard-layout>

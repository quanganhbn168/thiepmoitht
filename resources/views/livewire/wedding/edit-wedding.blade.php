<div class="max-w-5xl mx-auto">
    <!-- Top Actions Bar -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            @if($wedding->isPro())
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 border border-yellow-200">
                    ⭐ Pro
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                    Tiêu chuẩn
                </span>
            @endif
            <span class="text-gray-400">•</span>
            <span class="text-sm text-gray-500">{{ $wedding->template?->name }}</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="/{{ $wedding->slug }}" target="_blank" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Xem trước
            </a>
            <a href="{{ route('dashboard.weddings.wishes', $wedding) }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                💬 Lời chúc
            </a>
            <a href="{{ route('dashboard.weddings.rsvps', $wedding) }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                👥 Khách mời
            </a>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Tabs Navigation -->
            <div class="border-b border-gray-200 bg-gray-50">
                <nav class="flex overflow-x-auto" aria-label="Tabs">
                    @foreach([
                        'basic' => ['📋', 'Cơ bản'],
                        'groom' => ['👔', 'Nhà Trai'],
                        'bride' => ['👗', 'Nhà Gái'],
                        'media' => ['📸', 'Media'],
                        'settings' => ['⚙️', 'Cài đặt'],
                    ] as $tab => $info)
                        <button type="button" 
                            wire:click="$set('activeTab', '{{ $tab }}')"
                            class="flex-shrink-0 px-4 lg:px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors
                                {{ $activeTab === $tab 
                                    ? 'border-pink-500 text-pink-600 bg-white' 
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            <span class="mr-1">{{ $info[0] }}</span>
                            <span class="hidden sm:inline">{{ $info[1] }}</span>
                        </button>
                    @endforeach
                </nav>
            </div>

            <div class="p-4 sm:p-6 lg:p-8">
                <!-- TAB: CƠ BẢN -->
                <div x-show="$wire.activeTab === 'basic'" x-cloak class="space-y-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin cô dâu chú rể</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tên chú rể *</label>
                                <input type="text" wire:model="groom_name" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500"
                                    placeholder="Nguyễn Văn A">
                                @error('groom_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tên cô dâu *</label>
                                <input type="text" wire:model="bride_name" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500"
                                    placeholder="Trần Thị B">
                                @error('bride_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ngày cưới</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ngày cưới chính *</label>
                                <input type="date" wire:model="event_date" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                                @error('event_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ngày âm lịch</label>
                                <input type="text" value="{{ $wedding->event_date_lunar ?? 'Tự động tính' }}" disabled
                                    class="w-full border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Mẫu thiệp & Trạng thái</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Chọn mẫu *</label>
                                <select wire:model="template_id" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                                    @foreach($templates as $template)
                                        @php $tTier = \App\Enums\WeddingTier::tryFrom($template->tier) ?? \App\Enums\WeddingTier::STANDARD; @endphp
                                        <option value="{{ $template->id }}">
                                            [{{ $tTier->label() }}] {{ $template->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                                <select wire:model="status" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                                    @foreach(\App\Enums\WeddingStatus::options() as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB: NHÀ TRAI -->
                <div x-show="$wire.activeTab === 'groom'" x-cloak class="space-y-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">👔 Thông tin gia đình nhà trai</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ông (Cha)</label>
                                <input type="text" wire:model="groom_father" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bà (Mẹ)</label>
                                <input type="text" wire:model="groom_mother" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">💒 Lễ Thành Hôn</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Giờ làm lễ</label>
                                <input type="time" wire:model="groom_ceremony_time" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ngày (nếu khác)</label>
                                <input type="date" wire:model="groom_ceremony_date" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                                <textarea wire:model="groom_address" rows="2"
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500"></textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Link Google Maps</label>
                                <input type="url" wire:model="groom_map_url" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500"
                                    placeholder="https://maps.google.com/...">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">🍽️ Tiệc cưới nhà trai</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Giờ tiệc</label>
                                <input type="time" wire:model="groom_reception_time" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tên địa điểm</label>
                                <input type="text" wire:model="groom_reception_venue" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ tiệc</label>
                                <textarea wire:model="groom_reception_address" rows="2"
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500"></textarea>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">💳 QR Mừng cưới nhà trai</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh QR Code</label>
                                @if($wedding->getFirstMediaUrl('groom_qr'))
                                    <div class="mb-3 relative inline-block">
                                        <img src="{{ $wedding->getFirstMediaUrl('groom_qr') }}" class="w-32 h-32 object-contain border rounded-lg">
                                        <button type="button" wire:click="deleteMedia('groom_qr')" 
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                                @if($groom_qr)
                                    <div class="mb-3">
                                        <img src="{{ $groom_qr->temporaryUrl() }}" class="w-32 h-32 object-contain border rounded-lg border-green-300">
                                        <p class="text-xs text-green-600 mt-1">Ảnh mới (chưa lưu)</p>
                                    </div>
                                @endif
                                <input type="file" wire:model="groom_qr" accept="image/*"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Thông tin tài khoản</label>
                                <textarea wire:model="groom_qr_info" rows="4"
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500"
                                    placeholder="Ngân hàng: ...&#10;Số TK: ...&#10;Chủ TK: ..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB: NHÀ GÁI -->
                <div x-show="$wire.activeTab === 'bride'" x-cloak class="space-y-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">👗 Thông tin gia đình nhà gái</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ông (Cha)</label>
                                <input type="text" wire:model="bride_father" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bà (Mẹ)</label>
                                <input type="text" wire:model="bride_mother" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">💐 Lễ Vu Quy</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Giờ làm lễ</label>
                                <input type="time" wire:model="bride_ceremony_time" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ngày (nếu khác)</label>
                                <input type="date" wire:model="bride_ceremony_date" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                                <textarea wire:model="bride_address" rows="2"
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500"></textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Link Google Maps</label>
                                <input type="url" wire:model="bride_map_url" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500"
                                    placeholder="https://maps.google.com/...">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">🍽️ Tiệc cưới nhà gái</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Giờ tiệc</label>
                                <input type="time" wire:model="bride_reception_time" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tên địa điểm</label>
                                <input type="text" wire:model="bride_reception_venue" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ tiệc</label>
                                <textarea wire:model="bride_reception_address" rows="2"
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500"></textarea>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">💳 QR Mừng cưới nhà gái</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh QR Code</label>
                                @if($wedding->getFirstMediaUrl('bride_qr'))
                                    <div class="mb-3 relative inline-block">
                                        <img src="{{ $wedding->getFirstMediaUrl('bride_qr') }}" class="w-32 h-32 object-contain border rounded-lg">
                                        <button type="button" wire:click="deleteMedia('bride_qr')" 
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                                @if($bride_qr)
                                    <div class="mb-3">
                                        <img src="{{ $bride_qr->temporaryUrl() }}" class="w-32 h-32 object-contain border rounded-lg border-green-300">
                                        <p class="text-xs text-green-600 mt-1">Ảnh mới (chưa lưu)</p>
                                    </div>
                                @endif
                                <input type="file" wire:model="bride_qr" accept="image/*"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Thông tin tài khoản</label>
                                <textarea wire:model="bride_qr_info" rows="4"
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500"
                                    placeholder="Ngân hàng: ...&#10;Số TK: ...&#10;Chủ TK: ..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB: MEDIA -->
                <div x-show="$wire.activeTab === 'media'" x-cloak class="space-y-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">🎵 Nhạc nền</h3>
                        @if($wedding->background_music)
                            <p class="text-sm text-gray-500 mb-2">Đã có: {{ basename($wedding->background_music) }}</p>
                        @endif
                        <input type="file" wire:model="background_music" accept="audio/mpeg,audio/mp3"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                        <p class="text-xs text-gray-500 mt-1">Tối đa 10MB, định dạng MP3</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📸 Ảnh đại diện</h3>
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach([
                                ['cover', 'Ảnh chia sẻ (OG)', '1200x630'],
                                ['hero', 'Ảnh Hero', '9:16'],
                                ['groom_photo', 'Ảnh Chú rể', '3:4'],
                                ['bride_photo', 'Ảnh Cô dâu', '3:4'],
                            ] as $media)
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">{{ $media[1] }}</label>
                                    @if($wedding->getFirstMediaUrl($media[0]))
                                        <div class="relative group">
                                            <img src="{{ $wedding->getFirstMediaUrl($media[0]) }}" class="w-full h-64 object-contain bg-gray-50 border rounded-lg">
                                            <button type="button" wire:click="deleteMedia('{{ $media[0] }}')" 
                                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 shadow-md opacity-0 group-hover:opacity-100 transition-opacity">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                    @if(${$media[0]})
                                        <div class="relative">
                                            <img src="{{ ${$media[0]}->temporaryUrl() }}" class="w-full h-64 object-contain bg-gray-50 border-2 border-green-300 rounded-lg">
                                            <span class="absolute bottom-1 left-1 bg-green-500 text-white text-xs px-2 py-0.5 rounded shadow">Mới</span>
                                        </div>
                                    @endif
                                    <input type="file" wire:model="{{ $media[0] }}" accept="image/*"
                                        class="w-full text-xs text-gray-500 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                                    <p class="text-xs text-gray-400">{{ $media[2] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">🖼️ Album ảnh</h3>
                        @if($wedding->getMedia('gallery')->count() > 0)
                            <div class="grid grid-cols-4 md:grid-cols-6 gap-2 mb-4">
                                @foreach($wedding->getMedia('gallery') as $media)
                                    <div class="relative group">
                                        <img src="{{ $media->getUrl() }}" class="w-full h-32 object-contain bg-gray-50 border rounded">
                                        <button type="button" wire:click="deleteMedia('gallery', {{ $media->id }})" 
                                            class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full p-0.5 hover:bg-red-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <input type="file" wire:model="gallery" accept="image/*" multiple
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                        <p class="text-xs text-gray-500 mt-1">Tối đa 20 ảnh. Chọn nhiều ảnh cùng lúc.</p>
                    </div>
                </div>

                <!-- TAB: CÀI ĐẶT -->
                <div x-show="$wire.activeTab === 'settings'" x-cloak class="space-y-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">⚙️ Cài đặt chung</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">URL Slug</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">/</span>
                                    <input type="text" wire:model="slug" 
                                        class="flex-1 border-gray-300 rounded-r-lg focus:ring-pink-500 focus:border-pink-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu xem thiệp</label>
                                <input type="password" wire:model="password" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500"
                                    placeholder="Để trống nếu không cần">
                            </div>
                        </div>
                        </div>
                        
                        <div class="mt-4">
                             <label class="flex items-center gap-3">
                                <input type="checkbox" wire:model="can_share" 
                                    class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                <span class="text-sm font-medium text-gray-700">Cho phép mọi người xem (Public)</span>
                            </label>
                            <p class="text-xs text-gray-500 ml-7 mt-1">Bật để khách có thể xem thiệp mà không cần đăng nhập. Tắt để chỉ mình bạn xem.</p>
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center gap-3">
                            <input type="checkbox" wire:model="is_auto_approve_wishes" 
                                class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                            <span class="text-sm font-medium text-gray-700">Tự động duyệt lời chúc</span>
                        </label>
                        <p class="text-xs text-gray-500 ml-7 mt-1">Lời chúc sẽ hiện ngay không cần duyệt</p>
                    </div>

                    <!-- PRO FEATURES -->
                    <div class="border-t pt-8">
                        <div class="flex items-center gap-2 mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">✨ Tính năng Nâng cao</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="flex items-center gap-3">
                                    <input type="checkbox" wire:model="show_preload" 
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                    <span class="text-sm font-medium text-gray-700">Animation mở cửa "囍"</span>
                                </label>
                                <p class="text-xs text-gray-500 ml-7 mt-1">Hiển thị cửa Song Hỷ trượt mở</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Hiệu ứng rơi</label>
                                <select wire:model="falling_effect" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                                    @foreach(\App\Enums\FallingEffect::options() as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        @if(false)
                            <div class="mt-4 p-4 bg-gradient-to-r from-yellow-50 to-pink-50 rounded-lg border border-yellow-200">
                                <p class="text-sm text-gray-700">
                                    <strong>Nâng cấp lên Pro</strong> để mở khóa hiệu ứng premium, domain riêng, và nhiều tính năng hấp dẫn khác.
                                </p>
                                <a href="{{ route('dashboard.pricing') }}" class="inline-block mt-2 text-sm font-medium text-pink-600 hover:text-pink-700">
                                    Xem bảng giá →
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Share Link -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link chia sẻ thiệp cưới</label>
                        <div class="flex items-center gap-2">
                            <input type="text" readonly value="{{ url('/' . $wedding->slug) }}" 
                                class="flex-1 bg-white border-gray-300 rounded-lg text-gray-600 text-sm">
                            <button type="button" 
                                onclick="navigator.clipboard.writeText('{{ url('/' . $wedding->slug) }}'); alert('Đã copy link!');" 
                                class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                Copy
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="sticky bottom-0 bg-white border-t border-gray-200 px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('dashboard.weddings.index') }}" class="text-gray-600 hover:text-gray-800">
                        ← Quay lại danh sách
                    </a>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500" wire:loading>
                            <svg class="animate-spin h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Đang lưu...
                        </span>
                        <button type="submit" 
                            class="w-full sm:w-auto bg-pink-600 hover:bg-pink-700 text-white px-8 py-3 rounded-lg font-medium disabled:opacity-50"
                            wire:loading.attr="disabled">
                            💾 Lưu thay đổi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

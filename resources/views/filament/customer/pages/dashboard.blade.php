<x-filament-panels::page>
    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded-xl bg-primary-600 p-6 text-white shadow-sm md:col-span-2">
            <p class="text-sm font-medium text-primary-100">Không gian làm việc của bạn</p>
            <h2 class="mt-2 text-2xl font-bold">Một tài khoản, nhiều loại thiệp.</h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-primary-100">Quản lý Thiệp Hội ngộ và Thiệp cưới tại cùng một nơi. Các dịch vụ tiếp theo cũng sẽ thêm vào đây.</p>
            <div class="mt-5 flex flex-wrap gap-3">
                <a href="{{ $this->getCreateGatheringUrl() }}" class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-primary-700 transition hover:bg-primary-50">Tạo thiệp Hội ngộ</a>
                <a href="{{ $this->getCreateWeddingUrl() }}" class="rounded-lg border border-white/40 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">Tạo thiệp cưới</a>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Thiệp Hội ngộ</p>
            <p class="mt-2 text-4xl font-bold text-gray-950 dark:text-white">{{ $this->getGatherings()->count() }}</p>
            <a href="{{ $this->getGatheringIndexUrl() }}" class="mt-2 inline-block text-sm font-semibold text-primary-600 hover:text-primary-500">Quản lý thiệp</a>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Thiệp cưới</p>
            <p class="mt-2 text-4xl font-bold text-gray-950 dark:text-white">{{ $this->getWeddings()->count() }}</p>
            <a href="{{ $this->getWeddingIndexUrl() }}" class="mt-2 inline-block text-sm font-semibold text-primary-600 hover:text-primary-500">Quản lý thiệp</a>
        </div>
    </div>

    <div class="mt-6 rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 px-6 py-4 dark:border-gray-800">
            <div>
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">Thiệp Hội ngộ gần đây</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mở thiệp để chỉnh nội dung, ảnh, QR và danh sách khách mời.</p>
            </div>
            <a href="{{ $this->getGatheringIndexUrl() }}" class="text-sm font-semibold text-primary-600 hover:text-primary-500">Quản lý thiệp</a>
        </div>

        @if ($this->getGatherings()->isEmpty())
            <div class="px-6 py-12 text-center">
                <p class="font-medium text-gray-900 dark:text-white">Chưa có thiệp nào.</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Bắt đầu bằng một thiệp Hội ngộ đầu tiên nhé.</p>
                <a href="{{ $this->getCreateGatheringUrl() }}" class="mt-4 inline-flex rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-500">Tạo thiệp</a>
            </div>
        @else
            <div class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ($this->getGatherings() as $gathering)
                    <a href="{{ $this->getGatheringEditUrl($gathering) }}" class="flex items-center justify-between gap-4 px-6 py-4 transition hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <div class="min-w-0">
                            <p class="truncate font-semibold text-gray-950 dark:text-white">{{ $gathering->title }}</p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ $gathering->event_time?->format('H:i d/m/Y') ?? $gathering->event_date?->format('d/m/Y') ?? 'Chưa chốt thời gian' }}
                                <span class="px-1">·</span>
                                {{ $gathering->guests_count }} khách mời
                            </p>
                        </div>
                        <span @class([
                            'rounded-full px-2.5 py-1 text-xs font-semibold',
                            'bg-success-50 text-success-700 dark:bg-success-500/10 dark:text-success-400' => $gathering->status === 'published',
                            'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300' => $gathering->status !== 'published',
                        ])>
                            {{ $gathering->status === 'published' ? 'Đã xuất bản' : 'Bản nháp' }}
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mt-6 rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 px-6 py-4 dark:border-gray-800">
            <div>
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">Thiệp cưới gần đây</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tạo link thiệp cưới, ảnh chia sẻ và QR mừng cưới tại đây.</p>
            </div>
            <a href="{{ $this->getWeddingIndexUrl() }}" class="text-sm font-semibold text-primary-600 hover:text-primary-500">Quản lý thiệp</a>
        </div>

        @if ($this->getWeddings()->isEmpty())
            <div class="px-6 py-10 text-center">
                <p class="font-medium text-gray-900 dark:text-white">Chưa có thiệp cưới nào.</p>
                <a href="{{ $this->getCreateWeddingUrl() }}" class="mt-4 inline-flex rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-500">Tạo thiệp cưới</a>
            </div>
        @else
            <div class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ($this->getWeddings() as $wedding)
                    <a href="{{ $this->getWeddingEditUrl($wedding) }}" class="flex items-center justify-between gap-4 px-6 py-4 transition hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <div class="min-w-0">
                            <p class="truncate font-semibold text-gray-950 dark:text-white">{{ $wedding->groom_name }} &amp; {{ $wedding->bride_name }}</p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $wedding->event_time?->format('H:i d/m/Y') ?? $wedding->event_date?->format('d/m/Y') ?? 'Chưa chốt thời gian' }}</p>
                        </div>
                        <span @class([
                            'rounded-full px-2.5 py-1 text-xs font-semibold',
                            'bg-success-50 text-success-700 dark:bg-success-500/10 dark:text-success-400' => $wedding->status === 'published',
                            'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300' => $wedding->status !== 'published',
                        ])>
                            {{ $wedding->status === 'published' ? 'Đã xuất bản' : 'Bản nháp' }}
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-filament-panels::page>

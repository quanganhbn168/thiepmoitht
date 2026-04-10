<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}
        
        <div class="mt-6">
            <x-filament::button type="submit" size="lg">
                💾 Lưu cài đặt
            </x-filament::button>
        </div>
    </form>
    
    <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
        <h3 class="font-bold text-blue-800 mb-2">📌 Lưu ý</h3>
        <ul class="text-sm text-blue-700 space-y-1">
            <li>• Thay đổi giá sẽ ảnh hưởng đến trang chủ và dashboard ngay lập tức</li>
            <li>• Giá đại lý áp dụng cho đăng ký mới, không ảnh hưởng subscription hiện tại</li>
            <li>• Gói Pro: Ảnh không giới hạn, lưu trữ vĩnh viễn (không cần cài đặt)</li>
            <li>• Gói Doanh nghiệp: Quota không giới hạn (không cần cài đặt)</li>
        </ul>
    </div>
</x-filament-panels::page>

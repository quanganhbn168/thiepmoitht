<?php

namespace App\Filament\Pages;

use App\Filament\Resources\ReunionMessageResource;
use App\Filament\Resources\ReunionRsvpResource;
use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static string $view = 'filament.pages.dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canAccess(): bool
    {
        return auth()->check();
    }

    public function getTitle(): string | Htmlable
    {
        return auth()->user()?->isCustomer()
            ? 'Bảng điều khiển'
            : parent::getTitle();
    }

    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        if (auth()->user()?->isCustomer()) {
            return [];
        }

        return parent::getWidgets();
    }

    public function getCustomerQuickLinks(): array
    {
        return [
            [
                'title' => 'Xác nhận lời mời',
                'description' => 'Xem, thêm, sửa và quản lý danh sách khách xác nhận tham dự.',
                'url' => ReunionRsvpResource::getUrl(),
            ],
            [
                'title' => 'Sổ lưu bút',
                'description' => 'Quản lý lời chúc, lời nhắn và trạng thái duyệt hiển thị.',
                'url' => ReunionMessageResource::getUrl(),
            ],
        ];
    }
}

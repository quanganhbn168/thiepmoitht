<?php

namespace App\Filament\Pages;

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
        return auth()->user()?->isAdmin()
            || auth()->user()?->hasRole('agent')
            || auth()->user()?->role === 'agent';
    }

    public function getTitle(): string|Htmlable
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
}

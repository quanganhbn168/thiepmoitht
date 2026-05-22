<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user() && auth()->user()->isAdmin();
    }

    public static function canAccess(): bool
    {
        return auth()->user() && auth()->user()->isAdmin();
    }
}

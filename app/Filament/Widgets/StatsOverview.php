<?php

namespace App\Filament\Widgets;

use App\Models\Reunion;
use App\Models\ReunionRsvp;
use App\Models\ReunionMessage;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $totalReunions = Reunion::count();
        $totalUsers = User::count();
        $totalRsvps = ReunionRsvp::count();
        $totalMessages = ReunionMessage::count();
        
        // Growth calculations
        $lastMonthReunions = Reunion::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $reunionGrowth = $lastMonthReunions > 0 
            ? round((($totalReunions - $lastMonthReunions) / $lastMonthReunions) * 100, 1)
            : 100;
            
        return [
            Stat::make('👥 Tổng Users', number_format($totalUsers))
                ->description('Khách hàng sử dụng')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
                
            Stat::make('🎓 Thiệp Họp Lớp', number_format($totalReunions))
                ->description(($reunionGrowth >= 0 ? '+' : '') . $reunionGrowth . '% so với tháng trước')
                ->descriptionIcon($reunionGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($reunionGrowth >= 0 ? 'success' : 'danger'),
                
            Stat::make('✉️ Lời chúc & Khách', number_format($totalRsvps + $totalMessages))
                ->description($totalRsvps . ' khách / ' . $totalMessages . ' lời chúc')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('success'),
        ];
    }
}


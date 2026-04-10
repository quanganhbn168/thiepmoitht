<?php

namespace App\Filament\Widgets;

use App\Models\Reunion;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class CreationsChart extends ChartWidget
{
    protected static ?string $heading = '📈 Thiệp Họp Lớp mới (7 ngày qua)';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $days = collect(range(6, 0))->map(function ($daysAgo) {
            return Carbon::now()->subDays($daysAgo)->format('Y-m-d');
        });

        $reunionData = $days->map(function ($date) {
            return Reunion::whereDate('created_at', $date)->count();
        });

        $labels = $days->map(function ($date) {
            return Carbon::parse($date)->format('d/m');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Thiệp Họp Lớp',
                    'data' => $reunionData->toArray(),
                    'backgroundColor' => 'rgba(236, 72, 153, 0.5)',
                    'borderColor' => 'rgb(236, 72, 153)',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
            ],
            'labels' => $labels->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}


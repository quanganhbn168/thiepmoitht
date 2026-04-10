<?php

namespace App\Filament\Resources\ReunionMessageResource\Pages;

use App\Filament\Resources\ReunionMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReunionMessages extends ListRecords
{
    protected static string $resource = ReunionMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->slideOver(),
        ];
    }
}

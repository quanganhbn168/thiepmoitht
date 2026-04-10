<?php

namespace App\Filament\Resources\ReunionRsvpResource\Pages;

use App\Filament\Resources\ReunionRsvpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReunionRsvps extends ListRecords
{
    protected static string $resource = ReunionRsvpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->slideOver(),
        ];
    }
}

<?php

namespace App\Filament\Resources\ReunionResource\Pages;

use App\Filament\Resources\ReunionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReunions extends ListRecords
{
    protected static string $resource = ReunionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\GatheringResource\Pages;

use App\Filament\Resources\GatheringResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateGathering extends CreateRecord
{
    protected static string $resource = GatheringResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (blank($data['slug'] ?? null)) {
            $data['slug'] = Str::slug((string) ($data['title'] ?? 'hoi-ngo'));
        }

        return $data;
    }
}

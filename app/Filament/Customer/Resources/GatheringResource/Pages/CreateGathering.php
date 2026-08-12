<?php

namespace App\Filament\Customer\Resources\GatheringResource\Pages;

use App\Filament\Customer\Resources\GatheringResource;
use App\Filament\Resources\GatheringResource\Pages\CreateGathering as BaseCreateGathering;

class CreateGathering extends BaseCreateGathering
{
    protected static string $resource = GatheringResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = parent::mutateFormDataBeforeCreate($data);
        $data['user_id'] = auth()->id();

        return $data;
    }
}

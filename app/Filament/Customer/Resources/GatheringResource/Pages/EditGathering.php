<?php

namespace App\Filament\Customer\Resources\GatheringResource\Pages;

use App\Filament\Customer\Resources\GatheringResource;
use App\Filament\Resources\GatheringResource\Pages\EditGathering as BaseEditGathering;

class EditGathering extends BaseEditGathering
{
    protected static string $resource = GatheringResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = $this->getRecord()->user_id;

        return $data;
    }
}

<?php

namespace App\Filament\Customer\Resources\WeddingResource\Pages;

use App\Filament\Customer\Resources\WeddingResource;
use App\Filament\Resources\WeddingResource\Pages\EditWedding as BaseEditWedding;

class EditWedding extends BaseEditWedding
{
    protected static string $resource = WeddingResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = $this->getRecord()->user_id;

        return $data;
    }
}

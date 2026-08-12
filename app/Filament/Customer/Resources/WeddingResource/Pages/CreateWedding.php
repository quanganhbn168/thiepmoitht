<?php

namespace App\Filament\Customer\Resources\WeddingResource\Pages;

use App\Filament\Customer\Resources\WeddingResource;
use App\Filament\Resources\WeddingResource\Pages\CreateWedding as BaseCreateWedding;

class CreateWedding extends BaseCreateWedding
{
    protected static string $resource = WeddingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}

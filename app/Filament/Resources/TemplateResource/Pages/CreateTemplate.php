<?php

namespace App\Filament\Resources\TemplateResource\Pages;

use App\Filament\Resources\TemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTemplate extends CreateRecord
{
    protected static string $resource = TemplateResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['media_schema'])) {
            $data['media_schema'] = TemplateResource::sanitizeMediaSchema($data['media_schema']);
        }

        return $data;
    }
}

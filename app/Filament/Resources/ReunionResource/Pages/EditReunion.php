<?php

namespace App\Filament\Resources\ReunionResource\Pages;

use App\Filament\Resources\ReunionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReunion extends EditRecord
{
    protected static string $resource = ReunionResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->normalizeClassAlbums($data);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->normalizeClassAlbums($data);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    private function normalizeClassAlbums(array $data): array
    {
        if (isset($data['content']['class_albums'])) {
            $data['content']['class_albums'] = ReunionResource::normalizeClassAlbumsForStorage(
                $data['content']['class_albums']
            );
        }

        return $data;
    }
}

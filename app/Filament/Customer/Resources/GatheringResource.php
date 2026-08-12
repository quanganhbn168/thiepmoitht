<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\GatheringResource\Pages;
use App\Filament\Resources\GatheringResource as BaseGatheringResource;
use Illuminate\Database\Eloquent\Builder;

class GatheringResource extends BaseGatheringResource
{
    protected static ?string $navigationGroup = 'Thiệp của tôi';

    protected static ?string $navigationLabel = 'Thiệp Hội ngộ';

    protected static ?string $pluralModelLabel = 'Thiệp Hội ngộ của tôi';

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->isCustomer() ?? false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGatherings::route('/'),
            'create' => Pages\CreateGathering::route('/create'),
            'edit' => Pages\EditGathering::route('/{record}/edit'),
        ];
    }
}

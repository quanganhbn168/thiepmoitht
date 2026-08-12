<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\WeddingResource\Pages;
use App\Filament\Resources\WeddingResource as BaseWeddingResource;
use Illuminate\Database\Eloquent\Builder;

class WeddingResource extends BaseWeddingResource
{
    protected static ?string $navigationGroup = 'Thiệp của tôi';

    protected static ?string $navigationLabel = 'Thiệp cưới';

    protected static ?string $pluralModelLabel = 'Thiệp cưới của tôi';

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
            'index' => Pages\ListWeddings::route('/'),
            'create' => Pages\CreateWedding::route('/create'),
            'edit' => Pages\EditWedding::route('/{record}/edit'),
        ];
    }
}

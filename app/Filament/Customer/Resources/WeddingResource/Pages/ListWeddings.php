<?php

namespace App\Filament\Customer\Resources\WeddingResource\Pages;

use App\Filament\Customer\Resources\WeddingResource;
use App\Filament\Resources\WeddingResource\Pages\ListWeddings as BaseListWeddings;

class ListWeddings extends BaseListWeddings
{
    protected static string $resource = WeddingResource::class;
}

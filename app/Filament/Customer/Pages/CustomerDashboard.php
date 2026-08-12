<?php

namespace App\Filament\Customer\Pages;

use App\Filament\Customer\Resources\GatheringResource;
use App\Filament\Customer\Resources\WeddingResource;
use App\Models\Gathering;
use App\Models\Wedding;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

class CustomerDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = -2;

    protected static ?string $navigationLabel = 'Tổng quan';

    protected static ?string $title = 'Tài khoản của tôi';

    protected static string $view = 'filament.customer.pages.dashboard';

    public static function canAccess(): bool
    {
        return auth()->user()?->isCustomer() ?? false;
    }

    /**
     * @return Collection<int, Gathering>
     */
    public function getGatherings(): Collection
    {
        return Gathering::query()
            ->where('user_id', auth()->id())
            ->withCount('guests')
            ->latest()
            ->get();
    }

    public function getCreateGatheringUrl(): string
    {
        return GatheringResource::getUrl('create', panel: 'customer');
    }

    public function getGatheringIndexUrl(): string
    {
        return GatheringResource::getUrl(panel: 'customer');
    }

    public function getGatheringEditUrl(Gathering $gathering): string
    {
        return GatheringResource::getUrl('edit', ['record' => $gathering], panel: 'customer');
    }

    /**
     * @return Collection<int, Wedding>
     */
    public function getWeddings(): Collection
    {
        return Wedding::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    public function getCreateWeddingUrl(): string
    {
        return WeddingResource::getUrl('create', panel: 'customer');
    }

    public function getWeddingIndexUrl(): string
    {
        return WeddingResource::getUrl(panel: 'customer');
    }

    public function getWeddingEditUrl(Wedding $wedding): string
    {
        return WeddingResource::getUrl('edit', ['record' => $wedding], panel: 'customer');
    }
}

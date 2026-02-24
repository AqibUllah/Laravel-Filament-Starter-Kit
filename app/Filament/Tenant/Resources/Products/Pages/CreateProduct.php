<?php

namespace App\Filament\Tenant\Resources\Products\Pages;

use App\Filament\Tenant\Resources\Products\ProductResource;
use App\Services\FeatureLimiterService;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function beforeCreate(): void
    {
        $canCreate = app(FeatureLimiterService::class)
            ->forTenant(Filament::getTenant())
            ->canCreateProduct();

        if (! $canCreate) {
            $limit = app(FeatureLimiterService::class)
                ->forTenant(Filament::getTenant())
                ->getFeatureLimit('Products');

            Notification::make()
                ->danger()
                ->title('Product Limit Reached')
                ->body("Your plan reached your current limit of {$limit} Products. Upgrade your plan to unlock more.")
                ->persistent()
                ->send();

            $this->halt();
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['team_id'] = auth()->user()->tenant()?->id ?? auth()->user()->team_id;

        return $data;
    }
}

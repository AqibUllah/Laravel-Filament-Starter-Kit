<?php

namespace App\Filament\Tenant\Resources\Categories\Pages;

use App\Filament\Tenant\Resources\Categories\CategoryResource;
use App\Services\FeatureLimiterService;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function beforeCreate(): void
    {
        $canCreate = app(FeatureLimiterService::class)
            ->forTenant(Filament::getTenant())
            ->canCreateCategory();

        if (! $canCreate) {
            $limit = app(FeatureLimiterService::class)
                ->forTenant(Filament::getTenant())
                ->getFeatureLimit('Categories');

            Notification::make()
                ->danger()
                ->title('Category Limit Reached')
                ->body("Your plan reached your current limit of {$limit} Categories. Upgrade your plan to unlock more.")
                ->persistent()
                ->send();

            $this->halt();
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['team_id'] = auth()->user()->currentTeam?->id ?? auth()->user()->team_id;
        
        return $data;
    }
}

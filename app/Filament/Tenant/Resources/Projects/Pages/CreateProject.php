<?php

namespace App\Filament\Tenant\Resources\Projects\Pages;

use App\Filament\Tenant\Resources\Projects\ProjectResource;
use App\Services\FeatureLimiterService;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    protected function beforeCreate(): void
    {
        $canCreate = app(FeatureLimiterService::class)
            ->forTenant(Filament::getTenant())
            ->canCreateProject();

        if (! $canCreate) {
            $limit = app(FeatureLimiterService::class)
                ->forTenant(Filament::getTenant())
                ->getFeatureLimit('Projects');

            Notification::make()
                ->danger()
                ->title('Project Limit Reached')
                ->body("Your plan reached your current limit of {$limit} Projects. Upgrade your plan to unlock more.")
                ->persistent()
                ->send();

            $this->halt();
        }
    }
}

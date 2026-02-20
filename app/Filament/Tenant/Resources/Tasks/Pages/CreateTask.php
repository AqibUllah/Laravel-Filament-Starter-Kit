<?php

namespace App\Filament\Tenant\Resources\Tasks\Pages;

use App\Filament\Tenant\Resources\Tasks\TaskResource;
use App\Services\FeatureLimiterService;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;

    protected function beforeCreate(): void
    {
        $canCreate = app(FeatureLimiterService::class)
            ->forTenant(Filament::getTenant())
            ->canCreateTask();

        if (! $canCreate) {
            $limit = app(FeatureLimiterService::class)
                ->forTenant(Filament::getTenant())
                ->getFeatureLimit('Tasks');

            Notification::make()
                ->danger()
                ->title('Task Limit Reached')
                ->body("Your plan reached your current limit of {$limit} Tasks. Upgrade your plan to unlock more.")
                ->persistent()
                ->send();

            $this->halt();
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['assigned_by'] = auth()->id();

        return $data;
    }
}

<?php

namespace App\Filament\Tenant\Resources\Users\Pages;

use App\Filament\Tenant\Resources\Users\UserResource;
use App\Services\FeatureLimiterService;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function beforeCreate(): void
    {
        $canCreate = app(FeatureLimiterService::class)
            ->forTenant(Filament::getTenant())
            ->canCreateUser();

        if (! $canCreate) {
            Notification::make()
                ->danger()
                ->title('User Limit Reached')
                ->body('Your plan reached your current limit. Upgrade your plan to unlock more.')
                ->persistent()
                ->send();

            $this->halt();
        }
    }
}

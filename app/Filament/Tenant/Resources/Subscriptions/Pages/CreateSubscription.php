<?php

namespace App\Filament\Tenant\Resources\Subscriptions\Pages;

use App\Filament\Tenant\Resources\Subscriptions\SubscriptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSubscription extends CreateRecord
{
    protected static string $resource = SubscriptionResource::class;
}

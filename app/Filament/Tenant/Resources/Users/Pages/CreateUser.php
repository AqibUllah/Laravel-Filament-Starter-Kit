<?php

namespace App\Filament\Tenant\Resources\Users\Pages;

use App\Filament\Tenant\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}

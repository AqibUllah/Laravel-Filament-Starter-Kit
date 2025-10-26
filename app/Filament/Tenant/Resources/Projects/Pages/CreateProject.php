<?php

namespace App\Filament\Tenant\Resources\Projects\Pages;

use App\Filament\Tenant\Resources\Projects\ProjectResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;
}

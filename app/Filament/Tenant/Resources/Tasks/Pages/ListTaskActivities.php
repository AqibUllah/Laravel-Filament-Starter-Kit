<?php

namespace App\Filament\Tenant\Resources\Tasks\Pages;

use App\Filament\Tenant\Resources\Tasks\TaskResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class ListTaskActivities extends ListActivities
{
    protected static string $resource = TaskResource::class;
}

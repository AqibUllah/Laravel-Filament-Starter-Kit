<?php

namespace App\Filament\Admin\Resources\Usages\Pages;

use App\Filament\Admin\Resources\Usages\UsageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUsages extends ListRecords
{
    protected static string $resource = UsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

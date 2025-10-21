<?php

namespace App\Filament\Resources\PLans\Pages;

use App\Filament\Resources\PLans\PLanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPLans extends ListRecords
{
    protected static string $resource = PLanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\PLans\Pages;

use App\Filament\Resources\PLans\PLanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPLan extends EditRecord
{
    protected static string $resource = PLanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

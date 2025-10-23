<?php

namespace App\Filament\Admin\Resources\PLans\Pages;

use App\Filament\Admin\Resources\PLans\PLanResource;
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

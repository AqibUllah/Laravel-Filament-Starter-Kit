<?php

namespace App\Filament\Admin\Resources\Usages\Pages;

use App\Filament\Admin\Resources\Usages\UsageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUsage extends EditRecord
{
    protected static string $resource = UsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

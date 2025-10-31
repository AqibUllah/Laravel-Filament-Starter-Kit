<?php

namespace App\Filament\Tenant\Resources\EmailTemplateThemes\Pages;

use App\Filament\Tenant\Resources\EmailTemplateThemes\EmailTemplateThemeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditEmailTemplateTheme extends EditRecord
{
    protected static string $resource = EmailTemplateThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Tenant\Resources\EmailTemplateThemes\Pages;

use App\Filament\Tenant\Resources\EmailTemplateThemes\EmailTemplateThemeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmailTemplateThemes extends ListRecords
{
    protected static string $resource = EmailTemplateThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Tenant\Resources\EmailTemplateThemes\Pages;

use App\Filament\Tenant\Resources\EmailTemplateThemes\EmailTemplateThemeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEmailTemplateTheme extends CreateRecord
{
    protected static string $resource = EmailTemplateThemeResource::class;
}

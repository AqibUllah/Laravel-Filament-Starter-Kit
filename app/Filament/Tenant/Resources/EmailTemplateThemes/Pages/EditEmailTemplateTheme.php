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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Eager load the email_template relation to ensure it's available
        $this->record->load('email_template');

        // Set the template-keys value for preview when editing
        if ($this->record->email_template) {
            $data['template-keys'] = $this->record->email_template->key;
        }

        return $data;
    }
}

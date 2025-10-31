<?php

namespace App\Filament\Tenant\Resources\EmailTemplates\Pages;

use App\Filament\Tenant\Resources\EmailTemplates\EmailTemplateResource;
use App\Models\EmailTemplate;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ListEmailTemplates extends ListRecords
{
    protected static string $resource = EmailTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getActions(): array
    {
        return [
            Action::make('back')->label(__('Back'))
                ->url(EmailTemplateResource::getUrl())
            ,

            Action::make('preview')->label(__('Preview'))->modalContent(fn (EmailTemplate $record): View => view(
                'vb-email-templates::forms.components.iframe',
                ['record' => $record],
            ))->form(null),

            DeleteAction::make(),

            ForceDeleteAction::make()
                ->before(function (EmailTemplate $record, EmailTemplateResource $emailTemplateResource) {
                    $emailTemplateResource->handleLogoDelete($record->logo);
                }),

            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['logo_type'] = 'browse_another';

        if(!is_null($data['logo']) && Str::isUrl($data['logo'])) {
            $data['logo_type'] = 'paste_url';
            $data['logo_url'] = $data['logo'];
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $emailTemplateResource = new EmailTemplateResource();
        $sortedData = $emailTemplateResource->handleLogo($data);

        // deleting previous logo
        if ($record->logo != ($sortedData['logo'] ?? null)) {
            $emailTemplateResource->handleLogoDelete($record->logo);
        }

        $record->update($sortedData);

        return $record;
    }
}

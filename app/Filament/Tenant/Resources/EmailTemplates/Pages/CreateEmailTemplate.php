<?php

namespace App\Filament\Tenant\Resources\EmailTemplates\Pages;

use App\Filament\Tenant\Resources\EmailTemplates\EmailTemplateResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateEmailTemplate extends CreateRecord
{
    protected static string $resource = EmailTemplateResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $emailTemplateResource = new \Visualbuilder\EmailTemplates\Resources\EmailTemplateResource;
        $sortedData = $emailTemplateResource->handleLogo($data);

        return static::getModel()::create($sortedData);
    }
}

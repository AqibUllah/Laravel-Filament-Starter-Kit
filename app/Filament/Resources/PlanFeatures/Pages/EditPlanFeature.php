<?php

namespace App\Filament\Resources\PlanFeatures\Pages;

use App\Filament\Resources\PlanFeatures\PlanFeatureResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPlanFeature extends EditRecord
{
    protected static string $resource = PlanFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

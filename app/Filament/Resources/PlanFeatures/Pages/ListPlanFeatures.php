<?php

namespace App\Filament\Resources\PlanFeatures\Pages;

use App\Filament\Resources\PlanFeatures\PlanFeatureResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlanFeatures extends ListRecords
{
    protected static string $resource = PlanFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

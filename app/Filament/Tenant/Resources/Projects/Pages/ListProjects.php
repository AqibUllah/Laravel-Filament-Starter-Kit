<?php

namespace App\Filament\Tenant\Resources\Projects\Pages;

use App\Filament\Tenant\Resources\Projects\ProjectResource;
use App\Filament\Tenant\Widgets\ProjectStatsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProjectStatsWidget::class,
        ];
    }
}

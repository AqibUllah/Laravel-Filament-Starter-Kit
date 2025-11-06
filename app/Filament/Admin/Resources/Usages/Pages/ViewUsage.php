<?php

namespace App\Filament\Admin\Resources\Usages\Pages;

use App\Filament\Admin\Resources\Usages\UsageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewUsage extends ViewRecord
{
    protected static string $resource = UsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextEntry::make('team.name')
                //     ->label('Team'),
                // TextEntry::make('metric_name')
                //     ->label('Metric Name'),
                // TextEntry::make('quantity')
                //     ->label('Quantity'),
            ]);
    }
}

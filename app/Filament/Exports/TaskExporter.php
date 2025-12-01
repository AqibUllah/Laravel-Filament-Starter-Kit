<?php

namespace App\Filament\Exports;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Illuminate\Support\Carbon;

class TaskExporter extends Exporter
{
    protected static ?string $model = Task::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('title')->label('Title'),
            ExportColumn::make('assignee.name')->label('Assigned To'),
            ExportColumn::make('due_date')
                ->label('Due Date')
                ->formatStateUsing(fn ($state) => $state ? (is_string($state) ? $state : $state->format('Y-m-d')) : null),
            ExportColumn::make('priority')
                ->label('Priority')
                ->formatStateUsing(function ($state) {
                    if ($state instanceof PriorityEnum) {
                        return $state->getLabel();
                    }
                    return is_string($state) ? ucfirst($state) : (string) $state;
                }),
            ExportColumn::make('status')
                ->label('Status')
                ->formatStateUsing(function ($state) {
                    if ($state instanceof TaskStatusEnum) {
                        return $state->getLabel();
                    }
                    return is_string($state) ? ucfirst(str_replace('_', ' ', $state)) : (string) $state;
                }),
            ExportColumn::make('estimated_hours')->label('Est. Hours'),
            ExportColumn::make('actual_hours')->label('Actual Hours'),
            ExportColumn::make('created_at')
                ->label('Created At')
                ->formatStateUsing(fn ($state) => $state ? (is_string($state) ? $state : $state->format('Y-m-d H:i')) : null),
        ];
    }
}
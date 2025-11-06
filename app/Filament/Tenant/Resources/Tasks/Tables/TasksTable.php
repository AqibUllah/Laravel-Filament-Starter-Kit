<?php

namespace App\Filament\Tenant\Resources\Tasks\Tables;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Filament\Tenant\Resources\Tasks\TaskResource;
use App\Helpers\FeatureLimitHelper;
use App\Models\Task;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TasksTable
{
    public static function configure(Table $table): Table
    {

        $team = Filament::getTenant();
        $count = $team->tasks()->count();

        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                TextColumn::make('assignee.name')
                    ->label('Assigned To')
                    ->sortable(),
                TextColumn::make('due_date')
                    ->date()
                    ->sortable()
                    ->color(fn (Task $record) => $record->isOverdue() ? 'danger' : null),
                BadgeColumn::make('priority')
                    ->formatStateUsing(fn (PriorityEnum $state): string => $state->getLabel()),
                BadgeColumn::make('status')
                    ->formatStateUsing(fn (TaskStatusEnum $state) => $state->getLabel()),
                TextColumn::make('estimated_hours')
                    ->label('Est. Hours')
                    ->sortable(),
                TextColumn::make('actual_hours')
                    ->label('Actual Hours')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('assigned_to')
                    ->label('Assigned To')
                    ->options(fn () => filament()->getTenant()->members()->pluck('name', 'user_id')),
                SelectFilter::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                Filter::make('overdue')
                    ->label('Overdue Tasks')
                    ->query(fn (Builder $query) => $query->overdue()),
                Filter::make('due_this_week')
                    ->label('Due This Week')
                    ->query(fn (Builder $query) => $query->whereBetween('due_date', [now(), now()->addWeek()])),
            ])
            ->recordActions([
                // ... other actions
                Action::make('logTime')
                    ->label('Log Time')
                    ->icon('heroicon-o-clock')
                    ->form([
                        TextInput::make('actual_hours')
                            ->label('Hours Spent')
                            ->numeric()
                            ->minValue(0)
                            ->step(0.5)
                            ->required(),
                    ])
                    ->action(function (Task $record, array $data) {
                        $record->update(['actual_hours' => $data['actual_hours']]);
                    })
                    ->visible(fn (Task $record) => $record->status !== TaskStatusEnum::Completed),
                Action::make('markInProgress')
                    ->label('Start')
                    ->icon('heroicon-o-play')
                    ->action(fn (Task $record) => $record->update(['status' => 'in_progress']))
                    ->visible(fn (Task $record) => $record->status->value === 'pending')
                    ->color('primary'),
                Action::make('markCompleted')
                    ->label('Complete')
                    ->icon('heroicon-o-check')
                    ->form([
                        TextInput::make('actual_hours')
                            ->label('Hours Spent')
                            ->numeric()
                            ->minValue(0)
                            ->step(0.5)
                            ->hint('Optional: Enter time spent on this task'),
                    ])
                    ->action(function (Task $record, array $data) {
                        $record->markAsCompleted($data['actual_hours'] ?? null);
                    })
                    ->visible(fn (Task $record) => in_array($record->status, [TaskStatusEnum::Pending, TaskStatusEnum::InProgress]))
                    ->color('success'),
                Action::make('activities')->url(fn ($record) => TaskResource::getUrl('activities', ['record' => $record])),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('logTime')
                        ->label('Log Time')
                        ->icon('heroicon-o-clock')
                        ->form([
                            TextInput::make('actual_hours')
                                ->label('Hours Spent')
                                ->numeric()
                                ->minValue(0)
                                ->step(0.5)
                                ->required(),
                        ])
                        ->action(function ($records, array $data) {
                            $records->each(function ($record) use ($data) {
                                $record->update(['actual_hours' => $data['actual_hours']]);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('markCompleted')
                        ->label('Mark as Completed')
                        ->icon('heroicon-o-check')
                        ->action(fn ($records) => $records->each->markAsCompleted())
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('markInProgress')
                        ->label('Mark as Completed')
                        ->icon('heroicon-o-check')
                        ->form([
                            TextInput::make('actual_hours')
                                ->label('Hours Spent')
                                ->numeric()
                                ->minValue(0)
                                ->step(0.5)
                                ->hint('Optional: Enter time spent'),
                        ])
                        ->action(function ($records, array $data) {
                            $records->each(function ($record) use ($data) {
                                $record->markAsCompleted($data['actual_hours'] ?? null);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('due_date', 'asc')
            ->contentFooter(fn () => FeatureLimitHelper::alertIfExceeded('Tasks', $count, route('filament.tenant.pages.plans', ['tenant' => filament()->getTenant()])));
    }

    public static function canCreate(): bool
    {
        $currentTeam = Filament::getTenant();

        return $currentTeam && $currentTeam->userCanAssignTasks(auth()->user());
    }
}

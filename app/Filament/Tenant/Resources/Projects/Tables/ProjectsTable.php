<?php

namespace App\Filament\Tenant\Resources\Projects\Tables;

use App\Enums\PriorityEnum;
use App\Enums\ProjectStatusEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        $currentTeam = Filament::getTenant();

        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->description ? Str::limit(strip_tags($record->description), 50) : null)
                    ->url(fn ($record) => route('filament.tenant.resources.projects.edit', ['record' => $record, 'tenant' => $currentTeam])),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (ProjectStatusEnum $state): string => $state->getColor())
                    ->icon(fn (ProjectStatusEnum $state) => $state->getIcon())
                    ->sortable(),

                TextColumn::make('priority')
                    ->badge()
                    ->color(fn (PriorityEnum $state): string => $state->getColor())
                    ->icon(fn (PriorityEnum $state) => $state->getIcon())
                    ->sortable(),

                TextColumn::make('progress')
                    ->label('Progress')
                    ->color(fn ($state) => match (true) {
                        $state >= 100 => 'success',
                        $state >= 75 => 'info',
                        $state >= 50 => 'warning',
                        default => 'danger',
                    }),

                TextColumn::make('projectManager.name')
                    ->label('Manager')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Unassigned'),

                TextColumn::make('start_date')
                    ->date('M j, Y')
                    ->sortable(),

                TextColumn::make('due_date')
                    ->date('M j, Y')
                    ->sortable()
                    ->color(fn ($record) => $record->is_overdue ? 'danger' : null)
                    ->description(fn ($record) => $record->is_overdue ? 'Overdue' : null),

                TextColumn::make('budget')
                    ->money('USD')
                    ->sortable()
                    ->placeholder('Not set'),

                TextColumn::make('tasks_count')
                    ->label('Tasks')
                    ->state(fn ($record) => $record->tasks()->count())
                    ->badge()
                    ->color('info'),

                TextColumn::make('users_count')
                    ->label('Team')
                    ->state(fn ($record) => $record->users()->count())
                    ->badge()
                    ->color('success'),

                TextColumn::make('created_at')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(ProjectStatusEnum::class)
                    ->multiple(),

                SelectFilter::make('priority')
                    ->options(PriorityEnum::class)
                    ->multiple(),

                SelectFilter::make('project_manager_id')
                    ->label('Project Manager')
                    ->options($currentTeam->members()->pluck('name', 'user_id'))
                    ->searchable(),

                Filter::make('overdue')
                    ->query(fn (Builder $query): Builder => $query->overdue())
                    ->toggle(),

                Filter::make('high_priority')
                    ->query(fn (Builder $query): Builder => $query->highPriority())
                    ->toggle(),

                Filter::make('with_progress')
                    ->form([
                        \Filament\Forms\Components\TextInput::make('min_progress')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(0)
                            ->suffix('%'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['min_progress'],
                            fn (Builder $query, $progress): Builder => $query->withProgress($progress),
                        );
                    }),

                TernaryFilter::make('has_budget')
                    ->label('Has Budget')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('budget'),
                        false: fn (Builder $query) => $query->whereNull('budget'),
                    ),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('duplicate')
                        ->label('Duplicate')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('info')
                        ->action(function ($record) {
                            $newProject = $record->replicate();
                            $newProject->name = $record->name . ' (Copy)';
                            $newProject->status = ProjectStatusEnum::Planning;
                            $newProject->progress = 0;
                            $newProject->completed_at = null;
                            $newProject->archived_at = null;
                            $newProject->save();

                            \Filament\Notifications\Notification::make()
                                ->title('Project duplicated successfully')
                                ->success()
                                ->send();
                        }),
                    Action::make('archive')
                        ->label('Archive')
                        ->icon('heroicon-o-archive-box')
                        ->color('warning')
                        ->visible(fn ($record) => $record->status !== ProjectStatusEnum::Archived)
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->archive();

                            \Filament\Notifications\Notification::make()
                                ->title('Project archived successfully')
                                ->success()
                                ->send();
                        }),
                    Action::make('restore')
                        ->label('Restore')
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->color('success')
                        ->visible(fn ($record) => $record->status === ProjectStatusEnum::Archived)
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->restore();

                            \Filament\Notifications\Notification::make()
                                ->title('Project restored successfully')
                                ->success()
                                ->send();
                        }),
                    Action::make('complete')
                        ->label('Mark Complete')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn ($record) => $record->status !== ProjectStatusEnum::Completed)
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->markAsCompleted();

                            \Filament\Notifications\Notification::make()
                                ->title('Project marked as completed')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('archive_selected')
                        ->label('Archive Selected')
                        ->icon('heroicon-o-archive-box')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each->archive();

                            \Filament\Notifications\Notification::make()
                                ->title('Selected projects archived successfully')
                                ->success()
                                ->send();
                        }),
                    BulkAction::make('complete_selected')
                        ->label('Mark Complete')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each->markAsCompleted();

                            \Filament\Notifications\Notification::make()
                                ->title('Selected projects marked as completed')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }
}

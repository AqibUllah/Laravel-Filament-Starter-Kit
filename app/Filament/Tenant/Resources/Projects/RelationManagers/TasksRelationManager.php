<?php

namespace App\Filament\Tenant\Resources\Projects\RelationManagers;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatusEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    protected static ?string $title = 'Project Tasks';

    protected static ?string $modelLabel = 'Task';

    protected static ?string $pluralModelLabel = 'Tasks';

    public function form(Schema $schema): Schema
    {
        $currentTeam = Filament::getTenant();

        return $schema
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\Select::make('assigned_to')
                    ->label('Assign To')
                    ->options($currentTeam->members()->pluck('name', 'user_id'))
                    ->searchable()
                    ->required(),

                Forms\Components\DatePicker::make('due_date')
                    ->minDate(now()),

                Forms\Components\Select::make('priority')
                    ->options(PriorityEnum::class)
                    ->default(PriorityEnum::Medium),

                Forms\Components\Select::make('status')
                    ->options(TaskStatusEnum::class)
                    ->default(TaskStatusEnum::Pending),

                Forms\Components\TextInput::make('estimated_hours')
                    ->numeric()
                    ->suffix('hours')
                    ->step(0.5)
                    ->minValue(0),

                Forms\Components\TagsInput::make('tags')
                    ->placeholder('Add tags...'),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (TaskStatusEnum $state): string => $state->getColor())
                    ->icon(fn (TaskStatusEnum $state) => $state->getIcon())
                    ->sortable(),

                Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->color(fn (PriorityEnum $state): string => $state->getColor())
                    ->icon(fn (PriorityEnum $state) => $state->getIcon())
                    ->sortable(),

                Tables\Columns\TextColumn::make('assignee.name')
                    ->label('Assigned To')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('due_date')
                    ->date('M j, Y')
                    ->sortable()
                    ->color(fn ($record) => $record->isOverdue() ? 'danger' : null),

                Tables\Columns\TextColumn::make('estimated_hours')
                    ->suffix('h')
                    ->sortable(),

                Tables\Columns\TextColumn::make('actual_hours')
                    ->suffix('h')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(TaskStatusEnum::class)
                    ->multiple(),

                Tables\Filters\SelectFilter::make('priority')
                    ->options(PriorityEnum::class)
                    ->multiple(),

                Tables\Filters\SelectFilter::make('assigned_to')
                    ->label('Assigned To')
                    ->relationship('assignee', 'name')
                    ->searchable(),

                Tables\Filters\Filter::make('overdue')
                    ->query(fn (Builder $query): Builder => $query->overdue())
                    ->toggle(),

                Tables\Filters\TernaryFilter::make('trashed')
                    ->baseQuery(fn (Builder $query) => $query->withoutGlobalScopes([
                        SoftDeletingScope::class,
                    ])),
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['assigned_by'] = auth()->id();
                        $data['team_id'] = Filament::getTenant()->id;

                        return $data;
                    }),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
                Action::make('complete')
                    ->label('Complete')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status !== TaskStatusEnum::Completed)
                    ->action(function ($record) {
                        $record->markAsCompleted();

                        Notification::make()
                            ->title('Task marked as completed')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]))
            ->defaultSort('created_at', 'desc');
    }
}

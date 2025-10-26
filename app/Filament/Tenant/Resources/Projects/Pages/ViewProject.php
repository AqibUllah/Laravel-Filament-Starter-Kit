<?php

namespace App\Filament\Tenant\Resources\Projects\Pages;

use App\Enums\ProjectStatusEnum;
use App\Filament\Tenant\Resources\Projects\ProjectResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use \Filament\Schemas\Components\Section;
use \Filament\Schemas\Components\Grid;

class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Action::make('duplicate')
                ->label('Duplicate Project')
                ->icon('heroicon-o-document-duplicate')
                ->color('info')
                ->action(function () {
                    $newProject = $this->record->replicate();
                    $newProject->name = $this->record->name . ' (Copy)';
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
                ->visible(fn () => $this->record->status !== ProjectStatusEnum::Archived)
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->archive();

                    \Filament\Notifications\Notification::make()
                        ->title('Project archived successfully')
                        ->success()
                        ->send();
                }),
            Action::make('restore')
                ->label('Restore')
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('success')
                ->visible(fn () => $this->record->status === ProjectStatusEnum::Archived)
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->restore();

                    \Filament\Notifications\Notification::make()
                        ->title('Project restored successfully')
                        ->success()
                        ->send();
                }),
            Action::make('complete')
                ->label('Mark Complete')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => $this->record->status !== ProjectStatusEnum::Completed)
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->markAsCompleted();

                    \Filament\Notifications\Notification::make()
                        ->title('Project marked as completed')
                        ->success()
                        ->send();
                }),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Project Overview')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Project Name')
                                    ->weight(FontWeight::Bold)
                                    ->size('lg'),

                                TextEntry::make('status')
                                    ->badge()
                                    ->color(fn ($state) => $state->getColor())
                                    ->icon(fn ($state) => $state->getIcon()),

                                TextEntry::make('priority')
                                    ->badge()
                                    ->color(fn ($state) => $state->getColor())
                                    ->icon(fn ($state) => $state->getIcon()),
                            ]),

                        TextEntry::make('description')
                            ->label('Description')
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Section::make('Project Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('projectManager.name')
                                    ->label('Project Manager')
                                    ->placeholder('Unassigned'),

                                TextEntry::make('progress')
                                    ->label('Progress')
                                    ->suffix('%')
                                    ->color(fn ($state) => match (true) {
                                        $state >= 100 => 'success',
                                        $state >= 75 => 'info',
                                        $state >= 50 => 'warning',
                                        default => 'danger',
                                    }),

                                TextEntry::make('start_date')
                                    ->label('Start Date')
                                    ->date('M j, Y'),

                                TextEntry::make('due_date')
                                    ->label('Due Date')
                                    ->date('M j, Y')
                                    ->color(fn ($record) => $record->is_overdue ? 'danger' : null),

                                TextEntry::make('budget')
                                    ->label('Budget')
                                    ->money('USD')
                                    ->placeholder('Not set'),

                                TextEntry::make('estimated_hours')
                                    ->label('Estimated Hours')
                                    ->suffix(' hours')
                                    ->placeholder('Not set'),
                            ]),
                    ]),

                Section::make('Client Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('client_name')
                                    ->label('Client Name')
                                    ->placeholder('Not provided'),

                                TextEntry::make('client_email')
                                    ->label('Client Email')
                                    ->placeholder('Not provided'),

                                TextEntry::make('client_phone')
                                    ->label('Client Phone')
                                    ->placeholder('Not provided'),
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Project Statistics')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('tasks_count')
                                    ->label('Total Tasks')
                                    ->state(fn ($record) => $record->tasks()->count())
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('completed_tasks_count')
                                    ->label('Completed Tasks')
                                    ->state(fn ($record) => $record->tasks()->completed()->count())
                                    ->badge()
                                    ->color('success'),

                                TextEntry::make('users_count')
                                    ->label('Team Members')
                                    ->state(fn ($record) => $record->users()->count())
                                    ->badge()
                                    ->color('warning'),

                                TextEntry::make('duration')
                                    ->label('Duration')
                                    ->state(fn ($record) => $record->duration ? $record->duration . ' days' : 'Not set')
                                    ->placeholder('Not set'),
                            ]),
                    ]),

                Section::make('Additional Information')
                    ->schema([
                        TextEntry::make('tags')
                            ->label('Tags')
                            ->badge()
                            ->placeholder('No tags'),

                        TextEntry::make('notes')
                            ->label('Notes')
                            ->placeholder('No notes'),

                        TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime('M j, Y g:i A'),

                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime('M j, Y g:i A'),
                    ])
                    ->collapsible(),
            ]);
    }
}

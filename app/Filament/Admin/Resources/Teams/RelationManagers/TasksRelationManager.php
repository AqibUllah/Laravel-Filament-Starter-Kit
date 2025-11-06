<?php

namespace App\Filament\Admin\Resources\Teams\RelationManagers;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatusEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    protected static ?string $title = 'Tasks';

    protected static ?string $modelLabel = 'Task';

    protected static ?string $pluralModelLabel = 'Tasks';

    protected static bool $shouldSkipAuthorization = true;

    //    public function authorize(): bool
    //    {
    //        return true; // Allow admins to view all tasks
    //    }

    protected function modifyQueryUsingForRecord($query): void
    {
        parent::modifyQueryUsingForRecord($query);

        // Remove any global scopes for admin view
        $query->withoutGlobalScopes();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Task Information')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        RichEditor::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Select::make('priority')
                            ->options([
                                'high' => 'High',
                                'medium' => 'Medium',
                                'low' => 'Low',
                            ])
                            ->required(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'in_progress' => 'In Progress',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Assignment')
                    ->schema([
                        Select::make('assigned_to')
                            ->relationship('assignee', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('assigned_by')
                            ->relationship('assigner', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('project_id')
                            ->relationship('project', 'name')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(3),

                Section::make('Timeline & Hours')
                    ->schema([
                        DatePicker::make('due_date')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        TextInput::make('estimated_hours')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('actual_hours')
                            ->numeric()
                            ->minValue(0),
                        DatePicker::make('completed_at')
                            ->label('Completed At')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                    ])
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->limit(50),
                TextColumn::make('project.name')
                    ->label('Project')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (TaskStatusEnum $state): string => $state->getColor()),
                TextColumn::make('priority')
                    ->badge()
                    ->color(fn (PriorityEnum $state): string => $state->getColor()),
                TextColumn::make('assignee.name')
                    ->label('Assigned To')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('due_date')
                    ->date('M j, Y')
                    ->sortable(),
                TextColumn::make('completed_at')
                    ->date('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->emptyStateHeading('No tasks')
            ->emptyStateDescription('This team has no tasks yet.')
            ->emptyStateIcon('heroicon-o-clipboard-document-check');
    }
}

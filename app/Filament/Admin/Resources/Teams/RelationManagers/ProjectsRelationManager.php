<?php

namespace App\Filament\Admin\Resources\Teams\RelationManagers;

use App\Enums\PriorityEnum;
use App\Enums\ProjectStatusEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';

    protected static ?string $title = 'Projects';

    protected static ?string $modelLabel = 'Project';

    protected static ?string $pluralModelLabel = 'Projects';

    protected static bool $shouldSkipAuthorization = true;

    //    public function authorize(): bool
    //    {
    //        return true; // Allow admins to view all projects
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
                Section::make('Project Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        RichEditor::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Select::make('status')
                            ->options([
                                'planning' => 'Planning',
                                'in_progress' => 'In Progress',
                                'on_hold' => 'On Hold',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                                'archived' => 'Archived',
                            ])
                            ->required(),
                        Select::make('priority')
                            ->options([
                                'high' => 'High',
                                'medium' => 'Medium',
                                'low' => 'Low',
                            ]),
                    ])
                    ->columns(2),

                Section::make('Timeline')
                    ->schema([
                        DatePicker::make('start_date')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        DatePicker::make('due_date')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        TextInput::make('progress')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%'),
                    ])
                    ->columns(3),

                Section::make('Budget & Hours')
                    ->schema([
                        TextInput::make('budget')
                            ->numeric()
                            ->prefix('$'),
                        TextInput::make('estimated_hours')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('actual_hours')
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->columns(3),

                Section::make('Client Information')
                    ->schema([
                        TextInput::make('client_name')
                            ->maxLength(255),
                        TextInput::make('client_email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('client_phone')
                            ->tel()
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (ProjectStatusEnum $state) => $state->getColor()),
                TextColumn::make('priority')
                    ->badge()
                    ->color(fn (PriorityEnum $state): string => $state->getColor()),
                TextColumn::make('due_date')
                    ->date('M j, Y')
                    ->sortable(),
                TextColumn::make('progress')
                    ->label('Progress')
                    ->formatStateUsing(fn ($state) => $state.'%')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 100 => 'success',
                        $state >= 50 => 'warning',
                        default => 'danger',
                    }),
                TextColumn::make('budget')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->date('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->emptyStateHeading('No projects')
            ->emptyStateDescription('This team has no projects yet.')
            ->emptyStateIcon('heroicon-o-folder');
    }
}

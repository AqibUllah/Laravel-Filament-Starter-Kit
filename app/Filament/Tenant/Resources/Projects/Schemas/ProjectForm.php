<?php

namespace App\Filament\Tenant\Resources\Projects\Schemas;

use App\Enums\PriorityEnum;
use App\Enums\ProjectStatusEnum;
use App\Settings\TenantGeneralSettings;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        $currentTeam = Filament::getTenant();
        $settings = new TenantGeneralSettings;

        return $schema
            ->components([
                Section::make('Project Information')
                    ->description('Basic project details and settings')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->label('URL Slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull()
                            ->helperText('Used in project URLs. Leave empty to auto-generate from name.'),

                        RichEditor::make('description')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'blockquote',
                            ]),

                        Select::make('status')
                            ->options(ProjectStatusEnum::class)
                            ->default($settings->project_default_status ?? ProjectStatusEnum::Planning)
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === ProjectStatusEnum::Completed->value) {
                                    $set('progress', 100);
                                }
                            }),

                        Select::make('priority')
                            ->options(PriorityEnum::class)
                            ->default($settings->project_default_priority ?? PriorityEnum::Medium)
                            ->required(),

                        TextInput::make('progress')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state >= 100) {
                                    $set('status', ProjectStatusEnum::Completed->value);
                                }
                            }),
                    ])->columns(3),

                Section::make('Timeline & Budget')
                    ->description('Project schedule and financial information')
                    ->schema([
                        DatePicker::make('start_date')
                            ->required()
                            ->default(now())
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $dueDate = $get('due_date');
                                if ($state && $dueDate && $state > $dueDate) {
                                    $set('due_date', $state);
                                }
                            }),

                        DatePicker::make('due_date')
                            ->required()
                            ->afterOrEqual('start_date')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $startDate = $get('start_date');
                                if ($state && $startDate && $state < $startDate) {
                                    $set('start_date', $state);
                                }
                            }),

                        TextInput::make('budget')
                            ->numeric()
                            ->prefix('$')
                            ->step(0.01)
                            ->minValue(0)
                            ->helperText('Total project budget'),

                        TextInput::make('estimated_hours')
                            ->numeric()
                            ->suffix('hours')
                            ->step(0.5)
                            ->minValue(0)
                            ->helperText('Estimated total hours for the project'),

                        TextInput::make('actual_hours')
                            ->numeric()
                            ->suffix('hours')
                            ->step(0.5)
                            ->minValue(0)
                            ->helperText('Actual hours spent on the project'),
                    ])->columns(2),

                Section::make('Team & Assignment')
                    ->description('Project team members and management')
                    ->schema([
                        Select::make('project_manager_id')
                            ->label('Project Manager')
                            ->options($currentTeam->members()->pluck('name', 'user_id'))
                            ->searchable()
                            ->preload()
                            ->default(auth()->id())
                            ->required(),

                        Select::make('users')
                            ->label('Team Members')
                            ->multiple()
                            ->relationship('users', 'name')
                            ->preload()
                            ->searchable()
                            ->helperText('Select team members to assign to this project'),

                        Placeholder::make('team_info')
                            ->content('This project belongs to: '.$currentTeam->name)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Client Information')
                    ->description('Client details for this project')
                    ->collapsible()
                    ->schema([
                        TextInput::make('client_name')
                            ->maxLength(255)
                            ->helperText('Client or company name'),

                        TextInput::make('client_email')
                            ->email()
                            ->maxLength(255)
                            ->helperText('Primary client contact email'),

                        TextInput::make('client_phone')
                            ->tel()
                            ->maxLength(20)
                            ->helperText('Primary client contact phone'),
                    ])->columns(2),

                Section::make('Additional Details')
                    ->description('Tags, notes, and other project metadata')
                    ->collapsible()
                    ->schema([
                        TagsInput::make('tags')
                            ->placeholder('Add tags...')
                            ->helperText('Add relevant tags to categorize this project'),

                        Textarea::make('notes')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Internal notes and additional information'),

                        FileUpload::make('attachments')
                            ->multiple()
                            ->acceptedFileTypes(['application/pdf', 'image/*', 'text/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxFiles(10)
                            ->maxSize(10240) // 10MB
                            ->directory('project-attachments')
                            ->columnSpanFull()
                            ->helperText('Upload project documents and files (max 10MB each)'),
                    ]),

                Hidden::make('team_id')
                    ->default(fn () => $currentTeam->id),
            ]);
    }
}

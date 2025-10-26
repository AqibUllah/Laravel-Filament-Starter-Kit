<?php

namespace App\Filament\Tenant\Resources\Tasks\Schemas;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Project;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {

//        $currentTeam = \Auth::user()->currentTeam;

        $currentTeam = Filament::getTenant();

        return $schema
            ->components([
                Section::make('Task Details')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        Select::make('project')
                            ->label('Project')
                            ->relationship('Project', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Select a project'),
                        Select::make('assigned_to')
                            ->label('Assign To')
                            ->options($currentTeam->members()->pluck('name', 'user_id'))
                            ->searchable()
                            ->required(),
                        DatePicker::make('due_date')
                            ->minDate(now()),
                        Select::make('priority')
                            ->options(PriorityEnum::class)
                            ->default('medium'),
                        Select::make('status')
                            ->options(TaskStatusEnum::class)
                            ->default('pending'),
                    ])->columns(2),

                Section::make('Time Tracking')
                    ->schema([
                        TextInput::make('estimated_hours')
                            ->numeric()
                            ->minValue(0)
                            ->step(0.5)
                            ->suffix('hours'),
                        TextInput::make('actual_hours')
                            ->numeric()
                            ->minValue(0)
                            ->step(0.5)
                            ->suffix('hours')
                            ->disabled(fn ($context) => $context === 'create')
                            ->hint(fn ($record) => $record ? "Estimated: {$record->estimated_hours} hours" : ''),
                        Placeholder::make('time_difference')
                            ->label('Time Difference')
                            ->content(function ($record) {
                                if (!$record || !$record->estimated_hours || !$record->actual_hours) {
                                    return 'N/A';
                                }
                                $difference = $record->actual_hours - $record->estimated_hours;
                                $color = $difference <= 0 ? 'text-success-600' : 'text-danger-600';
                                $sign = $difference > 0 ? '+' : '';
                                return "<span class='{$color}'>{$sign}{$difference} hours</span>";
                            })
                            ->visible(fn ($record) => $record && $record->estimated_hours && $record->actual_hours)
                            ->html(),
                        TagsInput::make('tags')
                            ->placeholder('Add tags')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }


}

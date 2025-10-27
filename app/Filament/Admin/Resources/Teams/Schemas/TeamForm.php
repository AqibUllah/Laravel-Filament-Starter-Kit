<?php

namespace App\Filament\Admin\Resources\Teams\Schemas;

use App\Models\Plan;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Team Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignorable: fn ($record) => $record),
                        Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        TextInput::make('domain')
                            ->url()
                            ->columnSpanFull()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Team Owner & Plan')
                    ->schema([
                        Select::make('owner_id')
                            ->label('Owner')
                            ->relationship('owner', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('current_plan_id')
                            ->label('Current Plan')
                            ->relationship('currentPlan', 'name')
                            ->searchable()
                            ->preload(),
                        Toggle::make('status')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Toggle to activate or deactivate this tenant'),
                    ])
                    ->columns(1),
            ]);
    }
}

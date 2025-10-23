<?php

namespace App\Filament\Admin\Resources\PLans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PLanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Plan Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        TextInput::make('price')
                            ->numeric()
                            ->prefix('$')
                            ->required(),
                        Select::make('interval')
                            ->options([
                                'weekly' => 'Weekly',
                                'month' => 'Monthly',
                                'year' => 'Yearly',
                            ])
                            ->required(),
                        TextInput::make('trial_days')
                            ->numeric()
                            ->default(0),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),

                Section::make('Stripe Configuration')
                    ->schema([
                        TextInput::make('stripe_product_id')
                            ->maxLength(255),
                        TextInput::make('stripe_price_id')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Status')
                    ->schema([
                        Toggle::make('is_active')
                            ->default(true),
                        Toggle::make('is_featured')
                            ->default(false),
                    ])
                    ->columns(2),
            ]);
    }
}

<?php

namespace App\Filament\Admin\Resources\Usages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UsageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('team_id')
                    ->relationship('team', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('subscription_id')
                    ->relationship('subscription', 'id')
                    ->searchable()
                    ->preload(),

                Select::make('plan_feature_id')
                    ->relationship('planFeature', 'name')
                    ->distinct()
                    ->searchable()
                    ->preload(),

                TextInput::make('metric_name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., api_calls, storage_gb'),

                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->step(0.0001)
                    ->prefix('Qty:'),

                TextInput::make('unit_price')
                    ->required()
                    ->numeric()
                    ->step(0.0001)
                    ->prefix('$'),

                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->step(0.01)
                    ->prefix('$'),

                DateTimePicker::make('billing_period_start')
                    ->required(),

                DateTimePicker::make('billing_period_end')
                    ->required(),

                DateTimePicker::make('recorded_at')
                    ->required(),

                KeyValue::make('metadata')
                    ->keyLabel('Key')
                    ->valueLabel('Value'),
            ]);
    }
}

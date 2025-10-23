<?php

namespace App\Filament\Tenant\Resources\Subscriptions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('team_id')
                    ->relationship('team', 'name')
                    ->required(),
                Select::make('plan_id')
                    ->relationship('plan', 'name')
                    ->required(),
                TextInput::make('stripe_subscription_id')
                    ->maxLength(255),
                TextInput::make('stripe_customer_id')
                    ->maxLength(255),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'canceled' => 'Canceled',
                        'past_due' => 'Past Due',
                        'unpaid' => 'Unpaid',
                        'incomplete' => 'Incomplete',
                    ])
                    ->required(),
                DateTimePicker::make('trial_ends_at'),
                DateTimePicker::make('ends_at'),
                DateTimePicker::make('canceled_at'),
            ]);
    }
}

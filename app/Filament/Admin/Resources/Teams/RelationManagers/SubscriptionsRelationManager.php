<?php

namespace App\Filament\Admin\Resources\Teams\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions';

    protected static ?string $title = 'Subscriptions History';

    protected static ?string $modelLabel = 'Subscription';

    protected static ?string $pluralModelLabel = 'Subscriptions';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Subscription Details')
                    ->schema([
                        Select::make('plan_id')
                            ->relationship('plan', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'canceled' => 'Canceled',
                                'past_due' => 'Past Due',
                                'trial' => 'Trial',
                            ])
                            ->required(),
                        TextInput::make('stripe_subscription_id')
                            ->label('Stripe Subscription ID')
                            ->maxLength(255),
                        TextInput::make('stripe_customer_id')
                            ->label('Stripe Customer ID')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Billing Information')
                    ->schema([
                        TextInput::make('discount_amount')
                            ->numeric()
                            ->prefix('$'),
                        TextInput::make('final_amount')
                            ->numeric()
                            ->prefix('$'),
                        DatePicker::make('trial_ends_at')
                            ->label('Trial Ends At')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        DatePicker::make('ends_at')
                            ->label('Ends At')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        DatePicker::make('canceled_at')
                            ->label('Canceled At')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                    ])
                    ->columns(2),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('plan.name')
            ->columns([
                TextColumn::make('plan.name')
                    ->label('Plan')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'Free' => 'gray',
                        'Pro' => 'primary',
                        'Enterprise' => 'success',
                        default => 'info',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'canceled' => 'danger',
                        'past_due' => 'warning',
                        'trial' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('final_amount')
                    ->label('Amount')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('trial_ends_at')
                    ->label('Trial Ends')
                    ->date('M j, Y')
                    ->sortable(),
                TextColumn::make('ends_at')
                    ->label('Ends At')
                    ->date('M j, Y')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->date('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->emptyStateHeading('No subscriptions')
            ->emptyStateDescription('This team has no subscription history.')
            ->emptyStateIcon('heroicon-o-credit-card');
    }
}

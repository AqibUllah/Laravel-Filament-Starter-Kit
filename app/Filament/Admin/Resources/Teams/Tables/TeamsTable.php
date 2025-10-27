<?php

namespace App\Filament\Admin\Resources\Teams\Tables;

use App\Filament\Admin\Resources\Teams\TeamResource;
use App\Models\Team;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TeamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                return $query->with(['owner', 'currentPlan', 'subscriptions']);
            })
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                TextColumn::make('owner.name')
                    ->label('Owner')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('currentPlan.name')
                    ->label('Current Plan')
                    ->badge()
                    ->color(fn (?string $state): string => match($state) {
                        'Free' => 'gray',
                        'Pro' => 'primary',
                        'Enterprise' => 'success',
                        default => 'info',
                    }),
                TextColumn::make('latest_subscription_status')
                    ->label('Subscription Status')
                    ->badge()
                    ->getStateUsing(function (Team $record): string {
                        $latestSubscription = $record->subscriptions()->latest()->first();
                        return $latestSubscription?->status ?? 'none';
                    })
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'active' => 'Active',
                        'canceled' => 'Canceled',
                        'past_due' => 'Past Due',
                        'trial' => 'Trial',
                        'none' => 'No subscription',
                        default => 'Unknown',
                    })
                    ->color(fn (string $state): string => match($state) {
                        'active' => 'success',
                        'canceled' => 'danger',
                        'past_due' => 'warning',
                        'trial' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('members_count')
                    ->label('Members')
                    ->counts('members')
                    ->sortable(),
                TextColumn::make('projects_count')
                    ->label('Projects')
                    ->counts('projects')
                    ->sortable(),
                TextColumn::make('tasks_count')
                    ->label('Tasks')
                    ->counts('tasks')
                    ->sortable(),
                IconColumn::make('status')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('has_active_subscription')
                    ->label('Has Active Subscription')
                    ->query(fn ($query) => $query->whereHas('subscriptions', fn ($q) => $q->where('status', 'active'))),
                Filter::make('has_no_active_subscription')
                    ->label('No Active Subscription')
                    ->query(fn ($query) => $query->doesntHave('subscriptions', fn ($q) => $q->where('status', 'active'))),
                Filter::make('is_active')
                    ->label('Active Tenants')
                    ->query(fn ($query) => $query->where('status', true)),
                SelectFilter::make('currentPlan')
                    ->label('Plan')
                    ->relationship('currentPlan', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}

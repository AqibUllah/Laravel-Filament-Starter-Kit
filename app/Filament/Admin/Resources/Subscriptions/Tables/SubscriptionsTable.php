<?php

namespace App\Filament\Admin\Resources\Subscriptions\Tables;

use App\Enums\TaskStatusEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SubscriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('team.name')
                    ->searchable(),
               TextColumn::make('plan.name')
                    ->searchable(),
               TextColumn::make('status')
                    ->badge()
                    ->color(TaskStatusEnum::class),
               TextColumn::make('trial_ends_at')
                    ->dateTime()
                    ->sortable(),
               TextColumn::make('ends_at')
                    ->dateTime()
                    ->sortable(),
               TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'canceled' => 'Canceled',
                        'past_due' => 'Past Due',
                    ]),
                SelectFilter::make('plan')
                    ->relationship('plan', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
//                ViewAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

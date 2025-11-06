<?php

namespace App\Filament\Admin\Resources\Coupons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CouponsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'percentage' => 'success',
                        'fixed' => 'info',
                    }),

                TextColumn::make('value')
                    ->formatStateUsing(fn ($record) => $record->getFormattedDiscount())
                    ->sortable(),

                TextColumn::make('used_count')
                    ->label('Used')
                    ->sortable()
                    ->formatStateUsing(fn ($record, $state) => $record->usage_limit
                            ? "{$state}/{$record->usage_limit}"
                            : $state
                    ),

                TextColumn::make('valid_until')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Never expires')
                    ->color(fn ($record) => $record->valid_until && $record->valid_until->isPast()
                            ? 'danger'
                            : null
                    ),

                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'percentage' => 'Percentage Discount',
                        'fixed' => 'Fixed Amount Discount',
                    ]),

                SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

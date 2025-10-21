<?php

namespace App\Filament\Resources\PLans\Tables;

use App\Filament\Resources\PlanFeatures\PlanFeatureResource;
use App\Models\Plan;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class PLansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('interval')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'weekly' => 'primary',
                        'month' => 'info',
                        'year' => 'success',
                    }),
                IconColumn::make('is_active')
                    ->boolean(),
                IconColumn::make('is_featured')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('is_active')
                    ->query(fn ($query) => $query->where('is_active', true)),
                Filter::make('is_featured')
                    ->query(fn ($query) => $query->where('is_featured', true)),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('features')
                    ->url(fn (Plan $record) => PlanFeatureResource::getUrl('index', ['plan_id' => $record->id])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

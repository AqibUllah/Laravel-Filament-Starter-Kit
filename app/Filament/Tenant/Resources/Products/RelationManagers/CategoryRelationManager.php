<?php

namespace App\Filament\Tenant\Resources\Products\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
class CategoryRelationManager extends RelationManager
{
    protected static string $relationship = 'category';

    protected static ?string $title = 'Category';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('products_count')
                    ->label('Products Count')
                    ->getStateUsing(fn ($record) => $record->products()->count())
                    ->badge(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->headerActions([
                AssociateAction::make()
                    ->recordSelectSearchColumns(['name', 'slug'])
                    ->preloadRecordSelect(),
            ])
            ->actions([
                ViewAction::make(),
                DissociateAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                ]),
            ]);
    }
}

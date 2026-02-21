<?php

namespace App\Filament\Tenant\Resources\OrderResource\RelationManagers;

use App\Models\OrderItem;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'product_name';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $product = \App\Models\Product::find($state);
                            if ($product) {
                                $set('product_name', $product->name);
                                $set('product_price', $product->getCurrentPrice());
                                $set('total_price', $product->getCurrentPrice());
                            }
                        }
                    }),
                TextInput::make('product_name')
                    ->required()
                    ->maxLength(255)
                    ->readOnly(),
                TextInput::make('product_price')
                    ->label('Unit Price')
                    ->required()
                    ->numeric()
                    ->step(0.01)
                    ->prefix('$')
                    ->live()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $quantity = $get('quantity') ?? 1;
                        $total = $state * $quantity;
                        $set('total_price', $total);
                    }),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->live()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $price = $get('product_price') ?? 0;
                        $total = $state * $price;
                        $set('total_price', $total);
                    }),
                TextInput::make('total_price')
                    ->label('Total Price')
                    ->required()
                    ->numeric()
                    ->step(0.01)
                    ->prefix('$')
                    ->readOnly(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_name')
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product_name')
                    ->label('Product Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_price')
                    ->label('Unit Price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

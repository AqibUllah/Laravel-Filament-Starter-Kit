<?php

namespace App\Filament\Tenant\Resources\Products\Schemas;

use App\Enums\BlogStatusEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Product Information')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Textarea::make('description')
                        ->rows(3)
                        ->columnSpanFull(),
                    TextInput::make('sku')
                        ->label('SKU')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                ])
                ->columns(2),

            Section::make('Pricing')
                ->schema([
                    TextInput::make('price')
                        ->label('Regular Price')
                        ->required()
                        ->numeric()
                        ->prefix('$')
                        ->step(0.01),
                    TextInput::make('sale_price')
                        ->label('Sale Price')
                        ->numeric()
                        ->prefix('$')
                        ->step(0.01),
                    TextInput::make('cost_price')
                        ->label('Cost Price')
                        ->numeric()
                        ->prefix('$')
                        ->step(0.01),
                ])
                ->columns(3),

            Section::make('Inventory')
                ->schema([
                    TextInput::make('quantity')
                        ->required()
                        ->numeric()
                        ->default(0),
                    TextInput::make('min_stock_level')
                        ->label('Min Stock Level')
                        ->numeric()
                        ->default(0),
                    TextInput::make('max_stock_level')
                        ->label('Max Stock Level')
                        ->numeric()
                        ->nullable(),
                ])
                ->columns(3),

            Section::make('Physical Attributes')
                ->schema([
                    TextInput::make('weight')
                        ->numeric()
                        ->step(0.01)
                        ->suffix('kg'),
                    KeyValue::make('dimensions')
                        ->label('Dimensions (L×W×H)')
                        ->keyLabel('Dimension')
                        ->valueLabel('Value')
                        ->addActionLabel('Add dimension'),
                ])
                ->columns(2),

            Section::make('Classification')
                ->schema([
                    Select::make('category_id')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('slug')
                                ->required()
                                ->maxLength(255),
                            Textarea::make('description')
                                ->rows(2),
                        ]),
                    Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),
                    Toggle::make('is_public')
                        ->label('Publish')
                        ->default(true),
                    Toggle::make('is_featured')
                        ->label('Featured')
                        ->default(false),
                ])
                ->columns(3),

            Section::make('SEO')
                ->schema([
                    TextInput::make('meta_title')
                        ->label('Meta Title')
                        ->maxLength(255),
                    Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->rows(2),
                ])
                ->columns(1),

            Section::make('Additional Information')
                ->schema([
                    Repeater::make('tags')
                        ->label('Tags')
//                        ->simple('tag')
                        ->schema([
                            TextInput::make('tag')
                                ->required(),
                        ])
                        ->columnSpanFull(),
                    KeyValue::make('attributes')
                        ->label('Product Attributes')
                        ->keyLabel('Attribute')
                        ->valueLabel('Value')
                        ->addActionLabel('Add attribute')
                        ->columnSpanFull(),
                ])
                ->columns(1),
        ]);
    }
}

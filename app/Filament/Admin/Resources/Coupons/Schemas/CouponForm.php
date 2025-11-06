<?php

namespace App\Filament\Admin\Resources\Coupons\Schemas;

use App\Models\Coupon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required()
                    ->unique(Coupon::class, 'code', ignoreRecord: true)
                    ->maxLength(255)
                    ->placeholder('e.g., SAVE20')
                    ->helperText('Unique coupon code that users will enter'),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., 20% Off Special')
                    ->helperText('Display name for the coupon'),

                Textarea::make('description')
                    ->maxLength(1000)
                    ->placeholder('Optional description of the coupon')
                    ->rows(3),

                Select::make('type')
                    ->required()
                    ->options([
                        'percentage' => 'Percentage Discount',
                        'fixed' => 'Fixed Amount Discount',
                    ])
                    ->default('percentage')
                    ->live()
                    ->helperText('Choose how the discount is calculated'),

                TextInput::make('value')
                    ->required()
                    ->numeric()
                    ->step(0.01)
                    ->prefix(fn ($get) => $get('type') === 'percentage' ? '' : '$')
                    ->suffix(fn ($get) => $get('type') === 'percentage' ? '%' : '')
                    ->placeholder(fn ($get) => $get('type') === 'percentage' ? '20' : '10.00')
                    ->helperText(fn ($get) => $get('type') === 'percentage' ? 'Discount percentage (e.g., 20 for 20%)' : 'Fixed discount amount in dollars'),

                TextInput::make('minimum_amount')
                    ->numeric()
                    ->step(0.01)
                    ->prefix('$')
                    ->placeholder('0.00')
                    ->helperText('Minimum order amount required to use this coupon'),

                TextInput::make('maximum_discount')
                    ->numeric()
                    ->step(0.01)
                    ->prefix('$')
                    ->placeholder('No limit')
                    ->helperText('Maximum discount amount (useful for percentage coupons)'),

                TextInput::make('usage_limit')
                    ->numeric()
                    ->minValue(1)
                    ->placeholder('No limit')
                    ->helperText('Maximum number of times this coupon can be used'),

                DateTimePicker::make('valid_from')
                    ->placeholder('Immediately')
                    ->helperText('When the coupon becomes valid'),

                DateTimePicker::make('valid_until')
                    ->placeholder('Never expires')
                    ->helperText('When the coupon expires'),

                Toggle::make('is_active')
                    ->default(true)
                    ->helperText('Whether the coupon is currently active'),
            ]);
    }
}

<?php

namespace App\Filament\Tenant\Resources\Subscriptions;

use App\Filament\Tenant\Resources\Subscriptions\Pages\CreateSubscription;
use App\Filament\Tenant\Resources\Subscriptions\Pages\EditSubscription;
use App\Filament\Tenant\Resources\Subscriptions\Pages\ListSubscriptions;
use App\Filament\Tenant\Resources\Subscriptions\Schemas\SubscriptionForm;
use App\Filament\Tenant\Resources\Subscriptions\Tables\SubscriptionsTable;
use App\Models\Subscription;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ReceiptRefund;

    protected static string | UnitEnum | null $navigationGroup = 'Billing';

    public static function form(Schema $schema): Schema
    {
        return SubscriptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubscriptionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubscriptions::route('/'),
            'create' => CreateSubscription::route('/create'),
            'edit' => EditSubscription::route('/{record}/edit'),
//            'view' => Pages\ViewSubscription::route('/{record}'),
        ];
    }
}

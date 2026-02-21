<?php

namespace App\Filament\Tenant\Resources\Orders;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Filament\Tenant\Resources\Orders\Pages\CreateOrder;
use App\Filament\Tenant\Resources\Orders\Pages\EditOrder;
use App\Filament\Tenant\Resources\Orders\Pages\ListOrders;
use App\Filament\Tenant\Resources\OrderResource\RelationManagers\OrderItemsRelationManager;
use App\Models\Order;
use App\Services\InvoiceService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static string | BackedEnum | null $navigationIcon = Heroicon::ShoppingCart;
    protected static string|\UnitEnum|null $navigationGroup = 'Product Management';

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }

    protected static ?int $navigationSort = 3;

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Order Information')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        TextInput::make('order_number')
                            ->required()
                            ->readOnly()
                            ->default(function () {
                                $year = date('Y');
                                $sequence = \App\Models\Order::whereYear('created_at', $year)
                                    ->withTrashed()
                                    ->count() + 1;
                                return "ORD-{$year}-" . str_pad($sequence, 5, '0', STR_PAD_LEFT);
                            })
                            ->unique(ignoreRecord: true),
                        Select::make('payment_method')
                            ->options(PaymentMethod::class)
                            ->nullable()
                            ->default(null),
                        Select::make('payment_status')
                            ->options(PaymentStatus::class)
                            ->default(PaymentStatus::Pending)
                            ->required(),
                        Select::make('order_status')
                            ->options(OrderStatus::class)
                            ->default(OrderStatus::Pending)
                            ->required(),
                        TextInput::make('currency')
                            ->default(function () {
                                return \Filament\Facades\Filament::getTenant()?->currency ?? 'USD';
                            })
                            ->readOnly()
                            ->dehydrated(false)
                            ->hidden(),
                    ])
                    ->columns(2),

                Section::make('Amounts')
                    ->schema([
                        TextInput::make('subtotal_amount')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('$')
                            ->required(),
                        TextInput::make('tax_amount')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('$')
                            ->default(0),
                        TextInput::make('discount_amount')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('$')
                            ->default(0),
                        TextInput::make('total_amount')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('$')
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Addresses')
                    ->schema([
                        KeyValue::make('billing_address')
                            ->label('Billing Address')
                            ->columnSpanFull(),
                        KeyValue::make('shipping_address')
                            ->label('Shipping Address')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Section::make('Additional Information')
                    ->schema([
                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->formatStateUsing(fn (PaymentMethod $state): string => $state->getLabel())
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->badge()
                    ->color(fn (PaymentStatus $state): string => $state->getColor())
                    ->formatStateUsing(fn (PaymentStatus $state): string => $state->getLabel())
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_status')
                    ->label('Order Status')
                    ->badge()
                    ->color(fn (OrderStatus $state): string => $state->getColor())
                    ->formatStateUsing(fn (OrderStatus $state): string => $state->getLabel())
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('Transaction ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options(PaymentStatus::class),
                Tables\Filters\SelectFilter::make('order_status')
                    ->options(OrderStatus::class),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options(PaymentMethod::class),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('download_invoice')
                    ->label('Download Invoice')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function (Order $record, InvoiceService $invoiceService) {
                        $path = $invoiceService->generateInvoice($record);
                        $url = Storage::disk('public')->url($path);

                        return response()->download(Storage::disk('public')->path($path));
                    })
                    ->visible(fn (Order $record): bool => $record->isPaid()),
                Action::make('mark_as_shipped')
                    ->label('Mark as Shipped')
                    ->icon('heroicon-o-truck')
                    ->color('info')
                    ->action(function (Order $record) {
                        $record->markAsShipped();
                    })
                    ->visible(fn (Order $record): bool => $record->canBeShipped())
                    ->requiresConfirmation(),
                Action::make('cancel_order')
                    ->label('Cancel Order')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(function (Order $record) {
                        $record->cancel();
                    })
                    ->visible(fn (Order $record): bool => $record->canBeCancelled())
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::query()->count();
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

<?php

namespace App\Filament\Admin\Resources\Usages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;

class UsagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('team.name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('metric_name')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'api_calls' => 'info',
                        'storage_gb' => 'success',
                        'active_users' => 'warning',
                        'database_queries' => 'danger',
                        'email_sends' => 'primary',
                        default => 'gray',
                    }),

                TextColumn::make('quantity')
                    ->sortable()
                    ->numeric(decimalPlaces: 4)
                    ->alignEnd(),

                TextColumn::make('unit_price')
                    ->sortable()
                    ->money('USD')
                    ->alignEnd(),

                TextColumn::make('total_amount')
                    ->sortable()
                    ->money('USD')
                    ->alignEnd()
                    ->weight('bold'),

                TextColumn::make('billing_period_start')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('billing_period_end')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('recorded_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('team')
                    ->relationship('team', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('metric_name')
                    ->options([
                        'api_calls' => 'API Calls',
                        'storage_gb' => 'Storage Usage',
                        'active_users' => 'Active Users',
                        'database_queries' => 'Database Queries',
                        'email_sends' => 'Email Sends',
                    ]),

                Filter::make('billing_period')
                    ->form([
                        DatePicker::make('billing_period_start'),
                        DatePicker::make('billing_period_end'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['billing_period_start'],
                                fn (Builder $query, $date): Builder => $query->whereDate('billing_period_start', '>=', $date),
                            )
                            ->when(
                                $data['billing_period_end'],
                                fn (Builder $query, $date): Builder => $query->whereDate('billing_period_end', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

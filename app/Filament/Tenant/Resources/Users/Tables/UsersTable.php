<?php

namespace App\Filament\Tenant\Resources\Users\Tables;

use App\Helpers\FeatureLimitHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class UsersTable
{
    public static function configure(Table $table): Table
    {

        $team = Filament::getTenant();

        // Check plan limit
        $limit = $team->featureValue('Users', 0);
        $count = \DB::table('team_user')
            ->where('team_id', $team->id)
            ->distinct('user_id')
            ->count('user_id');
        $limitReached = $limit && $count >= $limit;

        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->circular()
                    ->getStateUsing(fn ($record) => $record->avatar ? Storage::disk('public')->url($record->avatar) : asset('images/default-user.webp')),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('phone'),
                ToggleColumn::make('is_active')
                    ->label('Active'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->contentFooter(fn () => FeatureLimitHelper::alertIfExceeded('Users', $count, route('filament.tenant.pages.plans', ['tenant' => filament()->getTenant()])));
    }
}

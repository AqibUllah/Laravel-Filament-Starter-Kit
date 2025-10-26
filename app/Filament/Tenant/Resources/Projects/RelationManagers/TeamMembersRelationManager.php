<?php

namespace App\Filament\Tenant\Resources\Projects\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class TeamMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $title = 'Team Members';

    protected static ?string $modelLabel = 'Member';

    protected static ?string $pluralModelLabel = 'Members';

    public function form(Schema $schema): Schema
    {
        $currentTeam = Filament::getTenant();

        return $schema
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Team Member')
                    ->options($currentTeam->members()->pluck('name', 'user_id'))
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('role')
                    ->options([
                        'member' => 'Member',
                        'lead' => 'Lead',
                        'admin' => 'Admin',
                    ])
                    ->default('member')
                    ->required(),

                Forms\Components\DatePicker::make('joined_at')
                    ->label('Joined Date')
                    ->default(now()),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pivot.role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'lead' => 'warning',
                        'member' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('pivot.joined_at')
                    ->label('Joined')
                    ->date('M j, Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('pivot.role')
                    ->label('Role')
                    ->options([
                        'member' => 'Member',
                        'lead' => 'Lead',
                        'admin' => 'Admin',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn (Forms\Components\Select $component): Forms\Components\Select => $component
                        ->options(Filament::getTenant()->members()->pluck('name', 'user_id'))
                        ->searchable()
                        ->preload()
                        ->required()
                    )
                    ->form([
                        Forms\Components\Select::make('role')
                            ->options([
                                'member' => 'Member',
                                'lead' => 'Lead',
                                'admin' => 'Admin',
                            ])
                            ->default('member')
                            ->required(),

                        Forms\Components\DatePicker::make('joined_at')
                            ->label('Joined Date')
                            ->default(now()),
                    ]),
            ])
            ->actions([
                DetachAction::make()
                    ->requiresConfirmation(),
                Action::make('update_role')
                    ->label('Update Role')
                    ->icon('heroicon-o-pencil')
                    ->form([
                        Forms\Components\Select::make('role')
                            ->options([
                                'member' => 'Member',
                                'lead' => 'Lead',
                                'admin' => 'Admin',
                            ])
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->pivot->update(['role' => $data['role']]);

                        \Filament\Notifications\Notification::make()
                            ->title('Role updated successfully')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
//            ->defaultSort('pivot.joined_at', 'desc')
            ->emptyStateHeading('No team members assigned')
            ->emptyStateDescription('Add team members to this project to get started.')
            ->emptyStateIcon('heroicon-o-users');
    }
}

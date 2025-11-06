<?php

namespace App\Filament\Admin\Resources\Teams\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    protected static ?string $title = 'Team Members';

    protected static ?string $modelLabel = 'Member';

    protected static ?string $pluralModelLabel = 'Members';

    protected static bool $shouldSkipAuthorization = true;

    //    public function authorize(): bool
    //    {
    //        return true; // Allow admins to view all team members
    //    }

    protected function modifyQueryUsingForRecord($query): void
    {
        parent::modifyQueryUsingForRecord($query);

        // Remove any global scopes for admin view
        $query->withoutGlobalScopes();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Team Membership')
                    ->schema([
                        Select::make('role')
                            ->options([
                                'owner' => 'Owner',
                                'admin' => 'Admin',
                                'super_admin' => 'Super Admin',
                                'member' => 'Member',
                            ])
                            ->default('member')
                            ->required(),
                        DatePicker::make('joined_at')
                            ->label('Joined Date')
                            ->default(now())
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                    ])
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('pivot.role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'owner' => 'danger',
                        'super_admin' => 'warning',
                        'admin' => 'info',
                        'member' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('pivot.created_at')
                    ->label('Joined')
                    ->date('M j, Y'),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
            ])
            ->filters([
                SelectFilter::make('pivot.role')
                    ->label('Role')
                    ->options([
                        'owner' => 'Owner',
                        'admin' => 'Admin',
                        'super_admin' => 'Super Admin',
                        'member' => 'Member',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->headerActions([
                AttachAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('update_role')
                    ->label('Update Role')
                    ->icon('heroicon-o-pencil')
                    ->form([
                        Select::make('role')
                            ->label('Role')
                            ->options([
                                'owner' => 'Owner',
                                'admin' => 'Admin',
                                'super_admin' => 'Super Admin',
                                'member' => 'Member',
                            ])
                            ->required(),
                    ])
                    ->action(function (Model $record, array $data) {
                        $record->pivot->update(['role' => $data['role']]);

                        \Filament\Notifications\Notification::make()
                            ->title('Role updated successfully')
                            ->success()
                            ->send();
                    }),
                DetachAction::make()
                    ->requiresConfirmation(),
                DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->requiresConfirmation(),
                    DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('No team members')
            ->emptyStateDescription('Add members to this team to get started.')
            ->emptyStateIcon('heroicon-o-users');
    }
}

<?php

namespace App\Filament\Tenant\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                RichEditor::make('bio')
                    ->label('Bio')
                    ->columnSpanFull(),
                TextInput::make('password')
                    ->password()
                    ->required(),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->saveRelationshipsUsing(function (Model $record, $state) {
                        $record->roles()->syncWithPivotValues($state, [config('permission.column_names.team_foreign_key') => getPermissionsTeamId()]);
                    })
                    ->multiple()
                    ->preload()
                    ->searchable(),
                TextInput::make('phone')
                    ->tel(),
                Toggle::make('is_active')
                    ->default(true),
                FileUpload::make('avatar')
                    ->maxSize(2048)
                    ->visibility('public')
                    ->disk('public')
                    ->directory('users')
                    ->uploadButtonPosition('center bottom')
                    ->uploadProgressIndicatorPosition('center bottom')
                    ->getUploadedFileNameForStorageUsing(
                        static fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                            ->prepend(auth()->user()->id . '_'),
                    )
                    ->avatar()
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp']),
            ]);
    }
}

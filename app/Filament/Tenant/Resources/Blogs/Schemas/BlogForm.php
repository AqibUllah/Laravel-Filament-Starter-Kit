<?php

namespace App\Filament\Tenant\Resources\Blogs\Schemas;

use App\Enums\BlogStatusEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->columnSpanFull()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    })
                    ->required(),

                Hidden::make('slug')
                    ->label('URL Slug')
                    ->unique(ignoreRecord: true)
                    ->helperText('Used in project URLs. Leave empty to auto-generate from name.'),

                FileUpload::make('featured_image')
                    ->directory('blogs')
                    ->image(),
                Textarea::make('excerpt')
                    ->rows(3)
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(BlogStatusEnum::class)
                    ->required()
                    ->live(),

                DateTimePicker::make('published_at')
                    ->label(fn($get) => $get('status') == BlogStatusEnum::Published ? 'Published at' : 'Scheduled at')
                    ->visible(fn ($get) =>
                        in_array($get('status'), [
                            BlogStatusEnum::Published,
                            BlogStatusEnum::Scheduled
                        ])
                    ),
            ]);
    }
}

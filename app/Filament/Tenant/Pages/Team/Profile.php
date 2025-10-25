<?php

namespace App\Filament\Tenant\Pages\Team;

use App\Models\Team;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Profile extends EditTenantProfile implements HasTable,HasSchemas
{
    use InteractsWithTable;
    use InteractsWithSchemas;

    protected string $view = 'filament.pages.team.profile';

    // current tenant/team instance
    public ?Team $team = null;


    public function mount(): void
    {
        parent::mount();

        // get current tenant (team) — adjust if you use other tenant helper
        $this->team = filament()->getTenant();
    }

    public function teamInfolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->team)
            ->components([
                Section::make('Team Information')
                    ->schema([
                        Split::make([
                            Grid::make()
                                ->schema([
                                    TextEntry::make('name')
                                        ->size('lg')
                                        ->weight('bold'),
                                    TextEntry::make('description')
                                        ->size('sm')
                                        ->color('gray'),
                                ]),
                        ]),
                    ]),

                Section::make('Team Members')
                    ->description('All members of this team')
                    ->schema([
                        Grid::make()
                            ->schema([
                                RepeatableEntry::make('members')
                                    ->schema([
                                        // Custom card design for team members
                                                Split::make([
                                                    Grid::make(1)
                                                        ->schema([
                                                            TextEntry::make('name')
                                                                ->weight('bold')
                                                                ->size('sm'),
                                                            TextEntry::make('email')
                                                                ->size('xs')
                                                                ->color('gray')
                                                                ->icon('heroicon-m-envelope'),
                                                        ]),
                                                ])
                                            ->extraAttributes([
                                                'class' => 'hover:shadow-lg transition-shadow duration-300 border border-gray-200 rounded-xl'
                                            ]),
                                    ])
                                    ->columns(1)
                                    ->grid(2) // 2 columns on desktop
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn(): BelongsToMany =>
            $this->team->members())
            ->modifyQueryUsing(fn ($query) => $query->whereNot('user_id', auth()->id()))
            ->inverseRelationship('teams')
            ->columns([
                TextColumn::make('name'),
            ])
            ->filters([
                // ...
            ])
            ->headerActions($this->getTableHeaderActions())
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                    ->label('Remove from my Team')
                ])
            ]);
    }

    // Table builder (you can configure header actions / default sort here)
//    protected function table(Table $table): Table
//    {
//        return $table
//            ->query($this->getTableQuery())
//            ->columns($this->getTableColumns())
//            ->headerActions($this->getTableHeaderActions())
//            ->actions($this->getTableRowActions())
//            ->bulkActions($this->getTableBulkActions());
//    }

    // Table query — scope to the current team members
    protected function getTableQuery(): Builder
    {
        // Make sure 'members' is a belongsToMany relation on Team
        // and we fetch the users via the relation query
        return $this->team
            ? $this->team->members()->getQuery()
            : User::query()->whereRaw('0 = 1'); // empty if no team
    }

    // Header actions (top-right create/invite)
    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('Add Member')
                ->icon('heroicon-o-user-plus')
                ->model(\App\Models\User::class)
                ->schema([
                    TextInput::make('name')
                        ->label('Full Name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('email')
                        ->label('Email Address')
                        ->email()
                        ->unique(\App\Models\User::class, 'email')
                        ->required(),

                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->required()
                        ->minLength(6)
                        ->same('password_confirmation'),

                    TextInput::make('password_confirmation')
                        ->label('Confirm Password')
                        ->password()
                        ->required(),
                ])
                ->mutateFormDataUsing(function (array $data) {
                    // optionally hash password or set defaults
                    return $data;
                })
                ->after(function (array $data) {
                    $member = User::create($data);
                    // `$record` is the created User — attach to team
//                    if ($this->team && $member) {
//                        $this->team->members()->attach($member->id);
//                    }
                }),
        ];
    }

    protected function getBasicSection()
    {
        return Section::make('Team Basic Information')
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('name')
                            ->maxLength(255),
                        TextInput::make('domain')
                            ->url()
                            ->maxLength(255),
                        Textarea::make('description')
                        ->rows(5),
                        FileUpload::make('logo')
                            ->openable()
                            ->maxSize(2048)
                            ->visibility('public')
                            ->disk('public')
                            ->directory('logos/teams')
                            ->imageResizeMode('contain')
                            ->imageCropAspectRatio('1:1')
                            ->panelAspectRatio('1:1')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('center bottom')
                            ->uploadButtonPosition('center bottom')
                            ->uploadProgressIndicatorPosition('center bottom')
                            ->getUploadedFileNameForStorageUsing(
                                static fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                    ->prepend(auth()->user()->teams()->first()->id . '_'),
                            )
                            ->extraAttributes(['class' => 'w-32 h-32'])
                            ->acceptedFileTypes(['image/png', 'image/jpeg']),
                        Toggle::make('status'),
                    ])->columns()
                ])->columnSpanFull();

    }

    protected function getMembersSection()
    {
        return Section::make('Team Members')
            ->schema([
                Group::make()
                    ->schema([
                        Select::make('members')
                            ->multiple()
                            ->relationship('members', 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Email address')
                                    ->email()
                                    ->required(),
                                TextInput::make('password')
                                    ->password()
                                    ->required(),
                            ])
                            ->searchable()
                            ->preload()
                            ->afterStateUpdated(function ($state, callable $set, callable $get, ?\App\Models\Team $record) {
                                if (! $record) return;

                                // Sync users with the team
                                $record->members()->attach($state);
                            }),
                    ])->columns()
                ])->columnSpanFull();

    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                $this->getBasicSection(),
//                $this->getMembersSection(),
            ]);
    }

    public static function getLabel(): string
    {
        return 'Team Profile';
    }



}

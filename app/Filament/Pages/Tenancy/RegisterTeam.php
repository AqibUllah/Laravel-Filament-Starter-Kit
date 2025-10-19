<?php
namespace App\Filament\Pages\Tenancy;

use App\Models\Team;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class RegisterTeam extends RegisterTenant
{
//    protected static string $view = 'filament.company.pages.register-team';
protected string $view = 'components.team.pages.register-team';

protected static string $layout = 'components.team.layout.custom-simple';
    public static function getLabel(): string
    {
        return 'Register team';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                TextInput::make('slug')->required(),
                TextInput::make('description'),
                TextInput::make('domain')->url(),
                // ...
            ]);
    }

    protected function handleRegistration(array $data): Team
    {
        $data['owner_id'] = auth()->id();

        $team = Team::create($data);
        $team->members()->attach(auth()->user());
        $team_name = $team->name;

        Notification::make()
            ->title('company created')
            ->success()
            ->icon('heroicon-o-document-text')
            ->body(Str::inlineMarkdown(__('New company created successfully', compact('team_name'))))
            ->send();

        return $team;
    }
}

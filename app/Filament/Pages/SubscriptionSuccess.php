<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Route;

class SubscriptionSuccess extends Page
{
    protected string $view = 'filament.pages.subscription-success';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::CheckBadge;
    protected static bool $shouldRegisterNavigation = false;

    public $sessionId;
    public $teamId;

    public function mount(): void
    {
        $this->sessionId = request()->get('session_id');
        $this->teamId = request()->get('team_id');

        if ($this->sessionId) {
            Notification::make()
                ->title('Subscription activated successfully!')
                ->success()
                ->send();
        }
    }

    public function getTitle(): string
    {
        return 'Subscription Success';
    }

    public static function getRoutes(): \Closure
    {
        return function () {
            Route::get('/subscription/success', static::class)
                ->middleware(['web', 'auth'])
                ->name('subscription.success');
        };
    }
}

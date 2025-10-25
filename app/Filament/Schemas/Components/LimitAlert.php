<?php

namespace App\Filament\Schemas\Components;

use Filament\Schemas\Components\Component;

class LimitAlert extends Component
{
    protected string $view = 'filament.schemas.components.limit-alert';

    public function __construct(
        public string $message,
        public string $type = 'warning',
        public ?string $upgradeUrl = null
    ) {}

    public static function make(string $message, string $type = 'warning', ?string $upgradeUrl = null): static
    {
        return app(static::class, [
            'message' => $message,
            'type' => $type,
            'upgradeUrl' => $upgradeUrl,
        ]);
    }
}

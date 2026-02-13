<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum BlogStatusEnum: string implements HasLabel,HasColor,HasIcon
{
    case Draft = 'draft';
    case Published = 'published';
    case Scheduled = 'scheduled';


    public function getLabel(): string|Htmlable|null
    {
        return match($this){
            self::Draft => 'Draft',
            self::Published => 'Published',
            self::Scheduled => 'Scheduled'
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Draft => 'success',
            self::Published => 'warning',
            self::Scheduled => 'danger',
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::Draft => Heroicon::LightBulb,
            self::Published => Heroicon::ChartBar,
            self::Scheduled => Heroicon::Clock,
        };
    }
}

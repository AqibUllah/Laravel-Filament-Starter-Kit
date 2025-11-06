<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum PriorityEnum: string implements HasColor, HasIcon, HasLabel
{
    case LOW = 'low';
    case Medium = 'medium';
    case High = 'high';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::LOW => 'Low',
            self::Medium => 'Medium',
            self::High => 'High',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::LOW => 'success',
            self::Medium => 'warning',
            self::High => 'danger',
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::LOW => Heroicon::ArrowDownCircle,
            self::Medium => Heroicon::ChartBar,
            self::High => Heroicon::ShieldExclamation,
        };
    }
}

<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum ProjectStatusEnum: string implements HasColor, HasIcon, HasLabel
{
    case Planning = 'planning';
    case InProgress = 'in_progress';
    case OnHold = 'on_hold';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Archived = 'archived';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Planning => 'Planning',
            self::InProgress => 'In Progress',
            self::OnHold => 'On Hold',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
            self::Archived => 'Archived',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Planning => 'info',
            self::InProgress => 'warning',
            self::OnHold => 'gray',
            self::Completed => 'success',
            self::Cancelled => 'danger',
            self::Archived => 'secondary',
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::Planning => Heroicon::ClipboardDocumentList,
            self::InProgress => Heroicon::PlayCircle,
            self::OnHold => Heroicon::PauseCircle,
            self::Completed => Heroicon::CheckCircle,
            self::Cancelled => Heroicon::XCircle,
            self::Archived => Heroicon::ArchiveBox,
        };
    }
}

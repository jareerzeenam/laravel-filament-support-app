<?php

namespace App\Enums\Feature;

use App\Enums\Traits\UseValueAsLabel;
use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum FeatureStatus: string implements HasColor, HasLabel
{
    use UseValueAsLabel;
    case Proposed = 'Proposed';
    case Planning = 'Planning';
    case InProgress = 'In Progress';
    case Completed = 'Completed';
    case Cancelled = 'Cancelled';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Proposed => 'gray',
            self::Planning => 'info',
            self::InProgress => 'primary',
            self::Completed => 'success',
            self::Cancelled => 'danger',
        };
    }

    //    public function getIcon(): string|BackedEnum|Htmlable|null
    //    {
    //        // TODO: Implement getIcon() method.
    //    }

}

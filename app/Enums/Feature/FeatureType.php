<?php

namespace App\Enums\Feature;

use App\Enums\Traits\UseValueAsLabel;
use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum FeatureType: string implements HasColor, HasIcon, HasLabel
{
    use UseValueAsLabel;

    case Feature = 'Feature';
    case Bug = 'Bug';
    case Improvement = 'Improvement';
    case Task = 'Task';
    case Integration = 'Integration';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Feature => 'primary',
            self::Bug => 'danger',
            self::Improvement => 'success',
            self::Task => 'warning',
            self::Integration => Color::Emerald,
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Feature => Heroicon::LightBulb,
            self::Bug => Heroicon::BugAnt,
            self::Improvement => Heroicon::PresentationChartBar,
            self::Task => Heroicon::ChartPie,
            self::Integration => Heroicon::Bolt,
        };
    }
}

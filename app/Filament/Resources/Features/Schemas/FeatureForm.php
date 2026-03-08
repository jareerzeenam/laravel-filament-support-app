<?php

namespace App\Filament\Resources\Features\Schemas;

use App\Enums\Feature\FeatureStatus;
use App\Enums\Feature\FeatureType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class FeatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([

                Section::make('Feature Details')
                    ->description('Details about the Feature')
                    ->columnSpanFull()
                    ->collapsible()
                    ->columns(3)
                    ->schema(self::getGeneralDetailsSchema()),

                Section::make('Effort & Cost')
                    ->description('Estimate the effort and cost for this feature')
                    ->columnSpanFull()
                    ->collapsible()
                    ->columns(2)
                    ->schema(self::getEffortAndCostSchema()),


            ]);
    }

    private static function getGeneralDetailsSchema(): array
    {
        return [
            TextInput::make('name')
                ->required(),
            Select::make('status')
                ->live()
                ->options(FeatureStatus::class)
                ->enum(FeatureStatus::class)
                ->searchable()
                ->required()
                ->default(FeatureStatus::Proposed),
            TimePicker::make('delivered_at')->visibleJs(<<<'JS'
                                $get('status') === 'Completed'
                            JS
            ),
            DatePicker::make('target_delivery_date')
                ->rules([
                    function (Get $get) {
                        return Rule::requiredIf($get('status') === FeatureStatus::Planning || $get('status') === FeatureStatus::InProgress);
                    },
                ])
                ->visibleJs(<<<'JS'
                                $get('status') === 'Planning' || $get('status') === 'In Progress'
                            JS
                ),

            ToggleButtons::make('type')
                ->hiddenLabel('type')
                ->options(FeatureType::class)
                ->enum(FeatureType::class)
                ->inline()
                ->required()
                ->default(FeatureType::Feature)
                ->columnSpanFull(),
            Slider::make('priority')
                ->required()
                ->pips(Slider\Enums\PipsMode::Steps)
                ->step(1)
                ->fillTrack()
                ->minValue(1)
                ->maxValue(10)
                ->default(0)
                ->columnSpan(2),

            RichEditor::make('description')
                ->required()
                ->extraInputAttributes([
                    'class' => 'min-h-[200px]',
                ])
                ->textColors([
                    '#ef4444' => 'Red',
                    '#10b981' => 'Green',
                    '#0ea5e9' => 'Sky',
                ])
                ->toolbarButtons([
                    ['bold', 'italic', 'underline', 'strike', 'link'],
                    ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                    ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                    ['table', 'attachFiles'],
                    ['undo', 'redo', 'textColor'],
                ])
                ->floatingToolbars([
                    'paragraph' => [
                        'bold', 'italic', 'underline', 'strike', 'subscript', 'superscript',
                    ],
                    'heading' => [
                        'h1', 'h2', 'h3',
                    ],
                    'table' => [
                        'tableAddColumnBefore', 'tableAddColumnAfter', 'tableDeleteColumn',
                        'tableAddRowBefore', 'tableAddRowAfter', 'tableDeleteRow',
                        'tableMergeCells', 'tableSplitCell',
                        'tableToggleHeaderRow', 'tableToggleHeaderCell',
                        'tableDelete',
                    ],
                ])
                ->columnSpanFull(),
        ];
    }

    private static function getEffortAndCostSchema(): array
    {
        return [

            TextInput::make('effort_in_days')
                ->required()
                ->numeric()
                ->afterStateUpdatedJs(<<< 'JS'
                       const isHighPriority = $get('is_high_cost');
                          const effort = $state;
                          const costPerDay = isHighPriority ? 1500 : 1000;
                          $set('cost', effort * costPerDay);
                       JS)
                ->default(0),

            TextInput::make('cost')
                ->required()
                ->numeric()
                ->default(0.0)
                ->prefix('£'),
            Toggle::make('is_high_cost')
                ->label('High Cost')
                ->dehydrated(false)
                ->afterStateUpdatedJs(<<< 'JS'
                          const isHighPriority = $state;
                              const effort = $get('effort_in_days');
                              const costPerDay = isHighPriority ? 1500 : 1000;
                              $set('cost', effort * costPerDay);
                       JS),
        ];
    }
}

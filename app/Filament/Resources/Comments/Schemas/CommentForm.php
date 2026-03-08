<?php

namespace App\Filament\Resources\Comments\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                RichEditor::make('body')
                    ->required()
                    ->columnSpanFull(),
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('feature_id')
                    ->label('Feature')
                    ->relationship('feature', 'name')
                    ->required(),
                Toggle::make('is_approved')
                    ->label('Approved')
                    ->required(),
            ]);
    }
}

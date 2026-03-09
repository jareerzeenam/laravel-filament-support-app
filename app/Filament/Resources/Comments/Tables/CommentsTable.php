<?php

namespace App\Filament\Resources\Comments\Tables;

use App\Filament\Resources\Features\RelationManagers\CommentsRelationManager;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class CommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('body')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('feature.name')
                    ->hiddenOn([CommentsRelationManager::class])
                    ->searchable(),
                IconColumn::make('is_approved')
                    ->label('Approved')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->emptyStateActions(
                [CreateAction::make()]
            )
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('Approve')
                        ->action(fn (Collection $records) => $records->each->update(['is_approved' => true]))
                        ->authorizeIndividualRecords('approve')
                        ->successNotificationTitle('Comments approved')
                        ->failureNotificationTitle(function (int $successCount, int $totalCount): string {
                            if ($successCount) {
                                return "{$successCount} of {$totalCount} comments approved";
                            }

                            return 'Failed to approve comments';
                        })
                        ->slideOver(false)
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->icon(Heroicon::OutlinedArchiveBox),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

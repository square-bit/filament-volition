<?php

namespace Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers;

use Filament\Forms\Components\Builder;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Squarebit\FilamentVolition\Contracts\IsFilamentCondition;
use Squarebit\FilamentVolition\Facades\FilamentVolition;
use Squarebit\FilamentVolition\Filament\Actions\CreateElementAction;
use Squarebit\FilamentVolition\Filament\Actions\EditElementAction;
use Squarebit\Volition\Models\Condition;

class ConditionsRelationManager extends RelationManager
{
    protected static string $relationship = 'conditions';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->conditions->count();
    }

    public function form(Form $form): Form
    {
        $schema = FilamentVolition::getFilamentBlocksForConditions();

        return count($schema) === 0 ? $form : $form->schema([
            Builder::make('payload')
                ->addActionLabel(__('Add'))
                ->hiddenLabel()
                ->columnSpanFull()
                ->required()
                ->maxItems(1)
                ->blockNumbers(false)
                ->reorderable(false)
                ->blocks($schema),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payload')
                    ->label(__('Condition'))
                    ->formatStateUsing(fn (IsFilamentCondition $state) => $state->getLabel()),
                Tables\Columns\TextColumn::make('condition')
                    ->label(__('Parameters'))
                    ->listWithLineBreaks(
                        fn (Condition $record) => count(explode(PHP_EOL, $record->payload->__toString())) > 1
                    )
                    ->getStateUsing(fn (Condition $record) => explode(PHP_EOL, $record->payload->__toString())),
                Tables\Columns\ToggleColumn::make('active'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateElementAction::make(),
            ])
            ->actions([
                EditElementAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateElementAction::make(),
            ]);
    }
}

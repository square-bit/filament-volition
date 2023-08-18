<?php

namespace Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers;

use Filament\Forms\Components\Builder;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Squarebit\FilamentVolition\Actions\CreateElementAction;
use Squarebit\FilamentVolition\Actions\EditElementAction;
use Squarebit\FilamentVolition\Contracts\IsFilamentCondition;
use Squarebit\Volition\Facades\Volition;
use Squarebit\Volition\Models\Action;

class ActionsRelationManager extends RelationManager
{
    protected static string $relationship = 'actions';

    public function form(Form $form): Form
    {
        $schema = Volition::getFilamentBlocksForActions();

        return count($schema) === 0
            ? $form
            : $form
                ->schema([
                    Builder::make('payload')
                        ->required()
                        ->maxItems(1)
                        ->reorderable(false)
                        ->blocks($schema),
                ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payload')
                    ->formatStateUsing(fn (IsFilamentCondition $state) => $state->getLabel()),
                Tables\Columns\TextColumn::make('condition')
                    ->getStateUsing(fn (Action $record) => $record->payload->__toString())
                    ->listWithLineBreaks()
                    ->bulleted(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make('aaa')->label('a'),
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

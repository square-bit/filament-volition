<?php

namespace Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers;

use Filament\Forms\Components\Builder;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Squarebit\FilamentVolition\Contracts\IsFilamentAction;
use Squarebit\FilamentVolition\Facades\FilamentVolition;
use Squarebit\FilamentVolition\Filament\Actions\CreateElementAction;
use Squarebit\FilamentVolition\Filament\Actions\EditElementAction;
use Squarebit\Volition\Models\Action;

class ActionsRelationManager extends RelationManager
{
    protected static string $relationship = 'actions';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->actions->count();
    }

    public function form(Form $form): Form
    {
        $schema = FilamentVolition::getFilamentBlocksForActions();

        return count($schema) === 0 ? $form : $form->schema([
            Builder::make('payload')
                ->addActionLabel(__('Add'))
                ->hiddenLabel()
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
                Tables\Columns\TextColumn::make('action')
                    ->formatStateUsing(fn (IsFilamentAction $state) => $state->getLabel()),
                Tables\Columns\TextColumn::make('parameters')
                    ->listWithLineBreaks(
                        fn (Action $record) => count(explode(PHP_EOL, $record->payload->__toString())) > 1
                    )
                    ->getStateUsing(fn (Action $record) => explode(PHP_EOL, $record->payload->__toString())),
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

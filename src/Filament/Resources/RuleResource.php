<?php

namespace Squarebit\FilamentVolition\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Squarebit\FilamentVolition\Facades\FilamentVolition;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\Pages;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers;
use Squarebit\Volition\Facades\Volition;
use Squarebit\Volition\Models\Rule;

class RuleResource extends Resource
{
    protected static ?string $model = Rule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\Select::make('applies_to')
                    ->label(__('Volitional'))
                    ->required()
                    ->options(array_combine(FilamentVolition::volitionals(), FilamentVolition::volitionals())),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ConditionsRelationManager::class,
            RelationManagers\ActionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRules::route('/'),
            'create' => Pages\CreateRule::route('/create'),
            'edit' => Pages\EditRule::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Rules');
    }
}

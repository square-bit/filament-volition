<?php

namespace Squarebit\FilamentVolition\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Squarebit\FilamentVolition\Facades\FilamentVolition;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\Pages;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers;
use Squarebit\Volition\Models\Rule;

class RuleResource extends Resource
{
    protected static ?string $model = Rule::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['conditions', 'actions']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Select::make('applies_to')
                    ->translateLabel()
                    ->required()
                    ->options(array_combine(FilamentVolition::volitionals(), FilamentVolition::volitionals())),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('applies_to')->searchable(),
                Tables\Columns\TextColumn::make('conditions')
                    ->label(__('Conditions'))
                    ->badge()
                    ->getStateUsing(fn (Rule $record) => $record->conditions_count),
                Tables\Columns\TextColumn::make('actions')
                    ->label(__('Actions'))
                    ->badge()
                    ->getStateUsing(fn (Rule $record) => $record->actions_count),

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

    public static function getNavigationIcon(): ?string
    {
        return config('filament-volition.navigation-icon');
    }

    public static function getNavigationGroup(): ?string
    {
        return config('filament-volition.navigation-group');
    }

    public static function getSlug(): string
    {
        return config('filament-volition.slug', 'volition');
    }
}
